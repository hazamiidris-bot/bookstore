<?php
session_start();
include "../config/database.php";

$error = "";

if(isset($_POST['login'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $sql->execute([$username]);

    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if($user){

        if(password_verify($password, $user['password'])){

            $_SESSION['id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];

            if($user['role'] == "admin"){
                header("Location: ../admin/dashboard.php");
                exit;
            }else{
                header("Location: ../index.php");
                exit;
            }

        }else{
            $error = "Password salah!";
        }

    }else{
        $error = "Username tidak ditemukan!";
    }

}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Zook BookStore</title>

    <link rel="stylesheet" href="../assets/css/auth.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>


<div class="container">

    <div class="left">

        <h1>Zook BookStore</h1>

        <p>
            Selamat datang kembali.
            Login untuk melanjutkan membaca,
            membeli buku favorit, dan mengelola akunmu.
        </p>

    </div>

    <div class="right">

        <h2>Welcome Back</h2>

        <p class="subtitle">
            Login ke akunmu.
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
                    name="username"
                    placeholder="Username"
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

            <button
                class="register-btn"
                name="login">
                Login
            </button>

        </form>

        <p class="login-text">

            Belum punya akun?

            <a href="register.php">
                Register
            </a>

        </p>

    </div>

</div>

</body>
</html>