<?php
session_start();
require 'config.php';   // provides $conn (mysqli)

if (!isset($_SESSION['payment_verified'])) {
    header("Location: index.php");
    exit();
}

require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email          = $_SESSION['email'];
$ticket         = $_SESSION['ticket'];
$reference_code = $_SESSION['reference_code'] ?? 'N/A';
$order_id       = $_SESSION['order_id']       ?? null;
$role           = $_SESSION['role']           ?? 'guest';

// Pick the correct ticket image based on role
$ticketImagePath = ($role === 'student')
    ? __DIR__ . '/tickets/angelites.jfif'
    : __DIR__ . '/tickets/non-angelites.jfif';

$ticketImageName = ($role === 'student')
    ? 'angelites.jfif'
    : 'non-angelites.jfif';

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'yaomanpineda@gmail.com';
    $mail->Password   = 'ohcikczruibefehj';          // app password (no spaces)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('yaomanpineda@gmail.com', 'HAU Ticket System');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Ticket Confirmed - HAU University Days';

    // Embed ticket image inline AND attach it so the user can save/print it
    if (file_exists($ticketImagePath)) {

        // Inline embed — referenced via cid:ticket_image in the HTML body
        $mail->addEmbeddedImage(
            $ticketImagePath,
            'ticket_image',      // CID used in <img src="cid:ticket_image">
            $ticketImageName,
            'base64',
            'image/jpeg'         // JFIF is JPEG internally
        );

        // Separate downloadable attachment
        $mail->addAttachment(
            $ticketImagePath,
            $ticketImageName,
            'base64',
            'image/jpeg'
        );

        $inlineImg = '<img src="cid:ticket_image" alt="Your Ticket"
                           style="max-width:100%;border-radius:8px;margin-top:16px;">';
    } else {
        // Safety fallback if the file is not found on disk
        $inlineImg = '<p><em>Ticket image could not be loaded. Please contact support.</em></p>';
    }

    $mail->Body = "
        <div style='font-family:Segoe UI,sans-serif;color:#2c2c2c;max-width:520px;margin:auto;'>
            <h2 style='color:#800000;'>Payment Verified ✅</h2>
            <p><strong>Ticket:</strong> {$ticket}</p>
            <p><strong>Reference:</strong> {$reference_code}</p>
            <p>Your ticket is confirmed. See you at University Days!</p>
            {$inlineImg}
            <p style='margin-top:16px;font-size:13px;color:#888;'>
                Your ticket image is also attached to this email so you can save or print it.
            </p>
        </div>
    ";

    $mail->send();

    // Log the sent ticket in the database
    if ($order_id) {
        $stmt = $conn->prepare(
            "INSERT IGNORE INTO sent_tickets (order_id) VALUES (?)"
        );
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();
    }

} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Ticket Confirmed</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Payment Verified 🎉</h2>
    <p>Your ticket has been sent to:</p>
    <strong><?php echo htmlspecialchars($email); ?></strong>
    <br><br>
    <p class="note">Reference: <strong><?php echo htmlspecialchars($reference_code); ?></strong></p>
    <br>
    <a href="logout.php">Finish</a>
</div>

</body>
</html>