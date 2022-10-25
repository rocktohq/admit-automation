<?php
session_start();

if(isset($_SESSION['name']) == 'admin') {
    include '../connect.php';
    
    // Delete Department
    if(isset($_POST['deleted'])) {
        $did = $_POST['did'];
        // Check if Exist or not
        $sql = "SELECT EXISTS (SELECT * FROM `sfmu.cse_syllabus` WHERE id = '$did') as `row_exists`  LIMIT 1";
        $result = $connect->query($sql);

        if($result->fetch_assoc()['row_exists'] > 0) {
            $sql = "DELETE FROM `sfmu.cse_syllabus` WHERE id = $did";
            $result = $connect->query($sql);
            if($result) {
                $notification = 'Course Deleted Successfully!';
                $border = 'success';
            } else {
                $notification = 'Error Deleting Course!';
                $border = 'danger';
            }
        } else {
            $notification = "Course doesn't Exists!";
            $border = 'danger';
        }
    }

    // Add Course
    if(isset($_POST['addd'])) {
        $admin = $connect->real_escape_string($_POST['admin']);
        $admin = strtolower($admin);
        $department = $connect->real_escape_string($_POST['department']);
        $department = strtolower($department);
        $password = $connect->real_escape_string($_POST['password']);
        $password = password_hash($password, PASSWORD_DEFAULT);
        // Check if Exist already
        $sql = "SELECT EXISTS (SELECT * FROM `sfmu.cse_syllabus` WHERE name = '$admin') as `row_exists`  LIMIT 1";
        $result = $connect->query($sql);

        if($result->fetch_assoc()['row_exists'] > 0) {
            $notification = 'Course Already Exists!';
            $border = 'danger';
         }
         else { 
            $sql = "INSERT INTO `sfmu.cse_syllabus`(name,department,password) VALUES ('$admin','$department','$password')";
            $result = $connect->query($sql);
            if($result) {
                $notification = 'Course Added Successfully!';
                $border = 'success';
            } else {
                $notification = 'Error Adding Course!';
                $border = 'danger';
            }
        }
        
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>

    <!-- PWA -->
    <meta property="og:image" content="../assets/icons/icon.png">
	<link rel="shortcut icon" href="../assets/icons/icon-64.png">
	<link rel="manifest" href="../manifest.json">

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap5.min.css">
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
        <button type="button" class="text-reset h2 ms-auto p-3 offcanvas-mobile-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-chevron-double-left"></i></button>


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
                            <a class="nav-link px-3 active" href="courses.php">
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
    <!-- Modals -->
    <!-- Modal for Add -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">Add New Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="row px-3">
                    <div class="modal-body">
                        <div class="col-md-10 mb-2">
                            <label for="admin" class="form-label">User Name:</label>
                            <input type="text" class="form-control" name="admin" id="admin" placeholder="User Name" required>
                        </div>
                        <div class="col-md-10 mb-2">
                            <label for="department" class="form-label">Department:</label>
                            <select class="form-select" name="department" id="department" required>
                                <option value="">Select Department</option>
                                <?php 
                                    $query = "SELECT `name`, `short_name` FROM `departments`";
                                    $results = $connect->query($query);
                                    if($results->num_rows > 0) {
                                        while($rows = $results->fetch_assoc()) {
                                            echo "<option value=".$rows['short_name'].">".strtoupper($rows['name'])."</option>";
                                        }
                                    } 
                                    
                                ?>
                            </select>
                        </div>
                        <div class="col-md-10">
                            <label for="password" class="form-label">Password:</label>
                            <input type="text" class="form-control" name="password" id="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button name="addd" type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal for Add -->
    
    <!-- Modals -->
    <!-- Admins Table -->
    <main class="mt-5 pt-3">
        <div class="container-fluid">
            <!-- Toast Notification -->
                <?php if(!empty($notification)) {   ?>
                    <div class="position-fixed bottom-0 end-0" style="z-index: 11">
                        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="me-auto">Notification</strong>
                                <small>Just Now</small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                <span class="h6 text-<?=$border;?>"><?php echo $notification; ?></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <div class="row">
                <div class="col-md-12 fw-bold fs-3">Courses</div>
                <section class="mt-2 px-2">
                    <div class="d-flex justify-content-start mb-4">
                        <span class="btn btn-primary me-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#modalAddx">
                            Add Course
                      </span>
                    </div>
                </section>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered cursor-pointer col-sm-12">
                        <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Course Title</th>
                                <th>Course Code</th>
                                <th>Credit</th>
                                <th>Department</th>
                                <th>For</th>
                                <th class="px-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="showdata">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <!-- Admins Table -->
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
            displayData();
        });

        // Display Data
        function displayData() {
                let displayData = true;
                $.ajax({
                    url: "st.php?a=showcourses",
                    type: "post",
                    data: {
                        displayData: displayData
                    },
                    success: function(data, status) {
                        $('#showdata').html(data);
                    }
                });
            }
    </script>
</body>

</html>
<?php } else {
    header("Location: ../index.php");
}

?>