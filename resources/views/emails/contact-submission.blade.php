<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>New contact submission</title></head>
<body style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;color:#1a1816;">
    <h2>New contact form submission</h2>
    <p><strong>Name:</strong> {{ $submission->name }}</p>
    <p><strong>Email:</strong> <a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a></p>
    @if ($submission->company)
        <p><strong>Company:</strong> {{ $submission->company }}</p>
    @endif
    @if ($submission->scope)
        <p><strong>Scope:</strong> {{ $submission->scope }}</p>
    @endif
    <p><strong>Message:</strong></p>
    <p style="white-space:pre-wrap;border-left:3px solid #ddd;padding-left:12px;">{{ $submission->message }}</p>
    <hr>
    <p style="color:#888;font-size:12px;">
        Submitted {{ $submission->created_at->toDayDateTimeString() }} from {{ $submission->ip ?: 'unknown IP' }}.
    </p>
</body>
</html>
