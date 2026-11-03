<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Kategori</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="wrapper">

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Kelola Kategori</h1>
<br>

<a href="add_category.php" class="add-btn">+ Tambah Kategori</a>

<br><br>

<table>
<tr>
<th>Nama Kategori</th>
<th>Aksi</th>
</tr>

<?php foreach($categories as $cat){ ?>
<tr>
<td><?= $cat['name']; ?></td>
<td>
<a href="edit_category.php?id=<?= $cat['id'] ?>">Edit</a>
|
<a href="delete_category.php?id=<?= $cat['id'] ?>" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
</td>
</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>