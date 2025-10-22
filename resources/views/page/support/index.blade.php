@extends('layouts.app')

@section('title', 'Hỗ trợ - Sky Music Store')

@section('content')
<div id="support" class="page-content">
        <section class="relative z-10 py-20 px-6">
            <div class="max-w-4xl mx-auto">
                <h2 class="orbitron text-5xl font-bold text-white text-center mb-16">🛠️ Hỗ Trợ Khách Hàng</h2>
                
                <!-- FAQ -->
                <div class="game-card rounded-xl p-8 mb-8">
                    <h3 class="orbitron text-2xl font-bold text-white mb-6">Câu Hỏi Thường Gặp</h3>
                    <div class="space-y-4">
                        <div class="border-b border-white border-opacity-20 pb-4">
                            <h4 class="inter font-semibold text-white mb-2">Làm sao để tải sheet nhạc sau khi mua?</h4>
                            <p class="inter text-blue-200">Sau khi thanh toán thành công, bạn sẽ nhận được link tải về email đã đăng ký.</p>
                        </div>
                        <div class="border-b border-white border-opacity-20 pb-4">
                            <h4 class="inter font-semibold text-white mb-2">Sheet nhạc có định dạng gì?</h4>
                            <p class="inter text-blue-200">Chúng tôi cung cấp sheet ở định dạng PDF và MIDI cho Sky Studio.</p>
                        </div>
                        <div class="border-b border-white border-opacity-20 pb-4">
                            <h4 class="inter font-semibold text-white mb-2">Có thể hoàn tiền không?</h4>
                            <p class="inter text-blue-200">Chúng tôi hỗ trợ hoàn tiền trong vòng 7 ngày nếu có vấn đề về chất lượng.</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="game-card rounded-xl p-8">
                    <h3 class="orbitron text-2xl font-bold text-white mb-6">Liên Hệ Với Chúng Tôi</h3>
                    
                    <!-- Thông báo thành công -->
                    @if(session('success'))
                        <div class="bg-green-500 bg-opacity-20 border-2 border-green-500 text-white px-6 py-4 rounded-lg mb-6 shadow-lg">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="text-lg font-bold text-white mb-3">✅ Gửi yêu cầu hỗ trợ thành công!</h3>
                                    
                                    <div class="bg-white bg-opacity-10 rounded-lg p-4 space-y-2 text-sm">
                                        <p><strong class="text-green-300">Họ và tên:</strong> <span class="text-white">{{ session('support_name') }}</span></p>
                                        <p><strong class="text-green-300">Email:</strong> <span class="text-white">{{ session('support_email') }}</span></p>
                                        <p><strong class="text-green-300">Loại vấn đề:</strong> <span class="text-white">{{ session('support_issue') }}</span></p>
                                        <div class="border-t border-white border-opacity-20 pt-2 mt-2">
                                            <strong class="text-green-300">Nội dung:</strong>
                                            <p class="text-white mt-1 italic">"{{ session('support_message') }}"</p>
                                        </div>
                                    </div>
                                    
                                    <p class="mt-3 text-green-200 text-sm">
                                        📧 Chúng tôi đã nhận được yêu cầu và sẽ phản hồi qua email trong vòng 24 giờ.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Thông báo lỗi -->
                    @if($errors->any())
                        <div class="bg-red-500 bg-opacity-20 border border-red-500 text-white px-4 py-3 rounded-lg mb-6">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('support.send') }}" accept-charset="UTF-8" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="inter text-white block mb-2">Họ và tên <span class="text-red-400">*</span></label>
                            <input type="text" name="name" value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}" 
                                   class="w-full p-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border border-white border-opacity-30 focus:border-blue-400 focus:outline-none" 
                                   placeholder="Nhập họ và tên" required>
                        </div>

                        <div>
                            <label class="inter text-white block mb-2">Email <span class="text-red-400">*</span></label>
                            <input type="email" name="email" value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" 
                                   class="w-full p-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border border-white border-opacity-30 focus:border-blue-400 focus:outline-none" 
                                   placeholder="Nhập email" required>
                        </div>

                        <div>
                            <label class="inter text-white block mb-2">Loại vấn đề <span class="text-red-400">*</span></label>
                            <select name="issue_type" 
                                    style="color: #000000 !important; background-color: rgba(255, 255, 255, 0.95) !important;"
                                    class="w-full p-3 rounded-lg border border-white border-opacity-30 focus:border-blue-400 focus:outline-none" required>
                                <option value="" style="color: #666666;">-- Chọn loại vấn đề --</option>
                                <option value="payment" {{ old('issue_type') == 'payment' ? 'selected' : '' }} style="color: #000000;">💳 Vấn đề thanh toán / Nạp xu</option>
                                <option value="download" {{ old('issue_type') == 'download' ? 'selected' : '' }} style="color: #000000;">📥 Vấn đề tải file / Download</option>
                                <option value="quality" {{ old('issue_type') == 'quality' ? 'selected' : '' }} style="color: #000000;">🎵 Chất lượng sheet nhạc</option>
                                <option value="account" {{ old('issue_type') == 'account' ? 'selected' : '' }} style="color: #000000;">👤 Vấn đề tài khoản</option>
                                <option value="technical" {{ old('issue_type') == 'technical' ? 'selected' : '' }} style="color: #000000;">⚙️ Lỗi kỹ thuật / Bug</option>
                                <option value="refund" {{ old('issue_type') == 'refund' ? 'selected' : '' }} style="color: #000000;">💰 Yêu cầu hoàn tiền</option>
                                <option value="suggestion" {{ old('issue_type') == 'suggestion' ? 'selected' : '' }} style="color: #000000;">💡 Góp ý / Đề xuất</option>
                                <option value="other" {{ old('issue_type') == 'other' ? 'selected' : '' }} style="color: #000000;">❓ Khác</option>
                            </select>
                        </div>

                        <div>
                            <label class="inter text-white block mb-2">Nội dung <span class="text-red-400">*</span></label>
                            <textarea name="message" rows="5" 
                                      class="w-full p-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border border-white border-opacity-30 focus:border-blue-400 focus:outline-none" 
                                      placeholder="Mô tả chi tiết vấn đề của bạn..." required>{{ old('message') }}</textarea>
                            <p class="inter text-blue-200 text-sm mt-1">Tối thiểu 10 ký tự</p>
                        </div>

                        <button type="submit" class="glow-button bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-3 rounded-full font-semibold hover:from-blue-600 hover:to-purple-700 transition-all">
                            📨 Gửi Yêu Cầu
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection