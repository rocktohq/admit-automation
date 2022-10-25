<?php
session_start();

if(isset($_SESSION['name'])) {
    include '../connect.php';


    if(isset($_POST['clear'])) {
        $query = "TRUNCATE TABLE `sfmu.logs`";
        $connect->query($query);
    }
    // Now Fetch Data form LOGS
    $sql = "SELECT * FROM `sfmu.logs`";
    $result = $connect->query($sql);
    
    
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Records</title>

    <!-- PWA -->
    <meta property="og:image" content="../assets/icons/icon.png">
	<link rel="shortcut icon" href="../assets/icons/icon-64.png">
	<link rel="manifest" href="../manifest.json">

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/app.css">

    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
</head>

<body>

    <!-- Navbar -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">

            <!-- OffCanvas Trigger -->
            <button class="navbar-toggler me-2 border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><span class="me-1 h3"><i class="bi bi-sliders2"></i></span></button>
            <!-- OffCanvas Trigger -->

            <a class="navbar-brand fw-bold text-uppercase me-auto" href="#">Admit Management</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="h3">
                <i class="bi bi-list"></i>
            </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Search -->
                <form class="d-flex ms-auto">
                    <div class="input-group my-3 my-lg-0">
                        <input type="text" id="searchbar-header" class="form-control" placeholder="" aria-label="" aria-describedby="button-addon2">
                        <button class="btn btn-primary" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
                        <div id="show-result"></div>
                    </div>
                </form>
                <!-- Search -->

                <!-- Profile Options -->
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-fill"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><span class="ms-3">User: </sapn><span class="text-danger fw-bold"><?php echo strtoupper($_SESSION['name']); ?></span></li>
                            <li><a class="dropdown-item" href="#">Admin Dashboard</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-end" href="../logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- Profile Options -->

            </div>
        </div>
    </nav>
    <!-- Navbar -->

    <!-- OffCanvas -->
    <div class="offcanvas offcanvas-start bg-dark text-white sidebar-nav" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <button type="button" class="text-reset h3 ms-auto p-3 offcanvas-mobile-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-chevron-double-left"></i></button>


        <!-- OffCanvas Nav -->
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li class="px-3">
                        <a class="nav-link" href="index.php">
                            <span class="me-2">
                                <i class="bi bi-speedometer2"></i>
                            </span>
                            <span>
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <li class="my-2">
                        <hr class="dropdown-divider">
                    </li>
                    <?php
                        if($_SESSION["role"] == 1) {
                    ?>
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3">
                            Management
                        </div>
                    </li>
                    <li>
                        <li>
                            <a class="nav-link px-3" href="admins.php">
                                <span class="me-2"><i class="bi bi-arrow-bar-right"></i></span>
                                <span>Administrators</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link px-3" href="students.php">
                                <span class="me-2"><i class="bi bi-arrow-bar-right"></i></span>
                                <span>Students</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link px-3" href="departments.php">
                                <span class="me-2"><i class="bi bi-arrow-bar-right"></i></span>
                                <span>Departments</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link px-3" href="courses.php">
                                <span class="me-2"><i class="bi bi-arrow-bar-right"></i></span>
                                <span>Courses</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link px-3 active" href="logs.php">
                                <span class="me-2"><i class="bi bi-arrow-bar-right"></i></span>
                                <span>Logs</span>
                            </a>
                        </li>       
                    </li>
                    <li class="my-2">
                        <hr class="dropdown-divider">
                    </li>
                    <?php } ?>
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3">
                            Services
                        </div>
                    </li>
                    <li>
                        <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#admitCollapse" role="button" aria-expanded="false" aria-controls="admitCollapse">
                            <span class="me-2"><i class="bi bi-arrow-right-square"></i></span>
                            <span>Export Admit Card</span>
                            <span class="right-icon ms-auto"><i class="bi bi-chevron-down"></i></span>
                        </a>
                        <div class="collapse" id="admitCollapse">
                            <div>
                                <ul class="navbar-nav px-3">
                                    <li>
                                        <a class="nav-link px-3" href="../pdf/mass.php">
                                            <span class="me-2"><i class="bi bi-arrow-bar-right"></i></span>
                                            <span>Bulk Export</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link px-3" href="../pdf/single.php">
                                            <span class="me-2"><i class="bi bi-arrow-bar-right"></i></span>
                                            <span>Individual Export</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- OffCanvas Nav -->

    </div>
    <!-- OffCanvas -->

    <!-- Main Contents -->
    <!-- Logs Table -->
    <main class="mt-5 pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 fw-bold fs-3">Admin Login Records</div>
                <section class="mt-2 px-2">
                    <div class="d-flex justify-content-start mb-4">
                        <form action="" method="post">
                            <button class="btn btn-primary" Type="submit" name="clear">Clear Logs</button>
                        </form>
                    </div>
                    <div id="table_inputs"></div>
                </section>
                <?php if(!$result->num_rows > 0) {
                        echo '<div class="mt-5 text-center h1"> No logs found!</div>';
                    } else {    ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered cursor-pointer col-sm-12">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>User Name</th>
                                <th>Department Name</th>
                                <th>Login Time</th>
                                <th>Logout Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                while($row = $result->fetch_assoc()) {

                                    $logintime = date_create($row['login_time']);
                                    $logintime = date_format($logintime, "d M, Y - h:i A");

                                    if($row['logout_time'] > 0) {
                                        $logout = date_create($row['logout_time']);
                                        $logout = date_format($logout, "d M, Y - h:i A");
                                    } else {
                                        $logout = "Active Now";
                                    }
                            ?>
                            <tr class="text-center">
                                <td class="py-3"><?php echo $i; $i++;?></td>
                                <td class="py-3 fw-bold"><?php echo strtoupper($row['user_name']); ?></td>
                                <td class="py-3"><?php echo strtoupper($row['department']); ?></td>
                                <td class="py-3"><?php echo $logintime; ?></td>
                                <td class="py-3"><span><?php echo $logout; ?></span></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
            </div>
        </div>
    </main>
    <!-- Logs Table -->
    <!-- Main Contents -->

    <!-- Footer -->
    <?php echo $devText; ?>
    <!-- Footer -->

    <!-- Loader -->
    <div id="pre-loader">
        <div class="loader"></div>
        <div class="loader-text">LOADING</div>
    </div>
    <!-- Loader -->

    <!-- JavaScripts -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Loader
            let loader = document.getElementById("pre-loader");
            // loader.classList.add("stop");
            setTimeout(() => { loader.classList.add("stop"); }, 500);

            $(".toast").toast('show');
        });
        
    </script>
</body>

</html>
<?php } else {
    header("Location: ../index.php");
}

?>