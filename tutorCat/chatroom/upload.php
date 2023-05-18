<?php
session_start();
// $fromUser = "1060555388";
$fromUser = $_POST["fromUser"];
$toUser = $_POST["toUser"];
// $toUser = "278494671";

if (isset($_POST['submit']) && isset($_FILES['fileToUpload'])) {
    require_once('../conn.php');

    echo "<pre>";
    print_r($_FILES['fileToUpload']);
    echo "</pre>";

    $img_name = $_FILES['fileToUpload']['name'];
    $img_size = $_FILES['fileToUpload']['size'];
    $tmp_name = $_FILES['fileToUpload']['tmp_name'];
    $error = $_FILES['fileToUpload']['error'];

    if ($error === 0) {
        if ($img_size > 1250000) {
            $em = "Sorry, your file is too large.";
            // header("Location: index.php?error=$em");
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");
            $allowed_exs_pdf = array("pdf", "doc", "docx");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = 'uploads/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // Insert into Database
                $sql = "INSERT INTO messages (FromUser, ToUser, msg, type) VALUES ('$fromUser', '$toUser', '$new_img_name', 'Image')";

                mysqli_query(getDBconn(), $sql);
                header("Location: chatusers.php?toUser=" . $toUser);
            } else if (in_array($img_ex_lc, $allowed_exs_pdf)) {
                //$new_img_name = uniqid("PDF-", true) . '.' . $img_ex_lc;
                //$img_upload_path = 'uploads/' . $new_img_name;
                $img_upload_path = 'uploads/' . $img_name;
                move_uploaded_file($img_name, $img_upload_path);

                // Insert into Database
                $sql = "INSERT INTO messages (FromUser, ToUser, msg, type) VALUES ('$fromUser', '$toUser', '$img_name', 'File')";

                mysqli_query(getDBconn(), $sql);
                header("Location: chatusers.php?toUser=" . $toUser);
            } else {
                $em = "You can't upload files of this type";
                // header("Location: index.php?error=$em");
            }
        }
    } else {
        $em = "unknown error occurred!";
        // header("Location: index.php?error=$em");
    }

} else {
    // header("Location: index.php");
}
?>