<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f4f7;
            color: #51545e;
            line-height: 1.6;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f4f4f7;
            padding: 40px 0;
        }
        .email-content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            color: #ffffff;
            font-size: 28px;
            font-weight: 600;
        }
        .email-body {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            color: #51545e;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 30px 0;
            border-radius: 4px;
        }
        .info-box p {
            margin: 8px 0;
            font-size: 14px;
        }
        .info-box strong {
            color: #2d3748;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .email-footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #718096;
        }
        .divider {
            height: 1px;
            background-color: #e2e8f0;
            margin: 30px 0;
        }
        .features {
            margin: 30px 0;
        }
        .feature-item {
            display: flex;
            align-items: start;
            margin-bottom: 20px;
        }
        .feature-icon {
            width: 40px;
            height: 40px;
            background-color: #e6f0ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        .feature-text h3 {
            margin: 0 0 5px 0;
            font-size: 16px;
            color: #2d3748;
        }
        .feature-text p {
            margin: 0;
            font-size: 14px;
            color: #718096;
        }
        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 20px 0;
            }
            .email-header {
                padding: 30px 20px;
            }
            .email-header h1 {
                font-size: 24px;
            }
            .email-body {
                padding: 30px 20px;
            }
            .greeting {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <!-- Header -->
            <div class="email-header">
                <h1>Welcome to {{ config('app.name') }}!</h1>
            </div>

            <!-- Body -->
            <div class="email-body">
                <p class="greeting">Hello {{ $user->name }},</p>

                <p class="message">
                    Thank you for joining {{ config('app.name') }}! We're thrilled to have you as part of our community.
                    Your account has been successfully created and you're all set to get started.
                </p>

                <div class="info-box">
                    <p><strong>Account Details:</strong></p>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Registration Date:</strong> {{ $user->created_at->format('F j, Y') }}</p>
                </div>

                <div style="text-align: center;">
                    <a href="{{ config('app.url') }}" class="cta-button">Get Started</a>
                </div>

                <div class="divider"></div>

                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM8 15L3 10L4.41 8.59L8 12.17L15.59 4.58L17 6L8 15Z" fill="#667eea"/>
                            </svg>
                        </div>
                        <div class="feature-text">
                            <h3>Secure Account</h3>
                            <p>Your data is protected with industry-standard security measures.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM8 15L3 10L4.41 8.59L8 12.17L15.59 4.58L17 6L8 15Z" fill="#667eea"/>
                            </svg>
                        </div>
                        <div class="feature-text">
                            <h3>24/7 Support</h3>
                            <p>Our support team is always here to help you whenever you need assistance.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM8 15L3 10L4.41 8.59L8 12.17L15.59 4.58L17 6L8 15Z" fill="#667eea"/>
                            </svg>
                        </div>
                        <div class="feature-text">
                            <h3>Regular Updates</h3>
                            <p>Stay informed with the latest features and improvements.</p>
                        </div>
                    </div>
                </div>

                <p class="message">
                    If you have any questions or need assistance getting started, please don't hesitate to reach out
                    to our support team at <a href="mailto:{{ config('mail.from.address') }}" style="color: #667eea;">{{ config('mail.from.address') }}</a>.
                </p>

                <p class="message" style="margin-top: 30px;">
                    Best regards,<br>
                    <strong>The {{ config('app.name') }} Team</strong>
                </p>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p style="margin-top: 10px;">
                    <a href="{{ config('app.url') }}/privacy" style="color: #667eea; text-decoration: none; margin: 0 10px;">Privacy Policy</a> |
                    <a href="{{ config('app.url') }}/terms" style="color: #667eea; text-decoration: none; margin: 0 10px;">Terms of Service</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
