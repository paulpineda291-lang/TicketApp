<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_POST['ticket'])) {
    header("Location: ticket.php");
    exit();
}

$_SESSION['ticket'] = $_POST['ticket'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Order Summary</h2>

    <p><strong>Ticket:</strong> <?php echo $_SESSION['ticket']; ?></p>
    <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>

    <br>

    <a href="dragonpay.php" class="pay-btn">Pay via DragonPay (QR)</a>
</div>

</body>
</html>
