<?php
session_start();
require 'db.php';
require('fpdf.php');

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$assessment_id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

$sql = "SELECT a.*, u.name, u.email FROM assessments a JOIN users u ON a.user_id = u.id WHERE a.user_id = ? AND a.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $assessment_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Assessment not found.");
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'HealthPal+ Assessment Report');

$pdf->SetFont('Arial', '', 12);
$pdf->Ln(10);
$pdf->Cell(0, 10, "Name: " . $data["name"], 0, 1);
$pdf->Cell(0, 10, "Email: " . $data["email"], 0, 1);
$pdf->Cell(0, 10, "Date: " . $data["created_at"], 0, 1);
$pdf->Ln(5);
$pdf->MultiCell(0, 10, "Symptoms: " . $data["symptoms"]);
$pdf->MultiCell(0, 10, "Diseases: " . $data["diseases"]);
$pdf->MultiCell(0, 10, "Lifestyle: " . $data["lifestyle"]);
$pdf->Cell(0, 10, "BMI: " . $data["bmi"], 0, 1);
$pdf->MultiCell(0, 10, "Tips: " . $data["tips"]);

if (!empty($data["image_path"])) {
    $imagePath = $data["image_path"];

    // Convert to full server path
    $fullPath = __DIR__ . '/' . $imagePath;

    if (file_exists($fullPath)) {
        $pdf->Ln(10);
        $pdf->Image($fullPath, null, null, 100);
    } else {
        $pdf->Ln(10);
        $pdf->Cell(0, 10, "⚠️ Image not found on server", 0, 1);
    }
}

$pdf->Output();
?>
