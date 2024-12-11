<?php 
    require_once(__DIR__ . "/../connect.php");
    session_start();

    // Tổng sản phẩm
    $sql = "SELECT COUNT(*) as sum FROM SanPham";
    $result = $conn->query($sql) or die("Can't get recordset");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $sum_products = $row['sum'];
    }

    // Tổng đơn hàng
    $sql = "SELECT COUNT(*) as sum FROM Orders";
    $result = $conn->query($sql) or die("Can't get recordset");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $sum_orders = $row['sum'];
    }

    // Tổng doanh thu
    $sql = "SELECT SUM(TongDoanhThu) as sum FROM DoanhThu";
    $result = $conn->query($sql) or die("Can't get recordset");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $sum_revenue = $row['sum'];
    }

    // Tổng danh mục
    $sql = "SELECT COUNT(loaihang) as sum FROM sanpham";
    $result = $conn->query($sql) or die("Can't get recordset");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $sum_categories = $row['sum'];
    }
?>

<div class="row g-3 my-2">
    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <h3 class="fs-2">
                    <?php echo $sum_products; ?>
                </h3>
                <p class="fs-5">Products</p>
            </div>
            <i class="fas fa-box fs-1 primary-text border rounded-full secondary-bg p-3"></i>
        </div>
    </div>

    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <h3 class="fs-2">
                    <?php echo $sum_orders; ?>
                </h3>
                <p class="fs-5">Orders</p>
            </div>
            <i class="fas fa-shopping-cart fs-1 primary-text border rounded-full secondary-bg p-3"></i>
        </div>
    </div>

    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <h3 class="fs-2">
                    <?php echo number_format($sum_revenue, 0, ',', '.'); ?>
                </h3>
                <p class="fs-5">Revenue</p>
            </div>
            <i class="fas fa-dollar-sign fs-1 primary-text border rounded-full secondary-bg p-3"></i>
        </div>
    </div>

    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <h3 class="fs-2">
                    <?php echo $sum_categories; ?>
                </h3>
                <p class="fs-5">Categories</p>
            </div>
            <i class="fas fa-tags fs-1 primary-text border rounded-full secondary-bg p-3"></i>
        </div>
    </div>
</div>
<?php $_SESSION["products_session"] = ""; ?>
