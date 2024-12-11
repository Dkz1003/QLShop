<?php
require_once(__DIR__ . "/../connect.php");
session_start();
if (!isset($_SESSION["Category_session"])) {
    $_SESSION["Category_session"] = "";
}

// Kiểm tra nếu form tìm kiếm được gửi
$searchTermName = $_POST['searchName'] ?? ''; // Tìm kiếm theo tên sản phẩm
$searchTermCategory = $_POST['searchCategory'] ?? ''; // Tìm kiếm theo loại hàng

// Chuẩn bị câu truy vấn tìm kiếm với điều kiện cả tên sản phẩm và loại hàng
$sql = "SELECT * FROM sanpham WHERE TenSanPham LIKE ? AND LoaiHang LIKE ? ORDER BY TenSanPham";
$stmt = $conn->prepare($sql);
$searchKeywordName = "%$searchTermName%";
$searchKeywordCategory = "%$searchTermCategory%";
$stmt->bind_param("ss", $searchKeywordName, $searchKeywordCategory);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style1.css" />
    <title>Admin</title>
</head>

<body>
    <div class="container-fluid px-4">
        <div class="row my-1">
            <h3 class="fs-4 mb-3">Danh Mục Sản Phẩm</h3>
            <div class="col">
                <!-- Form Tìm Kiếm -->
                <form method="post" action="">
                    <div class="mb-3 d-flex">
                        <input type="text" class="form-control" name="searchName" value="<?php echo htmlspecialchars($searchTermName); ?>" placeholder="Tìm kiếm theo tên sản phẩm..." />
                        <input type="text" class="form-control ms-2" name="searchCategory" value="<?php echo htmlspecialchars($searchTermCategory); ?>" placeholder="Tìm kiếm theo loại hàng..." />
                        <button type="submit" class="btn btn-primary ms-2">Tìm kiếm</button>
                    </div>
                </form>

                <!-- Thông báo Session -->
                <alert class="container container-fluid"><?php echo $_SESSION["Category_session"]; ?></alert>

                <!-- Bảng danh sách sản phẩm -->
                <table class="container container-fluid table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tên Sản Phẩm</th>
                            <th scope="col">Loại Hàng</th>
                            <th scope="col">Số Lượng</th>
                            <th scope="col">Giá Nhập</th>
                            <th scope="col">Giá Bán</th>
                            <th scope="col">Hình Ảnh</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $row["MaSanPham"]; ?></th>
                                <td><?php echo $row["TenSanPham"]; ?></td>
                                <td><?php echo $row["LoaiHang"]; ?></td>
                                <td><?php echo $row["SoLuong"]; ?></td>
                                <td><?php echo number_format($row["GiaNhap"], 0, ',', '.'); ?></td>
                                <td><?php echo number_format($row["GiaBan"], 0, ',', '.'); ?></td>
                                <td><img src="<?php echo $row["HinhAnh"]; ?>" alt="Hình ảnh" style="width:50px;height:50px;"></td>
                                <td><a href="product_edit.php?MaSanPham=<?php echo $row['MaSanPham']; ?>" class="btn btn-primary">Sửa</a></td>
                                <td><a href="/../QLDA/controller/product_action.php?action=remove&MaSanPham=<?php echo $row["MaSanPham"]; ?>" id="deleteBtn" class="btn btn-danger" onclick="confirmDelete()">Xóa</a></td>
                            </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>Không có sản phẩm nào tìm thấy.</td></tr>";
                        }
                        ?>
                        <tr>
                            <form method="post" action="/../QLDA/controller/categories_action.php?action=add" onsubmit="return validateForm()" enctype="multipart/form-data">
                                <th scope="row"></th>
                                <td><input type="text" class="form-control" id="TenSanPham" name="TenSanPham" placeholder="Tên Sản Phẩm"></td>
                                <td><input type="text" class="form-control" id="LoaiHang" name="LoaiHang" placeholder="Loại Hàng"></td>
                                <td><input type="number" class="form-control" id="SoLuong" name="SoLuong" placeholder="Số Lượng"></td>
                                <td><input type="number" class="form-control" id="GiaNhap" name="GiaNhap" placeholder="Giá Nhập"></td>
                                <td><input type="number" class="form-control" id="GiaBan" name="GiaBan" placeholder="Giá Bán"></td>
                                <td><input type="file" class="form-control" id="HinhAnh" name="HinhAnh"></td>
                                <td><button type="submit" id="addBtn" class="btn btn-success">Thêm</button></td>
                            </form>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete() {
            return confirm("Bạn có chắc muốn xóa?");
        }

        function validateForm() {
            // Validate form inputs here
            return true;
        }
    </script>
</body>

</html>

<?php 
$_SESSION["Category_session"] = "";
?>
