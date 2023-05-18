<?php

session_start();

$conn = mysqli_connect("localhost", "root", "", "tutorcatdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
var_dump((!isset($_SESSION['StudentID']) && !isset($_SESSION['TutorID'])));
//$conn = getDBconn();
if ((!isset($_SESSION['StudentID']) && !isset($_SESSION['TutorID']))) {
    echo '<script type="text/javascript"> window.location.replace("../../logout.php"); </script>';
    // header("location:../../index.html");
}

if (!isset($_POST["reportNotesCM"])) {
    echo "<script>alert('404 error')</script>";
    echo '<script type="text/javascript"> window.location.replace("../../logout.php"); </script>';
} else {


    if ($_POST["detail"] != null) {
        $detail = $_POST["detail"];
    } else {
        $detail = "have not details";
    }
    $senderEmail = $_SESSION['Email'];
    $reason = $_POST["report_reason"];
    $date = date("n/j/Y");

    $sql = "SELECT Email FROM student WHERE StudentID =" . $_POST["report_StudentID"];

    $result = $conn->query($sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $rs = mysqli_fetch_assoc($result);
        $getterEmail = $rs['Email'];
        var_dump($getterEmail);

    } else {
        echo '<script>alert("We cannot found this studentID.")</script>';
        echo '<script type="text/javascript"> window.location.replace("../../logout.php"); </script>';
    }
//    echo '<script>alert('.var_dump($_POST["report_StudentID"]).' )</script>';

    $sql = "INSERT INTO `reports`(
                `reportID`,
                `senderEmail`,
                `getterEmail`,
                `dateTime`,
                `reason`,
                `detail`,
                `report_status`
            )
            VALUES(
                NULL,
                '$senderEmail',
                '$getterEmail',
                '$date',
                'cm_$reason',
                '$detail',
                'Pending'
            )";


    var_dump($_POST["tutorPageEmail"]);
    try {
        mysqli_multi_query($conn, $sql);
        $link = "ReportProfileCM_success.php?tEmail=" . $_POST["tutorPageEmail"];
        echo '<script type="text/javascript"> window.location.replace("ReportProfileCM_success.php?tEmail=' . $_POST["tutorPageEmail"] .'"); </script>';
    } catch (mysqli_sql_exception $error) {
        echo " mysqli_query error .";
    }
}
?>
