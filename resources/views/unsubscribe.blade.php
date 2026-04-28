<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Unsubscribed</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background:#f7f6f2; margin:0; padding:48px 16px; color:#1a1816; }
        .card { max-width: 520px; margin: 64px auto; background: #fff; border:1px solid #ebe6dc; padding:40px; }
        h1 { margin: 0 0 12px; font-size: 22px; }
        p { color:#4a463f; line-height:1.6; }
        a { color: #1a1816; }
    </style>
</head>
<body>
    <div class="card">
        <h1>You're unsubscribed.</h1>
        <p><strong>{{ $email }}</strong> has been removed from the mailing list. You won't receive any further newsletters.</p>
        <p style="font-size:13px;color:#888;">Changed your mind? Just resubscribe at <a href="/">johnrudolphdrexler.com</a>.</p>
    </div>
</body>
</html>
