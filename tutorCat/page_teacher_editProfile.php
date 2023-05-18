<?php

require_once ("conn.php");
require_once('Common/header.php');
$tEmail = $_SESSION['Email'];
$result = mysqli_query(getDBconn(),"SELECT * FROM tutor WHERE Email='$tEmail';");

                
                while($row = mysqli_fetch_assoc($result)){
                    $tname = $row['FirstName'] .' '. $row['LastName'];
                    $fname = $row['FirstName'];
                    $lname = $row['LastName'];
                    $tEmail = $row['Email'];
                    $tPhone = $row['Phone'];
                    $detail = $row['Description'];
                    $pw = $row['Password']; 
                    $icon = $row['IconImg'];
                    $iconType = $row['IconImgType'];
                    if($icon == null){
//                       
                     $icon = '<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="" class="rounded-circle" width="200" height="200">';
                    }else{
                        $icon = '<img src="data:image/' . $iconType . ';base64,' . base64_encode($icon) . '" class="rounded-circle" width="200" height="200"  alt=""/>';
                    }
                }     
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
        $(document).ready(function() {
            $("#save_btn").hide();
            $("#newPw,#conPw,.hrLine").hide();
            $("#confirm_btn,#cancel_btn").hide();

            $("#profile_btn").click(function() {
                /*hide*/
                $("").hide();
                /*show*/
                $("#myProfile").show();
            });
            $("#course_btn").click(function() {
                /*hide*/
                $("#myProfile").hide();
                /*show*/
                $("").show();
            });
            /*save btn show if any thing change*/
            $("#phone,#floatingTextarea2").change(function() {

                if ($("#phone").val() == '<?php echo $tPhone; ?>' && $("#floatingTextarea2").val() == '<?php echo $detail; ?>') {
                    $("#password_block").show();
                    $("#save_btn").hide();
                } else {
                    $("#password_block").hide();
                    $("#save_btn").show();
                }

            });
            /* save_btn*/
            $("#save_btn").click(function() {
                $("#oldPw").val('<?php echo $pw; ?>');
                $("#oldPw").attr("readonly", true);
                $("#resetPw_btn").show();

                $("#newPw,#conPw,.hrLine").hide();
                $("#confirm_btn,#cancel_btn").hide();
                /*pattern*/
                if ($("#phone").val().length == 8) {
                    let form = document.getElementById("form__submit");
                    form.submit();
                } else {
                    $("#phone").addClass('is-invalid');

                }

            });


            /*reset password btn*/
            $("#resetPw_btn").click(function() {
                $(this).hide();
                $("#oldPw").val('');
                $("#oldPw").attr("readonly", false);
                $("#newPw,#conPw,.hrLine").show();
                $("#confirm_btn,#cancel_btn").show();
                $("#profile_block").hide();

            });
            /*cancel btn*/
            $("#cancel_btn").click(function() {

                $("#oldPw").val('<?php echo $pw; ?>');
                $("#oldPw").attr("readonly", true);
                $("#resetPw_btn").show();
                $("#newPw,#conPw,.hrLine").hide();
                $("#confirm_btn,#cancel_btn").hide();
                $("#profile_block").show();
            });


            /*CONFIRM_btn*/
            $("#confirm_btn").click(function() {
                //                alert("click! '<?php echo $pw; ?>'");

                if ($("#oldPw").val() == '<?php echo $pw; ?>') {
                    $("#oldPw").addClass('is-valid');
                    if ($("#newPw_input").val() == $("#conPw_input").val()) {
                        let form = document.getElementById("form__submit");
                        form.submit();

                    } else {
                        $("#newPw_input,#conPw_input").addClass('is-invalid');
                    }

                } else {
                    $("#oldPw").addClass('is-invalid');
                }


            });


        });

    </script>

</head>

<body>
    <div class="container">
        <form id="form__submit" action="updateProfile.php" method="POST" enctype="multipart/form-data">
            <div class="main-body">



                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    Click The Icon to change Image
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#imgModal" class="btn btn ms-lg-3" style="height:15rem;width:15rem;object-fit: contain;"><?php echo $icon; ?></a>
                                    <div class="mt-3">
                                        <h4><?php echo $tname; ?></h4>
                                        <div class="container height-100 d-flex align-items-center justify-content-center">

                                            <div class="form-floating w-100">
                                                <textarea name="Description" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"><?php echo $detail; ?></textarea>
                                                <label for="floatingTextarea2">Enter Here</label>
                                                <div class="row">
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-9 text-secondary">


                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--                profile start-->
                    <div id="myProfile" class="col-md-8">
                        <div id="profile_block" class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">First Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="fname" class="form-control" value="<?php echo $fname; ?>" readonly="true">
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Last Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="lname" class="form-control" value="<?php echo $lname; ?>" readonly="true">
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">

                                        <input type="text" name="Email" class="form-control" value="<?php echo $tEmail;?>" readonly="true">
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
                                            <input id="phone" type="number" class="form-control" name="Phone" value="<?php echo $tPhone; ?>">
                                            <div id="" class="invalid-feedback">
                                                Invalid change!
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!--                            save button-->
                            <a class="btn btn-brand" target="__blank" id="save_btn" onclick="submitForm()">Save Changes</a>
                            <!--<input id="save_btn" type="submit" name="submit" class="btn btn-brand px-4" value="Save Changes" >-->
                        </div>
                        <!--                      Password setting start-->

                        <div id="password_block" class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Current Password</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input id="oldPw" type="password" name="oldPw" class="form-control" value="<?php echo $pw; ?>" readonly="true">
                                        <div id="" class="invalid-feedback">
                                            Wrong Password!
                                        </div>
                                    </div>

                                </div>
                                <hr class="hrLine">
                                <div class="row" id="newPw">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">New Password</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input id="newPw_input" type="password" name="newPw" class="form-control" value="">
                                        <div id="" class="invalid-feedback">
                                            Password not match!
                                        </div>
                                    </div>
                                </div>
                                <hr class="hrLine">
                                <div class="row mb-2" id="conPw">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Confirm Password</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input id="conPw_input" type="password" name="conPw" class="form-control" value="">
                                        <div id="" class="invalid-feedback">
                                            Password not match!
                                        </div>
                                    </div>


                                </div>
                                <a class="btn btn-brand" target="__blank" id="resetPw_btn">Reset Password</a>
                                <!--                            confirm btn & cancel btn-->

                                <a class="btn btn-brand" target="__blank" id="confirm_btn" onclick="submitForm()">Confirm</a>
                                <a class="btn btn-dark" target="__blank" id="cancel_btn">Cancel</a>


                            </div>
                        </div>

                        <!-- profile end-->
                        <!--DSE and diploma start-->
                        <div class="row gutters-sm">
                            <div class="col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="d-flex align-items-center mb-3"><i class="material-icons text-brand mr-2">DSE</i>
                                        </h5>
                                        <h6>Still not input</h6>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="d-flex align-items-center mb-3"><i class="material-icons text-brand mr-2">Diploma</i></h5>
                                        <h6>大學:科技大學畢業<br><br>科目:企業管理</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--    img file model-->
    <div class="modal fade" id="imgModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body p-0">

                    <div class="container-fluid">
                        <div class="row gy-4">

                            <div class="col-lg-8">
                                <form action="uploadIcon.php" name="uploadIcon" id="uploadIcon" method="post" enctype="multipart/form-data">
                                    <div class="col m-2">
                                        <!--                                       preview img block-->
                                        <div class="row p-2 border">
                                            <div class="border">
                                                <p><img id="output" width="20px" style="object-fit: scale-down;" /></p>

                                            </div>
                                        </div>
                                        <div class="row p-2 border mt-2" style="height: 10rem;">

                                            <input type="file" id="IconImg" name="IconImg" accept=".png, .jpg, .jpeg" onchange="loadFile(event)">
                                            <input type="hidden" id="IconType" name="IconType" value="">
                                            <p class="mb-0 text-start">Only accept image type : png , jpg , jpeg </p>
                                            <p class="text-start">The image size : smaller than 50M. </p>
                                            <script>
                                                let file = document.getElementById("IconImg");

                                                file.addEventListener("input", () => {
                                                    if (file.files.length) {
                                                        let fileExtension = file.files[0].name.split(".").pop()
                                                        document.getElementById("IconType").value = fileExtension;
                                                    }
                                                })

                                                var loadFile = function(event) {
                                                    var image = document.getElementById('output');
                                                    image.src = URL.createObjectURL(event.target.files[0]);
                                                };

                                            </script>

                                        </div>



                                    </div>
                                    <input type="hidden" name="Email" value="'<?php echo $tEmail; ?>'">
                                    <input class="btn btn-warning" type="submit" name="craeteBookSubmit" value="Confirm">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <style type="text/css">
        body {
            margin-top: 20px;
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



        .form-control {

            resize: none;
        }

        .form-control:focus {

            box-shadow: none;
            border: 2px solid blue;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        
    </style>

</body>

</html>
