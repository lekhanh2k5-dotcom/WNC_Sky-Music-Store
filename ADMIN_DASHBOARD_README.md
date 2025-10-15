# 📊 ADMIN DASHBOARD - THỐNG KÊ

## ✅ Đã triển khai các thống kê thực tế

### 📈 **1. Stats Cards (4 thẻ thống kê chính)**

#### 💰 Tổng Doanh Thu
- **Nguồn dữ liệu**: Bảng `purchases` - cột `coins_spent`
- **Tính toán**: Tổng tất cả các đơn hàng có status = 'completed'
- **Hiển thị**: Số xu (Sky Coins) với % tăng trưởng so với tháng trước
- **Màu sắc**: Xanh lá nếu tăng, đỏ nếu giảm

#### 🛒 Đơn Hàng
- **Nguồn dữ liệu**: Bảng `purchases`
- **Tính toán**: Đếm số lượng đơn hàng có status = 'completed'
- **Hiển thị**: Tổng số đơn với % tăng trưởng so với tháng trước
- **Màu sắc**: Xanh dương nếu tăng, đỏ nếu giảm

#### 👥 Người Dùng
- **Nguồn dữ liệu**: Bảng `users`
- **Tính toán**: Đếm tất cả người dùng trong hệ thống
- **Hiển thị**: Tổng số user với % tăng trưởng người dùng mới tháng này
- **Màu sắc**: Tím nếu tăng, đỏ nếu giảm

#### 🎼 Sheet Nhạc
- **Nguồn dữ liệu**: Bảng `products`
- **Tính toán**: Đếm sản phẩm có is_active = 1
- **Hiển thị**: Tổng số sheet + số sheet mới thêm trong tháng
- **Màu sắc**: Vàng cố định

---

### 📊 **2. Biểu đồ Doanh Thu Theo Tháng**

- **Loại biểu đồ**: Line Chart (Chart.js)
- **Dữ liệu**: 6 tháng gần nhất
- **Nguồn**: Bảng `purchases` - group by tháng và năm
- **Tính năng**:
  - Hover để xem chi tiết doanh thu từng tháng
  - Hiển thị định dạng tiền Việt Nam (dấu phẩy ngăn cách)
  - Responsive design
  - Màu xanh dương (#3B82F6)

---

### 🏆 **3. Top Sheet Nhạc Bán Chạy**

- **Hiển thị**: Top 3 sản phẩm
- **Tính toán**: Đếm số lần mua mỗi sản phẩm từ bảng `purchases`
- **Sắp xếp**: Giảm dần theo số lượt mua
- **Huy chương**:
  - 🥇 Top 1
  - 🥈 Top 2
  - 🥉 Top 3
- **Thông tin hiển thị**: 
  - Tên sheet nhạc
  - Tác giả
  - Số lượt mua

---

### 📋 **4. Đơn Hàng Gần Đây**

- **Hiển thị**: 10 đơn hàng mới nhất
- **Thông tin**:
  - ID đơn hàng
  - Tên khách hàng
  - Tên sản phẩm
  - Giá (số xu)
  - Thời gian (relative time: "2 hours ago")
  - Trạng thái (badge màu)
- **Nguồn**: Bảng `purchases` join với `users` và `products`
- **Sắp xếp**: Mới nhất trước

---

## 🔧 **Files đã tạo/sửa**

### 1. **DashboardController.php** (MỚI)
```
app/Http/Controllers/DashboardController.php
```
- Xử lý tất cả logic thống kê
- Lấy dữ liệu từ database
- Tính toán % tăng trưởng
- Truyền data về view

### 2. **routes/web.php** (ĐÃ SỬA)
- Thay đổi route `/admin/dashboard` từ closure sang DashboardController

### 3. **dashboard.blade.php** (ĐÃ SỬA)
- Thay đổi từ dữ liệu tĩnh sang dynamic
- Thêm Chart.js cho biểu đồ
- Thêm @push('scripts') cho JavaScript

### 4. **layouts/admin.blade.php** (ĐÃ SỬA)
- Thêm @stack('scripts') để hỗ trợ JavaScript từ các trang con

---

## 📊 **Công thức tính toán**

### % Tăng trưởng
```
Growth % = ((Tháng này - Tháng trước) / Tháng trước) × 100
```

### Doanh thu theo tháng
```sql
SELECT 
    MONTH(created_at) as month,
    YEAR(created_at) as year,
    SUM(coins_spent) as total
FROM purchases
WHERE status = 'completed'
    AND created_at >= NOW() - INTERVAL 6 MONTH
GROUP BY year, month
ORDER BY year, month
```

### Top sản phẩm
```sql
SELECT 
    product_id,
    COUNT(*) as purchase_count
FROM purchases
WHERE status = 'completed'
GROUP BY product_id
ORDER BY purchase_count DESC
LIMIT 3
```

---

## 🎨 **Giao diện**

- ✅ Giữ nguyên thiết kế gốc
- ✅ Chỉ thay đổi dữ liệu từ tĩnh sang động
- ✅ Responsive design
- ✅ Dark theme
- ✅ Icon và màu sắc đẹp mắt
- ✅ Biểu đồ interactive với Chart.js

---

## 🚀 **Cách sử dụng**

1. Đảm bảo có dữ liệu trong bảng `purchases`, `users`, `products`
2. Truy cập `/admin/dashboard`
3. Tất cả thống kê sẽ tự động tính toán từ database
4. Biểu đồ sẽ render với Chart.js

---

## 📝 **Ghi chú**

- Nếu chưa có dữ liệu, các thống kê sẽ hiển thị 0 hoặc thông báo "Chưa có dữ liệu"
- % tăng trưởng sẽ là 0 nếu tháng trước không có dữ liệu
- Biểu đồ sẽ trống nếu không có giao dịch trong 6 tháng qua
- Tất cả dữ liệu là REAL-TIME từ database

---

## 🎯 **Kết quả**

✅ Dashboard hoàn toàn dynamic
✅ Thống kê chính xác từ database
✅ Biểu đồ đẹp mắt với Chart.js
✅ Giao diện giữ nguyên như ban đầu
✅ Code sạch, dễ bảo trì
