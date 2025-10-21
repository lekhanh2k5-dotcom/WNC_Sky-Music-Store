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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .content {
            background: #f7f7f7;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .info-row {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #667eea;
            border-radius: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        .message-box {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        .badge {
            display: inline-block;
            padding: 5px 12px;
            background: #667eea;
            color: white;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0;">🆘 YÊU CẦU HỖ TRỢ MỚI</h1>
        <p style="margin: 10px 0 0 0;">Sky Music Store Support System</p>
    </div>
    
    <div class="content">
        <p>Xin chào Admin,</p>
        <p>Bạn có một yêu cầu hỗ trợ mới từ khách hàng:</p>
        
        <div class="info-row">
            <div class="info-label">👤 Họ và tên:</div>
            <div>{{ $userName }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">📧 Email:</div>
            <div><a href="mailto:{{ $userEmail }}">{{ $userEmail }}</a></div>
        </div>
        
        <div class="info-row">
            <div class="info-label">🏷️ Loại vấn đề:</div>
            <div>
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
                <span class="badge">{{ $issueTypes[$issueType] ?? $issueType }}</span>
            </div>
        </div>
        
        <div class="info-row">
            <div class="info-label">📅 Thời gian:</div>
            <div>{{ date('d/m/Y H:i:s') }}</div>
        </div>
        
        <h3 style="color: #667eea; margin-top: 30px;">📝 Nội dung chi tiết:</h3>
        <div class="message-box">
            {!! nl2br(e($messageContent)) !!}
        </div>
        
        <p style="margin-top: 30px;">
            <strong>⚡ Hành động:</strong><br>
            Vui lòng phản hồi khách hàng trong vòng 24 giờ bằng cách reply email này.
        </p>
        
        <div class="footer">
            <p>Email này được gửi tự động từ hệ thống Sky Music Store</p>
            <p>© 2025 Sky Music Store. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
