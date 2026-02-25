<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
</head>
<body style="margin:0;padding:0;background:#020617;font-family:'Plus Jakarta Sans',Arial,sans-serif;color:#e2e8f0;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="620" cellspacing="0" cellpadding="0" style="width:100%;max-width:620px;background:#0f172a;border-radius:12px;overflow:hidden;border:1px solid #334155;box-shadow:0 16px 34px rgba(2,6,23,.45);">
                    <tr>
                        <td style="background:linear-gradient(90deg,#020617,#0f172a);padding:18px 20px;border-bottom:1px solid #334155;">
                            <img src="{{ asset('watermark/KINGSBRIDGE.png') }}" alt="Kingsbridge Motors" style="height:42px;width:auto;display:block;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 20px 10px;">
                            <h1 style="margin:0;font-size:22px;line-height:1.3;color:#f8fafc;">Password Reset Request</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 20px 18px;">
                            <p style="margin:0 0 10px;font-size:15px;line-height:1.6;color:#cbd5e1;">Hello,</p>
                            <p style="margin:0 0 10px;font-size:15px;line-height:1.6;color:#cbd5e1;">You are receiving this email because we received a password reset request for your account.</p>
                            <p style="margin:0;font-size:15px;line-height:1.6;color:#cbd5e1;">Click the button below to reset your password:</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 20px 24px;">
                            <a href="{{ url('/reset-password/' . $token) }}" style="display:inline-block;background:linear-gradient(120deg,#fbbf24,#fcd34d);color:#111827;text-decoration:none;font-weight:700;font-size:14px;padding:11px 16px;border-radius:8px;">Reset Password</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 20px 20px;">
                            <p style="margin:0;font-size:14px;line-height:1.6;color:#94a3b8;">If you did not request a password reset, no further action is required.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 20px;background:#0b1327;border-top:1px solid #334155;">
                            <p style="margin:0;font-size:12px;color:#94a3b8;">Kingsbridge Motors Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
