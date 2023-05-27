<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CJB</title>
</head>
<body>
    <h4>Bạn đã đặt thành công {{ $data[0]['tickets'] }} vé của tour {{ $data[0]['tour_name'] }} 
        do {{ $data[0]['user_name'] }} cung cấp, tour bất đầu vào ngày {{ date('d-m-Y', strtotime($data[0]['from_date'])) }} và đến ngày {{ date('d-m-Y', strtotime($data[0]['to_date'])) }}
    </h4>
    <h4>Vui lòng đến đúng ngày và giao email này cho nhà cung cấp. Trân trọng</h4>
    <h4>Tận hưởng chuyến đi của bạn</h4>
</body>
</html>