# PURE E-commerce — Laravel 12 (Premium Edition)

## Yêu cầu
- PHP 8.2+ (khuyến nghị PHP 8.3), Composer 2
- MySQL 8+, Node.js LTS + npm
- VS Code + extension PHP Intelephense (khuyến nghị)

## Cài đặt trên Windows / VS Code
1. Giải nén ZIP, mở đúng thư mục `PURE_Ecommerce_Source` trong VS Code.
2. Mở Terminal → New Terminal. Kiểm tra `php -v`, `composer -V`, `node -v`, `npm -v`.
3. Chạy `composer install`.
4. Sao chép cấu hình: PowerShell `Copy-Item .env.example .env`.
5. Tạo database trong MySQL/phpMyAdmin: `CREATE DATABASE pure_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`
6. Mở `.env`, cấu hình `DB_DATABASE=pure_db`, `DB_USERNAME`, `DB_PASSWORD`. Giữ `SESSION_DRIVER=file`, `CACHE_STORE=file`, `QUEUE_CONNECTION=sync` cho bản local.
7. Chạy `php artisan key:generate`.
8. Chạy `php artisan migrate:fresh --seed` (xóa và tạo lại các bảng; chỉ dùng khi chưa có dữ liệu cần giữ). Nếu cần giữ dữ liệu, dùng `php artisan migrate --seed`.
9. Chạy `npm install` rồi `npm run build` để tạo `public/build/manifest.json`.
10. Chạy `php artisan optimize:clear`, sau đó `php artisan serve`. Mở `http://127.0.0.1:8000`.

## Tài khoản quản trị demo
- Email: `admin@pure.vn`
- Mật khẩu: `Pure@12345`
- Đổi mật khẩu ngay khi triển khai thật.

## Chức năng
- Cửa hàng: trang chủ, danh mục, tìm kiếm, lọc giá, chi tiết, giỏ hàng.
- Thành viên: đăng ký/đăng nhập, hồ sơ, đơn hàng, wishlist, đánh giá (chỉ khách đã nhận hàng; chờ duyệt).
- Checkout: mã `PURE10`, phí ship 30.000đ dưới 500.000đ, miễn phí từ 500.000đ; COD/VNPay/MoMo.
- Admin: dashboard, sản phẩm, danh mục, đơn hàng, khách hàng, mã giảm giá, báo cáo.

## Cấu hình VNPay sandbox
Điền `VNPay_TmnCode`, `VNPay_HashSecret` và URL sandbox trong `.env`. Cần đăng ký merchant sandbox với VNPay và cấu hình Return URL phù hợp.

## Cấu hình MoMo sandbox
Điền `MOMO_PARTNER_CODE`, `MOMO_ACCESS_KEY`, `MOMO_SECRET_KEY`, `MOMO_ENDPOINT`. URL IPN phải truy cập được từ Internet (localhost không nhận IPN trực tiếp); dùng tunnel HTTPS trong môi trường thử nghiệm.

**Lưu ý thanh toán:** Không bật production chỉ bằng cách đổi endpoint. Hãy dùng đúng thông tin merchant, HTTPS, kiểm thử chữ ký/IPN, đối soát giao dịch và xác minh trạng thái qua kênh server-to-server theo tài liệu merchant hiện hành. Đơn hàng không được tự đánh dấu đã thanh toán khi thiếu chữ ký hợp lệ.

## Lỗi thường gặp
- `Vite manifest not found`: chạy `npm install` và `npm run build`.
- `Table cache doesn't exist`: giữ `CACHE_STORE=file`; chạy `php artisan optimize:clear`.
- `Connection refused`: server chưa chạy; mở terminal tại thư mục dự án và chạy `php artisan serve`.
- `Unknown column`: chạy `php artisan migrate:fresh --seed` nếu đây là database thử nghiệm và có thể xóa dữ liệu.
