<?php

include '../connect.php';

if(isset($_GET['a'])) {

    // Show Data
    if($_GET['a'] === 'showlist') {
        if(isset($_POST['displayData'])) {
            $i = 1;
            $sql = "SELECT * FROM `sfmu.students`";
            $result = $connect->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {

                    if($row['batch'] < 10) {
                        $batch = '0'.$row['batch'];
                    } else {
                        $batch = $row['batch'];
                    }

                    echo "<tr class='text-center'>
                            <td class='fw-bold'>{$i}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['uid']}</td>
                            <td>".strtoupper($row["department"])."</td>
                            <td>{$batch}</td>
                            <td>{$row['year']}</td>
                            <td>{$row['semester']}</td>

                            <td class='text-center'>
                                <span class='me-1 btn btn-danger' onclick='deleteUser({$row['id']})'><i class='bi bi-trash'></i></span>
                                <span class='btn btn-primary' onclick='updateUser({$row['id']})'><i class='bi bi-pencil-square'></i></i></span>
                            </td>
                        </tr>";
                    $i++;
                }
            }
            else{
                echo "<tr><td colspan='8' class='text-center'>0 result's found</td></tr>";
            }
        }          
    }

    // Show Data
    if($_GET['a'] === 'search') {
        if(isset($_POST['name'])) {
            $i = 1;
            $sql = "SELECT * FROM `sfmu.students` WHERE `name` LIKE '%".$_POST['name']."%' OR `uid` LIKE '%".$_POST['name']."%'";
            $result = $connect->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {

                    if($row['batch'] < 10) {
                        $batch = '0'.$row['batch'];
                    } else {
                        $batch = $row['batch'];
                    }
                    
                    echo "<tr class='text-center'>
                            <td class='fw-bold'>{$i}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['uid']}</td>
                            <td>".strtoupper($row["department"])."</td>
                            <td>{$batch}</td>
                            <td>{$row['year']}</td>
                            <td>{$row['semester']}</td>

                            <td class='text-center'>
                                <span class='me-1 btn btn-danger' onclick='deleteUser({$row['id']})'><i class='bi bi-trash'></i></span>
                                <span class='btn btn-primary' onclick='updateUser({$row['id']})'><i class='bi bi-pencil-square'></i></i></span>
                            </td>
                        </tr>";
                    $i++;
                }
            }
            else{
                echo "<tr><td colspan='8' class='text-center'>0 result's found</td></tr>";
            }
        }          
    }

    // Delete Data
    if($_GET['a'] === 'deletedata') {
        if(isset($_POST['deleteId'])) {
            $did = $_POST['deleteId'];
            $sql = "DELETE FROM `sfmu.tmp` WHERE id = $did";
            $result = $connect->query($sql);
            if($result) {
                echo 'Student Deleted Successfully!';
            } else {
            echo 'Error Deleting Data!';
            }
        }
        
    }

    // Before Updating Data
    if($_GET['a'] === 'updatedata') {
        extract($_POST);
        // If name submitted
        if(isset($_POST['upId'])) {
            $upId = $_POST['upId'];
        
            // Show Data
            $sql = "SELECT retake, improvement, recourse, incomplete FROM `sfmu.tmp` WHERE id = $upId";
                $result = $connect->query($sql);
                $row = $result->fetch_assoc();
                $data = array();
                $data = $row;
                echo json_encode($data);
        }
        else {
            $data['sratus'] = 200;
            $data['message'] = "Data not found!";
        }
    }

    // Main Update
    if($_GET['a'] === 'update') {
        if(isset($_POST['id'])) {
            $id = $_POST['id'];
        }

        // Checking Data
        $sql = "SELECT retake, improvement, recourse, incomplete FROM `sfmu.tmp` WHERE id = $id";
        $result = $connect->query($sql);
        $row = $result->fetch_assoc();

        if(isset($_POST['retake'])) {
            $retake = $_POST['retake'];
        } 
        if(empty($retake)) {
            $retake = $row['retake'];
        }

        if(isset($_POST['improvement'])) {
            $improvement = $_POST['improvement'];
        } 
        if(empty($improvement)) {
            $improvement = $row['improvement'];
        }

        if(isset($_POST['recourse'])) {
            $recourse = $_POST['recourse'];
        } 
        if(empty($recourse)) {
            $recourse = $row['recourse'];
        }
        if(isset($_POST['incomplete'])) {
            $incomplete = $_POST['incomplete'];
        } 
        if(empty($incomplete)) {
            $incomplete = $row['incomplete'];
        }

        $sql = "UPDATE `sfmu.tmp` SET `retake`='$retake',`improvement`='$improvement',`recourse`='$recourse',`incomplete`='$incomplete' WHERE id = $id";
        $result = $connect->query($sql);
        if($result) {
            echo 'Student Updated Successfully';
        } else { 
            echo 'Error Updating Data!'; 
        }
    }



    // Show CourseList
    if($_GET['a'] === 'showcourses') {
        if(isset($_POST['displayData'])) {
            $i = 1;
            $sql = "SELECT * FROM `sfmu.cse_syllabus_`";
            $result = $connect->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {

                    if ($row['year'] > 0) {
                        $year = $row['year'].' : '.$row['semester'];
                    } else {
                        $year = 'Optional';
                    }

                    echo '<tr>
                            <td class="text-center">'.$i.'</td>
                            <td>'.$row['course_title'].'</td>
                            <td class="text-center">'.$row['course_code'].'</td>
                            <td class="text-center">'.$row['credit'].'</td>
                            <td class="text-center">CSE</td>
                            <td class="text-center">'.$year.'</td>
                            <td class="text-center">
                                <span class="me-1 btn btn-danger" onclick="deleteUser('.$row['id'].')"><i class="bi bi-trash"></i></span>
                                <span class="btn btn-primary" onclick="updateUser('.$row['id'].')"><i class="bi bi-pencil-square"></i></i></span>
                            </td>
                        </tr>';
                    $i++;
                }
            }
            else{
                echo "<tr><td colspan='6' class='text-center'>0 result's found</td></tr>";
            }
        }
    }
}

?>