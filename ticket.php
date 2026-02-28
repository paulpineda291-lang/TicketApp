<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];  // "guest" or "student"
?>

<!DOCTYPE html>
<html>
<head>
  <title>Select Ticket</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
  <h2>Select Ticket</h2>

  <?php if ($role === 'guest'): ?>
    <!-- Guests only get one fixed option -->
    <p>You are signed in as a <strong>Guest</strong>.</p>
    <form action="checkout.php" method="post">
      <input type="hidden" name="ticket" value="Guest Ticket - ₱299">
      <p class="note">Your ticket: <strong>Guest Ticket — ₱299</strong></p>
      <br>
      <button type="submit">Proceed to Checkout</button>
    </form>

  <?php elseif ($role === 'student'): ?>
    <!-- Students only get one fixed option -->
    <p>You are signed in as a <strong>Student</strong>.</p>
    <form action="checkout.php" method="post">
      <input type="hidden" name="ticket" value="Student Ticket - ₱199">
      <p class="note">Your ticket: <strong>Student Ticket — ₱199</strong></p>
      <br>
      <button type="submit">Proceed to Checkout</button>
    </form>

  <?php else: ?>
    <!-- Fallback — should never happen -->
    <p>Invalid session. <a href="logout.php">Sign in again</a>.</p>
  <?php endif; ?>

  <a href="logout.php">← Back / Sign out</a>
</div>

</body>
</html>
