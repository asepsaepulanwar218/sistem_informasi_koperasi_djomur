<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link href="assets/css/styles2.css" rel="stylesheet" />
        <link href="assets/css/styles.css" rel="stylesheet" />
        <link href="css/sweetalert2.min.css" rel="stylesheet" />

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link href="css/tambahan.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    </head>
    <body>
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
        
        <?php 
        require 'koneksi.php';
        // $ambil_id =  '<div class="border-0 hitam" id="tenor2" name="tenor2" required readonly value="355"></div>'  ;
        // $user_id = 1;
        // $tenor = 6/2;
        // $idid = $ambil_id;
        // $stat1 = mysqli_query($conn, "SELECT status from angsuran where pinjaman_id = '$id_pinjam' and angsuran ='$angsur_sebelum'");
        // $tatus1 = mysqli_fetch_array($stat1);
        // $status_sebelum = $tatus1["status"];

            $nom = mysqli_query($conn,"SELECT sum(nominal_simpanan) nominal from sim_sukarela where simpanan_id in (select id from simpanan where anggota_id  = 'A0000007')");
            $nom1 = mysqli_fetch_array($nom);
            $nom2 =  $nom1["nominal"];
            
            $tarik = mysqli_query($conn,"SELECT sum(nominal) nominal from penarikan where simpanan_id in (select id from simpanan where anggota_id  = 'A0000007')");
            $tarik1 = mysqli_fetch_array($tarik);
            $tarik2 = $tarik1["nominal"];

            $salsimsuk = $nom2 - $tarik2;

            @$pinjaman = mysqli_query ($conn,"SELECT count(id) id FROM pinjaman WHERE id = '$anggota' and status = 'Progres'");
            @$pinjamannya = mysqli_fetch_array($pinjaman);
            @$pinjaman0 = $pinjamannya["id"];


        // $cek_kas = mysqli_query ($conn,'SELECT sum(kas_masuk) masuk from kas where id ='.$idid.'" ');
        // $kas = mysqli_fetch_array($cek_kas);
        // $masuk = $kas ["masuk"];

        // foreach  ($cek_kas as $kas) {
        //     echo $kas ["masuk"];
        // }

        // for ($x=1; $x<=$tenor; $x++) {
        //     echo ($kas_akhir+$x).'<br>';
        //     echo 'nilai = '.$idid.'<br>';
        //     // mysqli_query($conn, "INSERT INTO angsuran (tanggal, nominal, angsuran, pinjaman_id, status)
        //     //                                     VALUES ('2021-01-01', '5000','$x','4','Piutang')");
        // }
        
      // } else {
      //   echo 'gagal';
      

                    //echo 'saldo_sekarang = '.$saldo_sekarang.'<br>';
                    // echo 'ganti_tahun = '.$ganti_tahun.'<br>';
                    // echo 'maxBulan = '.$maxBulan.'<br>';
                    // echo 'maxBulanSebelum = '.$maxBulanSebelum.'<br>';
                     echo 'nilai = '.$pinjaman0.'<br>';
                     var_dump($pinjaman0);
         ?>           
                    </form>
        

    </body>
</html>