<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px;">
    <div style="max-width: 600px; margin: auto; background: white; border-radius: 8px; padding: 32px;">
        <h2 style="color: #0E2A47; margin: 0 0 16px;">Reset Your Password</h2>
        <p style="color: #333; line-height: 1.6;">You requested a password reset. Click the button below to set a new password:</p>
        <div style="text-align: center; margin: 24px 0;">
            <a href="{{ $resetLink }}" style="display: inline-block; padding: 14px 32px; background: #0E2A47; color: white; text-decoration: none; border-radius: 6px; font-size: 16px;">Reset Password</a>
        </div>
        <p style="color: #666; font-size: 12px; line-height: 1.5;">This link will expire in 60 minutes. If you didn't request this, please ignore this email.</p>
        <hr style="border: none; border-top: 1px solid #eee; margin: 24px 0;">
        <p style="color: #999; font-size: 11px;">Alumni Management System</p>
    </div>
</body>
</html>
