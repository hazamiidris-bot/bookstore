<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola User</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="wrapper">

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Kelola User</h1>
<br>

<table>
<tr>
<th>Nama</th>
<th>Email</th>
<th>Role</th>
<th>Aksi</th>
</tr>

<?php foreach($users as $u){ ?>
<tr>
<td><?= $u['fullname']; ?></td>
<td><?= $u['email']; ?></td>
<td><?= $u['role']; ?></td>
<td>

<?php if($u['id'] != $_SESSION['id']){ ?>
<a href="delete_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Hapus user ini?')">Hapus</a>
<?php } else { ?>
<span style="color:gray">(Kamu)</span>
<?php } ?>

</td>
</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>