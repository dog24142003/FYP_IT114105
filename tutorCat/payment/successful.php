<?php
session_start();
require_once('../conn.php');

if ($_SESSION['pay_by_point'] == false) {
    $getPoint = $_SESSION['price'] / 10;
    $_SESSION['Point'] += $getPoint;
    $sql = "UPDATE student SET Point = {$_SESSION["Point"]} WHERE StudentID = {$_SESSION["StudentID"]}";
}
$rs = mysqli_query(getDBconn(), $sql);

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
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <!-- <link href="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" rel="stylesheet" /> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/buy_point.css" />
    <title>Buy Point</title>
</head>

<body>
    <div class="spinner-wrapper">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
</script>
<script>
var item = '<?php echo $_SESSION['item']; ?>';
var price = '<?php echo $_SESSION['price']; ?>';
const spinnerWrapperEl = document.querySelector('.spinner-wrapper');
// alert('Point before: '
//     $oldPoint + 'Buy point: ' + $_SESSION['BuyPoint'] + 'Point now: ' + $_SESSION['Point']);

setTimeout(() => {
    spinnerWrapperEl.style.opacity = '0';
    //alert('1');
    alert("Thank you for you purchase! " +
        "\nYou have bought: " + item +
        "\nPrice: $" + price +
        "\nYou will get " + <?php echo $getPoint; ?> + " point!!");

}, 3000);
setTimeout(() => {
    window.location.href = '../index.php';
}, 3000);
</script>


</html>