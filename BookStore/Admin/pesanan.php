<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$orders = $conn->query("
SELECT orders.*, users.fullname AS customer
FROM orders
LEFT JOIN users ON orders.user_id = users.id
ORDER BY orders.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Pesanan</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="wrapper">

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Kelola Pesanan</h1>
<br>

<table>
<tr>
<th>ID</th>
<th>Customer</th>
<th>Total</th>
<th>Status</th>
<th>Tanggal</th>
<th>Aksi</th>
</tr>

<?php foreach($orders as $o){ ?>
<tr>
<td>#<?= $o['id']; ?></td>
<td><?= htmlspecialchars($o['customer'] ?? '-'); ?></td>
<td>Rp <?= number_format($o['total']); ?></td>
<td><?= $o['status']; ?></td>
<td><?= $o['created_at']; ?></td>
<td>

<form method="POST" action="update_status.php" style="display:inline">
<input type="hidden" name="id" value="<?= $o['id'] ?>">
<select name="status" onchange="this.form.submit()">
<option value="Pending" <?= $o['status']=='Pending'?'selected':'' ?>>Pending</option>
<option value="Paid" <?= $o['status']=='Paid'?'selected':'' ?>>Paid</option>
<option value="Cancelled" <?= $o['status']=='Cancelled'?'selected':'' ?>>Cancelled</option>
</select>
</form>

<br><br>

<a href="pembayaran.php?order_id=<?= $o['id'] ?>">Bukti Bayar</a>
&nbsp;|&nbsp;
<a href="pengiriman.php?order_id=<?= $o['id'] ?>">Bukti Kirim</a>
&nbsp;|&nbsp;
<a href="delete_pesanan.php?id=<?= $o['id'] ?>" style="color:#dc2626;" onclick="return confirm('Hapus pesanan #<?= $o['id'] ?>? Data ini tidak bisa dikembalikan.')">Hapus</a>

</td>
</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>