<body>
    <script async src="https://js.stripe.com/v3/buy-button.js">
    </script>

    <stripe-buy-button buy-button-id="buy_btn_1MrVY1Kh7qvMC9zzCgyPEz5F"
        publishable-key="pk_test_51MnxkNKh7qvMC9zzl8p0v2QcdcSiFCgkTFX6moYdGXh9VowD6YnwkIP8uRnxdD7zfonI5mBEMngcTP2hWYX6sRk000xHyMipou">
    </stripe-buy-button>
</body>
<script>
window.onload = function() {
    document.getElementsByTagName('stripe-buy-button')[0].click();
}
</script>