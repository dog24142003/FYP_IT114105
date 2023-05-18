<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/FYP/tutorCat/Common/header_abosulte.php");


$conn = mysqli_connect("localhost", "root", "", "tutorcatdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_once("$root/FYP/tutorCat/Common/fun_getPosition.php");

$position = getPosition();

if ($position != "Student") {
    echo '<script type="text/javascript"> window.location.replace("../../logout.php"); </script>';
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

            if (isset($_GET['fliterSubmit']) && !($_GET['filterSubject'] == "all")) {
                $sql = "SELECT notes.*,tutor.LastName,tutor.FirstName FROM notes,tutor,stunotes
                          WHERE notes.TutorID = tutor.TutorID 
                          AND State = 'public' 
                          AND stunotes.NotesID = notes.NotesID
                          AND stunotes.StudentID = '" . $_SESSION['StudentID'] . "'.
                          AND notes.Subject = '" . $_GET['filterSubject'] . "'";
            } else {
                $sql = "SELECT notes.*,tutor.LastName,tutor.FirstName FROM notes,tutor,stunotes
                      WHERE notes.TutorID = tutor.TutorID
                      AND State = 'public'
                      AND stunotes.NotesID = notes.NotesID
                      AND stunotes.StudentID = '" . $_SESSION['StudentID'] . "'";
            }

            $result = $conn->query($sql);

            if ($result) {
                $num = mysqli_num_rows($result);
            } else {
                $num = 0;
            }


            if ($num >= 1) {

                $conn->close();
            } else {

                echo "<div class='h1 border p-5'>
          No Notes Found ~
          <i class='fa-solid fa-face-sad-tear text-warning'></i>
          </div>";
            }

            if ($result) {


                while ($rc = mysqli_fetch_assoc($result)) {
                    extract($rc);
                    ?>

                    <div class="col-lg-3 col-md-6"
                         onclick="location.href='../../Common/notes/viewNotesDetails.php?notesId=<?php echo $NotesID ?>';">
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
            ?>

        </div>
    </div>
</section>


<script src="../../js/jquery.min.js"></script>
<script src="../../js/bootstrap.bundle.min.js"></script>
<script src="../../js/owl.carousel.min.js"></script>
<script src="../../js/app.js"></script>
</body>

</html>