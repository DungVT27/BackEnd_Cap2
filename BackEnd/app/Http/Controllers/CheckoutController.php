<?php

namespace App\Http\Controllers;
use App\Models\Ordereds;
use App\Models\Tours;
use App\Models\User;
use App\Models\Transactions;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserOrderedSuccess;
use App\Mail\TSOrderedSuccess;

use Illuminate\Http\Request;


class CheckoutController extends Controller
{
    public function checkout(){
        $tour = Tours::where('id', $_POST['tour_id'])->get()->toArray();
        $slot = $tour[0]['slot'];
        if($slot < $_POST['amount']){
            return back();
        }

        if(isset($_COOKIE['user_id']) && isset($_COOKIE['tour_id']) && isset($_COOKIE['price']) && isset($_COOKIE['amount'])){
            setcookie('user_id', 0, time() - 1);
            setcookie('tour_id', 0, time() - 1);
            setcookie('price', 0, time() - 1);
            setcookie('amount', 0, time() - 1);
        }
        $time = time();
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/api/payment/done";
        $vnp_TmnCode = "OMDEPK94";//Mã website tại VNPAY 
        $vnp_HashSecret = "EYXDOSVGKBEAZCAIXQEAKDMVGVOJWMST"; //Chuỗi bí mật

        $vnp_TxnRef = $time; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $_POST['order_desc'];
        $vnp_OrderType = "Thanh toán hóa đơn";
        $vnp_Amount = $_POST['amount'] * $_POST['price'] ;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';

        setcookie('user_id', $_POST['user_id']);
        setcookie('tour_id', $_POST['tour_id']);
        setcookie('price', $_POST['price']);
        setcookie('amount', $_POST['amount']);
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            // "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        // var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } 
    }

    public function done(Request $request)
    {
        $user = User::where('id', $_COOKIE['user_id'])->get()->toArray();
        // dd($user);

        $tourTickets = Tours::where('id', $_COOKIE['tour_id'])->get()->toArray();
        $slot = $tourTickets[0]['slot'] - $_COOKIE['amount'];
        Tours::find($_COOKIE['tour_id'])->update([
            'slot' => $slot,
        ]);


        // dd($request->all());
        $order = Ordereds::create([
            'user_id' => $_COOKIE['user_id'],
            'tour_id' => $_COOKIE['tour_id'],
            'price' => $_COOKIE['price'], 
            'tickets' => $_COOKIE['amount'],
            'created_at' => now(),
        ]);

        // dd($request->vnp_Amount);
        Transactions::create([
            'ordered_id' => $order->id,
            'amount' => $request->vnp_Amount,
            'bankCode' => $request->vnp_BankCode,
            'cardType' => $request->vnp_CardType,
            'responseCode' => $request->vnp_ResponseCode,
        ]);

        $orderDetail = Ordereds::join('tours', 'ordereds.tour_id', '=', 'tours.id')
            ->join('ts_profiles', 'tours.ts_id', '=', 'ts_profiles.id')
            ->join('users', 'ts_profiles.user_id', '=', 'users.id')
            ->select('users.name as user_name', 'users.email', 'tours.name as tour_name', 'tours.from_date', 'tours.to_date', 'ordereds.*')
            ->where('ordereds.id', $order->id)
            ->get()
            ->toArray();
        $orderDetail[0]['orderedUser'] = $user;
        // dd($orderDetail);

        $mailForUser = new UserOrderedSuccess($orderDetail);
        Mail::to($user[0]['email'])->send($mailForUser);

        $mailForTs = new TSOrderedSuccess($orderDetail);
        Mail::to($orderDetail[0]['email'])->send($mailForTs);

        header("Location:http://localhost:3000/bookTour.html");
        exit;
    }

    public function payment()
    {
        return view('payment');
    }
}
