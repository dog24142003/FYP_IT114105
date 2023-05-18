<?php

require_once("conn.php");
require_once('Common/header.php');
$tEmail = $_SESSION['Email'];


$result = mysqli_query(getDBconn(), "SELECT * FROM student WHERE Email='$tEmail';");
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $tname = $row['FirstName'] . ' ' . $row['LastName'];
        $fname = $row['FirstName'];
        $lname = $row['LastName'];
        $tEmail = $row['Email'];
        $tPhone = $row['Phone'];
        $icon = $row['IconImg'];
        $iconType = $row['IconImgType'];
        $subject = $row['Subject'];
        
        if ($icon == null) {
            //                       
            $icon = '<img src="img/logo.jpg"  class="rounded-circle" ';
        } else {
            $icon = '<img src="data:image/' . $iconType . ';base64,' . base64_encode($icon) . '" class="rounded-circle" width="200" height="200" alt=""/>';
        }

    }

    //    extract($result);
} else {
    echo $tEmail;
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



    <title>Your Profile</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" href="css/owl.theme.default.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="css/style.css" />
    <!--   Required js-->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/app.js"></script>
    <!--    jquery code-->
    <script>
        $(document).ready(function () {

            $("#profile_btn").click(function () {
                /*hide*/
                $("").hide();
                /*show*/
                $("#myProfile").show();
            });
            $("#course_btn").click(function () {
                /*hide*/
                $("#myProfile").hide();
                /*show*/
                $("").show();
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
                                    


                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a class="btn btn-brand" target="__blank"
                                            href="page_student_editProfile.php">Edit
                                            Profile</a>

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
                                <a id="course_btn" href="student_schedule.php" class="btn btn-brand">Calendar</a>
                                <a id="note_btn" href="student/notes/StuNotesList.php" class="btn btn-brand">Notes</a>


                            </div>
                        </ul>
                    </div>
                </div>
                <!--                profile start-->
                <div id="myProfile" class="col-md-8">
                    <div class="card mb-3">
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
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Subjects need improve</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="Email" class="form-control" value="<?php echo $subject; ?>"
                                        readonly="true">

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- profile end-->


                </div>
            </div>
        </div>

    </div>

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

        .gutters-sm>.col,
        .gutters-sm>[class*=col-] {
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