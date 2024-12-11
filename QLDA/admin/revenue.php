<?php
require_once(__DIR__ . "/../connect.php");
session_start();

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

// Khởi tạo các biến
$filter = '';
$viewType = '';
$data = [];

// Xử lý lọc doanh thu
if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
    $viewType = isset($_POST['view_type']) ? $_POST['view_type'] : '';

    if ($filter == 'date') {
        // Truy vấn doanh thu theo ngày
        $sql = "SELECT NgayDatHang, SUM(TongTien) AS TotalRevenue 
                FROM orders 
                GROUP BY NgayDatHang";
        $result = $conn->query($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
    } elseif ($filter == 'category') {
        // Truy vấn doanh thu theo loại hàng
        $sql = "SELECT sanpham.LoaiHang, SUM(order_details.SoLuong * sanpham.GiaBan) AS TotalRevenue 
                FROM order_details 
                JOIN sanpham ON order_details.MaSanPham = sanpham.MaSanPham 
                GROUP BY sanpham.LoaiHang";
        $result = $conn->query($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Doanh Thu</title>
</head>
<body>
    <div class="container mt-4">
        <h3>Quản Lý Doanh Thu</h3>

        <!-- Form chọn loại lọc -->
        <form method="post" class="mb-4">
            <div class="d-flex align-items-center">
                <div class="form-group me-3">
                    <label for="filter" class="form-label">Lọc Doanh Thu Theo:</label>
                    <select id="filter" name="filter" class="form-control">
                        <option value="date" <?php echo $filter == 'date' ? 'selected' : ''; ?>>Ngày</option>
                        <option value="category" <?php echo $filter == 'category' ? 'selected' : ''; ?>>Loại Hàng</option>
                    </select>
                </div>
                <div class="form-group me-3">
                    <label for="view_type" class="form-label">Hiển Thị Dạng:</label>
                    <select id="view_type" name="view_type" class="form-control">
                        <option value="table" <?php echo $viewType == 'table' ? 'selected' : ''; ?>>Bảng</option>
                        <option value="chart" <?php echo $viewType == 'chart' ? 'selected' : ''; ?>>Biểu đồ</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Xác Nhận</button>
            </div>
        </form>

        <!-- Hiển thị dữ liệu -->
        <?php if (!empty($data)): ?>
            <?php if ($viewType == 'table'): ?>
                <!-- Hiển thị bảng -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th><?php echo $filter == 'date' ? 'Ngày' : 'Loại Hàng'; ?></th>
                            <th>Doanh Thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $stt = 1; ?>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?php echo $stt++; ?></td>
                                <td><?php echo $filter == 'date' ? $row['NgayDatHang'] : $row['LoaiHang']; ?></td>
                                <td><?php echo number_format($row['TotalRevenue'], 2, ',', '.'); ?> VND</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif ($viewType == 'chart'): ?>
                <!-- Hiển thị biểu đồ -->
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
                <script>
                    const ctx = document.getElementById('revenueChart').getContext('2d');
                    const revenueChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?php echo json_encode(array_column($data, $filter == 'date' ? 'NgayDatHang' : 'LoaiHang')); ?>,
                            datasets: [{
                                label: 'Doanh Thu',
                                data: <?php echo json_encode(array_column($data, 'TotalRevenue')); ?>,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            <?php endif; ?>
        <?php else: ?>
            <p class="text-center">Không có dữ liệu để hiển thị</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
