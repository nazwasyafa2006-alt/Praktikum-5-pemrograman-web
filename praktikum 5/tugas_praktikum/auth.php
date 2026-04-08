<?php
session_start();
require_once 'config.php';

/* REGISTER */
if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn,"INSERT INTO user (nama,email,password)
    VALUES('$name','$email','$password')");

    echo "<script>alert('Berhasil daftar');</script>";
}

/* LOGIN */
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $data = mysqli_query($conn,"SELECT * FROM user WHERE email='$email'");
    $user = mysqli_fetch_assoc($data);

    if($user && password_verify($password,$user['password'])){
        $_SESSION['login'] = true;
        $_SESSION['name'] = $user['nama'];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<script>alert('Login gagal');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>GreenDayeuh</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg,#1b5e20,#4caf50); height:100vh;">

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-4">

<div class="card p-3 mb-3">
<h4 class="text-center">Login</h4>
<form method="POST">
<input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
<input class="form-control mb-2" type="password" name="password" placeholder="Password" required>
<button class="btn btn-success w-100" name="login">Login</button>
</form>
</div>

<div class="card p-3">
<h4 class="text-center">Register</h4>
<form method="POST">
<input class="form-control mb-2" type="text" name="name" placeholder="Nama" required>
<input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
<input class="form-control mb-2" type="password" name="password" placeholder="Password" required>
<button class="btn btn-dark w-100" name="register">Daftar</button>
</form>
</div>

</div>
</div>
</div>

</body>
</html>