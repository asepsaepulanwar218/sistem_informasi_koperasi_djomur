<?php

require 'koneksi.php';

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
        <span>Halaman Registrasi</span>  <br> 
        Koperasi Djoyo Makmur
    </h3>

    <?php if (isset($error)) : ?>
        <p style="color: red; font-style: italic; font-family:cambria; background-color:lavender; text-align:center;">
            maaf username/password salah
        </p>
    <?php endif;?>

	<form action="" id="lg-form" name="lg-form" method="post">
        
        <div>
			<label for="nama_user">ID Anggota:</label>
			<input type="text" name="nama_user" id="nama_user" placeholder="Masukan ID Anggota" required autocomplete="off"/> 
        </div>
		<div>
			<label for="username">Username:</label>
			<input type="text" name="username" id="username" placeholder="Masukan id username" required autocomplete="off"/>
		</div>

		<div>
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" placeholder="Masukan password" required/>
		</div>
        <div>
            <label for="ulang_pass" class="form-label hitam">Ulang Password Baru</label>
            <input type="password" class="form-control form-control-sm hitam" name="ulang_pass" id = "ulang_pass" autocomplete="off" oninput="cekPass()" placeholder="Ulangi Password" >
            <p class="pesan mt-1 small"></p>
        </div>
		<div style="color: white; text-align: center;">
			<button type="submit" name="saveAkun" id="submit">Simpan</button>
		</div>

	</form>
	<div id="message"></div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/sweetalert2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <!-- <script src="assets/demo/datatables-demo.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<!-- Sweetalert, Fungsi dan Validasi-->
<?php

    // ubah Data
    if(isset($_POST["saveAkun"])) {

        global $conn;
        $nama_user = htmlspecialchars($_POST["nama_user"]);
        $id_anggota = strtoupper($nama_user);
        $username = htmlspecialchars($_POST["username"]);

        $cekUser = mysqli_query($conn, "SELECT count(id) cek FROM user where nama_user = '$id_anggota' ");
        $cekUser = mysqli_fetch_array($cekUser);
        $cekUser = $cekUser['cek'];

        $cekAnggota = mysqli_query($conn, "SELECT count(id) cek FROM anggota where id = '$id_anggota' ");
        $cekAnggota = mysqli_fetch_array($cekAnggota);
        $cekAnggota = $cekAnggota['cek'];
        
        $cekUsername = mysqli_query($conn, "SELECT count(id) cek FROM user where username = '$username' ");
        $cekUsername = mysqli_fetch_array($cekUsername);
        $cekUsername = $cekUsername['cek'];

        if ($cekUser > 0) {
            echo "<script>
                Swal.fire(
                'Gagal!',
                'ID Anggota sudah terdaftar',
                'error'
                ).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = 'registrasi.php';
                    } else {
                    //if no clicked => do something else
                    }
                })
            </script>"; 
        }  else if ($cekAnggota == 0) {
                echo "<script>
                    Swal.fire(
                    'Gagal!',
                    'ID Tidak Ditemukan',
                    'error'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'registrasi.php';
                        } else {
                        //if no clicked => do something else
                        }
                    })
                </script>"; 
        } else if ($cekUsername > 0) {
            echo "<script>
                Swal.fire(
                'Gagal!',
                'Username sudah terpakai',
                'error'
                ).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = 'registrasi.php';
                    } else {
                    //if no clicked => do something else
                    }
                })
            </script>"; 
    } else {
            if (simpanAkun($_POST) > 0) {
                echo "<script>
                        Swal.fire(
                            'Berhasil !',
                            'Registrasi Selesai',
                            'success'
                            ).then(function(isConfirm) {
                                if (isConfirm) {
                                    document.location.href = 'login.php';
                                } 
                        });
                    </script>"; 
            } else {
                echo "
                <script>
                    Swal.fire(
                    'Gagal!',
                    'Registrasi Gagal',
                    'error'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'registrasi.php';
                        } else {
                        //if no clicked => do something else
                        }
                    })
                </script>
                ";  
            }
        }
    }
        

        
 
    //fungsi ubah
    function simpanAkun ($data) {
        global $conn;
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);
        $nama_user = htmlspecialchars($_POST["nama_user"]);
        $id_anggota = strtoupper($nama_user);
        $jabatan = 'anggota';

        mysqli_query($conn, "INSERT INTO user (nama_user, jabatan, username, password) VALUES ('$id_anggota','$jabatan','$username','$password') ");
        
    return mysqli_affected_rows($conn);
    }

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    document.getElementById("submit").disabled = true;
    function cekPass() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("ulang_pass").value;
        if (password != confirmPassword) {
        	document.getElementById("submit").disabled = true;
            $('.pesan').html('<p class="text-danger" style="color: red; text-align: center; background-color: white;"> Pengulangan Password tidak sesuai ! </p>');
            return false;
        }
        document.getElementById("submit").disabled = false;
        $('.pesan').html('<p class="text-success" style="color: white; text-align: center;"> Pengulangan Password sesuai ! </p>');
        return true;
    }
</script>
<script>
    // Hapus
    $('.alert_notif').on('click',function(){
                var getLink = $(this).attr('href');
                Swal.fire({
                    title: "Maaf !",
                    text: "Menu Khusus Pengurus Koperasi.",            
                    icon: 'error',
                
                }).then(result => {
                    if(result.isConfirmed){
                        window.location.href = getLink;
                    }
                })
                return false;
            });

</script>
   
</body>

</html>