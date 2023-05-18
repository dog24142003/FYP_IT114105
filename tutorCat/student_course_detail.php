<?php
require_once "conn.php";
require_once('Common/header.php');
// $studentID = $_SESSION['StudentID'];
$date = $_GET["date"];

$sql = "SELECT course.*, schedule.ScheduleID, schedule.state, schedule.StudentID, schedule.State, tutor.FirstName, tutor.LastName,tutor.SkypeAcc, tutor.Phone,  tutor.IconImg, tutor.IconImgType FROM Course, tutor, schedule WHERE studentID= '10003' AND date = '$date' AND tutor.TutorID=schedule.TutorID AND schedule.courseID = course.courseID;";
$result = mysqli_query(getDBconn(), $sql);
if ($result->num_rows > 0) {
    $showDate = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $tutorID = $row['TutorID'];
        $tname = $row['FirstName'] . ' ' . $row['LastName'];
        $cName = $row['CName'];
        $cost = $row['Cost'];
        $subject = $row['Subject'];
        $time = $row['Time'];
        $hour = $row['Hour'];
        $detail = $row['Description'];
        $noOfClass = $row['NoOfClass'];
        $iconImg = $row['IconImg'];
        $iconImgType = $row['IconImgType'];
        $total = $cost * $noOfClass;
        $courseTime  = date("g:i a", strtotime($row['Time']));
        $endTime  = date("g:i a", strtotime($row['Time'] . ' + ' . $row['Hour'] . ' hours'));
        $skypeAcc = $row['SkypeAcc'];
        $phone = $row['Phone'];
        $state = $row['state'];
    }


} else {
    echo "Error";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" href="css/owl.theme.default.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <!-- buy course CSS JS-->
    <link rel="stylesheet" href="css/buyCourse.css" />
</head>

<body>
    <div class="invoice">
        <div class="row m-0">
            <div class="col-md-7 col-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="row box-right">
                            <div class="col-md-10 ps-0 ">
                                <div class="ps-3 fw-bold h5 mb-0"><?php echo $date; ?></div>
                                <br>
                                <p class="h1 fw-bold d-flex">
                                    <?php echo $courseTime . '-' . $endTime ?>
                                </p>
                                <hr>
                                <div class="row text-center">
                                    <div class="col-md-2 img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-md-none d-lg-flex">
                                        <div class="img-holder">
                                            <img src="img/user/icon.jpeg" class="img-holder ">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="textmuted">Tutor</p>
                                        <?php echo $tname; ?>
                                    </div>
                                </div>
                                <hr>
                                <!-- <p class="ms-3 px-2 bg-green">+10% since last month</p> -->
                            </div>
                            <div class="h5">
                                <?php echo $cName ?>
                            </div>
                            <div class="row">
                                <div class="col-md-4 textmuted">
                                    Duration
                                </div>
                                <div class="col-md-4 textmuted">
                                    Price
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 h5 ">
                                    <?php echo $hour; ?> Hours
                                </div>
                                <div class="col-md-4 h5">
                                    $<?php echo $cost; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 px-0 mb-4">

                    </div>
                    <!-- Payment Method box -->
                    <div class="col-12 px-0">
                        <div class="box-right">
                            <div class="col-md-10 ps-0 ">
                                <div class="fw-bold h3">Communcation Tool</div><br>

                                <div class="row">
                                    <div class="col-md-4 h5 text-primary">
                                        Skype
                                    </div>
                                    <div class="col-md-5 textmuted">
                                        Tutor Account
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-md-4 h5 ">

                                    </div>
                                    <div class="col-md-4 h5">
                                        <?php echo $skypeAcc; ?>
                                    </div>
                                    <hr>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 h5 ">
                                        Phone
                                    </div>
                                    <div class="col-md-4 textmuted">
                                        Tutor No.
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4 h5 ">

                                    </div>
                                    <div class="col-md-4 h5">
                                        <?php echo $phone; ?>
                                    </div>

                                </div>
                            </div>

                            <!-- <div class="d-flex mb-2">
                            <p class="h7">#AL2545</p>
                            <p class="ms-auto bg btn btn-primary p-blue h8"><span class="far fa-clone pe-2"></span>COPY
                                PAYMENT LINK </p>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="textmuted h8">Project / Description</p> <input class="form-control" type="text" placeholder="Legal Consulting">
                            </div>
                            <div class="col-6">
                                <p class="textmuted h8">Issused on</p> <input class="form-control" type="text" placeholder="Oct 25, 2020">
                            </div>
                            <div class="col-6">
                                <p class="textmuted h8">Due on</p> <input class="form-control" type="text" placeholder="Oct 25, 2020">
                            </div>
                        </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-12 ps-md-5 p-0 ">
                <div class="box-left">
                    <h1>State :</h1>
                    <p class="h2 fw-bold d-flex ">
                        
                        <?php echo $state; ?>
                    </p>

                        <hr>
                        <div class="d-grid gap-2">
                        <a class="btn btn-outline-secondary" href="page_viewTeachers.php" type="button">Book another lesson</a>  
                        </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/app.js"></script>

</body>

</html>