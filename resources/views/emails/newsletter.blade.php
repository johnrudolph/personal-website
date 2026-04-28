<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $newsletter->subject }}</title>
</head>
<body style="margin:0;padding:0;background:#f7f6f2;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;color:#1a1816;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f7f6f2;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width:600px;background:#ffffff;border:1px solid #ebe6dc;">
                    <tr>
                        <td style="padding:32px 32px 8px;font-size:16px;line-height:1.6;">
                            {!! $bodyHtml !!}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 32px 32px;font-size:12px;line-height:1.5;color:#6b6760;border-top:1px solid #ebe6dc;">
                            You're receiving this because you signed up at johnrudolphdrexler.com.<br>
                            <a href="{{ $unsubscribeUrl }}" style="color:#6b6760;text-decoration:underline;">Unsubscribe</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
