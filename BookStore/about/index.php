<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>About Us - Zook BookStore</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
.about-wrap{ max-width:800px; margin:50px auto; padding:0 20px; }
.about-wrap h1{ font-size:36px; margin-bottom:10px; }
.about-wrap p{ line-height:1.8; color:#444; margin-bottom:20px; }
.about-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-top:40px; }
.about-card{ background:white; padding:25px; border-radius:15px; box-shadow:0 5px 15px rgba(0,0,0,.08); text-align:center; }
.about-card i{ font-size:32px; color:#2563EB; margin-bottom:15px; }
.about-card h3{ margin-bottom:10px; }
.about-card p{ font-size:14px; color:#666; margin:0; }
</style>
</head>
<body>

<?php include "../includes/navbar.php"; ?>

<div class="about-wrap">

<h1>Tentang Zook BookStore</h1>

<p>
Zook BookStore adalah toko buku online yang menghadirkan koleksi manga, novel,
dan buku-buku pilihan untuk para pecinta cerita. Kami percaya setiap buku
punya cerita yang layak dibaca dan dibagikan.
</p>

<p>
Selain berbelanja, Zook BookStore juga menjadi ruang bagi komunitas pembaca
untuk berdiskusi, berbagi rekomendasi, dan terhubung dengan sesama pecinta buku
lewat fitur Community kami.
</p>

<div class="about-grid">

<div class="about-card">
<i class="fa-solid fa-book"></i>
<h3>Koleksi Lengkap</h3>
<p>Ratusan judul buku dari berbagai genre dan penulis.</p>
</div>

<div class="about-card">
<i class="fa-solid fa-truck-fast"></i>
<h3>Pengiriman Cepat</h3>
<p>Pesanan diproses dan dikirim dengan cepat ke seluruh Indonesia.</p>
</div>

<div class="about-card">
<i class="fa-solid fa-users"></i>
<h3>Komunitas Aktif</h3>
<p>Bergabung dan diskusi dengan sesama pembaca lainnya.</p>
</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>
