<?php

require_once("conn.php");

require_once('Common/header.php');
$tEmail = $_SESSION['Email'];
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
    echo "Error ";
}


/*$sql = "SELECT * FROM book,account,teacher
WHERE book.teacherId = teacher.teacherId 
AND teacher.userId = account.userId ";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);*/


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <title>Your Profile</title>

    <!--    jquery code-->
    <script>
        function askCourseDelete(elementID) {
            cid = document.getElementById('delCID_' + elementID).value;
            if (confirm('Delete Course, course ID :' + cid + '?')) {
                // Save it!
                location.href = 'delCourse.php?CourseID=' + cid;

            }

        }

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
                $("#dse_block").show();
            });
            $("#course_btn").click(function () {
                /*hide*/
                $("#myProfile").hide();
                $("#rating_block").hide();
                $("#dse_block").hide();
                /*show*/
                $("#course_block").show();
            });

            $("#rate_btn").click(function () {
                /*hide*/
                $("#myProfile").hide();
                $("#course_block").hide();
                $("#dse_block").hide();
                /*show*/
                $("#rating_block").show();
            });

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
                                <p class="text-secondary mb-1">
                                    <?php echo $detail; ?>
                                </p>


                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class="btn btn-brand" target="__blank" href="page_teacher_editProfile.php">Edit
                                        Profile
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <ul class="list-group list-group-flush">
                        <div class="btn-group-vertical">
                            <a id="profile_btn" href="#" class="btn btn-brand active" aria-current="page">My
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
                <!--DSE and diploma start-->
                <div class="row gutters-sm" id="dse_block">
                    <div class="col-sm-12 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="d-flex align-items-center mb-3"><i class="material-icons text-brand mr-2">DSE
                                        Scanner</i>
                                </h5>
                                <h4>There not any result</h4>
                                <!--									submit doc-->
                                <a href="page_dse_result.php">Click Here To Edit Your Hong Kong Diploma of Secondary
                                    Education Examination Result Table </a>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- profile end-->

                <!-- Course List -->
                <?php

                $conn = getDBconn();

                $sql = "SELECT * FROM course WHERE cState ='public' AND TutorID=" . $tutorID . ";";


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
                                <h4>Course</h4> &nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-outline-dark"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#courseDetail"
                                                                                onclick="location.href='createCourse.php';">
                                    Add Course
                                </button>&nbsp;
                                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#courseDetail"
                                        onclick="location.href='teacher_schedule.php';">
                                    Manage Course
                                </button>
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
                                                            <button type="button" class="btn btn-danger" onclick="askCourseDelete(' . $i . ');">Delete</button>
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
                                                            <h4>Course</h4> &nbsp;&nbsp;&nbsp;&nbsp;<button
                                                                    class="btn btn-outline-dark" data-bs-toggle="modal"
                                                                    data-bs-target="#courseDetail"
                                                                    onclick="location.href='createCourse.php';">
                                                                Add Course
                                                            </button>
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
                            <h6>Course ID</h6>
                            <div>' . $row['CourseID'] . '</div>
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
                            <div class="modal-footer">
                               
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

                                                        <?php
                                                        // mysqli_free_result($result);
                                                        $conn = getDBconn();

                                                        $sql = "SELECT * FROM tutor_rating,student
                                                                    WHERE tutor_rating.StudentID = student.StudentID 
                                                                    AND tutor_rating.TutorID = " . $tutorID;

                                                        // book_rating.bookId =".$_GET['bookId']

                                                        $result = $conn->query($sql);
                                                        $num = mysqli_num_rows($result);

                                                        if ($num >= 1) {
                                                            // extract(mysqli_fetch_assoc($result));
                                                            // mysqli_free_result($result);
                                                            $conn->close();
                                                        } else {
                                                            echo "Error ,no Rating Comment found";
                                                        }


                                                        while ($rc = mysqli_fetch_assoc($result)) {
                                                            extract($rc);

                                                            ?>


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
                                                    </div>
                                                </div>
                                            </div>


                                    </div>

                                </div>
                            </div>

                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="RatingModal" tabindex="-1" aria-hidden="true">
                            <form action="">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="RatingModalLabel">Modal title</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col text-center h4 text-brand">
                                                    Your Raing : 4/5 .
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col text-center h4">
                                                    <i id="star_1" onclick="InputRating(1)"
                                                       class="ratingStar fa-solid fa-star text-warning"></i>
                                                    <i id="star_2" onclick="InputRating(2)"
                                                       class="ratingStar fa-solid fa-star text-warning"></i>
                                                    <i id="star_3" onclick="InputRating(3)"
                                                       class="ratingStar fa-solid fa-star text-warning"></i>
                                                    <i id="star_4" onclick="InputRating(4)"
                                                       class="ratingStar fa-solid fa-star text-warning"></i>
                                                    <i id="star_5" onclick="InputRating(5)"
                                                       class="ratingStar fa-regular fa-star text-warning"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <input type="text" name="comment"
                                                       placeholder="Write down your comment in here. ">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="button" class="btn btn-brand">Comment</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <script>
                            function InputRating() {

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
