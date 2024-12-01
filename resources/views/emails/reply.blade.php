<!-- resources/views/emails/reply.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Your Message</title>
</head>

<body>
    <p>Hello {{ $senderName }},</p>
    <p>Thank you for reaching out to us. Here is a recap of your message and our reply:</p>

    <p><strong>Your Message:</strong></p>
    <blockquote style="margin-left: 20px; padding-left: 10px; border-left: 2px solid #ccc;">
        {{ $userMessage }}
    </blockquote>

    <p><strong>Our Reply:</strong></p>
    <blockquote style="margin-left: 20px; padding-left: 10px; border-left: 2px solid #4CAF50;">
        {{ $replyMessage }}
    </blockquote>
    <p>Best regards,<br>LSPU BAO</p>
</body>

</html>