<?php
session_start();
require_once('../conn.php');

if(isset($_POST['notesId'])){
    $_SESSION['buyNotesID'] = $_POST['notesId'];
}else if(isset($_POST["orderSubmit"])){
    
    $_SESSION['buytype'] = "Course";
    $_SESSION['CourseID'] = $_POST["newCourseID"];
    $_SESSION['newTotalPrice'] = $_POST["newTotalPrice"];
    $_SESSION['studentID'] = $_POST["studentID"];
    $_SESSION['tutorID'] =$_POST["tutorID"];

}
$_SESSION['item'] = $_POST["item"];
$_SESSION['price'] = $_POST["price"];
$_SESSION['pay_by_point'] = false;

if ($_SESSION['account'] == 'Student') {
    $sql = "SELECT * FROM student WHERE StudentID = {$_SESSION['StudentID']}";
} else {
    $sql = "SELECT * FROM tutor WHERE TutorID = {$_SESSION['TutorID']}";
}

if ($_SESSION['Point'] < $_SESSION['price']) {
    $disable = "disabled";
    $alert = 'alert("Insufficient point!!");';
} else {
    $disable = "";
}
$rs = mysqli_query(getDBconn(), $sql);
$row = mysqli_fetch_array($rs);
?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <link rel="stylesheet" href="../css/payment.css" />
    <title>Payment</title>
</head>
<div class="iphone">
    <header class="header">
        <h1>Checkout</h1>
    </header>
    <form method="post" id="method" action="https://www.sandbox.paypal.com/cgi-bin/webscr">
        <div>
            <legend>Item</legend>

            <div class="card">
                <item>
                    <?php echo $_SESSION['item']; ?> <br />
                </item>
            </div>
        </div>
        <br>
        <fieldset>
            <legend>Payment Method</legend>

            <div class="form__radios">
                <div class="form__radio">
                    <label for="paypal"><svg class="icon">
                            <use xlink:href="#icon-paypal" />
                        </svg>PayPal</label>
                    <input checked id="paypal" name="payment-method" type="radio"
                        onclick="showBill(); showB(); document.getElementById('method').action='https://www.sandbox.paypal.com/cgi-bin/webscr';" />
                </div>

                <div class="form__radio">
                    <label for="visa"><svg class="icon">
                            <use xlink:href="#icon-visa" />
                        </svg>Visa</label>
                    <input id="visa" name="payment-method" type="radio"
                        onclick="showBill(); showB(); document.getElementById('method').action='../payment/credit_card.php';" />
                </div>

                <div class="form__radio">
                    <label for="mastercard"><svg class="icon">
                            <use xlink:href="#icon-mastercard" />
                        </svg>Master</label>
                    <input id="mastercard" name="payment-method" type="radio"
                        onclick="showBill(); showB(); document.getElementById('method').action='../payment/credit_card.php';" />
                </div>
                <div class="form__radio">
                    <label for="alipay"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                            fill="currentColor" class="bi bi-alipay" viewBox="0 0 16 16">
                            <path
                                d="M2.541 0H13.5a2.551 2.551 0 0 1 2.54 2.563v8.297c-.006 0-.531-.046-2.978-.813-.412-.14-.916-.327-1.479-.536-.303-.113-.624-.232-.957-.353a12.98 12.98 0 0 0 1.325-3.373H8.822V4.649h3.831v-.634h-3.83V2.121H7.26c-.274 0-.274.273-.274.273v1.621H3.11v.634h3.875v1.136h-3.2v.634H9.99c-.227.789-.532 1.53-.894 2.202-2.013-.67-4.161-1.212-5.51-.878-.864.214-1.42.597-1.746.998-1.499 1.84-.424 4.633 2.741 4.633 1.872 0 3.675-1.053 5.072-2.787 2.08 1.008 6.37 2.738 6.387 2.745v.105A2.551 2.551 0 0 1 13.5 16H2.541A2.552 2.552 0 0 1 0 13.437V2.563A2.552 2.552 0 0 1 2.541 0Z" />
                            <path
                                d="M2.309 9.27c-1.22 1.073-.49 3.034 1.978 3.034 1.434 0 2.868-.925 3.994-2.406-1.602-.789-2.959-1.353-4.425-1.207-.397.04-1.14.217-1.547.58Z" />
                        </svg>Alipay / WeChat Pay</label>
                    <input id="alipay" name="payment-method" type="radio"
                        onclick="showBill(); showAW(); document.getElementById('method').action='../payment/alipay.php';" />
                </div>
                <div class="form__radio" <?php if ($disable == "disabled") {
                    echo "onclick='$alert'";
                } ?>>
                    <label for="point"><svg style="color: rgb(223, 130, 67);" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="40" zoomAndPan="magnify"
                            viewBox="0 0 30 30.000001" height="40" preserveAspectRatio="xMidYMid meet" version="1.0">
                            <defs>
                                <clipPath id="id1">
                                    <path
                                        d="M 7.03125 2.902344 L 25.175781 2.902344 L 25.175781 26.128906 L 7.03125 26.128906 Z M 7.03125 2.902344 "
                                        clip-rule="nonzero" fill="#df8243"></path>
                                </clipPath>
                            </defs>
                            <g clip-path="url(#id1)">
                                <path fill="#df8243"
                                    d="M 16.878906 2.921875 L 7.5625 2.921875 C 7.269531 2.921875 7.03125 3.15625 7.03125 3.449219 L 7.03125 25.597656 C 7.03125 25.886719 7.269531 26.125 7.5625 26.125 L 11.300781 26.125 C 11.59375 26.125 11.832031 25.886719 11.832031 25.597656 L 11.832031 18.738281 L 16.703125 18.738281 C 21.691406 18.738281 25.175781 15.457031 25.175781 10.757812 C 25.175781 6.070312 21.84375 2.921875 16.878906 2.921875 Z M 15.816406 15.042969 L 11.832031 15.042969 L 11.832031 6.601562 L 15.828125 6.601562 C 18.734375 6.601562 20.371094 8.085938 20.371094 10.855469 C 20.371094 13.542969 18.6875 15.042969 15.816406 15.042969 Z M 15.816406 15.042969 "
                                    fill-opacity="1" fill-rule="nonzero"></path>
                            </g>
                        </svg>Point</label>
                    <input id="point" name="payment-method" type="radio"
                        onclick="showPoint(); showB(); document.getElementById('method').action='../payment/use_point.php';"
                        <?php echo $disable ?> />
                </div>
            </div>
        </fieldset>
        <br>
        <div id="bill">
            <h2>Shopping Bill</h2>

            <table>
                <tbody>
                    <tr>
                        <td>Price Total</td>
                        <td align="right">$
                            <?php echo $_POST["price"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Discount
                            %
                        </td>
                        <td align="right">
                            -$0
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td align="right">$
                            <?php echo $_POST["price"]; ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div id="pointPay" style="display: none;">
            <h2>Pay By Point</h2>
            <table>
                <tbody>
                    <tr>
                        <td>Your Point</td>
                        <td align="right">
                            <?php echo $_SESSION["Point"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Cost By Point
                        </td>
                        <td align="right">
                            -
                            <?php echo $_POST["price"]; ?>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Point Left</td>
                        <td align="right">
                            <?php echo $_SESSION["Point"] - $_POST["price"]; ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <br>
        <div>
            <button class="button button--full" type="submit" name="finalizeOrder" id="finalizeOrder"><svg class="icon">
                    <use xlink:href="#icon-shopping-bag" />
                </svg>Buy Now</button>
            <script async src="https://js.stripe.com/v3/buy-button.js">
            </script>

            <stripe-buy-button id="awb" buy-button-id="buy_btn_1MrWMnKh7qvMC9zzWdJeuG2H"
                publishable-key="pk_test_51MnxkNKh7qvMC9zzl8p0v2QcdcSiFCgkTFX6moYdGXh9VowD6YnwkIP8uRnxdD7zfonI5mBEMngcTP2hWYX6sRk000xHyMipou"
                style="display: none;">
            </stripe-buy-button>
            <br>
            <input class="button button--full" style="cursor:pointer;" type="button" value="Cancel"
                onclick="history.back()"></input>
        </div>
        <input type="hidden" value="_xclick" name="cmd">
        <input type="hidden" value="tutorcat@gmail.com" name="business">

        <input type="hidden" value="Buy <?php echo $_SESSION["item"]; ?>" name="item_name">
        <input type="hidden" value="NA" name="item_number">
        <input type="hidden" value="<?php echo $_POST["price"]; ?>" name="amount">
        <input type="hidden" value="" name="invoice">
        <input type="hidden" value="0" name="discount_amount">
        <input type="hidden" value="0" name="no_shipping">
        <input type="hidden" value="No comments" name="cn">
        <input type="hidden" value="HKD" name="currency_code">
        <input type="hidden"
            value="http://127.0.0.1:<?php echo $_SERVER['SERVER_PORT'] . str_replace(realpath($_SERVER["DOCUMENT_ROOT"]), "", getcwd()); ?>/successful.php"
            name="return">
        <input type="hidden" value="HK" name="lc">
        <input type="hidden" value="PP-BuyNowBF" name="bn">
    </form>
</div>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none">

    <symbol id="icon-shopping-bag" viewBox="0 0 24 24">
        <path
            d="M20 7h-4v-3c0-2.209-1.791-4-4-4s-4 1.791-4 4v3h-4l-2 17h20l-2-17zm-11-3c0-1.654 1.346-3 3-3s3 1.346 3 3v3h-6v-3zm-4.751 18l1.529-13h2.222v1.5c0 .276.224.5.5.5s.5-.224.5-.5v-1.5h6v1.5c0 .276.224.5.5.5s.5-.224.5-.5v-1.5h2.222l1.529 13h-15.502z" />
    </symbol>

    <symbol id="icon-mastercard" viewBox="0 0 504 504" width="40" height="40">
        <path
            d="m504 252c0 83.2-67.2 151.2-151.2 151.2-83.2 0-151.2-68-151.2-151.2 0-83.2 67.2-151.2 150.4-151.2 84.8 0 152 68 152 151.2z"
            fill="#ffb600" />
        <path d="m352.8 100.8c83.2 0 151.2 68 151.2 151.2 0 83.2-67.2 151.2-151.2 151.2-83.2 0-151.2-68-151.2-151.2"
            fill="#f7981d" />
        <path d="m352.8 100.8c83.2 0 151.2 68 151.2 151.2 0 83.2-67.2 151.2-151.2 151.2" fill="#ff8500" />
        <path
            d="m149.6 100.8c-82.4.8-149.6 68-149.6 151.2s67.2 151.2 151.2 151.2c39.2 0 74.4-15.2 101.6-39.2 5.6-4.8 10.4-10.4 15.2-16h-31.2c-4-4.8-8-10.4-11.2-15.2h53.6c3.2-4.8 6.4-10.4 8.8-16h-71.2c-2.4-4.8-4.8-10.4-6.4-16h83.2c4.8-15.2 8-31.2 8-48 0-11.2-1.6-21.6-3.2-32h-92.8c.8-5.6 2.4-10.4 4-16h83.2c-1.6-5.6-4-11.2-6.4-16h-70.4c2.4-5.6 5.6-10.4 8.8-16h53.6c-3.2-5.6-7.2-11.2-12-16h-29.6c4.8-5.6 9.6-10.4 15.2-15.2-26.4-24.8-62.4-39.2-101.6-39.2 0-1.6 0-1.6-.8-1.6z"
            fill="#ff5050" />
        <path
            d="m0 252c0 83.2 67.2 151.2 151.2 151.2 39.2 0 74.4-15.2 101.6-39.2 5.6-4.8 10.4-10.4 15.2-16h-31.2c-4-4.8-8-10.4-11.2-15.2h53.6c3.2-4.8 6.4-10.4 8.8-16h-71.2c-2.4-4.8-4.8-10.4-6.4-16h83.2c4.8-15.2 8-31.2 8-48 0-11.2-1.6-21.6-3.2-32h-92.8c.8-5.6 2.4-10.4 4-16h83.2c-1.6-5.6-4-11.2-6.4-16h-70.4c2.4-5.6 5.6-10.4 8.8-16h53.6c-3.2-5.6-7.2-11.2-12-16h-29.6c4.8-5.6 9.6-10.4 15.2-15.2-26.4-24.8-62.4-39.2-101.6-39.2h-.8"
            fill="#e52836" />
        <path
            d="m151.2 403.2c39.2 0 74.4-15.2 101.6-39.2 5.6-4.8 10.4-10.4 15.2-16h-31.2c-4-4.8-8-10.4-11.2-15.2h53.6c3.2-4.8 6.4-10.4 8.8-16h-71.2c-2.4-4.8-4.8-10.4-6.4-16h83.2c4.8-15.2 8-31.2 8-48 0-11.2-1.6-21.6-3.2-32h-92.8c.8-5.6 2.4-10.4 4-16h83.2c-1.6-5.6-4-11.2-6.4-16h-70.4c2.4-5.6 5.6-10.4 8.8-16h53.6c-3.2-5.6-7.2-11.2-12-16h-29.6c4.8-5.6 9.6-10.4 15.2-15.2-26.4-24.8-62.4-39.2-101.6-39.2h-.8"
            fill="#cb2026" />
        <g fill="#fff">
            <path
                d="m204.8 290.4 2.4-13.6c-.8 0-2.4.8-4 .8-5.6 0-6.4-3.2-5.6-4.8l4.8-28h8.8l2.4-15.2h-8l1.6-9.6h-16s-9.6 52.8-9.6 59.2c0 9.6 5.6 13.6 12.8 13.6 4.8 0 8.8-1.6 10.4-2.4z" />
            <path
                d="m210.4 264.8c0 22.4 15.2 28 28 28 12 0 16.8-2.4 16.8-2.4l3.2-15.2s-8.8 4-16.8 4c-17.6 0-14.4-12.8-14.4-12.8h32.8s2.4-10.4 2.4-14.4c0-10.4-5.6-23.2-23.2-23.2-16.8-1.6-28.8 16-28.8 36zm28-23.2c8.8 0 7.2 10.4 7.2 11.2h-17.6c0-.8 1.6-11.2 10.4-11.2z" />
            <path
                d="m340 290.4 3.2-17.6s-8 4-13.6 4c-11.2 0-16-8.8-16-18.4 0-19.2 9.6-29.6 20.8-29.6 8 0 14.4 4.8 14.4 4.8l2.4-16.8s-9.6-4-18.4-4c-18.4 0-36.8 16-36.8 46.4 0 20 9.6 33.6 28.8 33.6 6.4 0 15.2-2.4 15.2-2.4z" />
            <path
                d="m116.8 227.2c-11.2 0-19.2 3.2-19.2 3.2l-2.4 13.6s7.2-3.2 17.6-3.2c5.6 0 10.4.8 10.4 5.6 0 3.2-.8 4-.8 4s-4.8 0-7.2 0c-13.6 0-28.8 5.6-28.8 24 0 14.4 9.6 17.6 15.2 17.6 11.2 0 16-7.2 16.8-7.2l-.8 6.4h14.4l6.4-44c0-19.2-16-20-21.6-20zm3.2 36c0 2.4-1.6 15.2-11.2 15.2-4.8 0-6.4-4-6.4-6.4 0-4 2.4-9.6 14.4-9.6 2.4.8 3.2.8 3.2.8z" />
            <path
                d="m153.6 292c4 0 24 .8 24-20.8 0-20-19.2-16-19.2-24 0-4 3.2-5.6 8.8-5.6 2.4 0 11.2.8 11.2.8l2.4-14.4s-5.6-1.6-15.2-1.6c-12 0-24 4.8-24 20.8 0 18.4 20 16.8 20 24 0 4.8-5.6 5.6-9.6 5.6-7.2 0-14.4-2.4-14.4-2.4l-2.4 14.4c.8 1.6 4.8 3.2 18.4 3.2z" />
            <path
                d="m472.8 214.4-3.2 21.6s-6.4-8-15.2-8c-14.4 0-27.2 17.6-27.2 38.4 0 12.8 6.4 26.4 20 26.4 9.6 0 15.2-6.4 15.2-6.4l-.8 5.6h16l12-76.8zm-7.2 42.4c0 8.8-4 20-12.8 20-5.6 0-8.8-4.8-8.8-12.8 0-12.8 5.6-20.8 12.8-20.8 5.6 0 8.8 4 8.8 13.6z" />
            <path
                d="m29.6 291.2 9.6-57.6 1.6 57.6h11.2l20.8-57.6-8.8 57.6h16.8l12.8-76.8h-26.4l-16 47.2-.8-47.2h-23.2l-12.8 76.8z" />
            <path
                d="m277.6 291.2c4.8-26.4 5.6-48 16.8-44 1.6-10.4 4-14.4 5.6-18.4 0 0-.8 0-3.2 0-7.2 0-12.8 9.6-12.8 9.6l1.6-8.8h-15.2l-10.4 62.4h17.6z" />
            <path
                d="m376.8 227.2c-11.2 0-19.2 3.2-19.2 3.2l-2.4 13.6s7.2-3.2 17.6-3.2c5.6 0 10.4.8 10.4 5.6 0 3.2-.8 4-.8 4s-4.8 0-7.2 0c-13.6 0-28.8 5.6-28.8 24 0 14.4 9.6 17.6 15.2 17.6 11.2 0 16-7.2 16.8-7.2l-.8 6.4h14.4l6.4-44c.8-19.2-16-20-21.6-20zm4 36c0 2.4-1.6 15.2-11.2 15.2-4.8 0-6.4-4-6.4-6.4 0-4 2.4-9.6 14.4-9.6 2.4.8 2.4.8 3.2.8z" />
            <path
                d="m412 291.2c4.8-26.4 5.6-48 16.8-44 1.6-10.4 4-14.4 5.6-18.4 0 0-.8 0-3.2 0-7.2 0-12.8 9.6-12.8 9.6l1.6-8.8h-15.2l-10.4 62.4h17.6z" />
        </g>
        <path
            d="m180 279.2c0 9.6 5.6 13.6 12.8 13.6 5.6 0 10.4-1.6 12-2.4l2.4-13.6c-.8 0-2.4.8-4 .8-5.6 0-6.4-3.2-5.6-4.8l4.8-28h8.8l2.4-15.2h-8l1.6-9.6"
            fill="#dce5e5" />
        <path
            d="m218.4 264.8c0 22.4 7.2 28 20 28 12 0 16.8-2.4 16.8-2.4l3.2-15.2s-8.8 4-16.8 4c-17.6 0-14.4-12.8-14.4-12.8h32.8s2.4-10.4 2.4-14.4c0-10.4-5.6-23.2-23.2-23.2-16.8-1.6-20.8 16-20.8 36zm20-23.2c8.8 0 10.4 10.4 10.4 11.2h-20.8c0-.8 1.6-11.2 10.4-11.2z"
            fill="#dce5e5" />
        <path
            d="m340 290.4 3.2-17.6s-8 4-13.6 4c-11.2 0-16-8.8-16-18.4 0-19.2 9.6-29.6 20.8-29.6 8 0 14.4 4.8 14.4 4.8l2.4-16.8s-9.6-4-18.4-4c-18.4 0-28.8 16-28.8 46.4 0 20 1.6 33.6 20.8 33.6 6.4 0 15.2-2.4 15.2-2.4z"
            fill="#dce5e5" />
        <path
            d="m95.2 244.8s7.2-3.2 17.6-3.2c5.6 0 10.4.8 10.4 5.6 0 3.2-.8 4-.8 4s-4.8 0-7.2 0c-13.6 0-28.8 5.6-28.8 24 0 14.4 9.6 17.6 15.2 17.6 11.2 0 16-7.2 16.8-7.2l-.8 6.4h14.4l6.4-44c0-18.4-16-19.2-22.4-19.2m12 34.4c0 2.4-9.6 15.2-19.2 15.2-4.8 0-6.4-4-6.4-6.4 0-4 2.4-9.6 14.4-9.6 2.4.8 11.2.8 11.2.8z"
            fill="#dce5e5" />
        <path
            d="m136 290.4s4.8 1.6 18.4 1.6c4 0 24 .8 24-20.8 0-20-19.2-16-19.2-24 0-4 3.2-5.6 8.8-5.6 2.4 0 11.2.8 11.2.8l2.4-14.4s-5.6-1.6-15.2-1.6c-12 0-16 4.8-16 20.8 0 18.4 12 16.8 12 24 0 4.8-5.6 5.6-9.6 5.6"
            fill="#dce5e5" />
        <path
            d="m469.6 236s-6.4-8-15.2-8c-14.4 0-19.2 17.6-19.2 38.4 0 12.8-1.6 26.4 12 26.4 9.6 0 15.2-6.4 15.2-6.4l-.8 5.6h16l12-76.8m-20.8 41.6c0 8.8-7.2 20-16 20-5.6 0-8.8-4.8-8.8-12.8 0-12.8 5.6-20.8 12.8-20.8 5.6 0 12 4 12 13.6z"
            fill="#dce5e5" />
        <path
            d="m29.6 291.2 9.6-57.6 1.6 57.6h11.2l20.8-57.6-8.8 57.6h16.8l12.8-76.8h-20l-22.4 47.2-.8-47.2h-8.8l-27.2 76.8z"
            fill="#dce5e5" />
        <path
            d="m260.8 291.2h16.8c4.8-26.4 5.6-48 16.8-44 1.6-10.4 4-14.4 5.6-18.4 0 0-.8 0-3.2 0-7.2 0-12.8 9.6-12.8 9.6l1.6-8.8"
            fill="#dce5e5" />
        <path
            d="m355.2 244.8s7.2-3.2 17.6-3.2c5.6 0 10.4.8 10.4 5.6 0 3.2-.8 4-.8 4s-4.8 0-7.2 0c-13.6 0-28.8 5.6-28.8 24 0 14.4 9.6 17.6 15.2 17.6 11.2 0 16-7.2 16.8-7.2l-.8 6.4h14.4l6.4-44c0-18.4-16-19.2-22.4-19.2m12 34.4c0 2.4-9.6 15.2-19.2 15.2-4.8 0-6.4-4-6.4-6.4 0-4 2.4-9.6 14.4-9.6 3.2.8 11.2.8 11.2.8z"
            fill="#dce5e5" />
        <path
            d="m395.2 291.2h16.8c4.8-26.4 5.6-48 16.8-44 1.6-10.4 4-14.4 5.6-18.4 0 0-.8 0-3.2 0-7.2 0-12.8 9.6-12.8 9.6l1.6-8.8"
            fill="#dce5e5" />
    </symbol>

    <symbol id="icon-paypal" viewBox="0 0 491.2 491.2" width="40" height="40">
        <path
            d="m392.049 36.8c-22.4-25.6-64-36.8-116-36.8h-152.8c-10.4 0-20 8-21.6 18.4l-64 403.2c-1.6 8 4.8 15.2 12.8 15.2h94.4l24-150.4-.8 4.8c1.6-10.4 10.4-18.4 21.6-18.4h44.8c88 0 156.8-36 176.8-139.2.8-3.2.8-6.4 1.6-8.8-2.4-1.6-2.4-1.6 0 0 5.6-38.4 0-64-20.8-88"
            fill="#263b80" />
        <path
            d="m412.849 124.8c-.8 3.2-.8 5.6-1.6 8.8-20 103.2-88.8 139.2-176.8 139.2h-44.8c-10.4 0-20 8-21.6 18.4l-29.6 186.4c-.8 7.2 4 13.6 11.2 13.6h79.2c9.6 0 17.6-7.2 19.2-16l.8-4 15.2-94.4.8-5.6c1.6-9.6 9.6-16 19.2-16h12c76.8 0 136.8-31.2 154.4-121.6 7.2-37.6 3.2-69.6-16-91.2-6.4-7.2-13.6-12.8-21.6-17.6"
            fill="#139ad6" />
        <path
            d="m391.249 116.8c-3.2-.8-6.4-1.6-9.6-2.4s-6.4-1.6-10.4-1.6c-12-2.4-25.6-3.2-39.2-3.2h-119.2c-3.2 0-5.6.8-8 1.6-5.6 2.4-9.6 8-10.4 14.4l-25.6 160.8-.8 4.8c1.6-10.4 10.4-18.4 21.6-18.4h44.8c88 0 156.8-36 176.8-139.2.8-3.2.8-6.4 1.6-8.8-4.8-2.4-10.4-4.8-16.8-7.2-1.6 0-3.2-.8-4.8-.8"
            fill="#232c65" />
        <path d="m275.249 0h-152c-10.4 0-20 8-21.6 18.4l-36.8 230.4 246.4-246.4c-11.2-1.6-23.2-2.4-36-2.4z"
            fill="#2a4dad" />
        <path
            d="m441.649 153.6c-2.4-4-4-8-7.2-12-5.6-6.4-13.6-12-21.6-16.8-.8 3.2-.8 5.6-1.6 8.8-20 103.2-88.8 139.2-176.8 139.2h-44.8c-10.4 0-20 8-21.6 18.4l-25.6 161.6z"
            fill="#0d7dbc" />
        <path d="m50.449 436.8h94.4l23.2-145.6c0-2.4.8-4 1.6-5.6l-131.2 131.2-.8 4.8c-.8 8 4.8 15.2 12.8 15.2z"
            fill="#232c65" />
        <path d="m246.449 0h-123.2c-3.2 0-5.6.8-8 1.6l-12 12c-.8 1.6-1.6 3.2-1.6 4.8l-24 150.4z" fill="#436bc4" />
        <path d="m450.449 232.8c2.4-12 3.2-23.2 3.2-34.4l-156 156c76-.8 135.2-32 152.8-121.6z" fill="#0cb2ed" />
        <path d="m248.849 471.2 12.8-80-100 100h68c9.6 0 17.6-7.2 19.2-16z" fill="#0cb2ed" />
        <g fill="#33e2ff" opacity=".6">
            <path d="m408.049 146.4 45.6 45.6c0-5.6-1.6-11.2-2.4-16.8l-40-40c-1.6 4-2.4 7.2-3.2 11.2z" />
            <path d="m396.849 180c-1.6 3.2-3.2 6.4-4.8 9.6l55.2 55.2c.8-4 1.6-8 2.4-12z" />
            <path d="m431.249 287.2c1.6-3.2 3.2-6.4 4.8-9.6l-60.8-60.8c-2.4 2.4-4 5.6-6.4 8z" />
            <path d="m335.249 250.4 69.6 69.6 7.2-7.2-68-68c-3.2 1.6-5.6 3.2-8.8 5.6z" />
            <path d="m292.849 266.4 76 76c3.2-1.6 6.4-3.2 9.6-4.8l-74.4-74.4c-4 .8-7.2 2.4-11.2 3.2z" />
            <path d="m320.849 353.6c4-.8 8.8-.8 12.8-1.6l-80-80c-4.8 0-8.8.8-13.6.8z" />
            <path d="m196.049 272.8h-6.4c-2.4 0-4.8.8-6.4.8l86.4 87.2c2.4-2.4 5.6-4.8 8.8-5.6z" />
            <path d="m164.049 314.4 94.4 94.4 2.4-12.8-94.4-94.4z" />
            <path d="m156.049 364.8 94.4 94.4 2.4-12-94.4-94.4z" />
            <path d="m150.449 403.2-1.6 12.8 75.2 75.2h5.6c2.4 0 4.8-.8 7.2-1.6z" />
            <path d="m140.049 466.4 24.8 24.8h14.4l-36.8-36.8z" />
        </g>
    </symbol>

    <symbol id="icon-visa" viewBox="0 0 504 504" width="40" height="40">
        <path d="m184.8 324.4 25.6-144h40l-24.8 144z" fill="#3c58bf" />
        <path d="m184.8 324.4 32.8-144h32.8l-24.8 144z" fill="#293688" />
        <path
            d="m370.4 182c-8-3.2-20.8-6.4-36.8-6.4-40 0-68.8 20-68.8 48.8 0 21.6 20 32.8 36 40s20.8 12 20.8 18.4c0 9.6-12.8 14.4-24 14.4-16 0-24.8-2.4-38.4-8l-5.6-2.4-5.6 32.8c9.6 4 27.2 8 45.6 8 42.4 0 70.4-20 70.4-50.4 0-16.8-10.4-29.6-34.4-40-14.4-7.2-23.2-11.2-23.2-18.4 0-6.4 7.2-12.8 23.2-12.8 13.6 0 23.2 2.4 30.4 5.6l4 1.6z"
            fill="#3c58bf" />
        <path
            d="m370.4 182c-8-3.2-20.8-6.4-36.8-6.4-40 0-61.6 20-61.6 48.8 0 21.6 12.8 32.8 28.8 40s20.8 12 20.8 18.4c0 9.6-12.8 14.4-24 14.4-16 0-24.8-2.4-38.4-8l-5.6-2.4-5.6 32.8c9.6 4 27.2 8 45.6 8 42.4 0 70.4-20 70.4-50.4 0-16.8-10.4-29.6-34.4-40-14.4-7.2-23.2-11.2-23.2-18.4 0-6.4 7.2-12.8 23.2-12.8 13.6 0 23.2 2.4 30.4 5.6l4 1.6z"
            fill="#293688" />
        <path
            d="m439.2 180.4c-9.6 0-16.8.8-20.8 10.4l-60 133.6h43.2l8-24h51.2l4.8 24h38.4l-33.6-144zm-18.4 96c2.4-7.2 16-42.4 16-42.4s3.2-8.8 5.6-14.4l2.4 13.6s8 36 9.6 44h-33.6z"
            fill="#3c58bf" />
        <path
            d="m448.8 180.4c-9.6 0-16.8.8-20.8 10.4l-69.6 133.6h43.2l8-24h51.2l4.8 24h38.4l-33.6-144zm-28 96c3.2-8 16-42.4 16-42.4s3.2-8.8 5.6-14.4l2.4 13.6s8 36 9.6 44h-33.6z"
            fill="#293688" />
        <path d="m111.2 281.2-4-20.8c-7.2-24-30.4-50.4-56-63.2l36 128h43.2l64.8-144h-43.2z" fill="#3c58bf" />
        <path d="m111.2 281.2-4-20.8c-7.2-24-30.4-50.4-56-63.2l36 128h43.2l64.8-144h-35.2z" fill="#293688" />
        <path d="m0 180.4 7.2 1.6c51.2 12 86.4 42.4 100 78.4l-14.4-68c-2.4-9.6-9.6-12-18.4-12z" fill="#ffbc00" />
        <path d="m0 180.4c51.2 12 93.6 43.2 107.2 79.2l-13.6-56.8c-2.4-9.6-10.4-15.2-19.2-15.2z" fill="#f7981d" />
        <path d="m0 180.4c51.2 12 93.6 43.2 107.2 79.2l-9.6-31.2c-2.4-9.6-5.6-19.2-16.8-23.2z" fill="#ed7c00" />
        <g fill="#051244">
            <path d="m151.2 276.4-27.2-27.2-12.8 30.4-3.2-20c-7.2-24-30.4-50.4-56-63.2l36 128h43.2z" />
            <path d="m225.6 324.4-34.4-35.2-6.4 35.2z" />
            <path
                d="m317.6 274.8c3.2 3.2 4.8 5.6 4 8.8 0 9.6-12.8 14.4-24 14.4-16 0-24.8-2.4-38.4-8l-5.6-2.4-5.6 32.8c9.6 4 27.2 8 45.6 8 25.6 0 46.4-7.2 58.4-20z" />
            <path
                d="m364 324.4h37.6l8-24h51.2l4.8 24h38.4l-13.6-58.4-48-46.4 2.4 12.8s8 36 9.6 44h-33.6c3.2-8 16-42.4 16-42.4s3.2-8.8 5.6-14.4" />
        </g>
    </symbol>
</svg>
<script>
function showPoint() {
    <?php $_SESSION['pay_by_point'] = true; ?>
    document.getElementById('bill').style.display = 'none';
    document.getElementById('pointPay').style.display = 'block';
}

function showBill() {
    <?php $_SESSION['pay_by_point'] = false; ?>
    document.getElementById('pointPay').style.display = 'none';
    document.getElementById('bill').style.display = 'block';
}

function showAW() {
    document.getElementById('awb').style.display = 'block';
    document.getElementById('finalizeOrder').style.display = 'none';
}

function showB() {
    document.getElementById('awb').style.display = 'none';
    document.getElementById('finalizeOrder').style.display = 'block';
}
</script>

</html>