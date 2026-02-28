<?php
session_start();
require 'config.php';   // provides $conn (mysqli)

/* ---------------------------------------------------------------
   GUEST LOGIN - Gmail only
---------------------------------------------------------------- */
if (isset($_POST['guest_login'])) {

    $email = trim($_POST['guest_email']);

    if (!empty($email) && str_ends_with($email, "@gmail.com")) {

        // Upsert the user so we always have a DB record
        $stmt = $conn->prepare(
            "INSERT INTO users (email, role)
             VALUES (?, 'guest')
             ON DUPLICATE KEY UPDATE role = 'guest'"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();

        $_SESSION['email'] = $email;
        $_SESSION['role']  = "guest";

        header("Location: ticket.php");
        exit();

    } else {
        echo "<script>
            alert('Guest login requires a Gmail address (@gmail.com).');
            window.location.href='index.php';
        </script>";
        exit();
    }
}

/* ---------------------------------------------------------------
   STUDENT LOGIN - Official HAU email only
---------------------------------------------------------------- */
if (isset($_POST['student_login'])) {

    $email          = trim($_POST['student_email']);
    $student_number = trim($_POST['student_number']);

    if (!empty($email) && !empty($student_number) &&
        str_ends_with($email, "@student.hau.edu.ph")) {

        // Upsert the student record
        $stmt = $conn->prepare(
            "INSERT INTO users (email, role, student_number)
             VALUES (?, 'student', ?)
             ON DUPLICATE KEY UPDATE
                 role           = 'student',
                 student_number  = VALUES(student_number)"
        );
        $stmt->bind_param("ss", $email, $student_number);
        $stmt->execute();
        $stmt->close();

        $_SESSION['email']          = $email;
        $_SESSION['student_number'] = $student_number;
        $_SESSION['role']           = "student";

        header("Location: ticket.php");
        exit();

    } else {
        echo "<script>
            alert('Use your official HAU student email (@student.hau.edu.ph).');
            window.location.href='index.php';
        </script>";
        exit();
    }
}
?>