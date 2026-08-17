# 🛒 Dự án Gentech 2026

## 🎯 Nội dung và Mục đích chính

**Gentech** là một hệ thống Website Thương Mại Điện Tử (E-commerce) chuyên kinh doanh và quản lý các sản phẩm, thiết bị công nghệ.

Dự án được xây dựng với 2 mục đích cốt lõi:

1. **Dành cho Khách hàng (Client):** Tạo ra một không gian mua sắm trực tuyến hiện đại, thân thiện. Khách hàng có thể dễ dàng tìm kiếm thiết bị, xem chi tiết, quản lý giỏ hàng và tiến hành đặt hàng một cách tiện lợi.
2. **Dành cho Quản trị viên (Admin):** Cung cấp một hệ thống quản lý tập trung (Dashboard) mạnh mẽ, giúp chủ cửa hàng kiểm soát chặt chẽ Kho hàng (Inventory), Sản phẩm, Đơn hàng, Doanh thu và tệp Khách hàng.

## 🚀 Các tính năng nổi bật

- **Giao diện Khách hàng (Client):**
  - Danh mục sản phẩm công nghệ đa dạng.
  - Hệ thống Giỏ hàng (Cart) linh hoạt (Thêm, bớt, tính tiền).
  - Quy trình thanh toán và đặt hàng.
- **Giao diện Quản trị (Admin):**
  - **Bảng điều khiển (Dashboard):** Tổng hợp và thống kê số liệu kinh doanh.
  - **Quản lý Kho (Inventory):** Kiểm soát số lượng hàng nhập/xuất/tồn kho.
  - Quản lý toàn diện Sản phẩm, Danh mục, Đơn hàng và Người dùng.

## 🔄 Luồng hoạt động chính (User Flow)

Để dễ hình dung cách hệ thống vận hành, dưới đây là luồng hoạt động cơ bản của 2 đối tượng chính:

**1. Luồng mua hàng của Khách hàng (Client Flow):**

- **Bước 1:** Khách truy cập trang chủ, xem danh mục hoặc tìm kiếm sản phẩm công nghệ.
- **Bước 2:** Click xem chi tiết sản phẩm và chọn **Thêm vào giỏ hàng**.
- **Bước 3:** Vào giỏ hàng kiểm tra lại số lượng, giá tiền -> Chuyển sang bước **Thanh toán (Checkout)**.
- **Bước 4:** Điền thông tin người nhận, chốt đơn hàng và theo dõi trạng thái đơn.

**2. Luồng quản trị của Admin (Admin Flow):**

- **Bước 1:** Đăng nhập vào trang Quản trị (Admin Panel).
- **Bước 2 (Xử lý đơn):** Nhận thông báo đơn hàng mới -> Kiểm tra thông tin -> Cập nhật trạng thái đơn hàng (Đã xác nhận, Đang giao hàng, Hoàn thành).
- **Bước 3 (Quản lý kho):** Vào mục **Inventory** để kiểm tra sản phẩm nào sắp hết -> Cập nhật thêm số lượng tồn kho.
- **Bước 4 (Thống kê):** Mở **Dashboard** xem báo cáo tổng quan về doanh thu và số lượng đơn hàng bán ra.

## 💻 Công nghệ sử dụng

- **Ngôn ngữ / Framework:** PHP (kiến trúc MVC - Model View Controller)
- **Giao diện (Frontend):** HTML, CSS, JavaScript (Vanilla)
- **Cơ sở dữ liệu:** MySQL
- **Môi trường Server:** XAMPP / WAMP

## 📂 Cấu trúc dự án (Directory Structure)

```text
Gentech/
├── assets/       # Tài nguyên tĩnh (CSS, JS, hình ảnh)
├── configs/      # Cấu hình dự án (kết nối CSDL trong env.php)
├── controllers/  # Xử lý logic chính (AdminController,...)
├── models/       # Xử lý dữ liệu và truy vấn MySQL
├── routes/       # Nơi định tuyến (Routing) các URL
├── views/        # Giao diện hiển thị (phân chia admin/ và client/)
├── uploads/      # Chứa file ảnh upload của sản phẩm/người dùng
└── index.php     # File gốc để chạy toàn bộ hệ thống
```

## 🛠 Hướng dẫn cài đặt

1. **Clone/Copy:** Đưa thư mục dự án `Gentech` vào thư mục `htdocs` của ứng dụng XAMPP.
2. **Cơ sở dữ liệu:** Mở phpMyAdmin, tạo một Database mới và Import file SQL của dự án vào.
3. **Cấu hình kết nối:** Mở file `configs/env.php` và điền thông tin kết nối DB (Tên DB, User, Pass).
4. **Chạy dự án:** Mở trình duyệt và truy cập `http://localhost/DuanGentech2026/Gentech/`.

---

_Dự án được xây dựng và phát triển trong năm 2026._

Môi trường test của VNPAY
Ngân hàng: NCB
Số thẻ: 9704198526191432198
Tên chủ thẻ: NGUYEN VAN A
Ngày phát hành: 07/15
Mật khẩu OTP: 123456
