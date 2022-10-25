<?php

include '../connect.php';

if(isset($_POST['name'])) {
    $i = 1;
    $sql = "SELECT * FROM `sfmu.students` WHERE `name` LIKE '%".$_POST['name']."%' OR `uid` LIKE '%".$_POST['name']."%'";
    $result = $connect->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            
            echo '<tr>
                <td class="fw-bold"> '.$i.'</td>
                <td>'.$row['name'].'</td>
                <td>'.$row['uid'].'</td>
            </tr>';
            $i++;
        }
    }
    else{
        echo "<tr><td colspan='3' class='text-center'>0 result's found</td></tr>";
    }
} 