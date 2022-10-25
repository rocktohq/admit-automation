<?php
include '../connect.php';
include 'functions.php';

session_start();

if(isset($_SESSION['name'])) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Admit Export</title>

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
                                        <a class="nav-link px-3" href="mass.php">
                                            <span class="me-2"><i class="bi bi-arrow-bar-right"></i></span>
                                            <span>Bulk Export</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link px-3 active" href="single.php">
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
                <div class="col-12 fw-bold fs-3">Individual Admit Export</div>
            </div>
            <div class="col-sm-8 offset-sm-2">
                <!-- Form -->
                <?php 
                    if(isset($_POST['search'])) {
                        $studentid = $_POST['studentid'];

                        $sql = "SELECT * FROM `sfmu.students` WHERE uid = '$studentid'";
                        $result = $connect->query($sql);
                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                if($row['batch'] < 10) {
                                    $batch = '0'.$row['batch'];
                                } else {
                                    $batch = $row['batch'];
                                }

                            ?>
                            <div class="m-end">
                                <a href="" class="btn btn-primary">Search another Student</a>
                            </div>
                            <div class="card mt-3">
                                <div class="card-header mb-2">Student Information:</div>
                                <div class="px-5">
                                    <table class="mb-3 fw-bold">
                                        <tr>
                                            <td class="pe-5">Name: <?= $row['name']; ?></td>
                                            <td>ID: <?= $row['uid']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Department: <?= strtoupper($row['department']); ?></td>
                                            <td class="pe-5">Batch: <?= $batch; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-5">Year: <?php echo $row['year']; echo supText($row['year']); ?></td>
                                            <td>Semester: <?php echo $row['semester']; echo supText($row['semester']); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-5">Admission Session: <?= $row['session']; ?></td>
                                            <?php
                                                if($_SESSION["role"] == 1) {
                                            ?>
                                            <td><a href="../admin/students.php" class="btn btn-primary">Update Student</a></td>
                                            <?php } else { ?>
                                                <td><span class="text-danger">Contact Administrator to update the Student's info.</span></td>
                                            <?php } ?>
                                        </tr>
                                    </table>
                                </div>
                                
                            </div>
                            <form class="mass-form ms-auto px-3 pt-4" id="formData" action="pdfView2.php" method="post">
                                <div class="input-group mb-2">
                                    <input type="hidden" name="sname" id="sname" value="<?= $row['name']; ?>">
                                    <input type="hidden" name="uid" id="uid" value="<?= $row['uid']; ?>">
                                    <input type="hidden" name="batch" id="batch" value="<?= $row['batch']; ?>">
                                    <input type="hidden" name="year" id="year" value="<?= $row['year']; ?>">
                                    <input type="hidden" name="semester" id="semester" value="<?= $row['semester']; ?>">
                                    <input type="hidden" name="session" id="session" value="<?= $row['session']; ?>">
                                    <input type="hidden" name="department" id="department" value="<?= $row['department']; ?>">

                                    <div class="col-md-8 offset-2">
                                        <select class="form-select" name="examtype" id="examtype" required>
                                        <option value="">Select Exam Type</option>
                                        <option value="11">Winter - Mid-Term</option>
                                        <option value="12">Winter - Final</option>
                                        <option value="21">Summer - Mid-Term</option>
                                        <option value="22">Summer - Final</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="input-group mb-2">                                  
                                    <div class="col-md-8">
                                        <select class="form-select" name="stype[]" id="stype" multiple="multiple" required>
                                        <option value="">Select Student Type</option>
                                        <option value="Regular">Regular</option>
                                        <option value="Retake">Retake</option>
                                        <option value="Improvement">Improvement</option>
                                        <option value="Recourse">Recourse</option>
                                        <!-- <option value="Incomplete">Incomplete</option> -->
                                        </select>
                                    </div>
                                </div>
                                <div class="input-group mb-2">                                  
                                    <div class="col-md-8">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="retakeCheck" data-bs-toggle="collapse" data-bs-target="#retakeInput" aria-expanded="false" aria-controls="retakeInput">
                                            <label class="form-check-label" for="retakeCheck">
                                                Has Retake?
                                            </label>
                                        </div>
                                        <div class="collapse" id="retakeInput">
                                            <div class="col-md-10 mb-2">
                                                <label for="name" class="form-label">Course-Code:</label>
                                                <input type="text" class="form-control" name="retake" id="retake" placeholder="[ie: cse-1101,cse-1102]">
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="improvementCheck" data-bs-toggle="collapse" data-bs-target="#improvementInput" aria-expanded="false" aria-controls="improvementInput">
                                            <label class="form-check-label" for="improvementCheck">
                                                Has Improvement?
                                            </label>
                                        </div>
                                        <div class="collapse" id="improvementInput">
                                            <div class="col-md-10 mb-2">
                                                <label for="name" class="form-label">Course-Code:</label>
                                                <input type="text" class="form-control" name="improvement" id="improvement" placeholder="[ie: cse-1101,cse-1102]">
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="recourseCheck" data-bs-toggle="collapse" data-bs-target="#recourseInput" aria-expanded="false" aria-controls="recourseInput">
                                            <label class="form-check-label" for="recourseCheck">
                                                Has Recourse?
                                            </label>
                                        </div>
                                        <div class="collapse" id="recourseInput">
                                            <div class="col-md-10 mb-2">
                                                <label for="name" class="form-label">Course-Code:</label>
                                                <input type="text" class="form-control" name="recourse" id="recourse" placeholder="[ie: cse-1101,cse-1102]">
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="incompleteCheck" data-bs-toggle="collapse" data-bs-target="#incompleteInput" aria-expanded="false" aria-controls="incompleteInput">
                                            <label class="form-check-label" for="incompleteCheck">
                                                Has Incomplete?
                                            </label>
                                        </div>
                                        <div class="collapse" id="incompleteInput">
                                            <div class="col-md-10 mb-2">
                                                <label for="name" class="form-label">Course-Code:</label>
                                                <input type="text" class="form-control" name="incomplete" id="incomplete" placeholder="[ie: cse-1101,cse-1102]">
                                            </div>
                                        </div> -->
                                    </div>
                                </div>

                                <div class="input-group mb-5"> 
                                    <div class="col-md-8">
                                        <select class="form-select" name="syllabus" id="syllabus" required>
                                        <option value="">Select Syllabus</option>
                                        <option value="old">Old Syllabus</option>
                                        <option value="running">Running Syllabus</option>
                                        </select>
                                    </div>
                                </div>
                                

                                <div class="input-group">
                                    <button class="btn btn-primary" type="submit" id="downloadPdf" name="downloadPdf">Download</button>
                                </div>
                            </form>
                    <?php
                            }
                        } else {
                            ?>
                            
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                <div class="text-center">No student found! Please search again.</div>
                            </div>
                            <div class="card col-sm-8 offset-sm-2 mt-5">
                                <div class="card-header">Search Student</div>
                                <div class="col-sm-11 m-2">
                                    <input type="text" placeholder="Enter Student ID" class="form-control" id="search">
                                </div>
                                <div id="showlist"></div>
                            </div>
                            <?php
                        }
                    ?>
                
                <?php } else { ?>
                    <div class="card col-sm-8 offset-sm-2 mt-5">
                        <div class="card-header">Search Student</div>
                        <div class="col-11 m-2">
                            <input type="text" placeholder="Enter Student ID" class="form-control" id="search">
                        </div>
                        <div id="showlist"></div>
                    </div>
                
                <?php } ?>
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

    <!-- SVG -->
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>
    <!-- SVG -->
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
            
            $("#search").keyup(function(){
                let searchdata = $("#search").val();
                if(!searchdata) {
                    $("#showlist").html("");
                }
                else {
                    $.ajax({
                        type:'POST',
                        url:'slist.php?a=searchr',
                        data:{
                            name:searchdata,
                        },
                        success:function(data){
                            $("#showlist").html(data);
                        }
                    });
                }
            });
        });
    </script>
    <!-- JavaScripts -->
</body>

</html>

<?php } else {
    header("Location: ../index.php");
}

?>