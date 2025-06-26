<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="UTF-8">
  <title>HealthPal+</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen transition-colors duration-300">

<div class="flex">
  <!-- Sidebar -->
  <aside class="w-64 bg-blue-800 text-white h-screen p-4 space-y-4">
    <h2 class="text-2xl font-bold mb-6">HealthPal+</h2>
    <nav class="space-y-2">
      <a href="index.php" class="block hover:underline">🏠 Dashboard</a>
      <a href="assess.php" class="block hover:underline">📝 New Assessment</a>
      <a href="view_assessments.php" class="block hover:underline">📄 View Reports</a>
      <a href="profile.php" class="block hover:underline">👤 Profile</a>
      <a href="logout.php" class="block hover:underline text-red-300">🚪 Logout</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-6">
