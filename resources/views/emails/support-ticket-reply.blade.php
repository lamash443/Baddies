<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Support Ticket Reply</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f9f9f9; }
        .container { max-width: 600px; margin: 20px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #ff8c00; }
        .logo { font-size: 24px; font-weight: bold; color: #ff8c00; text-transform: uppercase; letter-spacing: 1px; }
        .content { margin-bottom: 30px; }
        .reply-message { font-size: 16px; margin-bottom: 25px; white-space: pre-line; }
        .original-message { background: #f5f5f5; border-left: 4px solid #ccc; padding: 15px; border-radius: 4px; font-size: 14px; color: #666; }
        .original-message-title { font-weight: bold; margin-bottom: 10px; color: #444; }
        .footer { text-align: center; font-size: 12px; color: #999; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Baddies Club Support</div>
        </div>
        
        <div class="content">
            <p>Hi {{ $ticket->name }},</p>
            
            <div class="reply-message">
                {{ $replyMessage }}
            </div>
            
            <p>Best regards,<br>The Baddies Club Team</p>
        </div>
        
        <div class="original-message">
            <div class="original-message-title">On {{ $ticket->created_at->format('M j, Y \a\t g:i A') }}, you wrote regarding "{{ $ticket->subject }}":</div>
            <div style="white-space: pre-line;">{{ $ticket->message }}</div>
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} Baddies Club. All rights reserved.
        </div>
    </div>
</body>
</html>
