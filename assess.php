<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}
?>

<?php include 'includes/header.php'; ?>

<h2>Health Assessment</h2>
<form action="save_assessment.php" method="POST" enctype="multipart/form-data">
    <label>Symptoms:</label><br>
    <textarea name="symptoms" rows="4" cols="50" required></textarea><br><br>

    <label>Diseases:</label><br>
    <input type="text" name="diseases" placeholder="e.g., diabetes, Migrane"><br><br>

    <label>Lifestyle:</label><br>
    <select name="lifestyle" required>
        <option value="Active">Active</option>
        <option value="Moderate">Moderate</option>
        <option value="Sedentary">Sedentary</option>
    </select><br><br>

        <label>Upload Your Image:</label><br>
    <input type="file" name="image" accept="image/*"><br><br>

    <button type="submit">Submit Assessment</button>
</form>


<?php include 'includes/footer.php'; ?>
