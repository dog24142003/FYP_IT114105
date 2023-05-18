<!DOCTYPE html>
<html>

<!-- HTML head -->
<?php
session_start();

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/FYP/tutorCat/conn.php");
$path = "http://localhost/FYP/tutorCat/";

if (isset($_SESSION['account'])) {
    if ($_SESSION['account'] == 'Tutor') {
        $myPF = 'page_teacher_profile.php';
    } else if ($_SESSION['Email'] == 'admin@tutorcat.com') {
        $myPF = 'page_admin_profile.php';
    } else {
        $myPF = 'page_student_profile.php';
    }
} else {
    $myPF = 'index.php';
}


?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo $path ?>css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo $path ?>css/owl.carousel.min.css" />
    <link rel="stylesheet" href="<?php echo $path ?>css/owl.theme.default.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" / integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $path ?>css/style.css" />
    <title>Tutor Cat</title>
</head>

<html>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">
    <!-- Site navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">Tutor Cat<span class="dot">.</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $path ?>index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $path ?>page_viewTeachers.php">Tutor List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $path ?>Common/notes/NotesList.php">NoteBook</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        if (isset($_SESSION['StudentID']) || isset($_SESSION['TutorID'])) {
                            if ($_SESSION['account'] == 'Tutor') {
                                echo '<li class="nav-item"><a id="myPF" class="nav-link" href='.$path . $myPF . '>My Profile</a></li>';
                            } else if ($_SESSION['account'] == 'Student') {
                                echo '<li class="nav-item"><a id="myPF" class="nav-link" href=' .$path. $myPF . '>My Profile</a></li>';
                            }
                        }
                        ?>
                    </li>
                </ul>
                <?php
                if (isset($_SESSION['StudentID']) || isset($_SESSION['TutorID'])) {
                    echo '<a class="nav-link">Welcome ' . $_SESSION["FirstName"] . '<h5><strong><div onclick="point()"style="text-align:right; cursor: pointer;">' . $_SESSION["Point"] . ' Point</div></strong></h5></a>';
                    echo '<a href="' . $path . 'chatroom/chatusers.php" class="btn btn-brand ms-lg-3">Chat Room</a>';
                    echo '<a href="' . $path . 'logout.php" class="btn btn-brand ms-lg-3">Logout</a>';
                } else {
                    echo '<a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-brand ms-lg-3">Sign
                        up</a>';
                    echo '<a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal1"
                        class="btn btn-brand ms-lg-3">Login</a>';
                }
                ?>
            </div>
        </div>
    </nav>
    <!-- Sign Up Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body p-0">

                    <div class="container-fluid">
                        <div class="row gy-4">
                            <div class="col-lg-4 col-sm-12 bg-cover" style="background-image: url(<?php echo $path ?>img/c2.jpg); min-height: 300px">
                            </div>
                            <div class="col-lg-8">
                                <form class="p-lg-5 col-12 row g-3" action="<?php echo $path ?>signup.php" method="post">
                                    <div>
                                        <h1>Sign Up Now</h1>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal1">Already
                                            signed up? Login now</a>
                                        <p>
                                            Sign up to get 10 points for buying courses or notebooks.
                                        </p>
                                        <div class="error-txt" id="error">Error message</div>
                                    </div>

                                    <div class="col-8">
                                        <input type="radio" id="student" name="account" value="Student" aria-describedby="emailHelp" checked />
                                        <label for="student" class="form-label">Student</label>
                                        <input type="radio" id="Tutor" name="account" value="Tutor" aria-describedby="emailHelp" style="margin-left: 50px;" />
                                        <label for="Tutor" class="form-label">Tutor</label>
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="firstname" class="form-label">First Name</label>
                                        <input type="text" class="form-control" placeholder="Tutor" id="firstname" name="firstname" aria-describedby="emailHelp" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="lastname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" placeholder="Cat" id="lastname" name="lastname" aria-describedby="emailHelp" required />
                                    </div>
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" placeholder="tutorcat@gmail.com" id="email" name="email" aria-describedby="emailHelp" required />
                                    </div>
                                    <div class="col-12">
                                        <label for="password" class="form-label">Password</label>
                                        <i class='fa fa-eye' id='pwicon' onclick="toggle()"></i>
                                        <input type="password" class="form-control" placeholder="********" id="password" name="password" aria-describedby="emailHelp" required />

                                    </div>
                                    <div class="col-12">
                                        <label for="confirmpassword" class="form-label">Confirm Password</label>
                                        <i class='fa fa-eye' id='cpwicon' onclick="togglec()"></i>
                                        <input type="password" class="form-control" placeholder="********" id="cpassword" name="confirmpassword" aria-describedby="emailHelp" required />
                                    </div>

                                    <div class="col-12">
                                        <label for="Subject" class="form-label">Subject</label><br>
                                        <div class="checkbox-wrapper">
                                            <div style="float:left; width:125px;">
                                                <input type="checkbox" id="Chinese" name="subject[]" value="Chinese">
                                                <label for="Chinese"> Chinese</label>
                                            </div>
                                            <div style="float:left; width:135px;">
                                                <input type="checkbox" id="English" name="subject[]" value="English">
                                                <label for="English"> English</label>
                                            </div>
                                            <div style="float:left; width:125px;">
                                                <input type="checkbox" id="Math" name="subject[]" value="Math">
                                                <label for="Math"> Math</label>
                                            </div>
                                            <div style="float:left; width:175px;">
                                                <input type="checkbox" id="General Education" name="subject" value="General Education">
                                                <label for="General Education"> General Education</label>
                                            </div>
                                            <div style="float:left; width:125px;">
                                                <input type="checkbox" id="M1" name="subject[]" value="M1">
                                                <label for="M1"> M1</label>
                                            </div>
                                            <div style="float:left; width:135px;">
                                                <input type="checkbox" id="M2" name="subject[]" value="M2">
                                                <label for="M2"> M2</label>
                                            </div>
                                            <div style="float:left; width:125px;">
                                                <input type="checkbox" id="Biology" name="subject[]" value="Biology">
                                                <label for="Biology"> Biology</label>
                                            </div>
                                            <div style="float:left; width:125px;">
                                                <input type="checkbox" id="Chemistry" name="subject[]" value="Chemistry">
                                                <label for="Chemistry"> Chemistry</label>
                                            </div>
                                            <div style="float:left; width:125px;">
                                                <input type="checkbox" id="Physics" name="subject[]" value="Physics">
                                                <label for="Physics"> Physics</label>
                                            </div>
                                            <div style="float:left; width:135px;">
                                                <input type="checkbox" id="Chinese History" name="subject[]" value="Chinese History">
                                                <label for="Chinese History"> Chinese History</label>
                                            </div>
                                            <div style="float:left; width:125px;">
                                                <input type="checkbox" id="History" name="subject[]" value="History">
                                                <label for="History"> History</label>
                                            </div>
                                            <div style="float:left; width:125px;">
                                                <input type="checkbox" id="BAFS" name="subject[]" value="BAFS">
                                                <label for="BAFS"> BAFS</label>
                                            </div>
                                            <div style="float:left; width:125px;">
                                                <input type="checkbox" id="Geography" name="subject[]" value="Geography">
                                                <label for="Geography"> Geography</label>
                                            </div>
                                            <div style="float:left; width:135px;">
                                                <input type="checkbox" id="Economic" name="subject[]" value="Economic">
                                                <label for="Economic"> Economic</label>
                                            </div>
                                            <div style="float:left; width:125px;">
                                                <input type="checkbox" id="Visual Art" name="subject[]" value="Visual Art">
                                                <label for="Visual Art"> Visual Art</label>
                                            </div>
                                        </div>
                                        <br>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-brand" id="submit" name="submit">
                                            Sign Up
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
    <!-- Login Modal-->
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body p-0">

                    <div class="container-fluid">
                        <div class="row gy-4">
                            <div class="col-lg-4 col-sm-12 bg-cover" style="background-image: url(<?php echo $path ?>img/c2.jpg); min-height: 300px">
                                <div></div>
                            </div>
                            <div class="col-lg-8">
                                <form class="p-lg-5 col-12 row g-3" action="<?php echo $path ?>login.php" method="post">
                                    <div>
                                        <h1>Login</h1>
                                        <p>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Not yet
                                                signed up? Sign up now</a>
                                        </p>
                                    </div>
                                    <div class="col-8">
                                        <input type="radio" id="student" name="account" value="Student" aria-describedby="emailHelp" checked />
                                        <label for="student" class="form-label">Student</label>
                                        <input type="radio" id="Tutor" name="account" value="Tutor" aria-describedby="emailHelp" style="margin-left: 50px;" />
                                        <label for="Tutor" class="form-label">Tutor</label>
                                    </div>
                                    <div class="col-8">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" placeholder="tutorcat@gmail.com" id="email" name="email" aria-describedby="emailHelp" required />
                                    </div>
                                    <div class="col-8">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" placeholder="********" id="password" name="password" aria-describedby="emailHelp" required />
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-brand" name="submit">
                                            Login
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
    <script src="<?php echo $path ?>js/jquery.min.js"></script>
    <script src="<?php echo $path ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $path ?>js/owl.carousel.min.js"></script>
    <script src="<?php echo $path ?>js/app.js"></script>
    <script src="<?php echo $path ?>js/showhidepw.js"></script>
    <script id="navbar_set">
        signup = false;
        const queryString = window.location.search;

        $(document).ready(function() {
            if (queryString == "?signup") {
                $("#exampleModal").modal('show');
            }
            if (queryString == "?login") {
                $("#exampleModal1").modal('show');
            }
            $('#error').hide();


            $("#submit").click(function() {
                if ($("#password").val() != $("#cpassword").val()) {
                    $('#error').show();
                    $('#error').text("Password not match!");
                    return false;
                }
            });


        });
    </script>
    <script type="application/javascript">
        function point() {
            window.location.replace("<?php echo $path ?>payment/example.php");
        }
    </script>
</body>