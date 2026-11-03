<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$totalBook=$conn->query("SELECT COUNT(*) FROM books")->fetchColumn();

$totalUser=$conn->query("SELECT COUNT(*) FROM users")->fetchColumn();

$totalPesanan=$conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();

$pendapatan=$conn->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status = 'Paid'")->fetchColumn();

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Dashboard Admin</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="wrapper">

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Dashboard</h1>

<br>

<div class="cards">

<div class="card">

<h3>Total Buku</h3>

<h1><?= $totalBook ?></h1>

</div>

<div class="card">

<h3>Total User</h3>

<h1><?= $totalUser ?></h1>

</div>

<div class="card">

<h3>Total Pesanan</h3>

<h1><?= $totalPesanan ?></h1>

</div>

<div class="card">

<h3>Pendapatan</h3>

<h1>Rp <?= number_format($pendapatan,0,',','.') ?></h1>

</div>

</div>

</div>

</div>

</body>

</html>