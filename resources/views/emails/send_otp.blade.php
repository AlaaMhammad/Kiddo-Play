<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333333;
            text-align: center;
        }

        p {
            font-size: 16px;
            color: #555555;
            line-height: 1.5;
        }

        .otp-code {
            display: block;
            width: fit-content;
            margin: 20px auto;
            font-size: 32px;
            font-weight: bold;
            color: #ffffff;
            background-color: #1a73e8;
            padding: 15px 30px;
            border-radius: 8px;
            letter-spacing: 4px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #999999;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>OTP Verification Code</h2>
        <p>Hello <strong>{{ $otp->user->name }}</strong>,</p>
        <p>Use the following One-Time Password (OTP) to verify your email address. This code is valid until
            <strong>{{ $otp->expires_at->format('H:i') }}</strong>.</p>

        <span class="otp-code">{{ $otp->code }}</span>

        <p>If you did not request this, please ignore this email.</p>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
