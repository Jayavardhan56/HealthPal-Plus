<?php
session_start();
require 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM assessments WHERE user_id=? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include 'includes/header.php'; ?>

<h1 class="text-2xl font-bold text-blue-800 mb-4">Your Past Assessments</h1>

<?php if ($result->num_rows > 0): ?>
  <div class="space-y-6">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="bg-white p-6 rounded shadow border border-blue-100">
        <p><span class="font-semibold text-gray-700">Date:</span> <?= date("d M Y, H:i", strtotime($row["created_at"])) ?></p>
        <p><span class="font-semibold text-gray-700">BMI:</span> <?= $row["bmi"] ?></p>
        <p><span class="font-semibold text-gray-700">Tips:</span> <?= htmlspecialchars($row["tips"]) ?></p>

        <?php if (!empty($row["image_path"]) && file_exists($row["image_path"])): ?>
          <img src="<?= $row["image_path"] ?>" alt="Assessment Image" class="mt-4 rounded border w-64 shadow">
        <?php endif; ?>

        <div class="mt-4 space-x-4">
          <!-- PDF Download -->
          <a href="generate_pdf.php?id=<?= $row['id'] ?>" target="_blank" class="text-blue-600 font-semibold hover:underline">
            📄 Download PDF
          </a>

          <!-- Delete Button -->
          <a href="delete_assessment.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this assessment?');" class="text-red-600 font-semibold hover:underline">
            🗑 Delete
          </a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php else: ?>
  <p class="text-gray-600">No assessments found yet.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
