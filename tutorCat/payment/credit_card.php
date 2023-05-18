<?php
session_start();
require_once('../conn.php');

// $_SESSION['BuyPoint'] = $_POST["submit"];
// if ($_POST["submit"] == 200) {
//     $total = 190;
// } else if ($_POST["submit"] == 400) {
//     $total = 360;
// } else if ($_POST["submit"] == 600) {
//     $total = 510;
// } else if ($_POST["submit"] == 800) {
//     $total = 656;
// } else if ($_POST["submit"] == 1000) {
//     $total = 800;
// } else {
//     $total = 100;
// }
$total = $_SESSION['price'];

if ($_SESSION['account'] == 'Student') {
    $sql = "SELECT * FROM student WHERE StudentID = {$_SESSION['StudentID']}";
} else {
    $sql = "SELECT * FROM tutor WHERE TutorID = {$_SESSION['TutorID']}";
}

$rs = mysqli_query(getDBconn(), $sql);
$row = mysqli_fetch_array($rs);
?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="../css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="../css/owl.carousel.min.css" />
    <link rel="stylesheet" href="../css/owl.theme.default.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" /
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <!-- <link href="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" rel="stylesheet" /> -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" rel="stylesheet" /> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../css/style.css" />
    <!-- <link rel="stylesheet" href="../css/payment.css" /> -->
    <title>Payment</title>
</head>

<body>
    <form action="stripe_payment.php" method="POST" name="payment" style="display: none;">
        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="pk_test_51MnxkNKh7qvMC9zzl8p0v2QcdcSiFCgkTFX6moYdGXh9VowD6YnwkIP8uRnxdD7zfonI5mBEMngcTP2hWYX6sRk000xHyMipou"
            data-name="Credit Card Payment"
            data-description="Buy <?php echo $_SESSION['item']; ?> $<?php echo $total; ?>"
            data-amount="<?php echo $total * 100; ?>" data-currency="hkd" data-label="Pay">
        </script>
    </form>
</body>
<script>
window.onload = function() {
    document.getElementsByTagName('button')[0].click();
}
</script>

</html>