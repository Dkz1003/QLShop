<?php
require_once(__DIR__ . "/../connect.php");
session_start();

$action = $_GET['action'] ?? '';

if ($action === 'add') {
    $MaSanPham = $_GET['MaSanPham'];
    $TenSanPham = $_POST['TenSanPham'];
    $LoaiHang = $_POST['LoaiHang'];
    $SoLuong = $_POST['SoLuong'];
    $GiaNhap = $_POST['GiaNhap'];
    $GiaBan = $_POST['GiaBan'];

    // Xử lý upload hình ảnh mới (nếu có)
    $HinhAnh = $product['HinhAnh']; // Giữ hình ảnh cũ nếu không thay đổi
    if (isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['error'] === UPLOAD_ERR_OK) {
        $HinhAnh = "../image/" . basename($_FILES['HinhAnh']['name']);
        move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $HinhAnh);
    }

    // Câu lệnh SQL để thêm sản phẩm
    $sql = "INSERT INTO sanpham (TenSanPham, LoaiHang, SoLuong, GiaNhap, GiaBan, HinhAnh) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssidds", $TenSanPham, $LoaiHang, $SoLuong, $GiaNhap, $GiaBan, $HinhAnh);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        $_SESSION["Category_session"] = "<div class=\"container container-fluid alert alert-success\" role=\"alert\">Thêm Sản Phẩm Thành Công</div>";
    } else {
        $_SESSION["Category_session"] = "<div class=\"container container-fluid alert alert-warning\" role=\"alert\">Lỗi Khi Thêm</div>";
    }
    header("Location: ../admin/?page_layout=quan_ly_danh_muc");  // Quay về danh mục
    exit();

} elseif ($action === 'remove') {
    $MaSanPham = $_GET['MaSanPham'];

    // Câu lệnh SQL để xóa sản phẩm
    $sql = "DELETE FROM sanpham WHERE MaSanPham = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $MaSanPham);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        $_SESSION["Category_session"] = "<div class=\"container container-fluid alert alert-success\" role=\"alert\">Xóa Thành Công</div>";
    } else {
        $_SESSION["Category_session"] = "<div class=\"container container-fluid alert alert-warning\" role=\"alert\">Lỗi Khi Xóa</div>";
    }
    header("Location: ../admin/?page_layout=quan_ly_danh_muc");  // Quay về danh mục
    exit();

}elseif ($action === 'edit') {
    $MaSanPham = $_GET['MaSanPham'];
    $TenSanPham = $_POST['TenSanPham'];
    $LoaiHang = $_POST['LoaiHang'];
    $SoLuong = $_POST['SoLuong'];
    $GiaNhap = $_POST['GiaNhap'];
    $GiaBan = $_POST['GiaBan'];

    // Xử lý upload hình ảnh mới (nếu có)
    $HinhAnh = $product['HinhAnh']; // Giữ hình ảnh cũ nếu không thay đổi
    if (isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['error'] === UPLOAD_ERR_OK) {
        $HinhAnh = "../image/" . basename($_FILES['HinhAnh']['name']);
        move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $HinhAnh);
    }

    $sql = "UPDATE sanpham 
            SET TenSanPham='$TenSanPham', LoaiHang='$LoaiHang', SoLuong=$SoLuong, GiaNhap=$GiaNhap, GiaBan=$GiaBan, HinhAnh='$HinhAnh' 
            WHERE MaSanPham=$MaSanPham";
    if ($conn->query($sql)) {
        $_SESSION["Category_session"] = "Sản phẩm đã được sửa thành công.";
    } else {
        $_SESSION["Category_session"] = "Lỗi khi sửa sản phẩm.";
    }
    header("Location: /QLDA/admin/?page_layout=quan_ly_danh_muc");
    exit();
}
?>
