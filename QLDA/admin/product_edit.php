<?php
require_once(__DIR__ . "/../connect.php");
session_start();

// Lấy mã sản phẩm từ URL
$MaSanPham = $_GET["MaSanPham"] ?? null;
if (!$MaSanPham) {
    header("Location: /QLDA/admin/?page_layout=quan_ly_danh_muc");
    exit();
}

// Lấy thông tin sản phẩm từ cơ sở dữ liệu
$sql = "SELECT * FROM sanpham WHERE MaSanPham = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $MaSanPham);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    // Nếu không tìm thấy sản phẩm, chuyển hướng về danh mục
    header("Location: /QLDA/admin/?page_layout=quan_ly_danh_muc");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Chỉnh Sửa Sản Phẩm</h2>
        <form method="post" action="/QLDA/controller/categories_action.php?action=edit&MaSanPham=<?php echo $product['MaSanPham']; ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="TenSanPham" class="form-label">Tên Sản Phẩm</label>
                <input type="text" class="form-control" id="TenSanPham" name="TenSanPham" value="<?php echo htmlspecialchars($product['TenSanPham']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="LoaiHang" class="form-label">Loại Hàng</label>
                <input type="text" class="form-control" id="LoaiHang" name="LoaiHang" value="<?php echo htmlspecialchars($product['LoaiHang']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="SoLuong" class="form-label">Số Lượng</label>
                <input type="number" class="form-control" id="SoLuong" name="SoLuong" value="<?php echo $product['SoLuong']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="GiaNhap" class="form-label">Giá Nhập</label>
                <input type="number" class="form-control" id="GiaNhap" name="GiaNhap" value="<?php echo $product['GiaNhap']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="GiaBan" class="form-label">Giá Bán</label>
                <input type="number" class="form-control" id="GiaBan" name="GiaBan" value="<?php echo $product['GiaBan']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="HinhAnh" class="form-label">Hình Ảnh</label>
                <input type="file" class="form-control" id="HinhAnh" name="HinhAnh">
                <img src="<?php echo $product['HinhAnh']; ?>" alt="Current Image" style="width: 100px; margin-top: 10px;">
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Sửa</button>
                <a href="/QLDA/admin/?page_layout=quan_ly_danh_muc" class="btn btn-secondary">Trở Về</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
