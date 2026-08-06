<?php
include "config/database.php";

$error = "";

if(isset($_POST['register'])){

    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm']);

    if($password != $confirm){

        $error = "Konfirmasi password tidak sama.";

    }else{

        $cek = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $cek->execute([$username,$email]);

        if($cek->rowCount()>0){

            $error="Username atau Email sudah digunakan.";

        }else{

            $hash=password_hash($password,PASSWORD_DEFAULT);

            $insert=$conn->prepare("INSERT INTO users(fullname,username,email,password)
            VALUES(?,?,?,?)");

            if($insert->execute([$fullname,$username,$email,$hash])){

                header("Location: login.php");
                exit;

            }else{

                $error="Terjadi kesalahan.";

            }

        }

    }

}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Register</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="assets/css/auth.css">

</head>

<body>

<div class="container">

<div class="left">

<h1>Zook BookStore</h1>

<p>

Temukan ribuan buku terbaik
mulai dari Novel, Manga,
Teknologi hingga Pendidikan.

</p>

</div>

<div class="right">

<h2>Create Account</h2>

<p class="subtitle">

Silakan buat akun terlebih dahulu.

</p>

<?php

if($error!=""){

echo "<div class='error'>$error</div>";

}

?>

<form method="POST">

<div class="input-box">

<i class="fa-solid fa-user"></i>

<input
type="text"
name="fullname"
placeholder="Nama Lengkap"
required>

</div>

<div class="input-box">

<i class="fa-solid fa-at"></i>

<input
type="text"
name="username"
placeholder="Username"
required>

</div>

<div class="input-box">

<i class="fa-solid fa-envelope"></i>

<input
type="email"
name="email"
placeholder="Email"
required>

</div>

<div class="input-box">

<i class="fa-solid fa-lock"></i>

<input
type="password"
name="password"
placeholder="Password"
required>

</div>

<div class="input-box">

<i class="fa-solid fa-lock"></i>

<input
type="password"
name="confirm"
placeholder="Konfirmasi Password"
required>

</div>

<button
class="register-btn"
name="register">

Create Account

</button>

</form>

<p class="login-text">

Sudah punya akun?

<a href="login.php">

Login

</a>

</p>

</div>

</div>

</body>
</html>