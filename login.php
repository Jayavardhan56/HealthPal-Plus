<?php
session_start();
require 'db.php';

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

$error = "";

// Handle login on POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql  = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - HealthPal+</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-blue-50 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-800">Welcome to HealthPal+</h2>

    <?php if (!empty($error)) : ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
        <?= $error ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <div>
        <label class="block mb-1 text-sm font-medium">Email</label>
        <input type="email" name="email" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block mb-1 text-sm font-medium">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 transition">
        Login
      </button>
    </form>

    <p class="text-sm text-center text-gray-600 mt-4">
      Don't have an account?
      <a href="signup.php" class="text-blue-700 font-semibold hover:underline">Sign up</a>
    </p>
  </div>

</body>
</html>
