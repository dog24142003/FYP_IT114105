<?php

session_start();

$conn = mysqli_connect("localhost", "root", "", "tutorcatdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['StudentID'])) {

    echo '<script type="text/javascript"> window.location.replace("../../logout.php"); </script>';
}

require_once "../../conn.php";

$conn = getDBconn();


var_dump($_POST);
if (!isset($_POST["ratingFm"])) {
    echo "<script>alert('no form post geted')</script>";
} else {

    $comment = $_POST["comment"];
    $tutorID = $_POST["TutorID"];
    $rating = $_POST["rating"];
    $studentID = $_SESSION['StudentID'];


    echo $comment . $tutorID . $studentID . $rating;


    $sql = "INSERT INTO tutor_rating
            (TutorID , StudentID , Comment ,Rating , RatingDate)
            VALUES 
            ($tutorID,$studentID,'$comment',$rating,current_timestamp());";

    echo $sql;
    try {
        mysqli_query($conn, $sql);

        $sql = "SELECT * FROM tutor WHERE TutorID=" . $tutorID;

        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        extract($row);

        header("location:Rating_success.php?Email=" . $Email);
    } catch (mysqli_sql_exception $error) {
        echo " mysqli_query error .";
    }
}
