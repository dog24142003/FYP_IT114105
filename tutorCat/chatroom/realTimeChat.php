<?php
require_once('../conn.php');

$fromUser = $_POST["fromUser"];
$toUser = $_POST["toUser"];
$output = "";


$chats = mysqli_query(getDBConn(), "SELECT * FROM messages where (FromUser = '" . $fromUser . "' AND ToUser = '" .
    $toUser . "') OR
(FromUser = '" . $toUser . "' AND ToUser = '" . $fromUser . "')");

while ($chat = mysqli_fetch_assoc($chats)) {
    if ($chat["FromUser"] == $fromUser) {
        if ($chat["Type"] == "Text") {
            $output .= "<div style='text-align:right;'>
    <p style='background-color:lightblue; word-wrap:break-word; display:inline-block;
                        padding:5px; border-radius:10px; max width:70%;'>
        " . $chat["Msg"] . "
    </p>
</div>";
        } else if ($chat["Type"] == "Image") {
            $output .= "<div style='text-align:right;' value='" . $chat['Msg'] . "' onclick='openFile(this)'>
    <p style='background-color:lightblue; word-wrap:break-word; display:inline-block;
                        padding:5px; border-radius:10px; max width:70%;'>
                        <img src='uploads/" . $chat['Msg'] . "' style='width: 200px;
                        height: 200px;'>
</p>
</div>";
        } else {
            $output .= "<div style='text-align:right;' value='" . $chat['Msg'] . "' onclick='openFile(this)'>
    <p style='background-color:lightblue; word-wrap:break-word; display:inline-block;
                        padding:5px; border-radius:10px; max width:70%;'>
                        <img width='5' height='300' name='plugin' src='uploads/PDF.png'>
                        " . $chat['Msg'] . "
    </p>
</div>";
        }
    } else {
        if ($chat["Type"] == "Text") {
            $output .= "<div style='text-align:left;'>
    <p style='background-color:yellow; word-wrap:break-word; display:inline-block;
                        padding:5px; border-radius:10px; max width:70%;'>
        " . $chat["Msg"] . "
    </p>
</div>";
        } else if ($chat["Type"] == "Image") {
            $output .= "<div style='text-align:left;' value='" . $chat['Msg'] . "' onclick='openFile(this)'>
    <p style='background-color:lightblue; word-wrap:break-word; display:inline-block;
                        padding:5px; border-radius:10px; max width:70%;'>
                        <img src='uploads/" . $chat['Msg'] . "' style='width: 200px;
                        height: 200px;'>
    </p>
</div>";
        } else {
            $output .= "<div style='text-align:left;' value='" . $chat['Msg'] . "' onclick='openFile(this)'>
    <p style='background-color:lightblue; word-wrap:break-word; display:inline-block;
                        padding:5px; border-radius:10px; max width:70%;'>
                        <img width='5' height='300' name='plugin' src='uploads/PDF.png'>
                        " . $chat['Msg'] . "
    </p>
</div>";
        }
    }
}
echo $output; ?>

<!-- <img src="uploads/<?= $images['image_url'] ?>"> -->

<script>
function openFile(value) {
    var fileName = "uploads/" + value.getAttribute('value');
    const url = window.location.href;
    const urlsplit = url.split('/');
    window.open(url.replace(urlsplit[urlsplit.length - 1], fileName));
}

function getCurrentURL() {
    return window.location.href
}
</script>