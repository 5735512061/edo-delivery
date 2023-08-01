<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edo Delivery</title>
</head>
<body>
    <h1 style="font-family: Mitr !important;">ข้อความติดต่อ</h1>
    <h2 style="font-family: Mitr !important;">{{$details['subject']}}</h2>
    <p style="font-family: Mitr !important;">เบอร์โทรศัพท์ : {{$details['phone']}}</p>
    <p style="font-family: Mitr !important;">ข้อความติดต่อ : {{$details['message_contact']}}</p>
    <a href="{{url('/admin/message')}}/{{$details['store_name']}}" style="font-family: Mitr !important;">ตอบกลับข้อความ</a>
</body>
</html>