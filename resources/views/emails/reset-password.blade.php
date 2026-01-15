<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - OJTracker</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Arial', 'Helvetica', sans-serif; background-color: #f4f4f7;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f4f4f7;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" style="width: 600px; max-width: 100%; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center; border-radius: 8px 8px 0 0;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: bold;">OJTracker</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="margin: 0 0 20px 0; color: #333333; font-size: 24px; font-weight: 600;">Reset Your Password</h2>
                            
                            <p style="margin: 0 0 20px 0; color: #666666; font-size: 16px; line-height: 1.5;">
                                You are receiving this email because we received a password reset request for your account.
                            </p>
                            
                            <p style="margin: 0 0 30px 0; color: #666666; font-size: 16px; line-height: 1.5;">
                                Click the button below to reset your password:
                            </p>
                            
                            <!-- Reset Button -->
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="{{ url('/') }}?token={{ $token }}&email={{ urlencode($email) }}" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 14px 30px; border-radius: 6px; font-size: 16px; font-weight: 600;">
                                    Reset Password
                                </a>
                            </div>
                            
                            <p style="margin: 20px 0; color: #666666; font-size: 14px; line-height: 1.5;">
                                This password reset link will expire in <strong>60 minutes</strong>.
                            </p>
                            
                            <p style="margin: 20px 0; color: #666666; font-size: 14px; line-height: 1.5;">
                                If you're having trouble clicking the button, copy and paste the URL below into your web browser:
                            </p>
                            
                            <p style="margin: 20px 0; padding: 15px; background-color: #f8f9fa; border-radius: 4px; word-break: break-all; color: #667eea; font-size: 12px;">
                                {{ url('/') }}?token={{ $token }}&email={{ urlencode($email) }}
                            </p>
                            
                            <!-- Info Box -->
                            <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 30px 0; border-radius: 4px;">
                                <p style="margin: 0; color: #856404; font-size: 14px; line-height: 1.5;">
                                    <strong>⚠️ Security Note:</strong> If you did not request a password reset, please ignore this email. Your password will remain unchanged.
                                </p>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 30px; text-align: center; border-radius: 0 0 8px 8px; border-top: 1px solid #e0e0e0;">
                            <p style="margin: 0 0 10px 0; color: #999999; font-size: 12px;">
                                This is an automated message from OJTracker. Please do not reply to this email.
                            </p>
                            <p style="margin: 0; color: #999999; font-size: 12px;">
                                &copy; {{ date('Y') }} OJTracker. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
