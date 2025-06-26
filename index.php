<?php
session_start();
require 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// Fetch user name
$stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();

// Optional: Fetch last BMI
$bmi = null;
$stmt = $conn->prepare("SELECT bmi FROM assessments WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($bmi);
$stmt->fetch();
$stmt->close();
?>

<?php include 'includes/header.php'; ?>

<h1 class="text-2xl font-bold text-blue-800 mb-4">Welcome, <?= htmlspecialchars($name) ?> 👋</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
  <div class="bg-white rounded shadow p-6">
    <h2 class="text-xl font-semibold text-blue-700 mb-2">Latest BMI</h2>
    <p class="text-3xl text-gray-800"><?= $bmi ? $bmi : 'N/A' ?></p>
  </div>

  <div class="bg-white rounded shadow p-6">
    <h2 class="text-xl font-semibold text-blue-700 mb-2">Start Assessment</h2>
    <a href="assess.php" class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Get Started</a>
  </div>

  <div class="bg-white rounded shadow p-6">
    <h2 class="text-xl font-semibold text-blue-700 mb-2">View Past Reports</h2>
    <a href="view_assessments.php" class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">History</a>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
