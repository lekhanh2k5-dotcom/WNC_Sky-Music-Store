# 🛒 ADMIN ORDERS - QUẢN LÝ ĐỠN HÀNG

## ✅ Đã triển khai trang Đơn Hàng với dữ liệu thực

### 📊 **1. Thống Kê Tổng Quan (3 Cards)**

#### 🛒 Tổng Đơn Hàng
- **Nguồn**: Bảng `purchases` 
- **Tính toán**: COUNT(*) tất cả đơn hàng
- **Hiển thị**: Tổng số đơn hàng trong hệ thống

#### 💰 Tổng Doanh Thu
- **Nguồn**: Bảng `purchases` với status = 'completed'
- **Tính toán**: SUM(coins_spent) từ các đơn hoàn thành
- **Hiển thị**: Tổng số xu thu được (Sky Coins)

#### ✅ Đơn Hoàn Thành
- **Nguồn**: Bảng `purchases` với status = 'completed'
- **Tính toán**: COUNT(*) các đơn đã hoàn thành
- **Hiển thị**: Số lượng đơn thành công

---

### 🔍 **2. Tìm Kiếm & Lọc**

#### Tìm kiếm
- **Input**: Ô tìm kiếm với placeholder "Tìm kiếm khách hàng..."
- **Tìm theo**: 
  - Tên khách hàng (user.name)
  - Email khách hàng (user.email)
- **Kiểu tìm**: LIKE %search%

#### Lọc trạng thái
- **Dropdown**: Select box với các trạng thái
  - Tất cả trạng thái (mặc định)
  - Hoàn thành
  - Chờ xử lý
  - Đã hủy
- **Action**: Lọc theo status trong database

#### Nút hành động
- 🔍 **Nút Tìm**: Submit form tìm kiếm/lọc
- ✕ **Xóa lọc**: Reset về trạng thái ban đầu (chỉ hiện khi có filter)

---

### 📋 **3. Bảng Đơn Hàng**

#### Cột dữ liệu:
1. **ID Đơn**: #ID từ database
2. **Khách Hàng**: 
   - Tên (từ bảng users)
   - Email (từ bảng users)
3. **Sản Phẩm**: Tên sheet nhạc (từ bảng products)
4. **Số Xu**: Số xu đã chi (coins_spent)
5. **Ngày Mua**: created_at (định dạng: dd/mm/yyyy HH:mm)
6. **Trạng Thái**: 
   - ✅ Hoàn thành (xanh lá)
   - ⏳ Chờ xử lý (vàng)
   - ❌ Đã hủy (đỏ)

#### Tính năng:
- ✅ Hiển thị đầy đủ thông tin đơn hàng
- ✅ Relationship với User và Product
- ✅ Pagination (20 đơn/trang)
- ✅ Responsive design
- ✅ Empty state khi chưa có đơn

---

### 📑 **4. Pagination**

- **Số đơn mỗi trang**: 20
- **Style**: Tailwind pagination
- **Vị trí**: Dưới bảng đơn hàng
- **Tính năng**: Giữ nguyên filter khi chuyển trang

---

## 🔧 **Files đã tạo/sửa**

### 1. **OrderController.php** (MỚI)
```
app/Http/Controllers/OrderController.php
```
- **index()**: Lấy danh sách đơn hàng + thống kê
- **show()**: Xem chi tiết đơn (API endpoint)
- **updateStatus()**: Cập nhật trạng thái (API endpoint)

#### Logic index():
```php
- Lấy request (search, status)
- Query với whereHas() cho tìm kiếm user
- Filter theo status nếu có
- Paginate 20 items
- Tính tổng orders, revenue, completed
- Trả về view với dữ liệu
```

### 2. **routes/web.php** (ĐÃ SỬA)
```php
Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
```

### 3. **orders.blade.php** (ĐÃ SỬA)
- Thêm 3 stat cards thống kê
- Thêm form tìm kiếm & lọc
- Cập nhật bảng đơn hàng với dữ liệu động
- Thêm pagination
- Giữ nguyên tab Nạp xu/Rút xu (chưa triển khai)

---

## 📊 **Queries sử dụng**

### Lấy đơn hàng với filter
```sql
SELECT * FROM purchases
INNER JOIN users ON purchases.user_id = users.id
INNER JOIN products ON purchases.product_id = products.id
WHERE (users.name LIKE '%search%' OR users.email LIKE '%search%')
  AND purchases.status = 'completed'
ORDER BY purchases.created_at DESC
LIMIT 20
```

### Thống kê tổng quan
```sql
-- Tổng đơn hàng
SELECT COUNT(*) FROM purchases

-- Tổng doanh thu
SELECT SUM(coins_spent) FROM purchases WHERE status = 'completed'

-- Đơn hoàn thành
SELECT COUNT(*) FROM purchases WHERE status = 'completed'
```

---

## 🎨 **Giao diện**

### Màu sắc trạng thái:
- **Hoàn thành**: `status-badge status-active` (xanh lá)
- **Chờ xử lý**: `status-badge status-pending` (vàng)
- **Đã hủy**: `status-badge status-inactive` (đỏ)

### Layout:
```
┌─────────────────────────────────────────┐
│  3 Stats Cards (Tổng đơn | Doanh thu | Hoàn thành)
├─────────────────────────────────────────┤
│  [Tiêu đề]     [Search] [Filter] [Tìm]  │
├─────────────────────────────────────────┤
│  [Tab: Đơn hàng | Nạp xu | Rút xu]      │
├─────────────────────────────────────────┤
│  ┌───────────────────────────────────┐  │
│  │     Bảng Đơn Hàng (20 rows)      │  │
│  └───────────────────────────────────┘  │
│  [Pagination: << 1 2 3 >>]              │
└─────────────────────────────────────────┘
```

---

## 🚀 **Tính năng nổi bật**

✅ **Real-time data** từ database
✅ **Tìm kiếm** theo tên/email khách hàng
✅ **Lọc** theo trạng thái đơn hàng
✅ **Pagination** với 20 đơn/trang
✅ **Responsive** cho mobile/tablet
✅ **Stats cards** tổng quan
✅ **Empty state** thân thiện
✅ **Badge** màu sắc theo trạng thái

---

## 📝 **Ghi chú**

### Tab Nạp xu & Rút xu:
- Hiện tại chỉ có giao diện tĩnh
- Chưa có dữ liệu thực từ database
- Có thể triển khai sau khi có bảng transactions

### Mở rộng tương lai:
- [ ] Export đơn hàng ra Excel/CSV
- [ ] Xem chi tiết đơn hàng (modal popup)
- [ ] Cập nhật trạng thái đơn hàng
- [ ] Lọc theo ngày tháng
- [ ] Thống kê biểu đồ doanh thu theo đơn hàng

---

## 🎯 **Kết quả**

✅ Trang đơn hàng hoàn toàn dynamic
✅ Dữ liệu chính xác từ database
✅ Tìm kiếm & lọc hoạt động tốt
✅ Giao diện đẹp, dễ sử dụng
✅ Code sạch, dễ bảo trì
