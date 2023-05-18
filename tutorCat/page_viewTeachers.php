<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <!-- Teacher List -->
    <link rel="stylesheet" href="css/courseList.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css"
        integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />
    <!--   Required js-->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/app.js"></script>
    <!--    jquery code-->
</head>
<?php require_once('common/header.php'); ?>

<body>
    <!--Course List-->
    <div class="container">


        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="career-search mb-60">

                    <!-- <form action="#" class="career-form mb-60">
                        <div class="row">
                            <div class="col-md-6 col-lg-3 my-3">
                                <div class="input-group position-relative">
                                    <input type="text" class="form-control" placeholder="Enter Your Keywords"
                                        id="keywords">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 my-3">
                                <select class="custom-select">
                                    <option selected="">Chinese</option>
                                    <option value="1">English</option>
                                    <option value="2">Mathematics</option>
                                    <option value="3">M1</option>
                                    <option value="4">M2</option>
                                    <option value="5">Biology</option>
                                    <option value="6">Chemical</option>
                                    <option value="7">Chinese History</option>
                                    <option value="8">History</option>
                                    <option value="9">Economic</option>
                                    <option value="10">Geography</option>
                                    <option value="11">Physics</option>
                                    <option value="12">Accounting</option>
                                    <option value="13">ICT</option>
                                    <option value="14">Art</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3 my-3">
                                <select class="custom-select">
                                    <option selected="">Select Teacher Type</option>
                                    <option value="1">Professional</option>
                                    <option value="2">Community</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3 my-3">
                                <button type="button" class="btn btn-lg btn-block btn-light btn-custom"
                                    id="contact-submit">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <div class="filter-result">
                        <p class="mb-30 ff-montserrat">Updated Teacher List</p>


                        <?php
                        require_once("conn.php");

                        $result = mysqli_query(getDBconn(), "SELECT * FROM tutor");

                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row["UniqueID"] == 0) {
                                continue;
                            }
                            $results[] = $row;
                        }

                        foreach ($results as $key => $result) {

                            echo '<div class="job-box d-md-flex align-items-center justify-content-between mb-30">
                    <div class="job-left my-4 d-md-flex align-items-center flex-wrap ">
                        <div class="img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-md-none d-lg-flex">
                            <img src="img/user/icon.jpeg" class="img-holder ">
                        </div>
                        <div class="job-content">
                            <h5 class="text-center text-md-left">' . $result['FirstName'] . ' ' . $result['LastName'] . '</h5>
                            <ul class="d-md-flex flex-wrap text-capitalize ff-open-sans">
                                <li class="mr-md-4">Subject: ' . $result['Subject'] . '</li>

                                </ul>
                                <ul class="d-md-flex flex-wrap text-capitalize ff-open-sans">
                                    <li class="mr-md-4">' . $result['Description'] . '</li>
                                    </ul>
                                    <ul class="d-md-flex flex-wrap text-capitalize ff-open-sans">
                                       
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="job-right my-4 flex-shrink-0"> <button class="btn d-block w-100 d-sm-inline-block btn-light" onclick="location.href=\'page_viewTeacher_profile.php?Email=' . $result['Email'] . '\'">Show Detail</button>
                            </div>
                        </div>';

                        }
                        ?>
</body>

</html>