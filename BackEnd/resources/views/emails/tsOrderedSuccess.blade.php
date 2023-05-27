<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CJB</title>
</head>
<body>
    <h4>Người dùng {{ $data[0]['orderedUser'][0]['name'] }} đã đặt thành công {{ $data[0]['tickets'] }} vé của tour {{ $data[0]['tour_name'] }} 
        khởi hành từ ngày {{ date('d-m-Y', strtotime($data[0]['from_date'])) }} và đến ngày {{ date('d-m-Y', strtotime($data[0]['to_date'])) }} do bạn cung cấp
    </h4>
    <h4>Tận hưởng ngày của bạn</h4>
</body>
</html>