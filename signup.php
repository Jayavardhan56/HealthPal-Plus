<?php
session_start();
require 'db.php';

$success = "";
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $age      = (int)$_POST["age"];
    $gender   = $_POST["gender"];
    $height   = (float)$_POST["height"];
    $weight   = (float)$_POST["weight"];

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, age, gender, height, weight) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssissi", $name, $email, $password, $age, $gender, $height, $weight);

        if ($stmt->execute()) {
            $success = "Registration successful! You can now log in.";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up - HealthPal+</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-blue-50 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-800">Create Your HealthPal+ Account</h2>

    <?php if (!empty($success)) : ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 text-sm">
        <?= $success ?>
      </div>
    <?php elseif (!empty($error)) : ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
        <?= $error ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <input type="text" name="name" placeholder="Full Name" required class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-400" />
      <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-400" />
      <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-400" />

      <input type="number" name="age" placeholder="Age" min="0" required class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-400" />
      
      <select name="gender" required class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-400">
        <option value="">Select Gender</option>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
      </select>

      <input type="number" name="height" placeholder="Height (cm)" required class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-400" />
      <input type="number" name="weight" placeholder="Weight (kg)" required class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-400" />

      <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 transition">
        Sign Up
      </button>
    </form>

    <p class="text-sm text-center text-gray-600 mt-4">
      Already have an account?
      <a href="login.php" class="text-blue-700 font-semibold hover:underline">Log in</a>
    </p>
  </div>

</body>
</html>
