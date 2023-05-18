<?php

require_once "conn.php";

$conn = getDBconn();
$courseID = $_GET['CourseID'];
var_dump($courseID);
if (!isset($_GET['CourseID'])) {
    echo "<script>alert('404 error')</script>";
} else {
    $sql = "UPDATE course SET cState = 'private' WHERE CourseID = '$courseID';";
   // $sql = "DELETE FROM course WHERE CourseID = '$courseID';";
    try {
        mysqli_query($conn, $sql);
    } catch (mysqli_sql_exception $error) {
        echo " mysqli_query error .";
    }
    // var_dump($sql);

    echo '<script>window.location.href="page_teacher_profile.php";</script>';
}

?>