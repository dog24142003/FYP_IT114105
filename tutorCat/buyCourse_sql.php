<?php
require_once "conn.php";
session_start();
$conn = getDBconn();

// if (!isset($_POST["orderSubmit"])) {
//     echo "<script>alert('404 error')</script>";
// } else {
    //  var_dump($_POST["newTotalPrice"],$_POST["newTotalPrice"],$_POST["studentID"]);
    $courseID = $_SESSION['CourseID'];
    $totalPrice = $_SESSION['newTotalPrice'];
    $studentID = $_SESSION['studentID'];
    $tutorID =$_SESSION['tutorID'];

    $sql = "INSERT INTO broughtcourse (BroughtID, StudentID, TutorID, CourseID, TotalPrice) VALUES (NULL,'$studentID', '$tutorID', '$courseID','$totalPrice');";
    try {
        
        mysqli_query($conn, $sql);
        // header("location:");
    } catch (Exception $error) {
        echo '<script>Caught exception: ',  $error->getMessage(), '</script>';
    }

    try {
        $sql = "UPDATE course SET cState='private' WHERE CourseID=".$courseID.";";
        mysqli_query($conn, $sql);

    } catch (Exception $error) {
        echo '<script>Caught exception: ',  $error->getMessage(), '</script>';
    }

    try {
        $sql = "UPDATE schedule SET StudentID=".$studentID." WHERE CourseID=".$courseID.";";
        mysqli_query($conn, $sql);
        echo '<script>alert("Buy course successfully.")</script>';
        // header("location:");
    } catch (Exception $error) {
        echo '<script>Caught exception: ',  $error->getMessage(), '</script>';
    }
    echo '<script>window.location.href="index.php";</script>';
// }
