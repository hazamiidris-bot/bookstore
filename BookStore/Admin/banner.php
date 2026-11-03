<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$totalBanner = $conn->query("SELECT COUNT(*) FROM banners")->fetchColumn();

$books = $conn->query("SELECT id, title FROM books ORDER BY title ASC");

$error = "";

if(isset($_POST['save'])){

    if($totalBanner >= 5){

        $error = "Maksimal 5 banner. Hapus salah satu dulu sebelum menambah.";

    } else {

        $title = $_POST['title'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $book_id = $_POST['book_id'] ?: null;
        $image = "";

        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
            $image = time()."_".$_FILES['image']['name'];
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                "../uploads/banners/".$image
            );
        }

        $sql = $conn->prepare("INSERT INTO banners (title, author, description, image, book_id) VALUES (?,?,?,?,?)");
        $sql->execute([$title, $author, $description, $image, $book_id]);

        header("Location: banner.php");
        exit;
    }
}

$banners = $conn->query("
SELECT banners.*, books.title AS book_title
FROM banners
LEFT JOIN books ON banners.book_id = books.id
ORDER BY banners.id ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Banner</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="wrapper">

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Kelola Banner Home</h1>
<p style="color:gray; margin-top:5px;">Maksimal 5 banner (<?= $totalBanner ?>/5 terpakai)</p>
<br>

<?php if($error){ ?>
<p style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:15px;"><?= $error ?></p>
<?php } ?>

<?php if($totalBanner < 5){ ?>

<form method="POST" enctype="multipart/form-data" class="book-form">

<label>Judul Buku / Banner</label>
<input type="text" name="title" required>

<label>Penulis / Author</label>
<input type="text" name="author" placeholder="Contoh: Tatsuki Fujimoto">

<label>Deskripsi</label>
<textarea name="description" rows="4"></textarea>

<label>Link ke Buku (opsional, klik banner akan ke halaman ini)</label>
<select name="book_id">
<option value="">-- Tidak Terhubung --</option>
<?php foreach($books as $bk){ ?>
<option value="<?= $bk['id'] ?>"><?= htmlspecialchars($bk['title']) ?></option>
<?php } ?>
</select>

<label>Gambar Banner</label>
<input type="file" name="image" accept="image/*" required>

<br><br>

<button class="save-btn" name="save">Tambah Banner</button>

</form>

<br>

<?php } ?>

<table>
<tr>
<th>Gambar</th>
<th>Judul</th>
<th>Author</th>
<th>Link ke Buku</th>
<th>Aksi</th>
</tr>

<?php foreach($banners as $b){ ?>
<tr>
<td><img src="../uploads/banners/<?= $b['image'] ?>" width="100" style="border-radius:8px;"></td>
<td><?= htmlspecialchars($b['title']) ?></td>
<td><?= htmlspecialchars($b['author'] ?? '-') ?></td>
<td><?= htmlspecialchars($b['book_title'] ?? '-') ?></td>
<td>
<a href="edit_banner.php?id=<?= $b['id'] ?>">Edit</a>
&nbsp;|&nbsp;
<a href="delete_banner.php?id=<?= $b['id'] ?>" onclick="return confirm('Hapus banner ini?')" style="color:#dc2626;">Hapus</a>
</td>
</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>