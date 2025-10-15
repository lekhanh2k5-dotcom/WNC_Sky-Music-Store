<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - Sky Music Store</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Inter:wght@400;600&display=swap');
        
        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: #ffffff;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
        }
        
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        .email-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.3) 0%, rgba(118, 75, 162, 0.3) 100%);
            padding: 40px 30px;
            text-align: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #fbbf24 0%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 10px 0;
        }
        
        .icon {
            font-size: 60px;
            margin-bottom: 10px;
        }
        
        .email-body {
            padding: 40px 30px;
        }
        
        .greeting {
            font-family: 'Orbitron', sans-serif;
            font-size: 24px;
            color: #fbbf24;
            margin-bottom: 20px;
        }
        
        .content-text {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            line-height: 1.8;
            margin: 15px 0;
        }
        
        .button-container {
            text-align: center;
            margin: 35px 0;
        }
        
        .reset-button {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(135deg, #fbbf24 0%, #ec4899 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 10px 30px rgba(251, 191, 36, 0.4);
        }
        
        .warning-card {
            background: rgba(255, 193, 7, 0.15);
            border-left: 4px solid #ffc107;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .warning-card strong {
            color: #ffc107;
            font-size: 16px;
            display: block;
            margin-bottom: 10px;
        }
        
        .warning-card ul {
            margin: 10px 0 0 0;
            padding-left: 20px;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .warning-card li {
            margin: 8px 0;
        }
        
        .link-card {
            background: rgba(0, 0, 0, 0.2);
            border: 1px dashed rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
            word-break: break-all;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .divider {
            height: 2px;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.3), transparent);
            margin: 30px 0;
        }
        
        .footer {
            background: rgba(0, 0, 0, 0.2);
            padding: 30px;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .footer-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            margin: 10px 0;
        }
        
        .footer-link {
            color: #fbbf24;
            text-decoration: none;
        }
        
        .copyright {
            color: rgba(255, 255, 255, 0.5);
            font-size: 11px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <div class="icon">🎵</div>
            <div class="logo">SKY MUSIC STORE</div>
        </div>
        
        <div class="email-body">
            <h2 class="greeting">Xin chào @if(isset($userName)) {{ $userName }} @endif! 👋</h2>
            
            <p class="content-text">
                Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản <strong>Sky Music Store</strong> của bạn.
            </p>
            
            <div class="button-container">
                <a href="{{ $resetLink }}" class="reset-button">
                    🔑 Đặt Lại Mật Khẩu
                </a>
            </div>
            
            <div class="warning-card">
                <strong>⚠️ Lưu ý quan trọng:</strong>
                <ul>
                    <li>Link này sẽ <strong>hết hạn sau 60 phút</strong></li>
                    <li>Không chia sẻ link này với bất kỳ ai</li>
                    <li>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này</li>
                    <li>Tài khoản của bạn vẫn an toàn và không có thay đổi nào</li>
                </ul>
            </div>
            
            <div class="divider"></div>
            
            <p class="content-text" style="font-size: 14px;">
                <strong>🔧 Gặp vấn đề với nút bên trên?</strong><br>
                Sao chép và dán URL bên dưới vào trình duyệt của bạn:
            </p>
            
            <div class="link-card">
                {{ $resetLink }}
            </div>
        </div>
        
        <div class="footer">
            <p class="footer-text">
                <strong>Trân trọng,</strong><br>
                <span style="color: #fbbf24;">Sky Music Store Team</span> 🎶
            </p>
            
            <div class="divider" style="margin: 20px auto; max-width: 200px;"></div>
            
            <p class="footer-text">
                📧 Email này được gửi tự động, vui lòng không trả lời.<br>
                💬 Cần hỗ trợ? Liên hệ: <a href="mailto:support@skymusicstore.com" class="footer-link">support@skymusicstore.com</a>
            </p>
            
            <p class="copyright">
                © 2025 Sky Music Store. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>