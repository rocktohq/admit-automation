<?php
if(isset($_SESSION['name'])) {
    header("location: admin");
}
else {
include 'connect.php';

$message = '';

// If Form Submiited
if(isset($_POST['login'])) {

    // UserName
    if(isset($_POST['username'])) {
        $username = $connect->real_escape_string($_POST['username']);
        $username = strtolower($username);
    } else {
        $message = "Username is required!";
    }

    //Password
    if(isset($_POST['password'])) {
        $password = $connect->real_escape_string($_POST['password']);
    } else {
        $message = "Password is required!";
    }
    
    // Fetch the Password from DB
    $sql = "SELECT `password` FROM `sfmu.admin` WHERE name = '$username'";
    $result = $connect->query($sql);
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Compare the Passwords
        if(password_verify($password, $hashed_password)) {
            // Start the session
            session_start();
            $_SESSION["name"] = $username;
            $sql = "SELECT * FROM `sfmu.admin` WHERE name = '$username'";
            $result = $connect->query($sql);
            $row = $result->fetch_assoc();
            $department = $row['department'];
            $_SESSION["role"] = $row['role'];

            date_default_timezone_set('Asia/Dhaka');
            // $date = date('Y-m-d h:i:s');

            $query = "INSERT INTO `sfmu.logs`(`user_name`, `department`, `login_time`) VALUES('$username','$department', NOW())";
            
            $connect->query($query);
            
            header("Location: admin/index.php");
        } else { 
            $message = 'Incorrect password!'; 
        }  
    } else {
        $message = "Username doesn't exist!";
    }
    
    
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- PWA -->
    <meta property="og:title" content="Admin Login - SFMU Admit System">
    <meta property="og:type" content="website">
    <meta property="og:description" content="Shaikh Fazilatunnesa Mujib University's Admit Management System">
    <meta property="og:url" content="https://admit.monirhq.com">
    <meta property="og:image" content="assets/icons/icon.png">
	<link rel="shortcut icon" href="assets/icons/icon-64.png">
	<link rel="manifest" href="manifest.json">

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/admin.css">

</head>

<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-dark bg-dark d-flex justify-content-center align-items-center">
            <div class="nav-brand text-light text-center fs-3">Admin Login</div>
        </nav>
    </header>
    <!-- Toast Notification -->
  
    <?php if(!empty($message)) {   ?>
                    <div class="position-fixed top-0 start-50 translate-middle-x mt-5" style="z-index: 11">
                        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="me-auto">Login Error!</strong>
                                <small></small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                <span class="h6 text-danger"><strong>Error:</strong> <?php echo $message; ?></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
    <!-- Main Login -->
    <main class="wrapper">
        <div id="formContent">
            <!-- Icon -->
            <div class="first">
                <img src="assets/images/logo.png" id="icon" alt="Logo" />
            </div>

            <!-- Login Form -->
            <form action="" method="post">
                <input type="text" id="username" class="" name="username" placeholder="User Name" required>
                <input type="password" id="password" class="" name="password" placeholder="Password" required>
                <input type="submit" name="login" class="" value="Log In">
            </form>

        </div>
    </main>

    <!-- Footer -->
    <?php echo $devText; ?>

    <!-- JavaScripts -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/pwa.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".toast").toast('show');
        });


    </script>
</body>

</html>
<?php }  ?>