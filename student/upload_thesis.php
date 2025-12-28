<?php 
include '../config/db.php';
include '../includes/header.php';

if($_SESSION['role'] != 'student') header("Location: ../index.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file_name = time() . "_" . $_FILES['thesis_file']['name'];
    move_uploaded_file($_FILES['thesis_file']['tmp_name'], "../assets/uploads/" . $file_name);

    $stmt = $pdo->prepare("INSERT INTO theses (student_id, title, abstract, file_path) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $_POST['title'], $_POST['abstract'], $file_name]);
    echo "<p class='success'>Thesis uploaded successfully!</p>";
}
?>
<h2>Submit Thesis</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Thesis Title" required><br>
    <textarea name="abstract" placeholder="Abstract"></textarea><br>
    <label>Upload PDF:</label>
    <input type="file" name="thesis_file" accept=".pdf" required><br>
    <button type="submit" class="btn">Upload Submission</button>
</form>
<?php include '../includes/footer.php'; ?>