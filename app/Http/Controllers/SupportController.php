<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{
    public function index()
    {
        return view('page.support.index');
    }

    public function sendSupport(Request $request)
    {
        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'issue_type' => 'required|string',
            'message' => 'required|string|min:10',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'issue_type.required' => 'Vui lòng chọn loại vấn đề',
            'message.required' => 'Vui lòng nhập nội dung',
            'message.min' => 'Nội dung phải có ít nhất 10 ký tự',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Lấy email admin từ config hoặc env
        $adminEmail = env('ADMIN_EMAIL', '23010584@st.phenikaa-uni.edu.vn');

        try {
            // Gửi email cho admin
            Mail::send('emails.support-request', [
                'userName' => $request->name,
                'userEmail' => $request->email,
                'issueType' => $request->issue_type,
                'messageContent' => $request->message,
            ], function ($message) use ($adminEmail, $request) {
                $message->to($adminEmail);
                $message->subject('🆘 Yêu cầu hỗ trợ từ ' . $request->name . ' - Sky Music Store');
                $message->replyTo($request->email, $request->name);
            });

            // Gửi email xác nhận cho user
            Mail::send('emails.support-confirmation', [
                'userName' => $request->name,
                'issueType' => $request->issue_type,
            ], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('✅ Đã nhận yêu cầu hỗ trợ - Sky Music Store');
            });

            // Lấy tên loại vấn đề để hiển thị
            $issueTypes = [
                'payment' => '💳 Vấn đề thanh toán / Nạp xu',
                'download' => '📥 Vấn đề tải file / Download',
                'quality' => '🎵 Chất lượng sheet nhạc',
                'account' => '👤 Vấn đề tài khoản',
                'technical' => '⚙️ Lỗi kỹ thuật / Bug',
                'refund' => '💰 Yêu cầu hoàn tiền',
                'suggestion' => '💡 Góp ý / Đề xuất',
                'other' => '❓ Khác',
            ];
            $issueTypeName = $issueTypes[$request->issue_type] ?? $request->issue_type;

            // Lưu thông tin vào session để hiển thị
            return back()->with([
                'success' => true,
                'support_name' => $request->name,
                'support_email' => $request->email,
                'support_issue' => $issueTypeName,
                'support_message' => $request->message,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Không thể gửi email. Vui lòng thử lại sau. Lỗi: ' . $e->getMessage()]);
        }
    }
}
