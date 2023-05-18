<?php

require_once("conn.php");
require_once('Common/header.php');
$studentID = $_SESSION['StudentID'];
$courseID = $_GET['CourseID'];

$result = mysqli_query(getDBconn(), "SELECT course.*, tutor.tutorID, tutor.FirstName, tutor.LastName, tutor.IconImg, tutor.IconImgType FROM Course, tutor WHERE CourseID= '$courseID' AND tutor.TutorID=course.TutorID;");
if ($result->num_rows > 0) {
    $showDate = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $tutorID=$row['tutorID'];
        $tname = $row['FirstName'] . ' ' . $row['LastName'];
        $cName = $row['CName'];
        $cost = $row['Cost'];
        $subject = $row['Subject'];
        $time = $row['Time'];
        $detail = $row['Description'];
        $noOfClass = $row['NoOfClass'];
        $icon = $row['IconImg'];
        $iconImgType = $row['IconImgType'];
        $total = $cost * $noOfClass;
        $courseTime  = date("g:i a", strtotime($row['Time']));
        $endTime  = date("g:i a", strtotime($row['Time'] . ' + ' . $row['Hour'] . ' hours'));
        if ($icon == null) {
            $icon = '<img src="img/logo.jpg"  class="shadow-1-strong rounded-circle border" alt="avatar 1"
            style="width: 55px; height: auto; ';
        } else {
            $icon = '<img src="data:image/' . $iconType . ';base64,' . base64_encode($icon) . '" class="shadow-1-strong rounded-circle border " alt="avatar 1"
            style="width: 55px; height: auto;/>';
        }
    }
    $sql1 = "SELECT * FROM Schedule WHERE CourseID=" . $courseID;
    $result1 = mysqli_query(getDBconn(), "SELECT * FROM Schedule WHERE CourseID=" . $courseID);
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $showDate .= "" . $row1['Date'] . ",<br> ";
    }

    //    extract($result);
} else {
    echo "Error";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
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

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">

    <!-- Pay Course -->
    <div class="invoice">
        <div class="row m-0">
            <div class="col-md-7 col-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="row box-right">
                            <div class="col-md-10 ps-0 ">
                                <p class="ps-3 textmuted fw-bold h6 mb-0">My Point</p>
                                <p class="h1 fw-bold d-flex">
                                    <span class=" fas fa-dollar-sign textmuted pe-1 h6 align-text-top mt-1"></span><?php echo$_SESSION["Point"];?>
                                    <span class="textmuted">.00</span>
                                </p>
                                <!-- <p class="textmuted">Your point will be automatically deducted</p> -->
                                <!-- <p class="ms-3 px-2 bg-green">+10% since last month</p> -->
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                    </div>
                    <div class="col-12 px-0 mb-4">

                    </div>
                    <!-- Payment Method box -->
                    <div class="col-12 px-0">
                        <!-- <div class="box-right"> -->
                            <!-- <div class="d-flex mb-2">
                                <p class="fw-bold">Payment Method</p>

                            </div> -->
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
                        <!-- </div> -->
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-12 ps-md-5 p-0 ">
                <div class="box-left">
                    <p class="textmuted h8"></p>

                    <form 
                    action="payment/payment.php" 
                    id="OrderForm"
                    method="post" 
                    enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo $cName; ?>" name="item">
                    <input type="hidden" value="<?php echo $total; ?>" name="price">
                        <p class="fw-bold h7"><?php echo $tname; ?></p>
                        <br>
                        <p class=" h8" >
                            Course ID:<?php echo $courseID; ?></p>
                        <p class="textmuted h8">
                            <?php echo $detail; ?>, </p>
                        <p class="textmuted h8 mb-2"><?php echo $showDate; ?></p>
                        <p class="textmuted h8 mb-2"> <?php echo $courseTime; ?>-<?php echo $endTime; ?></p>
                        <p class=" h8 mb-2">$<?php echo $cost; ?>x <?php echo $noOfClass; ?></p>
                        <hr>
                        <div class="h8">

                            <div class="d-flex h7 mb-2">
                                <p class="">Total Amount</p>
                                <p class="ms-auto"><span class="fas fa-dollar-sign"></span>$
                                <div> <?php echo $total; ?></div>.00
                                </p>
                            </div>
                            <div class="d-flex h7 mb-2">
                                <p class="">Your Point</p>
                                <p class="ms-auto"><span class="fas fa-dollar-sign"></span>-$<?php echo $total; ?>.00</p>
                            </div>
                            <hr>
                            <input type="hidden" name="tutorID" id="tutorID" value="<?php echo $tutorID; ?>" />
                            <input type="hidden" name="newCourseID" id="newCourseID" value="<?php echo $courseID; ?>" />
                            <input type="hidden" name="newTotalPrice" id="newTotalPrice" value="<?php echo $total;?>" />
                            <input type="hidden" name="studentID" id="studentID" value="<?php echo $studentID ?>" />
                            <button class="btn btn-danger d-block h8" type="submit" name="orderSubmit">Confirm
                            </button>

                    </form>
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