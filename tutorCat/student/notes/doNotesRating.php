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
    $notesId = $_POST["notesID"];
    $rating = $_POST["rating"];
    $studentID = $_SESSION['StudentID'];

    echo $comment . $notesId . $studentID;


    $sql = "INSERT INTO notes_rating
    (NotesID , StudentID , Comment ,Rating , RatingDate)
    VALUES 
    ($notesId,$studentID,'$comment',$rating,current_timestamp());";


    try {
        mysqli_query($conn, $sql);
        header("location:Rating_success.php?notesId=".$notesId);
    } catch (mysqli_sql_exception $error) {
        echo " mysqli_query error .";
    }

}
