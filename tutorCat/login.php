<?php
require_once('conn.php');
session_start();
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $account = $_POST['account'];
    if ($account == 'Student') {
        $sql = "SELECT * FROM student where email = '$email' and password = '$password'";
    } else {
        $sql = "SELECT * FROM tutor where email = '$email' and password = '$password' and blockStatus = 0";
    }

    $rs = mysqli_query(getDBconn(), $sql);
    $row = mysqli_fetch_array($rs);

	
    if (is_array($row)) {
        if ($account == 'Tutor') {
            $_SESSION['TutorID'] = $row['TutorID'];
        } else {
            $_SESSION['StudentID'] = $row['StudentID'];
        }

        $_SESSION['Email'] = $row['Email'];

        $_SESSION['FirstName'] = $row['FirstName'];
        $_SESSION['UniqueID'] = $row['UniqueID'];
        $_SESSION['account'] = $account;
        $_SESSION['Point'] = $row['Point'];
        if ($account == 'Student') {
            $sql2 = "UPDATE student SET status = 'Active now' WHERE StudentID = {$row['StudentID']}";
        } else if ($account == 'Tutor') {
            $sql2 = "UPDATE tutor SET status = 'Active now' WHERE TutorID = {$row['TutorID']}";
        }
        $rs2 = mysqli_query(getDBconn(), $sql2);
		
    }
    else {
        echo '<script>alert("Login failed or Got suspend."); 
                     window.history.back();</script>';
    }
    if (isset($_SESSION["TutorID"]) || isset($_SESSION["StudentID"])) {
        header("Location:index.php");
    }
}
?>