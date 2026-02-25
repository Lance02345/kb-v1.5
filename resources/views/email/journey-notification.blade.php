<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subjectLine ?? 'Kingsbridge Motors' }}</title>
</head>
@php
    $logoBaseUrl = rtrim(config('app.url') ?: url('/'), '/');
    $logoUrl = $logoBaseUrl . '/watermark/king.png';
@endphp
<body style="margin:0;padding:0;background:#020617;font-family:'Plus Jakarta Sans',Arial,sans-serif;color:#e2e8f0;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="620" cellspacing="0" cellpadding="0" style="width:100%;max-width:620px;background:#0f172a;border-radius:12px;overflow:hidden;border:1px solid #334155;box-shadow:0 16px 34px rgba(2,6,23,.45);">
                    <tr>
                        <td style="background:linear-gradient(90deg,#020617,#0f172a);padding:18px 20px;border-bottom:1px solid #334155;">
                            <img src="{{ $logoUrl }}" alt="Kingsbridge Motors" style="height:42px;width:auto;display:block;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 20px 10px;">
                            <h1 style="margin:0;font-size:22px;line-height:1.3;color:#f8fafc;">{{ $heading }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 20px 18px;">
                            <p style="margin:0;font-size:15px;line-height:1.6;color:#cbd5e1;">{{ $messageLine }}</p>
                        </td>
                    </tr>

                    @if(!empty($details))
                    <tr>
                        <td style="padding:0 20px 14px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #334155;border-radius:8px;background:#0b1327;">
                                @foreach($details as $label => $value)
                                <tr>
                                    <td style="padding:9px 12px;border-bottom:1px solid #1e293b;font-size:12px;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;">{{ $label }}</td>
                                    <td style="padding:9px 12px;border-bottom:1px solid #1e293b;font-size:13px;color:#f8fafc;text-align:right;">{{ $value }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    @endif

                    @if(!empty($ctaText) && !empty($ctaUrl))
                    <tr>
                        <td style="padding:0 20px 24px;">
                            <a href="{{ $ctaUrl }}" style="display:inline-block;background:linear-gradient(120deg,#fbbf24,#fcd34d);color:#111827;text-decoration:none;font-weight:700;font-size:14px;padding:11px 16px;border-radius:8px;">
                                {{ $ctaText }}
                            </a>
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <td style="padding:16px 20px;background:#0b1327;border-top:1px solid #334155;">
                            <p style="margin:0;font-size:12px;color:#94a3b8;">Kingsbridge Motors Kenya</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
