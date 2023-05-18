<?php

session_start();

require_once "../../conn.php";

$conn = getDBconn();

if (!isset($_SESSION['TutorID'])) {

    echo '<script type="text/javascript"> window.location.replace("../../logout.php"); </script>';

}

if (!isset($_POST["craeteNotesSubmit"])) {
    echo "<script>alert('404 error')</script>";
} else {

    $notesName = $_POST["notesName"];
    $notesPrice = $_POST["notesPrice"];
    $notesSubject = $_POST["notesSubject"];
    $notesDetails = $_POST["notesDetails"];
    // $CoverImg = $_FILES["CoverImg"];
    $ImgType = $_POST["ImgType"];
    // $pdfUploader = $_FILES["pdfUploader"];
    var_dump($_SESSION['TutorID']);
    $tutorID = $_SESSION['TutorID'];
    

    echo $notesName . $notesPrice . $notesSubject . $notesDetails;

    $Imgblob = addslashes(file_get_contents($_FILES["CoverImg"]['tmp_name']));

    $pdfblob = addslashes(file_get_contents($_FILES["pdfUploader"]['tmp_name']));

    // Insert image content into database
    $sql = "INSERT INTO notes (
    NotesID, Name , Price, Img , ImgType, Detail,PDF, TutorID , Subject , ReleaseDate) 
    VALUES (
    NULL,'$notesName', $notesPrice,'$Imgblob','$ImgType',\"$notesDetails\",'$pdfblob','$tutorID','$notesSubject',current_timestamp()
    );";

    try {
        mysqli_query($conn, $sql);
        header("location:CreateNotes_success.php?tutorID=".$tutorID);
    } catch (mysqli_sql_exception $error) {
        echo " mysqli_query error .";
    }
}
