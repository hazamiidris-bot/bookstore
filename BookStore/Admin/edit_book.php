<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$id = $_GET['id'];

$kategori = $conn->query("SELECT * FROM categories ORDER BY name ASC");

$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if(!$book){
    die("Buku tidak ditemukan.");
}

if(isset($_POST['save'])){

    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    $cover = $book['cover'];

    if(isset($_FILES['cover']) && $_FILES['cover']['error'] == 0){

        $cover = time()."_".$_FILES['cover']['name'];

        move_uploaded_file(
            $_FILES['cover']['tmp_name'],
            "../uploads/books/".$cover
        );
    }

    $sql = $conn->prepare("UPDATE books SET
        title=?, author=?, category_id=?, price=?, stock=?, description=?, cover=?
        WHERE id=?");

    $sql->execute([
        $title, $author, $category, $price, $stock, $description, $cover, $id
    ]);

    header("Location: books.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Buku</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="wrapper">

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Edit Buku</h1>
<br>

<form method="POST" enctype="multipart/form-data" class="book-form">

<label>Judul Buku</label>
<input type="text" name="title" value="<?= $book['title'] ?>" required>

<label>Penulis</label>
<input type="text" name="author" value="<?= $book['author'] ?>" required>

<label>Kategori</label>
<select name="category">
<?php foreach($kategori as $k){ ?>
<option value="<?= $k['id'] ?>" <?= $k['id']==$book['category_id']?'selected':'' ?>>
<?= $k['name'] ?>
</option>
<?php } ?>
</select>

<label>Harga</label>
<input type="number" name="price" value="<?= $book['price'] ?>" required>

<label>Stok</label>
<input type="number" name="stock" value="<?= $book['stock'] ?>" required>

<label>Deskripsi</label>
<textarea name="description" rows="6"><?= $book['description'] ?></textarea>

<label>Cover Saat Ini</label>
<br>
<img src="../uploads/books/<?= $book['cover'] ?>" width="100" style="border-radius:8px; margin:10px 0;">

<label>Ganti Cover (opsional)</label>
<input type="file" name="cover" accept="image/*">

<br><br>

<button class="save-btn" name="save">Update Buku</button>

</form>

</div>
</div>

</body>
</html>