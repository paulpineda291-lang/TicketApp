<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['ticket'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>DragonPay QR</title>

    <style>
    /* RESET */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      min-height: 100vh;
      background: #8b0000;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    .container {
      width: 400px;
      background: #ffffff;
      padding: 35px;
      border-radius: 20px;
      box-shadow: 0 30px 80px rgba(0,0,0,0.5);
      text-align: center;
    }

    h2 {
      color: #800000;
      margin-bottom: 15px;
    }

    p {
      margin-bottom: 15px;
      font-size: 14px;
      color: #444;
    }

    img {
      margin: 20px 0;
    }

    /* CUSTOM FILE UPLOAD */
    .file-upload {
      display: flex;
      flex-direction: column;
      gap: 8px;
      margin-bottom: 15px;
    }

    .file-upload input[type="file"] {
      display: none;
    }

    .custom-file-btn {
      display: inline-block;
      padding: 12px;
      background: #800000;
      color: white;
      border-radius: 10px;
      text-align: center;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
    }

    .custom-file-btn:hover {
      background: #a00000;
    }

    #file-name {
      font-size: 13px;
      color: #666;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #800000;
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #a00000;
    }
    </style>

</head>
<body>

<div class="container">
    <h2>DragonPay Payment</h2>

    <p>Scan this QR to complete payment:</p>

    <img src="qr.jfif" width="200" alt="QR Code">

    <form action="verify.php" method="post" enctype="multipart/form-data">

        <div class="file-upload">
            <label for="proof" class="custom-file-btn">
                Upload Payment Screenshot
            </label>
            <input type="file" id="proof" name="proof" required>
            <span id="file-name">No file selected</span>
        </div>

        <button type="submit">Confirm Payment</button>

    </form>
</div>

<script>
document.getElementById("proof").addEventListener("change", function() {
    const fileName = this.files[0] ? this.files[0].name : "No file selected";
    document.getElementById("file-name").textContent = fileName;
});
</script>

</body>
</html>
