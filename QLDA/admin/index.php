<?php 
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style1.css">
    
    <title>Admin</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i class="fas fa-user-secret me-2"></i>ADMIN</div>
            <div class="list-group list-group-flush my-3">
                <a href="/QLDA/admin" class="list-group-item list-group-item-action bg-transparent second-text fw-bold" id="homeLink"><i
                        class="fas fa-tachometer-alt me-2" ></i>Trang Chủ</a>
                <a href="?page_layout=quan_ly_danh_muc" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-project-diagram me-2"></i>Danh Mục</a>
                <a href="?page_layout=quan_ly_don_hang" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-user me-2"></i>Đơn hàng</a>
                <a href="?page_layout=quan_ly_doanh_thu" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-map-marker me-2"></i>Doanh Thu</a>
                <a href="?page_layout=hay_cho_toi_an" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                        class="fas fa-power-off me-2"></i>Khuongdz</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0"></h2>
                </div>
            </nav>

            <div class="container container-fluid px-4">
                <?php
                    if(isset($_GET['page_layout'])){
                        switch ($_GET['page_layout']) {
                            case 'quan_ly_danh_muc': include_once 'categories.php';
                                break;
                            case 'quan_ly_don_hang': include_once 'orders.php';
                                break;
                            case 'quan_ly_doanh_thu': include_once 'revenue.php';
                                break;
                            case 'hay_cho_toi_an' : include_once 'khuong.php';
                                break;

                            default: include_once 'TrangChu.php';
    
                        }
                    }else{
                        include_once 'TrangChu.php';
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php $conn->close(); ?>