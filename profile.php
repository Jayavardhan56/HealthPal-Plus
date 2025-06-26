<?php
session_start();
require 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT name, email, age, gender, height, weight FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<?php include 'includes/header.php'; ?>

<h1 class="text-2xl font-bold text-blue-800 mb-6">My Profile</h1>

<div class="bg-white p-6 rounded-lg shadow-md max-w-xl mx-auto">
  <form action="update_profile.php" method="POST" class="space-y-4">
    <div>
      <label class="block mb-1 font-medium">Full Name</label>
      <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required
             class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
      <label class="block mb-1 font-medium">Email (read-only)</label>
      <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly
             class="w-full px-4 py-2 border bg-gray-100 rounded">
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block mb-1 font-medium">Age</label>
        <input type="number" name="age" value="<?= $user['age'] ?>" required
               class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block mb-1 font-medium">Gender</label>
        <select name="gender" required
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
          <option <?= $user['gender'] == "Male" ? "selected" : "" ?>>Male</option>
          <option <?= $user['gender'] == "Female" ? "selected" : "" ?>>Female</option>
          <option <?= $user['gender'] == "Other" ? "selected" : "" ?>>Other</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block mb-1 font-medium">Height (cm)</label>
        <input type="number" name="height" value="<?= $user['height'] ?>" required
               class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block mb-1 font-medium">Weight (kg)</label>
        <input type="number" name="weight" value="<?= $user['weight'] ?>" required
               class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
    </div>

    <div class="text-right">
      <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800 transition">
        Save Changes
      </button>
    </div>
  </form>
</div>

<?php include 'includes/footer.php'; ?>
