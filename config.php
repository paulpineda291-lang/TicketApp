<?php
$conn = new mysqli("localhost", "root", "", "hau_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

