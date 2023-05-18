<?php
require_once "conn.php";

$conn = getDBconn();

if (!isset($_POST["craeteCourseSubmit"])) {
    echo "<script>alert('404 error')</script>";
} else {

    $courseName = $_POST["courseName"];
    $coursePrice = $_POST["coursePrice"];
    $courseSubject = $_POST["courseSubject"];
    $courseDetails = $_POST["courseDetails"];
    $courseDate = $_POST["datePick"];
    $courseTime = date_create($_POST["courseTime"]);
    $dbTime  = date_format($courseTime,"H:i:s");
    $tutorID = $_POST["tutorID"];
    $hour = $_POST["hour"];
    $date = explode(",", $courseDate);
    $lesson = count($date);
    // Insert image content into database 
    // var_dump($courseTime);
    // var_dump($dbTime,$courseName, $coursePrice,$courseSubject,$courseDetails, $courseDate, $courseTime, $tutorID, $date,$lesson);

    $sql = "INSERT INTO course (CourseID, CName, Cost, Description, TutorID, Subject, Time, Hour, NoOfClass) VALUES (NULL,'$courseName', '$coursePrice','$courseDetails','$tutorID','$courseSubject','$dbTime','$hour','$lesson');";
    // var_dump($sql);
    try {
        
        mysqli_query($conn, $sql);
        // header("location:");
    } catch (Exception $error) {
        echo '<script>Caught exception: ',  $error->getMessage(), '</script>';
    }


   
    try {
        $sql = "SELECT MAX(CourseID) AS MCourseID FROM course;";
        $result = $conn->query($sql);
        $num = mysqli_num_rows($result);
        if ($num >= 1) {

            $rs = mysqli_fetch_assoc($result);
        } else {
            echo '<script>alert("This Course had not found.")</script>';
            echo '<script type="text/javascript"> window.location.replace("../../index.html"); </script>';
        }

        extract($rs);


        // header("location:");
    } catch (Exception $error) {
        echo '<script>alert("'.$error.'  ")</script>';
    }
    // echo '<script>alert("' . $date[1] . '")</script>';
    for ($x = 0; $x < $lesson; $x++) {

        $sql = "INSERT INTO schedule(".
            "ScheduleID, TutorID , StudentID, Date, State, CourseID) ".
            "VALUES ( NULL, '$tutorID',  NULL,'$date[$x]','wait','$MCourseID');";
        var_dump($sql);
        try {
            mysqli_query($conn, $sql);
            echo '<script>alert("Create course successfully.")</script>';
            
        } catch (Exception $error) {
            echo '<script>alert("'.$error.'  ")</script>';
        }
        // header("location:index.php");
        echo '<script>window.location.href="page_teacher_profile.php";</script>';
    }
}
