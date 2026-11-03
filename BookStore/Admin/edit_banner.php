<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$id = $_GET['id'];

$books = $conn->query("SELECT id, title FROM books ORDER BY title ASC");

$stmt = $conn->prepare("SELECT * FROM banners WHERE id = ?");
$stmt->execute([$id]);
$banner = $stmt->fetch();

if(!$banner){
    die("Banner tidak ditemukan.");
}

if(isset($_POST['save'])){

    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $book_id = $_POST['book_id'] ?: null;

    $image = $banner['image'];

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){

        if($banner['image'] && file_exists("../uploads/banners/".$banner['image'])){
            unlink("../uploads/banners/".$banner['image']);
        }

        $image = time()."_".$_FILES['image']['name'];
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../uploads/banners/".$image
        );
    }

    $sql = $conn->prepare("UPDATE banners SET
        title=?, author=?, description=?, image=?, book_id=?
        WHERE id=?");

    $sql->execute([
        $title, $author, $description, $image, $book_id, $id
    ]);

    header("Location: banner.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Banner</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="wrapper">

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Edit Banner</h1>
<br>

<form method="POST" enctype="multipart/form-data" class="book-form">

<label>Judul Buku / Banner</label>
<input type="text" name="title" value="<?= htmlspecialchars($banner['title']) ?>" required>

<label>Penulis / Author</label>
<input type="text" name="author" value="<?= htmlspecialchars($banner['author'] ?? '') ?>" placeholder="Contoh: Tatsuki Fujimoto">

<label>Deskripsi</label>
<textarea name="description" rows="4"><?= htmlspecialchars($banner['description']) ?></textarea>

<label>Link ke Buku (opsional, klik banner akan ke halaman ini)</label>
<select name="book_id">
<option value="">-- Tidak Terhubung --</option>
<?php foreach($books as $bk){ ?>
<option value="<?= $bk['id'] ?>" <?= $bk['id']==$banner['book_id']?'selected':'' ?>>
<?= htmlspecialchars($bk['title']) ?>
</option>
<?php } ?>
</select>

<label>Gambar Saat Ini</label>
<br>
<img src="../uploads/banners/<?= $banner['image'] ?>" width="200" style="border-radius:10px; margin:10px 0;">

<label>Ganti Gambar (opsional)</label>
<input type="file" name="image" accept="image/*">

<br><br>

<button class="save-btn" name="save">Update Banner</button>

</form>

</div>
</div>

</body>
</html>
