<?php
session_start();
include "../config/database.php";

$posts = $conn->query("
SELECT community_posts.*, users.fullname
FROM community_posts
LEFT JOIN users ON community_posts.user_id = users.id
ORDER BY community_posts.id DESC
");

if(isset($_POST['post'])){

    if(!isset($_SESSION['id'])){
        header("Location: ../User/login.php");
        exit;
    }

    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = $conn->prepare("INSERT INTO community_posts (user_id, title, content, created_at) VALUES (?,?,?, NOW())");
    $sql->execute([$_SESSION['id'], $title, $content]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Community - Zook BookStore</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
.community-wrap{ max-width:700px; margin:40px auto; padding:0 20px; }
.post-form{ background:white; padding:20px; border-radius:15px; box-shadow:0 5px 15px rgba(0,0,0,.08); margin-bottom:30px; }
.post-form input[type=text]{ width:100%; padding:12px; border:1px solid #ddd; border-radius:10px; font-family:inherit; margin-bottom:12px; }
.post-form textarea{ width:100%; padding:12px; border:1px solid #ddd; border-radius:10px; resize:vertical; min-height:80px; font-family:inherit; }
.post-form button{ margin-top:12px; padding:10px 20px; background:#2563EB; color:white; border:none; border-radius:8px; cursor:pointer; }
.post-card{ background:white; padding:20px; border-radius:15px; box-shadow:0 5px 15px rgba(0,0,0,.08); margin-bottom:20px; }
.post-card h3{ margin-bottom:8px; }
.post-card .author{ font-weight:600; margin-bottom:5px; color:#2563EB; }
.post-card .date{ font-size:12px; color:gray; margin-bottom:10px; }
</style>
</head>
<body>

<?php include "../includes/navbar.php"; ?>

<div class="community-wrap">

<h2>Community</h2>
<br>

<?php if(isset($_SESSION['id'])){ ?>

<div class="post-form">
<form method="POST">
<input type="text" name="title" placeholder="Judul postingan..." required>
<textarea name="content" placeholder="Bagikan pendapatmu tentang buku..." required></textarea>
<br>
<button type="submit" name="post">Posting</button>
</form>
</div>

<?php } else { ?>

<p><a href="../User/login.php">Login</a> untuk membuat post.</p>
<br>

<?php } ?>

<?php foreach($posts as $post){ ?>

<div class="post-card">
<h3><?= htmlspecialchars($post['title']) ?></h3>
<div class="author"><?= $post['fullname'] ?? 'Anonim' ?></div>
<div class="date"><?= date('d M Y, H:i', strtotime($post['created_at'])) ?></div>
<p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
</div>

<?php } ?>

</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>