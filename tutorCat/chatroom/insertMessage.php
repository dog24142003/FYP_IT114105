<?php
session_start();
require_once('../conn.php');

$fromUser = $_POST["fromUser"];
$toUser = $_POST["toUser"];
$msg = $_POST["msg"];
$type = $_POST["type"];

$output = "";

$sql = "INSERT INTO messages (FromUser, ToUser, msg, type) VALUES ('$fromUser', '$toUser', '$msg', '$type')";

$rs = mysqli_query(getDBconn(), $sql);

if ($rs) {
    $output .= "";
} else {
    $output .= "Error.";
}
echo $output;
?>