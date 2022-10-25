<?php
session_start();

if(isset($_SESSION['name'])) {
    include '../connect.php';

    // Chart Data
    $chartType = 'studentlist';
    $query = "SELECT
                department as department,
                COUNT(id) as total
            FROM `sfmu.students`
            GROUP BY department";
    $result = $connect->query($query);

    if($result->num_rows > 0) {
        foreach($result as $data) {
            $department[] = strtoupper($data['department']);
            $total[] = $data['total'];
        }
    }

    // Total Students
    $tquery = "SELECT id FROM `sfmu.students`";
    $tresult = $connect->query($tquery);
    $totalstudents = $tresult->num_rows;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- PWA -->
    <meta property="og:image" content="../assets/icons/icon.png">
	<link rel="shortcut icon" href="../assets/icons/icon-64.png">
	<link rel="manifest" href="../manifest.json">

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/app.css">
</head>

<body>

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
        <button type="button" class="text-reset h2 ms-auto p-3 offcanvas-mobile-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-chevron-double-left"></i></button>


        <!-- OffCanvas Nav -->
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li class="px-3">
                        <a class="nav-link active" href="index.php">
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
                            <a class="nav-link px-3" href="logs.php">
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
    <main class="mt-5 pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 fw-bold fs-3">Dashboard</div>
            </div>
            <!-- Cards -->
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-success h-100 card-stats">
                        <div class="card-body card-total border-5 border-light">
                            <p class="card-text text-center fs-2">Total Students: <span class="fw-bold fs-1"><?= $totalstudents; ?></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mb-4">
                    <div class="card text-dark bg-default h-100">
                        <div class="card-header fw-bold">Students Stats</div>
                        <div class="card-body">
                            <canvas id="studentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>
        $(document).ready(function() {
            // Loader
            let loader = document.getElementById("pre-loader");
            // loader.classList.add("stop");
            setTimeout(() => { loader.classList.add("stop"); }, 500);

            // Main Search
            $("#searchbar-header").keyup(function(){
                let searchdata = $("#searchbar-header").val();
                if(!searchdata) {
                    $("#show-result").html("");
                }
                else {
                    $.ajax({
                        type:'POST',
                        url:'search.php',
                        data:{
                            name:searchdata,
                        },
                        success:function(data){
                            $("#show-result").html(data);
                        }
                    });
                }
            });

            // Stats
            const ctx = document.getElementById('studentChart').getContext('2d');
            const studentChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($department); ?>,
                    datasets: [{
                        label: 'Students',
                        data: <?php echo json_encode($total); ?>,
                        backgroundColor: [
                            'rgba(0, 0, 0, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(0, 0, 0, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                        display: false,
                        },
                    },
                }
            });
        });
        
    </script>
</body>

</html>

<?php } else {
    header("Location: ../index.php");
}

?>