<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}

$user_id   = $_SESSION["user_id"];
$symptoms  = $_POST["symptoms"];
$diseases  = $_POST["diseases"];
$lifestyle = $_POST["lifestyle"];

// Get user's height and weight
$sql = "SELECT height, weight FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($height, $weight);
$stmt->fetch();
$stmt->close();

// Calculate BMI
if ($height > 0) {
    $height_m = $height / 100;
    $bmi = round($weight / ($height_m * $height_m), 1);
} else {
    $bmi = 0;
}

// 🧠 Determine BMI category and map to diseases
$bmi_category = "";
$diseaseList = [];
$tipsList = [];

if ($bmi < 18.5) {
    $bmi_category = "Underweight";
    $diseaseList = ["Anemia", "Fatigue", "Weak Immunity"];
} elseif ($bmi < 25) {
    $bmi_category = "Normal";
    $diseaseList = [];
} elseif ($bmi < 30) {
    $bmi_category = "Overweight";
    $diseaseList = ["Hypertension", "Fatty Liver", "Joint Pain"];
} else {
    $bmi_category = "Obese";
    $diseaseList = ["Type 2 Diabetes", "Heart Disease", "Sleep Apnea"];
}

// 🧠 Map disease tips
$allTips = [
    "Anemia" => "Eat iron-rich foods like spinach, red meat, and lentils.",
    "Fatigue" => "Get proper sleep and include complex carbs in diet.",
    "Weak Immunity" => "Consume vitamin C, turmeric milk, and probiotics.",
    "Hypertension" => "Reduce salt, avoid processed food, and walk daily.",
    "Fatty Liver" => "Avoid sugar, increase fiber, eat omega-3 rich food.",
    "Joint Pain" => "Maintain healthy weight, do low-impact exercise.",
    "Type 2 Diabetes" => "Avoid sugar and refined carbs, exercise regularly.",
    "Heart Disease" => "Eat heart-healthy fats, manage stress.",
    "Sleep Apnea" => "Reduce weight, avoid alcohol before bed, consult a doctor."
];

foreach ($diseaseList as $d) {
    if (isset($allTips[$d])) {
        $tipsList[] = $allTips[$d];
    }
}

// Combine diseases and tips into string for DB (optional for now)
$diseases = implode(", ", $diseaseList);
$tips = implode(" ", $tipsList);


// 🔁 Handle image upload
$image_path = null;
if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = time() . "_" . basename($_FILES["image"]["name"]);
    $targetPath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
        $image_path = $targetPath;
    }
}

// 🔁 Insert into assessments
$sql = "INSERT INTO assessments (user_id, symptoms, diseases, lifestyle, bmi, tips, image_path) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssdss", $user_id, $symptoms, $diseases, $lifestyle, $bmi, $tips, $image_path);
$stmt->execute();
$stmt->close();

// ✅ Redirect
header("Location: profile.php");
exit;
?>
