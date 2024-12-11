<?php
require_once(__DIR__ . '/../connect.php');
session_start();

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

// Xử lý tìm kiếm sản phẩm
$search = isset($_POST['search']) ? $_POST['search'] : '';
$searchSql = '';
if ($search) {
    $searchSql = "WHERE TenSanPham LIKE '%$search%' OR LoaiHang LIKE '%$search%' ";  // Tìm kiếm tên sản phẩm
}

// Lấy danh sách sản phẩm
$sql = "SELECT MaSanPham, TenSanPham, HinhAnh, GiaBan, SoLuong FROM sanpham $searchSql";
$result = $conn->query($sql);
$products = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}


// Xử lý đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order'])) {
        $orderItems = $_POST['order']; // Lấy dữ liệu sản phẩm đặt hàng

        if (!empty($orderItems)) {
            // Tạo một đơn hàng mới
            $today = date('Y-m-d');
            $stmt = $conn->prepare("INSERT INTO orders (NgayDatHang, TongTien, TrangThai) VALUES (?, ?, ?)");
            $status = 'Pending'; // Mặc định là 'Pending'
            $totalPrice = 0;
            $stmt->bind_param("sds", $today, $totalPrice, $status);
            $stmt->execute();
            $orderId = $stmt->insert_id; // Lấy mã đơn hàng vừa tạo

            // Lưu chi tiết đơn hàng và trừ số lượng sản phẩm
            foreach ($orderItems as $productId => $quantity) {
                if ($quantity > 0) {
                    // Lấy thông tin sản phẩm để tính tổng tiền
                    $stmt = $conn->prepare("SELECT GiaBan, SoLuong FROM sanpham WHERE MaSanPham = ?");
                    $stmt->bind_param("i", $productId);
                    $stmt->execute();
                    $product = $stmt->get_result()->fetch_assoc();
                    $price = $product['GiaBan'];
                    $stock = $product['SoLuong'];

                    // Kiểm tra và trừ số lượng
                    if ($stock >= $quantity) {
                        $totalPrice += $price * $quantity;

                        // Cập nhật lại số lượng sản phẩm trong kho
                        $stmt = $conn->prepare("UPDATE sanpham SET SoLuong = SoLuong - ? WHERE MaSanPham = ?");
                        $stmt->bind_param("ii", $quantity, $productId);
                        $stmt->execute();

                        // Thêm vào bảng order_details
                        $stmt = $conn->prepare("INSERT INTO order_details (MaDonHang, MaSanPham, SoLuong) VALUES (?, ?, ?)");
                        $stmt->bind_param("iii", $orderId, $productId, $quantity);
                        $stmt->execute();
                    } else {
                        echo "<div class='alert alert-danger'>Không đủ số lượng cho sản phẩm: " . $product['TenSanPham'] . "</div>";
                    }
                }
            }

            // Cập nhật tổng tiền cho đơn hàng
            $stmt = $conn->prepare("UPDATE orders SET TongTien = ? WHERE MaDonHang = ?");
            $stmt->bind_param("di", $totalPrice, $orderId);
            $stmt->execute();

            echo "<div class='alert alert-success'>Đặt hàng thành công! Mã đơn hàng: $orderId</div>";
        } else {
            echo "<div class='alert alert-danger'>Vui lòng chọn ít nhất một sản phẩm để đặt hàng.</div>";
        }
    } elseif (isset($_POST['confirmOrder'])) {
        // Xác nhận đơn hàng
        $orderId = $_POST['orderId'];
        $stmt = $conn->prepare("UPDATE orders SET TrangThai = 'Confirmed' WHERE MaDonHang = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();

        // Cập nhật doanh thu ngay khi xác nhận
        $stmt = $conn->prepare("SELECT TongTien FROM orders WHERE MaDonHang = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $totalPrice = $result['TongTien'];

        // Thêm doanh thu vào bảng doanhthu
        $stmt = $conn->prepare("INSERT INTO doanhthu (Ngay, TongDoanhThu) VALUES (?, ?)");
        $stmt->bind_param("sd", $today, $totalPrice);
        $stmt->execute();

        echo "<div class='alert alert-success'>Đơn hàng #$orderId đã được xác nhận và doanh thu đã được cập nhật.</div>";
    } elseif (isset($_POST['deleteOrder'])) {
        // Xóa đơn hàng
        $orderId = $_POST['orderId'];

        // Kiểm tra trạng thái đơn hàng
        $stmt = $conn->prepare("SELECT TongTien, TrangThai FROM orders WHERE MaDonHang = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $totalPrice = $result['TongTien'];
        $status = $result['TrangThai'];

        // Nếu đã xác nhận, trừ doanh thu
        if ($status === 'Confirmed') {
            $stmt = $conn->prepare("UPDATE doanhthu SET TongDoanhThu = TongDoanhThu - ? WHERE Ngay = ?");
            $stmt->bind_param("ds", $totalPrice, $today);
            $stmt->execute();
        }

        // Lấy chi tiết đơn hàng để trả lại số lượng sản phẩm
        $stmt = $conn->prepare("SELECT MaSanPham, SoLuong FROM order_details WHERE MaDonHang = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $orderDetails = $stmt->get_result();

        while ($orderDetail = $orderDetails->fetch_assoc()) {
            $productId = $orderDetail['MaSanPham'];
            $quantity = $orderDetail['SoLuong'];

            // Trả lại số lượng sản phẩm vào kho
            $stmt = $conn->prepare("UPDATE sanpham SET SoLuong = SoLuong + ? WHERE MaSanPham = ?");
            $stmt->bind_param("ii", $quantity, $productId);
            $stmt->execute();
        }

        // Xóa chi tiết đơn hàng và đơn hàng
        $stmt = $conn->prepare("DELETE FROM order_details WHERE MaDonHang = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM orders WHERE MaDonHang = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();

        echo "<div class='alert alert-success'>Đơn hàng #$orderId đã được xóa và số lượng sản phẩm đã được phục hồi.</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style1.css">
    <style>
        .card img {
            height: 150px;
            object-fit: cover;
        }
        /* Thiết lập chiều cao cố định cho tất cả các sản phẩm */
        .product-card {
            height: 100%;
        }

        /* Đảm bảo card có chiều cao bằng nhau */
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        /* Điều chỉnh form group để chiếm hết không gian còn lại */
        .form-group {
            margin-top: auto;
        }

        /* Đặt style cho thanh tìm kiếm */
        .search-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 300px;
        }
    </style>
    <title>Đặt Hàng</title>
</head>
<body>
<div class="container mt-4">
    <h3>Đặt Hàng</h3>

    <!-- Tìm kiếm -->
    <div class="search-bar">
        <form method="POST" class="d-flex" action="">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm đơn hàng..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-outline-secondary ms-2">Tìm</button>
        </form>
    </div>

    <form method="post">
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card product-card">
                        <img src="<?php echo $product['HinhAnh']; ?>" class="card-img-top" alt="<?php echo $product['TenSanPham']; ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $product['TenSanPham']; ?></h5>
                            <p class="card-text">Giá: <?php echo number_format($product['GiaBan'], 2, ',', '.'); ?> VND</p>
                            <div class="form-group flex-grow-1">
                                <label for="quantity_<?php echo $product['MaSanPham']; ?>">Số lượng:</label>
                                <input type="number" class="form-control" name="order[<?php echo $product['MaSanPham']; ?>]" id="quantity_<?php echo $product['MaSanPham']; ?>" min="0" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn btn-primary">Đặt Hàng</button>
    </form>

    <h4 class="mt-5">Danh Sách Đơn Hàng</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th scope="col">Mã Đơn Hàng</th>
                <th scope="col">Ngày Đặt Hàng</th>
                <th scope="col">Tổng Tiền</th>
                <th scope="col">Trạng Thái</th>
                <th scope="col">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $orderSql = "SELECT * FROM orders";
            $orders = $conn->query($orderSql);
            while ($order = $orders->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $order['MaDonHang']; ?></td>
                    <td><?php echo $order['NgayDatHang']; ?></td>
                    <td><?php echo number_format($order['TongTien'], 2, ',', '.'); ?> VND</td>
                    <td><?php echo $order['TrangThai']; ?></td>
                    <td>
                        <?php if ($order['TrangThai'] == 'Pending') : ?>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="orderId" value="<?php echo $order['MaDonHang']; ?>" />
                                <button type="submit" class="btn btn-primary" name="confirmOrder">Xác Nhận</button>
                            </form>
                        <?php endif; ?>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="orderId" value="<?php echo $order['MaDonHang']; ?>" />
                            <button type="submit" class="btn btn-danger" name="deleteOrder">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
