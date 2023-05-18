<?php

require_once "conn.php";

$conn = getDBconn();
$scheduleID = $_POST['scheduleID'];
$state = $_POST['state'];
var_dump($state.$scheduleID);
if (!isset($_POST['scheduleID'])&&!isset($_POST['state'])) {
    echo "<script>alert('404 error')</script>";
} else {
    $sql = "UPDATE schedule SET State = '$state' WHERE ScheduleID = '$scheduleID';";
    var_dump($sql);
   // $sql = "DELETE FROM course WHERE CourseID = '$courseID';";
    try {
        mysqli_query($conn, $sql);
    } catch (mysqli_sql_exception $error) {
        echo " mysqli_query error .";
    }
    // var_dump($sql);

    echo '<script>window.location.href="teacher_manageCourse.php";</script>';
}

?>