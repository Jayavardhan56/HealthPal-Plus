<?php
session_start();
require 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["health_image"])) {
    $target_dir = "uploads/";
    $file_name = "user_" . $user_id . "_" . basename($_FILES["health_image"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["health_image"]["tmp_name"], $target_file)) {
        // Save image path in assessments (latest record)
        $sql = "UPDATE assessments SET image_path=? WHERE user_id=? ORDER BY created_at DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $target_file, $user_id);
        $stmt->execute();
        echo "Image uploaded successfully.";
    } else {
        echo "Failed to upload image.";
    }
}
?>
