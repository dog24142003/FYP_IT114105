<?php
session_start();
require_once('../conn.php');

if ($_SESSION['account'] == 'Student') {
    $sql = "SELECT * FROM student WHERE StudentID = {$_SESSION['StudentID']}";
} else {
    $sql = "SELECT * FROM tutor WHERE TutorID = {$_SESSION['TutorID']}";
}

$rs = mysqli_query(getDBconn(), $sql);
$row = mysqli_fetch_array($rs);
$item = "Chinese Note";
$price = 200;
?>


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/owl.carousel.min.css" />
    <link rel="stylesheet" href="../css/owl.theme.default.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" /
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/point.css" />
    <title>Point</title>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand" href="../index.php">Tutor Cat<span class="dot">.</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Course</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services">NoteBook</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#portfolio">Profile</a>
                </li>
            </ul>
            <?php
            if (isset($_SESSION['StudentID']) || isset($_SESSION['TutorID'])) {
                echo '<a class="nav-link">Welcome ' . $_SESSION["FirstName"] . '<h5><strong><div onclick="point()"style="text-align:right; cursor: pointer;">' . $_SESSION["Point"] . ' Point</div></strong></h5></a>';
                echo '<a href="../chatroom/chatusers.php" class="btn btn-brand ms-lg-3">Chat Room</a>';
                echo '<a href="../logout.php" class="btn btn-brand ms-lg-3">Logout</a>';

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

<body>
    <div class="container-fluid" style="background: linear-gradient(90deg, #00C9FF 0%, #92FE9D 100%);">
        <div class="container p-5">
            <div class="row">
                <form action="payment.php" method="post">
                    <div class="col-lg-4 col-md-12 mb-4">
                        <div class="card h-100 shadow-lg">
                            <div class="card-body">
                                <div class="text-center p-3">
                                    <h3 class="card-title">
                                        <?php echo $item; ?>
                                    </h3>
                                    <br><br>
                                    <span class="h4"></span>
                                    <br><br>
                                </div>
                                <p class="card-text" style="font-weight:bold; text-align: center;">Get 10% price as
                                    point <br>
                                    (20)
                                </p>
                            </div>
                            <div class="card-body text-center">
                                <p class="card-text" style="font-weight:bold; font-size: 180%;">
                                    $
                                    <?php echo $price; ?>
                                </p>
                                <button name="submit" class="btn btn-outline-primary btn-lg"
                                    style="border-radius:30px">Buy</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $item; ?>" name="item">
                    <input type="hidden" value="<?php echo $price; ?>" name="price">
                </form>
            </div>
        </div>
    </div>




</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
</script>


</html>