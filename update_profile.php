<?php
session_start();
require 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// Update logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $age    = $_POST["age"];
    $gender = $_POST["gender"];
    $height = $_POST["height"];
    $weight = $_POST["weight"];

    $sql = "UPDATE users SET age=?, gender=?, height=?, weight=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isdsi", $age, $gender, $height, $weight, $user_id);
    $stmt->execute();

    $_SESSION["success"] = "Profile updated!";
    header("Location: profile.php");
    exit;
}
?>
