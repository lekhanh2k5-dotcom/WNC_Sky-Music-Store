<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 30px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .content {
            background: #f7f7f7;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .success-icon {
            font-size: 60px;
            margin-bottom: 10px;
        }
        .info-box {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 4px solid #10b981;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        ul {
            background: white;
            padding: 20px 40px;
            border-radius: 8px;
            margin: 15px 0;
        }
        ul li {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="success-icon">✅</div>
        <h1 style="margin: 0;">ĐÃ NHẬN YÊU CẦU HỖ TRỢ</h1>
        <p style="margin: 10px 0 0 0;">Cảm ơn bạn đã liên hệ với chúng tôi</p>
    </div>
    
    <div class="content">
        <p>Xin chào <strong>{{ $userName }}</strong>,</p>
        
        <p>Chúng tôi đã nhận được yêu cầu hỗ trợ của bạn về: 
            <strong style="color: #667eea;">
                @php
                    $issueTypes = [
                        'payment' => '💳 Vấn đề thanh toán / Nạp xu',
                        'download' => '📥 Vấn đề tải file / Download',
                        'quality' => '🎵 Chất lượng sheet nhạc',
                        'account' => '👤 Vấn đề tài khoản',
                        'technical' => '⚙️ Lỗi kỹ thuật / Bug',
                        'refund' => '💰 Yêu cầu hoàn tiền',
                        'suggestion' => '💡 Góp ý / Đề xuất',
                        'other' => '❓ Khác'
                    ];
                @endphp
                {{ $issueTypes[$issueType] ?? $issueType }}
            </strong>
        </p>
        
        <div class="info-box">
            <h3 style="color: #10b981; margin-top: 0;">⏰ Thời gian xử lý</h3>
            <p style="margin: 10px 0;">Chúng tôi sẽ phản hồi yêu cầu của bạn trong vòng <strong>24 giờ</strong> (trong giờ làm việc).</p>
        </div>
        
        <h3 style="color: #667eea;">📋 Tiếp theo bạn cần làm gì?</h3>
        <ul>
            <li>✉️ Kiểm tra email thường xuyên để nhận phản hồi từ chúng tôi</li>
            <li>📱 Đảm bảo email không bị đưa vào thư mục Spam</li>
            <li>🔍 Kiểm tra phần <strong>FAQ</strong> trên trang Support để tìm câu trả lời nhanh</li>
            <li>📞 Nếu cần gấp, vui lòng gọi hotline: <strong>1900-xxxx</strong></li>
        </ul>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/support') }}" class="button">
                🔙 Quay lại trang Hỗ trợ
            </a>
        </div>
        
        <p style="color: #666; font-size: 14px; margin-top: 30px;">
            <strong>Lưu ý:</strong> Đây là email tự động. Vui lòng không reply email này. 
            Chúng tôi sẽ phản hồi bạn qua email riêng từ đội ngũ support.
        </p>
        
        <div class="footer">
            <p><strong>Sky Music Store</strong> - Nơi âm nhạc hòa quyện</p>
            <p>Email: support@skymusic.com | Hotline: 1900-xxxx</p>
            <p>© 2025 Sky Music Store. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
