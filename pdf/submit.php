<?php
    session_start();
    include "../connect.php";
    
    if (isset($_SESSION["name"])) {
        
        
        if (isset($_POST["downloadPdf"])) {
            $department = $connect->real_escape_string(
            strtolower($_POST["department"])
            );
            $examtype = $_POST["examtype"];
            $esemester = $_POST["semester"];
            $year = $_POST["year"];
            
            if ($_POST["year"] == 11) {
                $year = 1;
                $semester = 1;
            }
            if ($_POST["year"] == 12) {
                $year = 1;
                $semester = 2;
            }
            if ($_POST["year"] == 21) {
                $year = 2;
                $semester = 1;
            }
            if ($_POST["year"] == 22) {
                $year = 2;
                $semester = 2;
            }
            if ($_POST["year"] == 31) {
                $year = 3;
                $semester = 1;
            }
            if ($_POST["year"] == 32) {
                $year = 3;
                $semester = 2;
            }
            if ($_POST["year"] == 41) {
                $year = 4;
                $semester = 1;
            }
            if ($_POST["year"] == 42) {
                $year = 4;
                $semester = 2;
            }
            
            // Color
            if ($examtype == "Final") {
                $color = "white";
                } else {
                $color = "white";
            }

            // Syllabus
            if(isset($_POST['syllabus'])) {
                $syllabus = $_POST['syllabus'];
            }
            
            // Print Details
            $sqlp = "UPDATE `sfmu.print_details` SET `department`='$department',`short_name`='$department',`color`='$color',`examtype`='$examtype',`esemester`='$esemester',`semester`='$semester',`year`='$year', `syllabus`='$syllabus' WHERE `id` = 1";
            
            //  $sqlp = "INSERT INTO `sfmu.print_details`(`id`, `department`, `examtype`, `semester`, `year`, `color`, `short_name`, `syllabus`) VALUES ('1', '$department', '$examtype', '$semester', '$year', '$color', '$department', '$syllabus')";

            // Execute the Query
            $connect->query($sqlp);
            
            // TMP
            if ($connect->query("DESCRIBE `sfmu.tmp_students`")) {
                // Let's Drop the table first
                $connect->query("TRUNCATE TABLE `sfmu.tmp_students`");
                // Now it's time to COPY the table
                $sql = "INSERT INTO `sfmu.tmp_students`
                SELECT *
                FROM
                `sfmu.students`
                WHERE department = '$department' AND year = '$year' AND semester = '$semester'";
                $connect->query($sql);
                } else {
                $sql = "CREATE TABLE `sfmu.tmp_students` AS SELECT * FROM `sfmu.students` WHERE department = '$department' AND year = '$year' AND semester = '$semester'";
                $connect->query($sql);
            }
        }
        
        // Notification
        $notification = "";
        
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Students List for Bulk Export</title>

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
                            <?php if ($_SESSION["role"] == 1) { ?>
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
            <!-- Students Table -->
            <main class="mt-5 pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 fw-bold fs-3">Students List for Bulk Export</div>
                        <section class="mt-2 px-2">
                            <div class="d-flex justify-content-between mb-4">
                                <div class="col-sm-4 ms-1">
                                    <a href="pdfView.php" class="btn btn-primary" id="downloadpdf">Download PDF</a>
                                </div>
                                
                                <div class="col-sm-4 me-1">
                                    <input type="text" placeholder="Enter Last 4 Digits of Student's ID" class="form-control" id="search">
                                </div>
                                
                            </div>
                        </section>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered cursor-pointer col-sm-12">
                                <thead class="table-success">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Student ID</th>
                                        <th>Year</th>
                                        <th>Retake</th>
                                        <th>Improvement</th>
                                        <th>Recourse</th>
                                        <!-- <th>Incomplete</th> -->
                                        <th class="px-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="showlist">
                                    <?php
                                        //var_dump($_POST);
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <!-- Students Table -->
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

            <!-- Modal for Update -->
            <div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="modalUpdateLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalUpdateLabel">Update Student Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="retakeCheck" data-bs-toggle="collapse" data-bs-target="#retakeInput" aria-expanded="false" aria-controls="retakeInput">
                                <label class="form-check-label" for="retakeCheck">
                                    Has Retake?
                                </label>
                            </div>
                            <div class="collapse" id="retakeInput">
                                <div class="col-md-10 mb-2">
                                    <label for="name" class="form-label">Course-Code:</label>
                                    <input type="text" class="form-control" name="retake" id="retake" placeholder="[ie: cse-101,cse-102]">
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
                                    <input type="text" class="form-control" name="improvement" id="improvement" placeholder="[ie: cse-101,cse-102]">
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
                                    <input type="text" class="form-control" name="recourse" id="recourse" placeholder="[ie: cse-101,cse-102]">
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
                                    <input type="text" class="form-control" name="incomplete" id="incomplete" placeholder="[ie: cse-101,cse-102]">
                                </div>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button name="update" type="submit" class="btn btn-primary" onclick="updateData()">Update</button>
                            <input type="hidden" id="updateId">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for Update -->
            <!-- Modal for Delete -->
            <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalDeleteLabel">Delete Student Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h4>Are you sure?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button name="delete" type="submit" class="btn btn-danger" onclick="delUser()">Confirm</button>
                            <input type="hidden" id="delid">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for Delete -->
            <!-- Notification -->
            <div class="position-fixed bottom-0 end-0" style="z-index: 11">
                <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Notification</strong>
                        <small>Just Now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <span class="h6" id="notification"></span>
                    </div>
                </div>
            </div>
            <!-- Notification -->
            <!-- JavaScripts -->
            <script src="../assets/js/bootstrap.bundle.min.js"></script>
            <script src="../assets/js/jquery-3.6.0.min.js"></script>
            <script>
                $('#admitCollapse').show();
                $(document).ready(function() {
                    // Loader
                    let loader = document.getElementById("pre-loader");
                    // loader.classList.add("stop");
                    setTimeout(() => { loader.classList.add("stop"); }, 500);
                    
                    displayData();
                    $("#search").keyup(function(){
                        let searchdata = $("#search").val();
                        if(!searchdata) {
                            displayData();
                        }
                        else {
                            $.ajax({
                                type:'POST',
                                url:'slist.php?a=search',
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
                
                // Display Data
                function displayData() {
                    let displayData = true;
                    $.ajax({
                        url: "slist.php?a=showlist",
                        type: "post",
                        beforeSend: function() {
                        },
                        data: {
                            displayData: displayData
                        },
                        success: function(data, status) {
                            $('#showlist').html(data);
                        }
                    });
                }
                
                // Delete User
                function deleteUser(deleteId) {
                    $('#delid').val(deleteId);
                    $('#modalDelete').modal('show');
                }
                
                function delUser() {
                    let deleteId = $('#delid').val();
                    $.ajax({
                        url: "slist.php?a=deletedata",
                        type: "post",
                        data: {
                            deleteId: deleteId
                        },
                        success: function(data, status) {
                            $('#modalDelete').modal('hide');
                            $('#notification').html(data)
                            $(".toast").toast('show');
                            displayData();
                        }
                    });
                }
                
                // Update User
                function updateUser(upId) {
                    $('#updateId').val(upId);
                    $.post("slist.php?a=updatedata", { upId: upId }, function(data, status) {
                        let id = JSON.parse(data);
                        $('#retake').val(id.retake);
                        $('#improvement').val(id.improvement);
                        $('#recourse').val(id.recourse);
                        $('#incomplete').val(id.incomplete);
                    });
                    
                    $('#modalUpdate').modal("show");
                }
                
                function updateData() {
                    let retake = $('#retake').val();
                    let improvement = $('#improvement').val();
                    let recourse = $('#recourse').val();
                    let incomplete = $('#incomplete').val();
                    let id = $('#updateId').val();
                    $.post("slist.php?a=update", {
                        retake: retake,
                        improvement: improvement,
                        recourse: recourse,
                        incomplete: incomplete,
                        id: id
                    },
                    function(data, status) {
                        $('#modalUpdate').modal("hide");
                        $('#notification').html(data)
                        $(".toast").toast('show');
                        displayData();
                    });
                }
            </script>
            <script>

                // Download PDF
                var downloadpdf = document.getElementById('downloadpdf');
                downloadpdf.addEventListener("click", function() {
                    downloadpdf.innerHTML = 'Downloading...';
                    downloadpdf.classList.add('disabled');
                    setTimeout("removeDsble()", 7000);
                });

                
                function removeDsble() {
                    downloadpdf.innerHTML = 'Download PDF';
                    downloadpdf.classList.remove('disabled');
                }
            </script>
            <!-- JavaScripts -->
        </body>
        
    </html>
    <?php $connect->close();
        } else {
        header("Location: ../index.php");
    }
?>
