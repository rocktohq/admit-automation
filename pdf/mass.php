<?php
include '../connect.php';
session_start();

if(isset($_SESSION['name'])) {
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Admit Export</title>

    <!-- PWA -->
    <meta property="og:image" content="../assets/icons/icon.png">
	<link rel="shortcut icon" href="../assets/icons/icon-64.png">
	<link rel="manifest" href="../manifest.json">

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <!-- CSS Files -->
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
        <button type="button" class="text-reset h2 ms-auto p-3 offcanvas-mobile-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-chevron-double-left"></i></button>

        <!-- OffCanvas Nav -->
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li class="px-3">
                        <a class="nav-link" href="../admin/index.php">
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
                            <a class="nav-link px-3" href="../admin/admins.php">
                                <span class="me-2"><i class="bi bi-arrow-bar-right"></i></span>
                                <span>Administrators</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link px-3" href="../admin/students.php">
                                <span class="me-2"><i class="bi bi-arrow-bar-right"></i></span>
                                <span>Students</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link px-3" href="../admin/departments.php">
                                <span class="me-2"><i class="bi bi-arrow-bar-right"></i></span>
                                <span>Departments</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link px-3" href="../admin/courses.php">
                                <span class="me-2"><i class="bi bi-arrow-bar-right"></i></span>
                                <span>Courses</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link px-3" href="../admin/logs.php">
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
                        <a class="nav-link px-3 sidebar-link active" data-bs-toggle="collapse" href="#admitCollapse" role="button" aria-expanded="false" aria-controls="admitCollapse">
                            <span class="me-2"><i class="bi bi-arrow-right-square"></i></span>
                            <span>Export Admit Card</span>
                            <span class="right-icon ms-auto"><i class="bi bi-chevron-down"></i></span>
                        </a>
                        <div class="collapse" id="admitCollapse">
                            <div>
                                <ul class="navbar-nav px-3">
                                    <li>
                                        <a class="nav-link px-3 active" href="mass.php">
                                            <span class="me-2"><i class="bi bi-arrow-bar-right"></i></span>
                                            <span>Bulk Export</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link px-3" href="single.php">
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
                <div class="col-12 fw-bold fs-3">Bulk Admit Export</div>
            </div>
            <div class="card mt-5 col-sm-10 offset-sm-1 pb-5">
                <div class="card-header">Enter Correct Information</div>
                <div class="col-sm-8 offset-sm-2">
                    <!-- Form -->
                    <form class="mass-form ms-auto px-3 pt-5" id="formData" action="submit.php" method="post">
                        <div class="input-group mb-2">
                            <div class="col-4">
                                <label for="department" class="me-2"><span class="text-danger"></span><span class="fw-bold">Department:</span></label>
                            </div>
                            <div class="col-8">
                                <select class="form-select" name="department" id="department" required>
                                <option value="">Select Department</option>
                                <?php 
                                    $sql = "SELECT
                                    department as department,
                                    COUNT(id) as total
                                    FROM `sfmu.students`
                                    GROUP BY department";
                                    $result = $connect->query($sql);
                                    if($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<option value=".$row['department'].">".strtoupper($row['department'])."</option>";
                                        }
                                    } 
                                ?>
                                </select>
                            </div> 
                        </div>
                        <div class="input-group mb-2">
                            <div class="col-4">
                                <label for="examtype" class="me-2"><span class="text-danger"></span><span class="fw-bold">Exam Type:</span></label>
                            </div>
                            <div class="col-8">
                                <select class="form-select" name="examtype" id="examtype" required>
                                <option value="">Select Exam type</option>
                                <option value="Mid-Term">Mid-Term</option>
                                <option value="Final">Final</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-group mb-2">
                            <div class="col-4">
                                <label for="semester" class="me-2"><span class="text-danger"></span><span class="fw-bold">Semester:</span></label>
                            </div>
                            <div class="col-8">
                                <select class="form-select" name="semester" id="semester" required>
                                <option value="">Select Semester</option>
                                <option value="Winter">Winter</option>
                                <option value="Summer">Summer</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-group mb-2">
                            <div class="col-4">
                                <label for="year" class="me-2"><span class="text-danger"></span><span class="fw-bold">Year:</span></label>
                            </div>
                            <div class="col-8">
                                <select class="form-select" name="year" id="year" required>
                                <option value="">Select Students</option>
                                <option value="11">1st Year - 1st Semester</option>
                                <option value="12">1st Year - 2nd Semester</option>
                                <option value="21">2nd Year - 1st Semester</option>
                                <option value="22">2nd Year - 2nd Semester</option>
                                <option value="31">3rd Year - 1st Semester</option>
                                <option value="32">3rd Year - 2nd Semester</option>
                                <option value="41">4th Year - 1st Semester</option>
                                <option value="42">4th Year - 2nd Semester</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-group mb-5">
                            <div class="col-4">
                                <label for="syllabus" class="me-2"><span class="text-danger"></span><span class="fw-bold">Syllabus:</span></label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="syllabus" id="syllabus" required>
                                <option value="">Select Syllabus</option>
                                <option value="old">Old Syllabus</option>
                                <option value="running">Running Syllabus</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-group">
                            <button class="btn btn-primary ms-auto" type="submit" id="downloadPdf" name="downloadPdf">Submit</button>
                        </div>
                    </form>
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
    <script>
        $('#admitCollapse').show();
        $(document).ready(function() {
            // Loader
            let loader = document.getElementById("pre-loader");
            // loader.classList.add("stop");
            setTimeout(() => { loader.classList.add("stop"); }, 300);
        });
    </script>
    <!-- JavaScripts -->
</body>

</html>

<?php } else {
    header("Location: ../index.php");
}

?>