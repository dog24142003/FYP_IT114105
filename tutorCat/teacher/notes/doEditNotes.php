<?php
require_once "../../conn.php";

session_start();

$conn = getDBconn();

if (!isset($_SESSION['TutorID'])) {

    echo '<script type="text/javascript"> window.location.replace("../../logout.php"); </script>';

}

if (!isset($_POST["HasEditSubmit"])) {

    echo "<script>alert('404 error')</script>";

} else {

    // var_dump($_POST);

    $notesSubject = $_POST["notesSubject"];
    $notesName = $_POST["notesName"];
    $notesPrice = $_POST["notesPrice"];
    $notesDetail = $_POST["notesDetail"];
    $notesID = $_POST["notesID"];

    // $CoverImg = $_FILES["CoverImg"];
    $ImgType = $_POST["ImgType"];
    // $pdfUploader = $_FILES["pdfUploader"];

    

    // Insert image content into database 

    $sql = "UPDATE notes SET Name = \"$notesName\" , Price = $notesPrice , Detail = \"$notesDetail\" , Subject = \"$notesSubject\" ";

    if (!$_FILES["CoverImgUploader"]['tmp_name'] == "") {
        $Imgblob = addslashes(file_get_contents($_FILES["CoverImgUploader"]['tmp_name']));
        var_dump($_FILES);
        $sql .= " , Img = '" . $Imgblob."'";
        $sql .= " , ImgType = '" . $ImgType."'";
    }

    if (!$_FILES["pdfUploader"]['tmp_name'] == "") {
        var_dump($_FILES);
        $pdfblob = addslashes(file_get_contents($_FILES["pdfUploader"]['tmp_name']));
        $sql .= " , PDF = '" . $pdfblob."'";
    }
 
    $sql .=" WHERE NotesID =" .$notesID;

    // Warning: A non-numeric value encountered in C:\xampp\htdocs\FYP\tutorCat\teacher\notes\doEditNotes.php on line 39
    try {
        mysqli_query($conn, $sql);

        var_dump($sql);
        echo '<script type="text/javascript"> window.location.replace("Edit_success.php?notesId='.$notesID.'"); </script>';
    } catch (mysqli_sql_exception $error) {
        echo " mysqli_query error .";
    }

}



?>