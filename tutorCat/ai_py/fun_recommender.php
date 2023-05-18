<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/FYP/tutorCat/conn.php");
$conn = getDBconn();

function haveEnoughRating($studentID)
{
    $sql = "SELECT * FROM notes_rating WHERE StudentID = $studentID";
    $conn = getDBconn();
    $result = $conn->query($sql);
    $num = mysqli_num_rows($result);

    if ($num >= 4) {
        return true;
    } else {

        return false;
    }
}

function getRecommender($studentID){
    $sql = "SELECT NotesID,Rating
            FROM notes_rating 
            WHERE StudentID = $studentID";

    $conn = getDBconn();

    $result = $conn->query($sql);
    $num = mysqli_num_rows($result);

    // Loop through the query results and add them to the $notes array
    if (mysqli_num_rows($result) >= 4) {

        $api_url = 'http://localhost:5000/recommend/'; // Replace with the actual URL of the Flask API program

        $student_id = $studentID;

        $response = file_get_contents($api_url . $student_id);

        $notes_ids = json_decode($response, true);

        $notes_ids = array_slice($notes_ids, 0, 4);

        return $notes_ids;

    } else {

        return false;

    }


}

?>