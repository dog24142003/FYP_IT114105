<?php
require_once("conn.php");
require_once('Common/header.php');

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/FYP/tutorCat/Common/fun_getPosition.php");
$position = getPosition();

$account = $_SESSION['account'];


$tEmail = $_GET['Email'];
if ($account == 'Tutor') {
    $tutorID = $_SESSION['TutorID']; ?>
    <script type='text/javascript'>
        $(document).ready(function () {
            document.getElementById("bkCourse").style.display = "none";
        });


    </script>

    <!-- <script>document.getElementById("bkCourse").setAttribute("hidden", "hidden");</script>'; -->
    <?php
} else {
    $studentID = $_SESSION['StudentID'];
}

$result = mysqli_query(getDBconn(), "SELECT * FROM tutor WHERE Email='$tEmail';");
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $tname = $row['FirstName'] . ' ' . $row['LastName'];
        $fname = $row['FirstName'];
        $lname = $row['LastName'];
        $tEmail = $row['Email'];
        $tutorID = $row['TutorID'];
        $tPhone = $row['Phone'];
        $detail = $row['Description'];
        $icon = $row['IconImg'];
        $iconType = $row['IconImgType'];
        if ($icon == null) {
            $icon = '<img src="img/logo.jpg"  class="rounded-circle" ';
        } else {
            $icon = '<img src="data:image/' . $iconType . ';base64,' . base64_encode($icon) . '" class="rounded-circle" width="200" height="200" alt=""/>';
        }
    }

    //    extract($result);
} else {
    echo "Error";
}


/*$sql = "SELECT * FROM book,account,teacher
WHERE book.teacherId = teacher.teacherId 
AND teacher.userId = account.userId ";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);*/

?>
<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<head>
    <meta charset="utf-8">

    <title>Your Profile</title>
    <!--    jquery code-->
    <script>
        $(document).ready(function () {
            $("#course_block").hide();
            $("#dse_diploma").hide();
            $("#rating_block").hide();

            $("#profile_btn").click(function () {
                /*hide*/
                $("#course_block").hide();
                $("#rating_block").hide();
                /*show*/
                $("#myProfile").show();
            });
            $("#course_btn").click(function () {
                /*hide*/
                $("#myProfile").hide();
                $("#rating_block").hide();
                /*show*/
                $("#course_block").show();
            });

            $("#rate_btn").click(function () {
                /*hide*/
                $("#myProfile").hide();
                $("#course_block").hide();
                /*show*/
                $("#rating_block").show();
            });
            var date = new Date();
            var year = date.getFullYear();
            var month = date.getMonth() + 1;
            var day = date.getDate();
            var curDate = day + "/" + month + "/" + year;

            $("#current_date").val(curDate);
        });
    </script>

</head>

<body>

<div class="container">
    <div class="main-body">
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">

                            <div class="mt-3">
                                <?php echo $icon; ?>
                                <h4>
                                    <?php echo $tname; ?>
                                </h4>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a class="btn btn-danger" target="__blank" data-bs-toggle="modal"
                                           data-bs-target="#report_modal">Report
                                        </a>

                                    </div>
                                </div>
                                <p class="text-secondary mb-1">
                                    <?php echo $detail; ?>
                                </p>


                            </div>

                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <ul class="list-group list-group-flush">
                        <div class="btn-group-vertical">
                            <a id="profile_btn" href="#" class="btn btn-brand active" aria-current="page">
                                Profile</a>
                            <a id="course_btn" href="#" class="btn btn-brand">Course</a>
                            <a id="note_btn" href="./teacher/notes/viewNotesList.php?tutorID=<?php echo $tutorID ?>"
                               class="btn btn-brand">Notes</a>
                            <a id="rate_btn" href="#" class="btn btn btn-brand">Rating</a>

                        </div>
                    </ul>
                </div>
            </div>
            <!--                profile start-->
            <div class="col-md-8">
                <div id="myProfile" class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="fname" class="form-control" value="<?php echo $tname; ?>"
                                       readonly="true">

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="Email" class="form-control" value="<?php echo $tEmail; ?>"
                                       readonly="true">

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">+ 852</span>
                                    <input type="number" class="form-control" name="Phone"
                                           value="<?php echo $tPhone; ?>" readonly="true">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- profile end-->
                <!--DSE and diploma start-->
                <div id="dse_diploma" class="row gutters-sm">
                    <div class="col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="d-flex align-items-center mb-3"><i
                                            class="material-icons text-brand mr-2">DSE</i>
                                </h5>
                                <h6>Still not input</h6>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="d-flex align-items-center mb-3"><i class="material-icons text-brand mr-2">Diploma</i>
                                </h5>
                                <h6>大學:科技大學畢業<br><br>科目:企業管理</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Course List -->
                <?php

                $conn = getDBconn();

                $sql = "SELECT * FROM course WHERE cState ='public' AND TutorID=" . $tutorID;


                $result = $conn->query($sql);
                $num = mysqli_num_rows($result);


                if ($num >= 1) {
                // extract(mysqli_fetch_assoc($result));
                // mysqli_free_result($result);
                $conn->close();

                while ($row = mysqli_fetch_assoc($result)) {
                    $results[] = $row;
                    $courseID = $row['CourseID'];
                }
                ?>
                <div class="col" id="course_block">
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Course</h4> &nbsp;&nbsp;&nbsp;&nbsp;
                                <!-- <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#courseDetail" onclick="location.href='createCourse.php';">
                                    Add Course
                                </button> -->
                            </div>
                            <div class="card-body">
                                <div class="media-list position-relative">
                                    <div class="table-responsive" id="project-team-scroll" tabindex="1"
                                         style="height: 400px; overflow: hidden; outline: none">
                                        <table class="table table-hover table-xl mb-0">
                                            <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($results as $key => $result) {

                                                echo '
                                                    <input type="hidden" name="courseID" id="delCID_' . $i . '" value="' . $result['CourseID'] . '" />
                                                    <tr>
                                                        <td class="text-truncate">' . $result['CName'] .
                                                    '<br/>
                                                            <div class="text-muted">' . $result['Description'] . '</div>
                                                        </td>

                                                        <td class="text-truncate">$' . $result['Cost'] . '</td>
                                                        <td class="text-truncate">
                                                            <button class="btn btn-outline-dark" data-bs-toggle="modal"
                                                                data-bs-target="#courseDetail' . $i . '">
                                                                Show Detail
                                                            </button>
                                                        </td>
                                                    </tr>';
                                                // onclick="location.href=\'delCourse.php?CourseID='.$result['CourseID'].'\'"
                                                $i++;
                                            }
                                            } else {
                                            ?>
                                            <div class="col" id="course_block">
                                                <div class="col-12 col-sm-12 col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Course</h4> &nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="media-list position-relative">
                                                                <div class="table-responsive" id="project-team-scroll"
                                                                     tabindex="1"
                                                                     style="height: 400px; overflow: hidden; outline: none">
                                                                    <table class="table table-hover table-xl mb-0">
                                                                        <tbody>
                                                                        <?php echo "<tr><td>No Course</tr></td>";
                                                                        }

                                                                        ?>
                                                                        </tbody>


                                                                    </table>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Course Modal -->
                                            <?php
                                            $conn = getDBconn();

                                            $sql = "SELECT * FROM course WHERE cState ='public' AND TutorID=" . $tutorID;
                                            $result = $conn->query($sql);
                                            if ($num >= 1) {
                                                $totalCourseID = [];
                                                $j = 0;
                                                $showDate = '';
                                                while ($row = $result->fetch_assoc()) {
                                                    $sql1 = "SELECT * FROM Schedule WHERE CourseID=" . $row['CourseID'];
                                                    $result1 = $conn->query($sql1);

                                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                                        $showDate .= "" . $row1['Date'] . "<br> ";
                                                    }
                                                    $courseTime = date("g:i a", strtotime($row['Time']));
                                                    $endTime = date("g:i a", strtotime($row['Time'] . ' + ' . $row['Hour'] . ' hours'));
                                                    echo '
                <div class="modal fade" id="courseDetail' . $j . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Course Detail</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <h6>Name</h6>
                            <div>' . $row['CName'] . '</div>
                            <h6>Subject</h6>
                            <div>' . $row['Subject'] . '</div>
                            <h6>Description</h6>
                            <div>' . $row['Description'] . '</div>
                            <h6>Total Price</h6>
                            <div>$' . $row['Cost'] * $row['NoOfClass'] . '</div>
                            <h6>Date</h6>
                            <div>' . $showDate . '</div>
                            <h6>Time</h6>
                            <div>' . $courseTime . '-' . $endTime . '</div>
                            <h6>Lessons</h6>
                            <div>' . $row['NoOfClass'] . '</div>
                            </div>
                            <div class="modal-footer" >
                                <button type="button" id="bkCourse"  class="btn btn-danger" onclick="location.href=\'buyCourse.php?CourseID=' . $row['CourseID'] . '\'">Book</button>
                            </div>
                        </div>
                    </div>
                </div>';
                                                    $j++;
                                                    $showDate = "";
                                                }
                                            } else {
                                                echo '';
                                            }

                                            ?>

                                            <div class="col">
                                                <div id="rating_block" class="card mb-3">
                                                    <div class="card-body">
                                                        <!-- mark -->


                                                        <div class="row p-0 m-3 mb-3 ">
                                                            <p class="h2 text-start border bg-warning rounded-pill px-4 p-2">
                                                                Comment</p>
                                                        </div>

                                                        <?php

                                                        $position = getPosition();

                                                        if ($position == "Student") {
                                                            $sql = "SELECT
                                                                    tutor_rating.*,
                                                                    tutor.Email,
                                                                    student.StudentID,
                                                                    student.FirstName,
                                                                    student.LastName,
                                                                    student.IconImg
                                                                    ,student.IconImgType
                                                                    FROM tutor_rating,tutor,student 
                                                                    WHERE tutor_rating.StudentID = " . $_SESSION['StudentID'] . "
                                                                    AND tutor_rating.TutorID = tutor.TutorID 
                                                                    AND student.StudentID = tutor_rating.StudentID
                                                                    AND tutor.Email = '" . $_GET['Email'] . "' 
                                                                    GROUP BY TutorID,student.StudentID;";


                                                            $result = $conn->query($sql);
                                                            if ($result) {
                                                                $num = mysqli_num_rows($result);
                                                            }

                                                            if ($num == 1) {

                                                                $rc = mysqli_fetch_assoc($result);
                                                                extract($rc);

                                                                ?>
                                                                <div class="row border rounded-pill text-white px-4 p-3 m-3 shadow h5 bg-secondary">
                                                                    Here is your Comment
                                                                </div>


                                                                <div class="row border rounded-pill p-3 m-3 bg-light shadow">
                                                                    <div class="col-3">
                                                                        <?php

                                                                        if ($IconImg == null) {
                                                                            echo '<img src="img/logo.jpg" class="rounded-circle object-fit-cover border">';
                                                                        } else {
                                                                            echo '<img src="data:image/' . $IconImgType . ';base64,' . base64_encode($IconImg) . '" class="rounded-circle object-fit-cover">';
                                                                        }

                                                                        ?>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <div class="row">
                                                                            <div class="col-6 text-start border-warning border border-2 text- rounded-pill"
                                                                                 name="RatingBy_UserName">
                                                                                <?php echo $FirstName . ", " . $LastName ?>
                                                                            </div>
                                                                            <div class="col-3 d-flex">
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
                                                                        <div class="row text-start"
                                                                             name="commentContent">
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

                                                                $sql = "SELECT
                                                                            tutor_rating.*,
                                                                            tutor.Email,
                                                                            student.FirstName,
                                                                            student.LastName,
                                                                            student.IconImg
                                                                            ,student.IconImgType
                                                                            FROM tutor_rating,tutor,student 
                                                                            WHERE tutor_rating.StudentID != " . $_SESSION['StudentID'] . "
                                                                            AND tutor_rating.TutorID = tutor.TutorID 
                                                                            AND student.StudentID = tutor_rating.StudentID
                                                                            AND tutor.Email = '" . $_GET['Email'] . "' 
                                                                            GROUP BY TutorID,StudentID;";
                                                            } else {
                                                                echo '
                                                                                <div class="row border p-3 m-3 mb-32 h5 bg-light rounded-pill">
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


                                                                $sql = "SELECT
                                                                            tutor_rating.*,
                                                                            tutor.Email,
                                                                            student.FirstName,
                                                                            student.LastName,
                                                                            student.IconImg
                                                                            ,student.IconImgType
                                                                            FROM tutor_rating,tutor,student 
                                                                            WHERE tutor_rating.StudentID != " . $_SESSION['StudentID'] . "
                                                                            AND tutor_rating.TutorID = tutor.TutorID 
                                                                            AND student.StudentID = tutor_rating.StudentID
                                                                            AND tutor.Email = '" . $_GET['Email'] . "' 
                                                                            GROUP BY TutorID,StudentID;";
                                                            }
                                                        } else {

                                                            $sql = "SELECT
                                                                        tutor_rating.*,
                                                                        tutor.Email,
                                                                        student.FirstName,
                                                                        student.LastName,
                                                                        student.IconImg
                                                                        ,student.IconImgType
                                                                        FROM tutor_rating,tutor,student 
                                                                        WHERE student.StudentID = tutor_rating.StudentID
                                                                        AND tutor_rating.TutorID = tutor.TutorID 
                                                                        AND tutor.Email = '" . $_GET['Email'] . "'
                                                                        GROUP BY TutorID,StudentID;";
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
                                                                <div class="col-3">
                                                                    <?php

                                                                    if ($IconImg == null) {
                                                                        echo '<img src="img/logo.jpg" class="rounded-circle object-fit-cover border">';
                                                                    } else {
                                                                        echo '<img src="data:image/' . $IconImgType . ';base64,' . base64_encode($IconImg) . '" class="rounded-circle object-fit-cover">';
                                                                    }

                                                                    ?>
                                                                </div>
                                                                <div class="col-7">
                                                                    <div class="row">
                                                                        <div class="col-6 text-start border-warning border border-2 text- rounded-pill"
                                                                             name="RatingBy_UserName">
                                                                            <?php echo $FirstName . ", " . $LastName ?>
                                                                        </div>
                                                                        <div class="col-4 d-flex">
                                                                            <?php
                                                                            for ($i = 0; $i < $Rating; $i++)
                                                                                echo '<p class="d-inline fa-sharp fa-solid fa-star text-warning"></p>';

                                                                            for ($i = 0; $i < 5 - $Rating; $i++)
                                                                                echo '<p class="d-inline fa-sharp fa-solid fa-star"></p>';

                                                                            ?>
                                                                        </div>

                                                                        <?php

                                                                        if (isset($_SESSION['account'])) {
                                                                            ?>

                                                                            <div class="col-2  align-self-center">

                                                                                <a data-bs-toggle="modal"
                                                                                   data-bs-target="#ReportModal_Comment"
                                                                                   onclick="report('<?php echo $FirstName; ?>','<?php echo $LastName; ?>','<?php echo $RatingDate; ?>','<?php echo $Comment; ?>','<?php echo $StudentID; ?>')">
                                                                                    <i class="fa-sharp fa-regular fa-flag h3 text-danger"></i>
                                                                                </a>
                                                                            </div>

                                                                            <?php
                                                                        } ?>
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
                                                            <!--loop end here  -->


                                                            <?php
                                                        }
                                                        ?>

                                                        <!-- mark -->
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <!-- rate Modal -->
                        <div class="modal fade" id="RatingModal" tabindex="-1" aria-hidden="true">
                            <form action="student/TutorRating/doTutorRating.php" method="post"
                                  onsubmit="return ratingOnSubmit();">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="RatingModalLabel">Rating</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col text-center">
                                                    minimal rating is one Star.
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col text-center h4 text-brand">
                                                    Your Raing for this tutor:
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
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <input type="hidden" id="rating" name="rating" value="">
                                            <input type="hidden" name="TutorID" value="<?php echo $tutorID ?>">
                                            <input type="submit" class="btn btn-brand" name="ratingFm" value="Comment">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- rate Model end-->
                        <!-- report Model start                              -->
                        <div class="modal fade" id="report_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-body p-0">

                                        <div class="container-fluid">
                                            <div class="row gy-4">
                                                <div class="col-lg-4 col-sm-12 bg-cover"
                                                     style="background-image: url(img/c2.jpg); min-height: 300px">
                                                    <div></div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <form class="p-lg-5 col-12 row g-3" enctype="multipart/form-data"
                                                          action="createReport.php" method="post">
                                                        <div>
                                                            <h1>Reporting</h1>

                                                            <span class="badge bg-info text-dark">User:<?php echo $tname; ?></span>

                                                        </div>

                                                        <input type="hidden" name="getter"
                                                               value="<?php echo $tEmail; ?>">
                                                        <input type="hidden" name="dateTime" id="current_date" value="">
                                                        <div class="col-8">
                                                            <label for="email" class="form-label">Report Reason</label>

                                                            <select name="reason_Option"
                                                                    class="form-select form-select-lg mb-3"
                                                                    aria-label=".form-select-lg example">
                                                                <option value="" disabled selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="harassment">Harassment</option>
                                                                <option value="Threats">Threats to personal safety
                                                                </option>
                                                                <option value="Sexual">Sexual content</option>
                                                                <option value="hateSpeech">Hate speech</option>
                                                                <option value="CourseCon">Course content does not match
                                                                    the course details
                                                                </option>
                                                            </select>
                                                            <label for="" class="form-label">Upload evidence
                                                                Video/Image</label>
                                                            <input type="file" name="fileToUpload" id="fileToUpload">


                                                        </div>
                                                        <div class="col-8">
                                                            <label for="password" class="form-label">Report
                                                                Detail</label>
                                                            <textarea name="Description" class="form-control"
                                                                      placeholder="Enter Here" id="floatingTextarea2"
                                                                      style="height:100px"></textarea>

                                                        </div>
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-brand" name="submit">
                                                                Send
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!--reportmodal-->
                        <div class="modal fade" id="ReportModal_Comment" tabindex="-1"
                             aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <form action="Common/Profile/doReportTutorCm.php" method="post">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Report </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
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
                                                            <input class="form-check-input" type="radio"
                                                                   name="report_reason"
                                                                   id="report_reason1" checked value="improper speech">
                                                            <label class="form-check-label" for="report_reason2">
                                                                improper speech
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                   name="report_reason"
                                                                   id="report_reason2"
                                                                   value="inappropriate promotion message">
                                                            <label class="form-check-label" for="report_reason">
                                                                inappropriate promotion message
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                   name="report_reason"
                                                                   value="verbally attack others">
                                                            <label class="form-check-label" for="report_reason">
                                                                verbally attack others
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                   name="report_reason"
                                                                   value="discriminatory speech">
                                                            <label class="form-check-label" for="report_reason">
                                                                discriminatory speech
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                   name="report_reason"
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

                                            <input type="hidden" value="<?php echo $tEmail; ?>" name="tutorPageEmail"
                                                   id="tutorPageEmail">
                                            <input type="hidden" value="" name="report_StudentID" id="report_StudentID">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" value="reported" class="btn btn-danger"
                                                    name="reportNotesCM">report it!
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <script>
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

                            function report(fName, lName, date, comment, reportedStuEm) {

                                //document.getElementById('report_Name').textContent = fName + lName;
                                //document.getElementById('report_comment').textContent = comment;
                                //document.getElementById('report_date').textContent = date;
                                //document.getElementById('report_comment').value = <?php //echo ""; ?>//;

                                document.getElementById('report_StudentID').value = reportedStuEm;
                                document.getElementById('report_Name').innerHTML = fName + "," + lName;
                                document.getElementById('report_comment').innerHTML = comment;
                                document.getElementById('report_date').innerHTML = date;
                            }


                            function myFunction(starNum) {
                                var x = document.querySelectorAll(".ratingStar");
                                x.classList.remove("fa-solid");

                                for (let i = 0; i < starNum; i++)

                                    x[0].style.backgroundColor = "red";
                            }
                        </script>


                        <style type="text/css">
                            body {

                                color: #1a202c;
                                text-align: left;
                                background-color: #e2e8f0;
                            }

                            .main-body {
                                padding: 15px;
                            }

                            .card {
                                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
                            }

                            .card {
                                position: relative;
                                display: flex;
                                flex-direction: column;
                                min-width: 0;
                                word-wrap: break-word;
                                background-color: #fff;
                                background-clip: border-box;
                                border: 0 solid rgba(0, 0, 0, .125);
                                border-radius: .25rem;
                            }

                            .card-body {
                                flex: 1 1 auto;
                                min-height: 1px;
                                padding: 1rem;
                            }

                            .gutters-sm {
                                margin-right: -8px;
                                margin-left: -8px;
                            }

                            .gutters-sm > .col,
                            .gutters-sm > [class*=col-] {
                                padding-right: 8px;
                                padding-left: 8px;
                            }

                            .mb-3,
                            .my-3 {
                                margin-bottom: 1rem !important;
                            }

                            .bg-gray-300 {
                                background-color: #e2e8f0;
                            }

                            .h-100 {
                                height: 100% !important;
                            }

                            .shadow-none {
                                box-shadow: none !important;
                            }

                            body {
                                background-color: #eee;
                            }

                            #icon {
                                object-fit: fill;
                            }
                        </style>

</body>

</html>