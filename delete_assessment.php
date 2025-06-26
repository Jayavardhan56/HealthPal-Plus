<?php
session_start();
require 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$assessment_id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

// Fetch the assessment to verify ownership and get image path
$sql = "SELECT image_path FROM assessments WHERE id=? AND user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $assessment_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data) {
    // Delete image if exists
    if (!empty($data['image_path']) && file_exists($data['image_path'])) {
        unlink($data['image_path']);
    }

    // Delete assessment record
    $del = $conn->prepare("DELETE FROM assessments WHERE id=? AND user_id=?");
    $del->bind_param("ii", $assessment_id, $user_id);
    $del->execute();
}

header("Location: view_assessments.php");
exit;
