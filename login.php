<?php 
session_start();

if (isset($_SESSION["login"])) {
    header('Location: index.php');
}

require 'koneksi.php';

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    //cek username
    if (mysqli_num_rows($result) ===1) {

        //cek password
        $row = mysqli_fetch_array($result);
        if ($password == $row["password"]) {
            //set session
            $_SESSION["login"] = $row["id"];
            $_SESSION["jabatan"] = $row["jabatan"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["nama_user"] = $row["nama_user"];
            if ($row["jabatan"] == 'anggota') {
                header("Location: indexAnggota.php");
            } else {
                header("Location: index.php");
            }

            exit;
        } 
    }

    $error = true;
} 

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link href="assets/css/log.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
    <link href="img/logo.png" rel="shortcut icon" />
</head>
<body>
<div class="lg-container">
	<h3>
        <img src="img/logo.png" alt="" width="50px" style="float:center;"><br>
        <span>Halaman Login</span>  <br> 
        Koperasi Djoyo Makmur
    </h3>

    <?php if (isset($error)) : ?>
        <p style="color: red; font-style: italic; font-family:cambria; background-color:lavender; text-align:center;">
            maaf username/password salah
        </p>
    <?php endif;?>

	<form action="" id="lg-form" name="lg-form" method="post">

		<div>
			<label for="username">Username:</label>
			<input type="text" name="username" id="username" placeholder="Masukan id username" required autocomplete="off"/>
		</div>

		<div>
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" placeholder="Masukan password" required/>
		</div>

		<div>
			<button type="submit" name="login">Login</button>
		</div>

	</form>
    
		<div style="color: white; text-align: center;">
			<a href="registrasi.php" style="color: white;">Registrasi</a>
		</div>
	<div id="message"></div>
</div>
</body>
</html>