<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>HAU University Days | Sign In</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-wrapper">

    <!-- LEFT SIDE -->
    <div class="left-section">
        <div class="logo-text">
            <h1>Holy Angel University</h1>
            <p>University Days</p>
        </div>

        <div class="ticket-wrapper">
            <img src="images/ticket-non.png" class="ticket ticket1">
            <img src="images/ticket-angelites.png" class="ticket ticket2">
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="container">
        <h2>Guest Sign In</h2>
        <form action="process.php" method="post">
            <input type="email" name="guest_email" placeholder="Email" required>
            <button type="submit" name="guest_login">Continue as Guest</button>
        </form>

        <hr>

        <h2>Student Sign In</h2>
        <form action="process.php" method="post">
            <input type="email" name="student_email" placeholder="University Email" required>
            <input type="text" name="student_number" placeholder="Student Number" required>
            <button type="submit" name="student_login">Continue as Student</button>
        </form>
    </div>

</div>

</body>
</html>
