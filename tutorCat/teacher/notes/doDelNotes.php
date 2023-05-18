<?php
                                     
require_once "../../conn.php";

session_start();

$conn = getDBconn();

if (!isset($_SESSION['TutorID'])) {

    echo '<script type="text/javascript"> window.location.replace("../../logout.php"); </script>';

}

if (!isset($_POST["delnotesFm"])) {
    echo "<script>alert('404 error')</script>";
} else {


    $notesId = $_POST["notesID"];

    $sql = "UPDATE notes SET State = 'private' WHERE NotesID = $notesId;";

    try {
        mysqli_query($conn, $sql);
        header("location:DelNotes_success.php");
    } catch (mysqli_sql_exception $error) {
        echo " mysqli_query error .";
    }

}

?>