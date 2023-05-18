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

    $price = $_SESSION["price"];
    $notesId = $_SESSION["buyNotesID"];
    $studentId = $_SESSION["StudentID"];

    echo $price . $notesId . $studentId;

    $sql = "SELECT Point FROM student WHERE StudentID =".$studentId;

    $result = $conn->query($sql);
    $num = mysqli_num_rows($result);
    
    if ($num == 1) {
        $rs = mysqli_fetch_assoc($result);
        extract($rs);
        $remaining = $Point - $price;
        var_dump($remaining);
    } else {
        echo '<script>alert("We cannot found this studentID.")</script>';
        echo '<script type="text/javascript"> window.location.replace("../../logout.php"); </script>';
    }


    $sql = "INSERT INTO stunotes
    (StudentID, NotesID, Price, BuyNotesDateTime)
    VALUES 
    ('$studentId','$notesId','$price',current_timestamp());";

    var_dump($sql);

//    $_SESSION['Point'] = $remaining;


    try {
        mysqli_multi_query($conn, $sql);
        echo '<script type="text/javascript"> window.location.replace("buyNotes_success.php?notesId='.$notesId.'"); </script>';
    } catch (mysqli_sql_exception $error) {
        echo " mysqli_query error .";
    }

