<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$cat = $stmt->fetch();

if(isset($_POST['save'])){

    $name = $_POST['name'];

    $sql = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $sql->execute([$name, $id]);

    header("Location: category.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Kategori</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="wrapper">

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Edit Kategori</h1>
<br>

<form method="POST" class="book-form">

<label>Nama Kategori</label>
<input type="text" name="name" value="<?= $cat['name'] ?>" required>

<br><br>

<button class="save-btn" name="save">Update Kategori</button>

</form>

</div>
</div>

</body>
</html>