<?php
    session_start();
    
    require_once('conn.php');
    if($_SESSION['account'] == 'Student'){
        $sql = "UPDATE student SET status = 'Offline' WHERE StudentID = {$_SESSION['StudentID']}";
    }else{
        $sql = "UPDATE tutor SET status = 'Offline' WHERE TutorID = {$_SESSION['TutorID']}";
    }
    $rs = mysqli_query(getDBconn(), $sql);   
    
    
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
?>