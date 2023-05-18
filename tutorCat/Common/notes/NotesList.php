<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/FYP/tutorCat/Common/header_abosulte.php");
require_once("$root/FYP/tutorCat/Common/fun_getPosition.php");
require_once("$root/FYP/tutorCat/ai_py/fun_recommender.php");


$conn = mysqli_connect("localhost", "root", "", "tutorcatdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="icon" type="image/x-icon" href="favicon.ico"/>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../../css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="../../css/owl.theme.default.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../../css/style.css"/>
    <title>Prixima BS5 Template</title>
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">

<!-- BOTTOM NAV -->

<section id="HereIsMain" class="text-center">
    <div class="container border border-2 mb-4 bg-light text-dark shadow-lg p-2 rounded-pill">
        <form method="get" action="#">
            <div class="row justify-content-around">
                <div class="row p-1">

                    <div class="col-1 h4 p-1">filter :</div>

                    <div class="col-2">
                        <select class="form-select shadow rounded-pill" name="filterSubject"
                                aria-label="Default select example">
                            <option name="all" value="all">All</option>
                            <?php
                            $OptionArray = array(
                                "Chinese",
                                "English",
                                "math",
                                "GeneralEducation",
                                "M1",
                                "M2",
                                "Biology",
                                "Chemistry",
                                "Physics",
                                "ChineseHistory",
                                "History",
                                "Bafs",
                                "Geography",
                                "Economic",
                                "VisualArt"
                            );

                            foreach ($OptionArray as $Option) {
                                ?>
                                <?php
                                if (isset($_GET['fliterSubmit'])) {
                                    ?>
                                    <option value="<?php echo $Option ?>" <?php if ($Option == $_GET['filterSubject']) : ?> selected="selected" <?php endif; ?>>
                                        <?php echo $Option ?></option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="<?php echo $Option ?>"><?php echo $Option ?></option>
                                    <?php
                                }
                                ?>

                                <?php
                            }
                            ?>
                        </select>
                    </div>


                    <div class="col-1">
                        <input type="submit" name="fliterSubmit" class="btn btn-primary rounded-pill shadow-lg"
                               value="Search">
                    </div>

                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="row g-4">

            <?php

            if (getPosition() == 'Student') {

                $recommend_ids = getRecommender($_SESSION['StudentID']);


                ?>

                <div class="container border border-2 mb-4 bg-light text-dark shadow-lg p-0 rounded-pill">
                    <div class="col-2 h4 p-1">Recommend Notes</div>
                </div>

                <?php

                if ($recommend_ids) {


                    foreach ($recommend_ids as $notes_id) {
                        $sql = "SELECT notes.*,tutor.LastName,tutor.FirstName 
                            FROM notes,tutor
                            WHERE notes.TutorID = tutor.TutorID 
                            AND NotesID = " . $notes_id;

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {

                            while ($rc = mysqli_fetch_assoc($result)) {
                                extract($rc);
                                ?>

                                <div class="col-lg-3 col-md-6"
                                     onclick="location.href='viewNotesDetails.php?notesId=<?php echo $NotesID ?>';">
                                    <div class="card shadow" style="width: 15rem ;">

                                        <div>
                                            <div class="position-absolute rounded bg-warning px-1" name="subject">
                                                <?php echo $Subject; ?>
                                            </div>
                                            <?php
                                            echo '<img src="data:image/' . $ImgType . ';base64,' . base64_encode($Img) . '" class="card-img-contain object-fit-cover rounded-top bg-light"
                                            style="height:10rem; object-fit: scale-down;" alt=""/>';
                                            ?>
                                        </div>
                                        <div class="card-body border">
                                            <h5 class="mb-0"
                                                style="width: 99%; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                                                <?php echo $Name; ?>
                                            </h5>
                                            <p class="mb-0" name="anthor">
                                                <?php echo $FirstName . "," . $LastName ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <?php

                            }
                        }
                    }


                } else {

                    $sql = "SELECT `Subject` FROM student WHERE studentID =" . $_SESSION['StudentID'];;

                    $result = mysqli_query($conn, $sql);
                    $rc = mysqli_fetch_assoc($result);

                    if ($rc['Subject'] == NULL) {
                        $sql = "SELECT stunotes.NotesID,COUNT(stunotes.NotesID) 
                            FROM stunotes,notes 
                            WHERE notes.NotesID = stunotes.NotesID 
                            AND notes.State = 'public'
                            GROUP BY stunotes.`NotesID` 
                            ORDER BY COUNT(stunotes.NotesID) DESC";

                        $result = mysqli_query($conn, $sql);

                        $notesID_list = array();

                        while ($rc = mysqli_fetch_assoc($result)) {
                            array_push($notesID_list, $rc['NotesID']);
                        }


                        if (count($notesID_list) > 4) {
                            $notesID_list = array_slice($notesID_list, 0, 4);
                        }

                        foreach ($notesID_list as $notes_id) {
                            $sql = "SELECT notes.*,tutor.LastName,tutor.FirstName 
                            FROM notes,tutor
                            WHERE notes.TutorID = tutor.TutorID 
                            AND NotesID = " . $notes_id;

                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {

                                while ($rc = mysqli_fetch_assoc($result)) {
                                    extract($rc);
                                    ?>

                                    <div class="col-lg-3 col-md-6"
                                         onclick="location.href='viewNotesDetails.php?notesId=<?php echo $NotesID ?>';">
                                        <div class="card shadow" style="width: 15rem ;">

                                            <div>
                                                <div class="position-absolute rounded bg-warning px-1" name="subject">
                                                    <?php echo $Subject; ?>
                                                </div>
                                                <?php
                                                echo '<img src="data:image/' . $ImgType . ';base64,' . base64_encode($Img) . '" class="card-img-contain object-fit-cover rounded-top bg-light"
                                            style="height:10rem; object-fit: scale-down;" alt=""/>';
                                                ?>
                                            </div>
                                            <div class="card-body border">
                                                <h5 class="mb-0"
                                                    style="width: 99%; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                                                    <?php echo $Name; ?>
                                                </h5>
                                                <p class="mb-0" name="anthor">
                                                    <?php echo $FirstName . "," . $LastName ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <?php

                                }
                            }
                        }

                    } else {
                        $stu_Subject = $rc['Subject'];
                        if (strpos($stu_Subject, ',')) {
                            $stu_Subject_array = explode(',', $stu_Subject);

                        } else {
                            $stu_Subject_array = array();
                            array_push($stu_Subject_array, $stu_Subject);
                        }

                        $sql = "SELECT
                                    stunotes.NotesID,
                                    COUNT(stunotes.NotesID)
                                FROM
                                    stunotes,
                                    notes
                                WHERE
                                    notes.NotesID = stunotes.NotesID 
                                    AND notes.State = 'public' 
                                    AND (notes.Subject = ";

                        $sql = $sql . ' "' . $stu_Subject_array[0] . '" ';

                        if (count($stu_Subject_array) > 1) {
                            foreach ($stu_Subject_array as $stu_Subject_index) {
                                $sql = $sql . ' OR notes.Subject =  "' . $stu_Subject_index . '" ';
                            }
                        }

                        $sql = $sql . ") GROUP BY
                                stunotes.`NotesID`
                            ORDER BY
                                COUNT(stunotes.NotesID)
                            DESC";

                        $result = mysqli_query($conn, $sql);
                        $num = mysqli_num_rows($result);

                        $notesID_list = array();

                        while ($rc = mysqli_fetch_assoc($result)) {
                            array_push($notesID_list, $rc['NotesID']);
                        }

                        if (count($notesID_list) < 4) {


                            $sql = "SELECT stunotes.NotesID,COUNT(stunotes.NotesID) 
                            FROM stunotes,notes 
                            WHERE notes.NotesID = stunotes.NotesID 
                            AND notes.State = 'public'";

                            foreach ($notesID_list as $notesID_list_index) {
                                $sql .= ' AND notes.NotesID !=  ' . $notesID_list_index . ' ';
                            }

                            $sql .= " GROUP BY stunotes.`NotesID` 
                                    ORDER BY COUNT(stunotes.NotesID) DESC";




                            $result = mysqli_query($conn, $sql);

                            if ($result) {

                                while ($rc = mysqli_fetch_assoc($result)) {
                                    array_push($notesID_list, $rc['NotesID']);
                                }
                            }
                        }


                        if (count($notesID_list) > 4) {
                            $notesID_list = array_slice($notesID_list, 0, 4);
                        }

                        foreach ($notesID_list as $notes_id) {
                            $sql = "SELECT notes.*,tutor.LastName,tutor.FirstName 
                                    FROM notes,tutor
                                    WHERE notes.TutorID = tutor.TutorID 
                                    AND NotesID = " . $notes_id;

                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {

                                while ($rc = mysqli_fetch_assoc($result)) {
                                    extract($rc);
                                    ?>

                                    <div class="col-lg-3 col-md-6"
                                         onclick="location.href='viewNotesDetails.php?notesId=<?php echo $NotesID ?>';">
                                        <div class="card shadow" style="width: 15rem ;">

                                            <div>
                                                <div class="position-absolute rounded bg-warning px-1" name="subject">
                                                    <?php echo $Subject; ?>
                                                </div>
                                                <?php
                                                echo '<img src="data:image/' . $ImgType . ';base64,' . base64_encode($Img) . '" class="card-img-contain object-fit-cover rounded-top bg-light"
                                            style="height:10rem; object-fit: scale-down;" alt=""/>';
                                                ?>
                                            </div>
                                            <div class="card-body border">
                                                <h5 class="mb-0"
                                                    style="width: 99%; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                                                    <?php echo $Name; ?>
                                                </h5>
                                                <p class="mb-0" name="anthor">
                                                    <?php echo $FirstName . "," . $LastName ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <?php

                                }
                            }
                        }
                    }

                }

                ?>

                <div class="container border border-2 mb-4 bg-light text-dark shadow-lg p-0 rounded-pill">
                    <div class="col-2 h4 p-1">ALL Notes</div>
                </div>

                <?php

            }

            if (isset($_GET['fliterSubmit']) && !($_GET['filterSubject'] == "all")) {
                $sql = "SELECT notes.*,tutor.LastName,tutor.FirstName FROM notes,tutor
          WHERE notes.TutorID = tutor.TutorID 
          AND State = 'public'
          AND notes.Subject = '" . $_GET['filterSubject'] . "'";
            } else {
                $sql = "SELECT notes.*,tutor.LastName,tutor.FirstName FROM notes,tutor
          WHERE notes.TutorID = tutor.TutorID 
          AND State = 'public'";
            }

            $result = $conn->query($sql);
            $num = mysqli_num_rows($result);

            if ($num >= 1) {

                $conn->close();
            } else {

                echo "<div class='h1 border p-5'>
          No Notes Found ~
          <i class='fa-solid fa-face-sad-tear text-warning'></i>
          </div>";
            }

            while ($rc = mysqli_fetch_assoc($result)) {
                extract($rc);
                ?>

                <div class="col-lg-3 col-md-6"
                     onclick="location.href='viewNotesDetails.php?notesId=<?php echo $NotesID ?>';">
                    <div class="card shadow" style="width: 15rem ;">

                        <div>
                            <div class="position-absolute rounded bg-warning px-1" name="subject">
                                <?php echo $Subject; ?>
                            </div>
                            <?php
                            echo '<img src="data:image/' . $ImgType . ';base64,' . base64_encode($Img) . '" class="card-img-contain object-fit-cover rounded-top bg-light"
                        style="height:10rem; object-fit: scale-down;" alt=""/>';
                            ?>
                        </div>
                        <div class="card-body border">
                            <h5 class="mb-0"
                                style="width: 99%; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                                <?php echo $Name; ?>
                            </h5>
                            <p class="mb-0" name="anthor">
                                <?php echo $FirstName . "," . $LastName ?>
                            </p>
                        </div>
                    </div>
                </div>

                <?php
            }
            ?>

        </div>
    </div>
</section>

<!--  <section id="pagination">-->
<!--    <div class="container">-->
<!--      <div class="row">-->
<!--        <div class="col d-flex justify-content-center ">-->
<!---->
<!--          <nav aria-label="Page navigation">-->
<!--            <ul class="pagination shadow">-->
<!--              <li class="page-item"><a class="page-link" href="#">Previous</a></li>-->
<!--              <li class="page-item"><a class="page-link" href="#">1</a></li>-->
<!--              <li class="page-item"><a class="page-link" href="#">2</a></li>-->
<!--              <li class="page-item"><a class="page-link" href="#">3</a></li>-->
<!--              <li class="page-item"><a class="page-link" href="#">Next</a></li>-->
<!--            </ul>-->
<!--          </nav>-->
<!---->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!---->
<!--  </section>-->

<script src="../../js/jquery.min.js"></script>
<script src="../../js/bootstrap.bundle.min.js"></script>
<script src="../../js/owl.carousel.min.js"></script>
<script src="../../js/app.js"></script>
</body>

</html>