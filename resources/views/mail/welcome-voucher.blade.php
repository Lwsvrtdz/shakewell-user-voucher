<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Service</title>
</head>
<body>
    <h1>Welcome, {{ $user->name }}!</h1>
    <p>Thank you for registering with us. As a token of our appreciation, here is your welcome voucher:</p>
    <h2>Voucher Code: {{ $voucherCode }}</h2>
    <p>Use this code at checkout to enjoy your discount.</p>
    <p>We hope you have a great experience with our service!</p>
    <p>Best regards,</p>
    <p>The Team</p>
</body>
</html>