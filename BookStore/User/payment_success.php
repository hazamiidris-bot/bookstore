<?php
session_start();
if(!isset($_SESSION['id'])){ header("Location: login.php"); exit; }
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pembayaran Terkirim - Zook BookStore</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>

.success-page{
    min-height:75vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:50px 20px;
    background:#f5f7fb;
}

.success-card{
    background:white;
    max-width:450px;
    width:100%;
    text-align:center;
    padding:50px 35px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,.06);
}

.success-icon{
    width:80px;
    height:80px;
    background:#dcfce7;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto 20px;
}

.success-icon i{
    font-size:36px;
    color:#16a34a;
}

.success-card h2{
    font-size:22px;
    margin-bottom:12px;
}

.success-card p{
    color:#666;
    font-size:14px;
    line-height:1.6;
    margin-bottom:26px;
}

.success-actions{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.btn-primary{
    background:#2563EB;
    color:white;
    border:none;
    padding:14px;
    border-radius:12px;
    font-weight:700;
    text-decoration:none;
    font-size:14px;
}

.btn-secondary{
    background:#f1f5f9;
    color:#333;
    border:none;
    padding:14px;
    border-radius:12px;
    font-weight:600;
    text-decoration:none;
    font-size:14px;
}

</style>
</head>
<body>

<?php include "../includes/navbar.php"; ?>

<div class="success-page">

<div class="success-card">

<div class="success-icon">
<i class="fa-solid fa-check"></i>
</div>

<h2>Pembayaran Terkirim!</h2>
<p>Terima kasih, bukti pembayaran kamu sedang diverifikasi oleh admin. Kamu bisa memantau statusnya di halaman Pesanan Saya.</p>

<div class="success-actions">
<a href="my_orders.php" class="btn-primary">Lihat Pesanan Saya</a>
<a href="book.php" class="btn-secondary">Belanja Lagi</a>
</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>