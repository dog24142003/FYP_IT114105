<?php
session_start();
require_once('..\vendor\autoload.php');

$total = $_SESSION['price'];

\Stripe\Stripe::setApiKey('sk_test_51MnxkNKh7qvMC9zz6j28mQlWppf0s4AZ8JKwItBsAjlwJNVH5Yh6HjAdR2IMC9OcHPm9OiPFhiVc8yC2agls4YaP00pZKLyzwa');
$charge = \Stripe\Charge::create([
    'source' => $_POST['stripeToken'],
    'description' => $_SESSION['item'],
    'amount' => $total * 100,
    'currency' => 'hkd',
]);


?>
<script>
    window.location.href = './successful.php';
</script>