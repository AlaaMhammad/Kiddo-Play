<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
        }

        p {
            color: #555555;
            line-height: 1.5;
        }

        a.button {
            display: inline-block;
            padding: 12px 25px;
            margin: 15px 0;
            font-size: 16px;
            color: #ffffff;
            background-color: #1a73e8;
            text-decoration: none;
            border-radius: 5px;
        }

        a.button:hover {
            background-color: #155ab6;
        }

        .otp {
            font-size: 18px;
            font-weight: bold;
            color: #1a73e8;
        }

        .note {
            font-size: 14px;
            color: #888888;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="app-brand justify-content-center mb-3">
            <img src="{{ $message->embed(public_path('dashboard/assets/img/kiddo.png')) }}" alt="logo"
                style="object-fit: cover; width: 20vw; height: 100px;">
        </div>
        <h1>Hello!</h1>
        <p>Please click the button below to verify your email address:</p>
        <a href="{{ $verfactionurl }}" class="button">Verify Email</a>
        <p>Your OTP code is: <span class="otp">{{ $otp }}</span></p>
        <p class="note">This verification link is valid for 10 minutes only. After that, it will expire and you will
            need to request a new one.</p>
    </div>
</body>

</html>
