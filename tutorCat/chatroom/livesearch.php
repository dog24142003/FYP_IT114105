<?php
session_start();
require_once('../conn.php');

if (isset($_POST['input'])) {
    $input = $_POST['input'];

    $sql = "SELECT * FROM tutor WHERE FirstName LIKE '{$input}%'";

    $results = mysqli_query(getDBConn(), $sql);

    while ($result = mysqli_fetch_assoc($results)) {
        if ($result["UniqueID"] == 0) {
            continue;
        }
        echo '<a href=?toUser=' . $result["UniqueID"] . ' class="list-group-item list-group-item-action border-0">
<div class="d-flex align-items-start" onclick="myFunction()">
    <div class="flex-grow-1 ml-3">
    <strong>' . $result["FirstName"] . ' ' . $result["LastName"] . '</strong>
        <div class="small"><i class="fa fa-circle" style="font-size:12px;color:green"></i> ' . $result["Status"] . '</div>
    </div>
</div>
</a>
<hr class="d-block d-lg-none mt-1 mb-0">';
    }
}
?>