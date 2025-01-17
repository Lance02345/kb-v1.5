<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .content {
            font-size: 16px;
            color: #555;
            margin-top: 10px;
        }
        .button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Password Reset Request</div>
        <div class="content">
            <p>Hello,</p>
            <p>You are receiving this email because we received a password reset request for your account.</p>
            <p>Click the button below to reset your password:</p>
            <a href="{{ url('/reset-password/' . $token) }}" class="button">Reset Password</a>
            <p>If you did not request a password reset, no further action is required.</p>
        </div>
        <div class="footer">
            <p>Thank you,<br>Kingsbridge Motors Team</p>
        </div>
    </div>
</body>
</html>
