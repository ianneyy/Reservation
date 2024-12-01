<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Details</title>
</head>

<body>
    <h1>Reservation Details</h1>
    <p><strong>Name:</strong> {{ $reservation->full_name }}</p>
    <p><strong>Email:</strong> {{ $reservation->email }}</p>
    <p><strong>Reservation Date:</strong> {{ $reservation->reservation_date }}</p>
    <p><strong>Order ID:</strong> {{ $reservation->order_id }}</p>
    <p><strong>Payment Method:</strong> {{ $reservation->pay_method }}</p>

    <img src="{{ asset('img/qrcodes/' . $reservation->id . '.svg') }}" alt="QR Code">

</body>

</html>