<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/FYP/tutorCat/Common/header_abosulte.php");
require_once("$root/FYP/tutorCat/Common/fun_getPosition.php");

$position = getPosition();

$conn = getDBconn();

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Prixima BS5 Template</title>
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">


<?php
$sql = "SELECT notes.*,tutor.FirstName,tutor.LastName,tutor.TutorID,tutor.Email FROM notes,tutor 
          WHERE notes.TutorID = tutor.TutorID
          AND NotesID = " . $_GET['notesId'];

$result = $conn->query($sql);
$num = mysqli_num_rows($result);

if ($num >= 1) {

    $rs = mysqli_fetch_assoc($result);
} else {
    echo '<script>alert("This Notes had not found.")</script>';
    echo '<script type="text/javascript"> window.location.replace("../../index.php"); </script>';
}

// if ($rs >= 1) {
//   extract($rs);
// } else {
//   echo '<script>alert("Book Cannot find!")</script>';
// }

extract($rs);

?>

<!-- BOTTOM NAV -->

<section id="HereIsMain" class="text-center">
    <div class="container">
        <div class="row mb-5 p-2 shadow rounded">
            <div class="col-8">
                <?php
                echo '<img src="data:image/' . $ImgType . ';base64,' . base64_encode($Img) . '"class="border"
            style="object-fit: contain; height: 35rem" />';
                ?>
                <div name="notesName"></div>
            </div>

            <div class="col-4 p-2">
                <div name="subject" class="bg-warning text-dark h4 rounded-pill">
                    <?php echo $Subject ?>
                </div>
                <div class="h3 text-start text-dark rounded-pill p-2 bg-light">
                    Notes Name:
                </div>
                <div name="notesName" class="h3 text-break text-start" style="height: 15%">
                    <?php echo $Name ?>
                </div>
                <div class="h4 text-start bg-light text-dark rounded-pill p-2">
                    author :
                </div>
                <div name="tutorName" class="h4 text-start" style="height: 15%">
                    <?php echo $FirstName . ", " . $LastName ?>
                </div>

                <div class="h4 text-start bg-light text-dark rounded-pill p-2">
                    Price :
                </div>

                <div name="NotesPrice" class="h4 text-start text-info">
                    $
                    <?php echo $Price ?>
                </div>

                <div class="row text-center p-2 d-flex justify-content-center mb-3">


                </div>

                <div class="row">
                    <?php
                    if ($position == 'Tutor') {

                        if ($_SESSION['TutorID'] == $TutorID) {
                            echo '
                  <div class="col">
                    <form action="../../teacher/notes/doDelNotes.php" method="post">
                      <input type="hidden" name="notesID" value="' . $_GET['notesId'] . '">
                      <input type="hidden" name="delnotesFm" value="Yes">
                      <input type="button" id="delNotesBtn" class="btn btn-danger" value="Delete"/>
                    </form>
                  </div>
                ';

                            echo '
                  <div class="col">
                    <a href="data:application/pdf;base64,' . base64_encode($PDF) . '" class= "btn btn-secondary" download >Download</a>
                  </div>
                ';

                            echo '
                  <div class="col">
                    <form action="../../teacher/notes/editNotes.php" class="d-inline" method="post">
                      <input type="hidden" name="notesID" value="' . $_GET['notesId'] . '">
                      <input type="submit" class="btn btn-warning" name="DeleteNotes" value="Edit" />
                    </form>
                  </div>
                ';
                        } else {

                            echo '
                  <div class="col">
                    <form action="../../page_viewTeacher_profile.php" method="get">
                      <input type="hidden" name="Email" value="' . $Email . '">
                      <input type="submit" id="delNotesBtn" class="btn btn-warning" value="View Tutor Profile"/>
                    </form>
                  </div>
                ';
                        }
                    }

                    if ($position == "Student") {

                        $sql = "SELECT * FROM stunotes 
              WHERE StudentID =" . $_SESSION['StudentID'] . "
              AND NotesID = " . $_GET['notesId'];

                        $result = $conn->query($sql);
                        $num = mysqli_num_rows($result);

                        if ($num == 1) {

                            $haveNotes = true;
                        } else {

                            $haveNotes = false;
                        }

                        mysqli_free_result($result);

                        if ($haveNotes) {

                            echo '<div class="col">
                <a href="data:application/pdf;base64,' . base64_encode($PDF) . '" class= "btn btn-secondary" download >Download</a>
                </div>
                ';

                            echo '
                <div class="col">
                  <form action="../../page_viewTeacher_profile.php" method="get">
                    <input type="hidden" name="Email" value="' . $Email . '">
                    <input type="submit" id="delNotesBtn" class="btn btn-warning" value="View Tutor"/>
                  </form>
                </div>
                ';
                        } else {

                            echo '
                  <div class="col">
                    <form action="../../student/notes/buynotes.php" method="post">
                      <input name="tutorId" type="hidden" value="' . $TutorID . '"/>
                      <input name="notesId" type="hidden" value="' . $_GET['notesId'] . '"/>
                      <input type="submit" class="btn btn-info" value="BuyNotes" />
                    </form>
                  </div>
                  
                    <div class="col">
                    <form action="../../page_viewTeacher_profile.php" method="get">
                      <input type="hidden" name="Email" value="' . $Email . '">
                      <input type="submit" id="delNotesBtn" class="btn btn-warning" value="View Tutor"/>
                    </form>
                  </div>
                ';
                        }
                    }

                    if ($position == "Guest") {
                        echo '
              <div class="col">
                <form action="../../page_viewTeacher_profile.php" method="get">
                  <input type="hidden" name="Email" value="' . $Email . '">
                  <input type="submit" id="delNotesBtn" class="btn btn-warning" value="View Tutor"/>
                </form>
              </div>
            ';
                    }

                    ?>


                </div>

            </div>
        </div>


        <div class="row  rounded-3 p-3 shadow">
            <div class="col">

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                    <li class="nav-item" role="presentation">
                        <button class="nav-link active link-darkg rounded-pill" id="pills-details-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-details" type="button" role="tab"
                                aria-controls="pills-details" aria-selected="true">Details
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link link-dark rounded-pill" id="pills-rating-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-rating" type="button" role="tab" aria-controls="pills-rating"
                                aria-selected="false">Rating
                        </button>
                    </li>

                </ul>


                <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane fade show active" id="pills-details" role="tabpanel"
                         aria-labelledby="pills-details-tab">
                        <pre class="text-start bg-light border-3 border border-warning  p-3 rounded-3 shadow"
                             style="white-space: pre-wrap;"><?php echo $Detail ?></pre>
                    </div>

                    <div class="tab-pane fade " id="pills-rating" role="tabpanel" aria-labelledby="pills-rating-tab">
                        <!-- mark -->
                        <div class="row p-0 m-3 mb-3 ">
                            <p class="h2 text-start border bg-warning rounded-pill px-4 p-2">Comment</p>
                        </div>

                        <?php

                        if ($position == "Student") {
                            $sql = "SELECT * FROM notes_rating,student
                                    WHERE notes_rating.StudentID = " . $_SESSION['StudentID'] . "
                                    AND notes_rating.StudentID = student.StudentID 
                                    AND notes_rating.NotesID = " . $_GET['notesId'];

                            $result = $conn->query($sql);
                            $num = mysqli_num_rows($result);
                            if ($num == 1) {

                                $rc = mysqli_fetch_assoc($result);
                                extract($rc);

                                ?>
                                <div class="row border rounded-pill text-white px-4 p-3 m-3 shadow h5 bg-secondary">
                                    Here is your Comment
                                </div>

                                <div class="row border rounded-pill p-3 m-3 bg-light shadow">
                                    <div class="col-1">
                                        <?php

                                        if ($IconImg == null) {
                                            echo '<img src="../../img/logo.jpg" class="rounded-circle object-fit-cover border">';
                                        } else {
                                            echo '<img src="data:image/' . $IconImgType . ';base64,' . base64_encode($IconImg) . '" class="rounded-circle object-fit-cover">';
                                        }

                                        ?>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col-4 text-start border-warning border border-2 text- rounded-pill"
                                                 name="RatingBy_UserName">
                                                <?php echo $FirstName . ", " . $LastName ?>
                                            </div>
                                            <div class="col-2 ">
                                                <?php
                                                for ($i = 0; $i < $Rating; $i++)
                                                    echo '<p class="d-inline fa-sharp fa-solid fa-star text-warning"></p>';

                                                for ($i = 0; $i < 5 - $Rating; $i++)
                                                    echo '<p class="d-inline fa-sharp fa-solid fa-star"></p>';

                                                ?>
                                            </div>
                                        </div>
                                        <div class="row text-start" name="commentDate">
                                            <div class="col">
                                                <?php echo $RatingDate ?>
                                            </div>
                                        </div>
                                        <div class="row text-start" name="commentContent">
                                            <div class="col text-break">
                                                <?php echo $Comment ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row border rounded-pill px-4 p-3 m-3 bg-secondary shadow h5 text-white">
                                    Other
                                </div>
                                <?php

                                $sql = "SELECT * FROM notes_rating,student
                                          WHERE notes_rating.StudentID = student.StudentID 
                                          AND notes_rating.StudentID != " . $_SESSION['StudentID'] . "
                                          AND notes_rating.NotesID = " . $_GET['notesId'];
                            } else {

                                $sql = "SELECT * FROM stunotes
                                              WHERE StudentID = " . $_SESSION['StudentID'] . "
                                              AND NotesID = " . $_GET['notesId'];

                                $result = $conn->query($sql);
                                $num = mysqli_num_rows($result);
                                if ($num == 1) {
                                    echo '
                    <div class="row border p-3 m-3 mb-32 h4 bg-light rounded-pill">
                      <div class="col-7 d-inline">
                        Click Button To Rating For Notes!

                      </div>
                      <div class="col-1 ">
                        <i class="fa-solid fa-arrow-right text-warning h4"></i>
                      </div>
                      <div class="col-4">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#RatingModal">
                            Comment !
                        </button>
                      </div>
                    </div>
                    ';
                                }

                                $sql = "SELECT * FROM notes_rating,student
                                          WHERE notes_rating.StudentID = student.StudentID 
                                          AND notes_rating.StudentID != " . $_SESSION['StudentID'] . "
                                          AND notes_rating.NotesID = " . $_GET['notesId'];
                            }
                        } else {

                            $sql = "SELECT * FROM notes_rating,student
                                    WHERE notes_rating.StudentID = student.StudentID 
                                    AND notes_rating.NotesID = " . $_GET['notesId'];
                        }


                        $result = $conn->query($sql);
                        $num = mysqli_num_rows($result);

                        if ($num >= 1) {

                            $conn->close();
                        } else {
                            echo "<div class='h1 p-5'>
                        No Comment Found ~
                        <i class='fa-solid fa-face-sad-tear text-warning bg-dark rounded-circle'></i>
                      </div>";
                        }


                        while ($rc = mysqli_fetch_assoc($result)) {
                            extract($rc);

                            ?>

                            <!--loop here  -->
                            <div class="row border rounded-pill p-3 m-3 bg-light shadow">
                                <div class="col-1">
                                    <?php
                                    if ($IconImg == null) {
                                        echo '<img src="../../img/logo.jpg" class="rounded-circle object-fit-cover border">';
                                    } else {
                                        echo '<img src="data:image/' . $IconImgType . ';base64,' . base64_encode($IconImg) . '" class="rounded-circle object-fit-cover">';
                                    }
                                    ?>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-4 text-start border-warning border border-2 text- rounded-pill"
                                             name="RatingBy_UserName">
                                            <?php echo $FirstName . ", " . $LastName ?>
                                        </div>
                                        <div class="col-2 ">
                                            <?php
                                            for ($i = 0; $i < $Rating; $i++)
                                                echo '<p class="d-inline fa-sharp fa-solid fa-star text-warning"></p>';

                                            for ($i = 0; $i < 5 - $Rating; $i++)
                                                echo '<p class="d-inline fa-sharp fa-solid fa-star"></p>';

                                            ?>
                                        </div>
                                    </div>
                                    <div class="row text-start" name="commentDate">
                                        <div class="col">
                                            <?php echo $RatingDate ?>
                                        </div>
                                    </div>
                                    <div class="row text-start" name="commentContent">
                                        <div class="col text-break">
                                            <?php echo $Comment ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (isset($_SESSION['Email'])) {
                                    ?>
                                    <div class="col-4 d-flex justify-content-end ">
                                        <div class="row  align-self-center">

                                            <a data-bs-toggle="modal" data-bs-target="#ReportModal"
                                               onclick="report('<?php echo $FirstName; ?>','<?php echo $LastName; ?>','<?php echo $RatingDate; ?>','<?php echo $Comment; ?>','<?php echo $StudentID; ?>')">
                                                <i class="fa-sharp fa-regular fa-flag h3 text-danger"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                } ?>

                            </div>
                            <!--loop end here  -->


                            <?php
                        }
                        ?>

                    </div>
                    <!-- mark -->


                </div>

            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="RatingModal" tabindex="-1" aria-hidden="true">
    <form action="../../student/notes/doNotesRating.php" method="post" onsubmit="return ratingOnSubmit();">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="RatingModalLabel">Rating</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col text-center">
                            minimal rating is one Star.
                        </div>
                    </div>

                    <div class="row">
                        <div class="col text-center h4 text-brand">
                            Your Raing for this notes:
                            <a id="outputStar">0<a>/5
                        </div>
                    </div>

                    <div class="row">
                        <div class="col text-center h4">
                            <i id="star_1" onclick="InputRating(1)"
                               class="ratingStar fa-regular fa-star text-warning"></i>
                            <i id="star_2" onclick="InputRating(2)"
                               class="ratingStar fa-regular fa-star text-warning"></i>
                            <i id="star_3" onclick="InputRating(3)"
                               class="ratingStar fa-regular fa-star text-warning"></i>
                            <i id="star_4" onclick="InputRating(4)"
                               class="ratingStar fa-regular fa-star text-warning"></i>
                            <i id="star_5" onclick="InputRating(5)"
                               class="ratingStar fa-regular fa-star text-warning"></i>
                        </div>
                    </div>
                    <div class="row">
                        <input type="text" class="form-control" name="comment"
                               placeholder="Write down your comment in here. " required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="hidden" id="rating" name="rating" value="">
                    <input type="hidden" name="notesID" value="<?php echo $_GET['notesId'] ?>">
                    <input type="submit" class="btn btn-brand" name="ratingFm" value="Comment">
                </div>
            </div>

        </div>
    </form>
</div>

<!--reportmodal-->
<div class="modal fade" id="ReportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="doReportNoteCm.php" method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Report </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row p-3">

                        <div class="row text-center">
                            <h4>User Name</h4>
                            <p id="report_Name"></p>
                        </div>

                        <div class="row  text-center">
                            <h4>Comment</h4>
                            <p id="report_comment"></p>
                        </div>

                        <div class="row pb-3 text-center">
                            <h5>Date</h5>
                            <p id="report_date"></p>
                        </div>

                        <div class="row  text-start">
                            <h5 class="text-center">Reason of Report</h5>

                            <div style="padding-left : 5rem;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="report_reason"
                                           id="report_reason1" checked value="improper speech">
                                    <label class="form-check-label" for="report_reason2">
                                        improper speech
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="report_reason"
                                           id="report_reason2" value="inappropriate promotion message">
                                    <label class="form-check-label" for="report_reason">
                                        inappropriate promotion message
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="report_reason"
                                           value="verbally attack others">
                                    <label class="form-check-label" for="report_reason">
                                        verbally attack others
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="report_reason"
                                           value="discriminatory speech">
                                    <label class="form-check-label" for="report_reason">
                                        discriminatory speech
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="report_reason"
                                           value="other">
                                    <label class="form-check-label" for="report_reason">
                                        other
                                    </label>
                                </div>


                            </div>
                        </div>


                    </div>
                    <div class="row pb-3 text-center ">
                        <h5>detail</h5>
                        <input type="text" name="detail" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" name="report_StudentID" id="report_StudentID">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" value="reported" class="btn btn-danger" name="reportNotesCM">report it!
                    </button>
                </div>
            </div>
        </div>
    </form>
  </div>


<script>
    function ratingOnSubmit() {
        let rating = document.getElementById("rating").value;
        if (rating == null) {
            swal("please give your rating by clicking the stars.");
            return false;
        } else {
            swal("Rating Successful", "Thxz for your rating !", "success");
            return true;
        }
    }

    function InputRating(rating) {

        for (let i = 1; i < 5 + 1; i++) {
            document.getElementById("star_" + i).classList.remove("fa-solid");
            document.getElementById("star_" + i).classList.remove("fa-regular");
        }

        for (let i = rating; i > 0; i--) {
            document.getElementById("star_" + i).classList.add("fa-solid");
        }

        for (let i = rating + 1; i < 5 + 1; i++) {
            document.getElementById("star_" + i).classList.add("fa-regular");
        }

        document.getElementById("outputStar").innerHTML = rating;
        document.getElementById("rating").value = rating;
    }

    function report(fName, lName, date, comment, reportedStu) {

        //document.getElementById('report_Name').textContent = fName + lName;
        //document.getElementById('report_comment').textContent = comment;
        //document.getElementById('report_date').textContent = date;
        //document.getElementById('report_comment').value = <?php //echo ""; ?>//;

        document.getElementById('report_StudentID').value = reportedStu;
        document.getElementById('report_Name').innerHTML = fName + "," + lName;
        document.getElementById('report_comment').innerHTML = comment;
        document.getElementById('report_date').innerHTML = date;
    }


    $(document).ready(function () {

        $('input:radio[name="report_reason"]').change(
            function () {
                if (this.checked && this.value == 'other') {
                    $("#report_other_reason").prop('disabled', false);
                } else {
                    $("#report_other_reason").prop('disabled', true);
                    document.getElementById('report_other_reason').value = "";
                }
            });

        $('#delNotesBtn').on('click', function () {

            let $form = $(this).closest('form');

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success m-3',
                    cancelButton: 'btn btn-danger m-3'
                },
                buttonsStyling: false,
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure to delete this notes?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $form.submit();
                }
            });

        });


    });
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../../js/jquery.min.js"></script>
<script src="../../js/bootstrap.bundle.min.js"></script>
<script src="../../js/owl.carousel.min.js"></script>
<script src="../../js/app.js"></script>
</body>

</html>