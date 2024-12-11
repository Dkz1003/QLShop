<?php
require_once(__DIR__ . "/../connect.php");
if (!isset($_SESSION["Category_session"])) {
    $_SESSION["Category_session"] = "";
}

$MaSanPham = $_GET["MaSanPham"];
$sql1 = "SELECT * FROM sanpham WHERE MaSanPham=$MaSanPham";
$rs1 = $conn->query($sql1);
$row1 = $rs1->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sửa Sản Phẩm</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <h1 class="container text-primary text-center">Chỉnh Sửa Sản Phẩm</h1>
    <div class="row">
        <div class="col-sm-10"></div>
        <a href="/QLDA/admin/?page_layout=quan_ly_danh_muc" class="col-sm-1 btn btn-secondary">Trở Về</a>
    </div>
    <form method="post" action="/../QLDA/controller/categories_action.php?action=edit&MaSanPham=<?php echo $MaSanPham ?>" class="container container-fluid">
        <div class="mb-3">
            <label for="TenSanPham" class="form-label">Tên Sản Phẩm</label>
            <input type="text" class="form-control" id="TenSanPham" name="TenSanPham" value="<?php echo $row1["TenSanPham"]; ?>" required>
        </div>
        <div class="mb-3">
            <label for="LoaiHang" class="form-label">Loại Hàng</label>
            <input type="text" class="form-control" id="LoaiHang" name="LoaiHang" value="<?php echo $row1["LoaiHang"]; ?>" required>
        </div>
        <div class="mb-3">
            <label for="SoLuong" class="form-label">Số Lượng</label>
            <input type="number" class="form-control" id="SoLuong" name="SoLuong" value="<?php echo $row1["SoLuong"]; ?>" required>
        </div>
        <div class="mb-3">
            <label for="GiaNhap" class="form-label">Giá Nhập</label>
            <input type="number" class="form-control" id="GiaNhap" name="GiaNhap" value="<?php echo $row1["GiaNhap"]; ?>" required>
        </div>
        <div class="mb-3">
            <label for="GiaBan" class="form-label">Giá Bán</label>
            <input type="number" class="form-control" id="GiaBan" name="GiaBan" value="<?php echo $row1["GiaBan"]; ?>" required>
        </div>
        <div class="row">
            <div class="col-11"></div>
            <button type="submit" class="btn btn-primary col-1">Sửa</button>
        </div>
    </form>
</body>

</html>
