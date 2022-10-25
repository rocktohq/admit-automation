<?php

/*
* Application developed by Saidul Mursalin
* Database connection configuration
*/

// DB Information
$host = 'localhost';        // Host Name
$dbName = 'sfmu.admits';       // Database Name
$dbUser = 'students';       // Database Username
$dbPass = 'students321';    // Database Password

// Let's try to Connect
$connect = new mysqli($host, $dbUser, $dbPass, $dbName);

// If there is any Error
if($connect -> connect_errno) {
  echo "Failed to connect to MySQL: " . $connect -> connect_error;
  exit();
}

// Copyright
$devText = '
    <footer>
      <div class="dev">
        <p class="text-center">Design & Developed by <span class="highlight">Saidul Mursalin</span>. Supervised by <span class="highlight">Fazle Rabbi Rushu</span></p>
      </div>
    </footer>';

// Site Link
$site = 'http://localhost/admit';

?>