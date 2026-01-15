<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verified - OJTracker</title>
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
                            <!-- Success Icon -->
                            <div style="text-align: center; margin-bottom: 30px;">
                                <svg width="80" height="80" viewBox="0 0 80 80" style="display: inline-block;">
                                    <circle cx="40" cy="40" r="40" fill="#10b981"/>
                                    <path d="M25 40 L35 50 L55 30" stroke="#ffffff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                </svg>
                            </div>
                            
                            <h2 style="margin: 0 0 20px 0; color: #333333; font-size: 24px; font-weight: 600; text-align: center;">Email Verified Successfully!</h2>
                            
                            <p style="margin: 0 0 20px 0; color: #666666; font-size: 16px; line-height: 1.5; text-align: center;">
                                Great news! Your email address has been successfully verified.
                            </p>
                            
                            <!-- Info Box -->
                            <div style="background-color: #f0fdf4; border: 1px solid #86efac; border-radius: 8px; padding: 20px; margin: 30px 0;">
                                <p style="margin: 0 0 10px 0; color: #166534; font-size: 14px; font-weight: 600;">
                                    ✓ Your account is now active
                                </p>
                                <p style="margin: 0; color: #166534; font-size: 14px; line-height: 1.5;">
                                    You can now complete your registration and start tracking your OJT hours with OJTracker.
                                </p>
                            </div>
                            
                            <p style="margin: 20px 0; color: #666666; font-size: 14px; line-height: 1.5;">
                                <strong>What's next?</strong>
                            </p>
                            
                            <ul style="margin: 0 0 20px 0; padding-left: 20px; color: #666666; font-size: 14px; line-height: 1.8;">
                                <li>Complete your registration on the website</li>
                                <li>Set up your profile and preferences</li>
                                <li>Start tracking your OJT hours</li>
                                <li>Monitor your progress and accomplishments</li>
                            </ul>
                            
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="{{ config('app.url') }}" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 14px 30px; border-radius: 6px; font-size: 16px; font-weight: 600;">
                                    Continue to OJTracker
                                </a>
                            </div>
                            
                            <!-- Security Note -->
                            <div style="background-color: #f8f9fa; border-left: 4px solid #667eea; padding: 15px; margin: 30px 0; border-radius: 4px;">
                                <p style="margin: 0; color: #666666; font-size: 12px; line-height: 1.5;">
                                    <strong>Security tip:</strong> If you didn't create an account with OJTracker, please contact our support team immediately.
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
