<?php

    require 'koneksi.php';

    session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
    }

    $user = $_SESSION["login"];
    $jabatan = $_SESSION["jabatan"];
    $username = $_SESSION["username"];

    //ambil id paling besar
    $maxId = mysqli_query($conn, "SELECT idAnggota as kodeTerbesar FROM idanggota");
    $data = mysqli_fetch_array($maxId);
    $idAnggota = substr($data['kodeTerbesar'],1);
    $idAnggota++;
    $idAnggota = sprintf("%07s",$idAnggota);
    

    //ketika tombol cari di klik
    if (isset($_POST["cari"])) {
        $result = cari($_POST["keyword"]);
    }

    

    $batas   = 10;
    $halaman = @$_GET['halaman'];
    if(empty($halaman)){
         $posisi  = 0;
        $halaman = 1;
    } else{
        $posisi  = ($halaman-1) * $batas;
    }

        $no = $posisi+1;
        // Filter data 
        //if (isset($_GET['filter'])) {
            // $search = htmlspecialchars($_POST["search"]);
            @$search = $_GET["search"];

            if ($search != null) {
                $sql=mysqli_query($conn,"SELECT a.*, d.divisi FROM anggota a join divisi d on a.divisi_id = d.id where a.id like '%$search%' or a.nama_anggota like '%$search%' or a.alamat like '%$search%' or d.divisi like '%$search%' or a.status like '%$search%' order by id asc limit $posisi,$batas");
            } else {
                $sql=mysqli_query($conn,"SELECT a.*, d.divisi FROM anggota a join divisi d on a.divisi_id = d.id order by id asc limit $posisi,$batas");
            }
        //} else {
            //$sql=mysqli_query($conn, "SELECT a.*, d.divisi FROM anggota a join divisi d on a.divisi_id = d.id order by id asc limit $posisi,$batas");
        //}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Koperasi-Djoyo</title>
    <link href="assets/css/styles2.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="css/sweetalert2.min.css" rel="stylesheet" />
    <link href="img/logo.png" rel="shortcut icon" />

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/tambahan.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

    <script src="js/jquery-3.6.1.min.js"></script>

</head>

<body id="page-top">

                                            <table class="table-utama tabel" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr class="text-center small">
                                                        <th>No</th>
                                                        <th>ID Anggota</th>
                                                        <th>Nama Anggota</th>
                                                        <th>ID Karyawan</th>
                                                        <th>No KTP</th>
                                                        <th>Alamat</th>
                                                        <th>No HP</th>
                                                        <th>Divisi</th>
                                                        <th>Tanggal Join</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>

                                                <!-- Looping Data Tarif -->
                                                <?php foreach($sql as $anggota ) : ?>
                                                    

                                                <tbody class="small">
                                                    <tr>
                                                        <td class="text-center no "><?= $no; ?></td>
                                                        <td><?= $anggota["id"]; ?></td>
                                                        <td><?= $anggota["nama_anggota"]; ?></td>
                                                        <td class="text-right"><?= $anggota["id_karyawan"]; ?></td>
                                                        <td class="text-right"><?= $anggota["ktp"]; ?></td>
                                                        <td><?= $anggota["alamat"]; ?></td>
                                                        <td class="text-right"><?= $anggota["no_hp"]; ?></td>
                                                        <td><?= $anggota["divisi"]; ?></td>
                                                        <td class="text-right"><?= tgl_indo(date('Y-m-d',strtotime($anggota['tanggal_join']))); ?></td>
                                                        <td><?= $anggota["status"]; ?></td>
                                                        <td class="text-center">
                                                            <a type="button" class="aksi text-dark" id="tombolUbah" data-toggle='modal' data-target="#editAnggota" 
                                                                data-id="<?= $anggota['id']; ?>"
                                                                data-nama_anggota="<?= $anggota['nama_anggota']; ?>"
                                                                data-ktp="<?= $anggota['ktp']; ?>"
                                                                data-alamat="<?= $anggota['alamat']; ?>"
                                                                data-no_hp="<?= $anggota['no_hp']; ?>"
                                                                data-divisi="<?= $anggota['divisi_id']; ?>"
                                                                data-tanggal_join="<?= $anggota['tanggal_join']; ?>"
                                                                data-status="<?= $anggota['status']; ?>"
                                                                data-karyawan="<?= $anggota['id_karyawan']; ?>"
                                                                ><i class="fas fa-solid fa-pen small"></i>
                                                            </a>
                                                            <a class="aksi text-dark alert_notif" href="hapus.php?kode_anggota=<?= $anggota["id"]; ?>"><i class="fas fa-solid fa-trash small"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            
                                                <?php $no++ ?>
                                                <?php endforeach; ?>

                                            </table>
                                            

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content-supplier">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin akan Logout ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" jika anda akan melanjutkan untuk logout.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="addtarif" tabindex="-1" aria-labelledby="addtarifLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content-supplier">
                <div class="modal-header">
                    <h5 class="modal-title" id="addtarifLabel">Form Tambah Data Anggota</h5>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" id="formTambah">
                        <div class="mb-2">
                            <label for="id_anggota" class="form-label small">ID Anggota</label>
                            <input type="text" class="form-control form-control-sm" name="id_anggota" id = "id_anggota" value="<?php echo "A".$idAnggota ?>" required readonly>
                        </div>   
                        <div class="mb-2">
                            <label for="id" class="form-label small">Karyawan</label>
                            <select class="custom-select" name="id" id="id" onchange="cek_db()" readonly>
                                <option value=""> </option>
                                <?php
                                $sql=mysqli_query($conn,"SELECT * FROM karyawan where id not in (select id_karyawan from anggota) order by id DESC");
                                while ($data = mysqli_fetch_array($sql)){
                                    echo '<option name="id" value="'.$data['id'].'">'.$data['id']." - ".$data['nama_karyawan'].'</option>';
                                }?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="nama_anggota" class="form-label small">Nama Anggota</label>
                            <input type="text" class="form-control form-control-sm" name="nama" id = "nama" required maxlength="100" autocomplete="off" readonly>
                        </div>   
                        <div class="mb-2">
                            <label for="ktp" class="form-label small">No KTP</label>
                            <input type="number" class="form-control form-control-sm" name="ktp" id = "ktp" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required maxlength="16" autocomplete="off" readonly>
                        </div>   
                        <div class="mb-2">
                            <label for="alamat" class="form-label small">Alamat</label>
                            <input type="text" class="form-control form-control-sm" name="alamat" id = "alamat" required maxlength="100" autocomplete="off" readonly>
                        </div>   
                        <div class="mb-2">
                            <label for="no_hp" class="form-label small">No HP</label>
                            <input type="number" class="form-control form-control-sm" name="no_hp" id = "no_hp" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"required maxlength="15" autocomplete="off" readonly>
                        </div>
                        <div class="mb-2">
                            <label for="divisi" class="form-label small">Divisi</label>
                            <input type="text" class="form-control form-control-sm" name="divisi" id = "divisi" required readonly>
                        </div>
                        <div class="mb-2">
                            <label for="tgl_join" class="form-label small">Tanggal Bergabung</label>
                            <input type="date" class="form-control form-control-sm" name="tgl_join" id = "tgl_join" required readonly>
                        </div>
                        <div class="mb-2">
                            <label for="status" class="form-label small">Status</label>
                            <input type="text" class="form-control form-control-sm" name="status" id = "status" value="Pasif" required readonly>
                        </div> 
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary btn-sm" name ="submit-anggota">Simpan</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" onclick="reset()">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Data-->
    <div class="modal fade" id="editAnggota" tabindex="-1" aria-labelledby="editSupplierLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content-supplier">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSupplierLabel">Form Edit Data Anggota</h5>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" id="formUbah">
                        <div class="mb-2">
                            <label for="id2" class="form-label small">ID Anggota</label>
                            <input type="text" class="form-control form-control-sm" name="id2" id = "id2" value="<?php echo "A".$idAnggota ?>" required readonly>
                        </div>   
                        <div class="mb-2">
                            <label for="idk" class="form-label small">ID Karyawan</label>
                            <input type="text" class="form-control form-control-sm" name="idk" id = "idk" value="<?php echo "A".$idAnggota ?>" required readonly>
                        </div>
                        <div class="mb-2">
                            <label for="nama_anggota" class="form-label small">Nama Anggota</label>
                            <input type="text" class="form-control form-control-sm" name="nama_anggota2" id = "nama_anggota2" required maxlength="100" autocomplete="off" readonly>
                        </div>   
                        <div class="mb-2">
                            <label for="ktp" class="form-label small">No KTP</label>
                            <input type="number" class="form-control form-control-sm" name="ktp2" id = "ktp2" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required maxlength="16" autocomplete="off" readonly>
                        </div>   
                        <div class="mb-2">
                            <label for="alamat" class="form-label small">Alamat</label>
                            <input type="text" class="form-control form-control-sm" name="alamat2" id = "alamat2" required maxlength="100" autocomplete="off" readonly>
                        </div>   
                        <div class="mb-2">
                            <label for="no_hp" class="form-label small">No HP</label>
                            <input type="number" class="form-control form-control-sm" name="no_hp2" id = "no_hp2" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"required maxlength="15" autocomplete="off" readonly>
                        </div>
                        <div class="mb-2">
                                <?php $divisi = mysqli_query($conn, "select * from divisi") ?>
                                <label for="divisi" class="form-label small">Divisi</label>
                                <select class="custom-select" id="divisi2" name="divisi2" required readonly>
                                    <option selected></option>
                                    <!-- Looping Data Tipe Bayar -->
                                    <?php foreach($divisi as $div ) : ?>
                                        <option  value="<?= $div["id"]; ?>"><?= $div["divisi"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <div class="mb-2">
                            <label for="tanggal_join2" class="form-label small">Tanggal Bergabung</label>
                            <input type="date" class="form-control form-control-sm" name="tanggal_join2" id = "tanggal_join2" required readonly>
                        </div>
                        <div class="mb-2">
                            <label for="status2" class="form-label small">Status</label>
                            <select class="custom-select" id="status2" name="status2" required readonly>
                                <option selected></option>
                                <option value="Aktif">Aktif</option>
                                <option value="Pasif">Pasif</option>
                            </select>
                        </div> 
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary btn-sm" name ="ubah_anggota">Ubah</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onchange="reset()">Batal</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
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

    <script src="js/myScript.js"></script>
<!-- Sweetalert, Fungsi dan Validasi-->
<?php
    // Tambah Data
        if(isset($_POST["submit-anggota"])) {
            //cek apakah data berhasil ditambahkan atau tidak
            if (tambah_anggota($_POST) > 0) {
                echo "
                <script>
                    Swal.fire(
                    'Berhasil!',
                    'Data anggota sudah tersimpan',
                    'success'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'anggota.php';
                        } else {
                        //if no clicked => do something else
                        }
                    })
                </script>
                "; 
            } else {
                echo "
                <script>
                    Swal.fire(
                    'Gagal!',
                    'Karyawan sudah menjadi anggota',
                    'error'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'anggota.php';
                        } else {
                        //if no clicked => do something else
                        }
                    })
                </script>
                ";  
            }
        }

        //fungsi tambah
        function tambah_anggota ($data) {
            global $conn;
            $id = htmlspecialchars($_POST["id_anggota"]);
            $id_karyawan = htmlspecialchars($_POST["id"]);
            $nama_anggota = htmlspecialchars($_POST["nama"]);
            $ktp = htmlspecialchars($_POST["ktp"]);
            $alamat = htmlspecialchars($_POST["alamat"]);
            $no_hp = htmlspecialchars($_POST["no_hp"]);
            $divisi = htmlspecialchars($_POST["divisi"]);
            $tgl_join = htmlspecialchars($_POST["tgl_join"]);
            $status = htmlspecialchars($_POST["status"]);
            $id_cust = substr($id,1,7);
            $id_customer = 'C'.$id_cust;

            
            $ada = mysqli_query($conn,"SELECT count(id_karyawan) karyawan FROM anggota WHERE id_karyawan='$id_karyawan'");
            $ada = mysqli_fetch_array($ada);
            $adagak = $ada['karyawan'];

            if ($adagak > 0) {
                return false;
            } else {
                $query = "INSERT INTO anggota
                        VALUES
                        ('$id', '$nama_anggota','$ktp','$alamat','$no_hp','$divisi','$tgl_join','$status','$id_karyawan')
                        ";
                $query2 = "INSERT INTO saldo_daily (tanggal, saldo, anggota_id)
                            VALUES
                            ('$tgl_join', 0, '$id')
                            ";
                $query3 = "INSERT INTO customer
                        VALUES
                        ('$id_customer', '$nama_anggota','$ktp','$alamat','$no_hp','$divisi','$tgl_join','$status','$id_karyawan')
                        ";
                    mysqli_query($conn, $query);
                    mysqli_query($conn, $query2);
                    mysqli_query($conn, $query3);
                mysqli_query($conn, "UPDATE idanggota set idAnggota = '$id'");
            }

            
        return mysqli_affected_rows($conn);
        }


        // Ubah Data
        if(isset($_POST["ubah_anggota"])) {
            //cek apakah data berhasil diubah atau tidak
            if (edit_anggota($_POST) > 0) {
                echo "
                <script>
                    Swal.fire(
                    'Berhasil!',
                    'Data anggota berhasil diedit',
                    'success'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'anggota.php';
                        } else {
                        //if no clicked => do something else
                        }
                    })
                </script>
                "; 
            } else {
                echo "
                <script>
                    Swal.fire(
                    'Gagal!',
                    'Data anggota gagal diedit',
                    'error'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'anggota.php';
                        } else {
                        //if no clicked => do something else
                        }
                    })
                </script>
                ";  
            }
        }

        //fungsi ubah 
        function edit_anggota ($data) {
            global $conn;
                $id2 = htmlspecialchars($_POST["id2"]);
                $nama_anggota2 = htmlspecialchars($_POST["nama_anggota2"]);
                $ktp2 = htmlspecialchars($_POST["ktp2"]);
                $alamat2 = htmlspecialchars($_POST["alamat2"]);
                $no_hp2 = htmlspecialchars($_POST["no_hp2"]);
                $divisi2 = htmlspecialchars($_POST["divisi2"]);
                $tanggal_join2 = htmlspecialchars($_POST["tanggal_join2"]);
                $status2 = htmlspecialchars($_POST["status2"]);
                $id_cust = substr($id2,1,7);
                $id_customer = 'C'.$id_cust;

            $edit = "UPDATE anggota set 
                             nama_anggota = '$nama_anggota2', 
                             ktp = '$ktp2', 
                             alamat = '$alamat2', 
                             no_hp = '$no_hp2',
                             divisi_id = '$divisi2',
                             tanggal_join = '$tanggal_join2',
                             status = '$status2'
                        where id = '$id2'
                             ";
            $edit2 = "UPDATE customer set
                            divisi_id = '$divisi2',
                            status = '$status2'
                            where id = '$id_customer'
                            ";
            mysqli_query($conn, $edit);
            mysqli_query($conn, $edit2);
        return mysqli_affected_rows($conn);
        }



?>
        <script>
            //Hapus
            $('.alert_notif').on('click',function(){
                var getLink = $(this).attr('href');
                Swal.fire({
                    title: "Yakin !",
                    text: "Akan Menghapus Data Ini ?",            
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Hapus',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: "Batal"
                
                }).then(result => {
                    if(result.isConfirmed){
                        window.location.href = getLink;
                    }
                })
                return false;
            });

            // Ubah Data
            $(document).on("click", "#tombolUbah", function() {
                let id = $(this).data("id");
                let nama_anggota = $(this).data("nama_anggota");
                let ktp = $(this).data("ktp");
                let alamat = $(this).data("alamat");
                let no_hp = $(this).data("no_hp");
                let divisi = $(this).data("divisi");
                let tanggal_join = $(this).data("tanggal_join");
                let status = $(this).data("status");
                let karyawan = $(this).data("karyawan");

                $(".modal-body #id2").val(id);
                $(".modal-body #nama_anggota2").val(nama_anggota);
                $(".modal-body #ktp2").val(ktp);
                $(".modal-body #alamat2").val(alamat);
                $(".modal-body #no_hp2").val(no_hp);
                $(".modal-body #divisi2").val(divisi);
                $(".modal-body #tanggal_join2").val(tanggal_join);
                $(".modal-body #status2").val(status);
                $(".modal-body #idk").val(karyawan);
            });

            function formReset() {
                document.getElementById("formTambah").reset();
                document.getElementById("formUbah").reset();
            }
        </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
      function cek_db(){
        var id = $("#id").val();
        $.ajax({
          url : 'auto_proses.php',
          data : "id="+id,
        }).success(function (data){
          var json = data,
          obj = JSON.parse(json);
          $('#nama').val(obj.nama);
          $('#ktp').val(obj.ktp);
          $('#alamat').val(obj.alamat);
          $('#no_hp').val(obj.no_hp);
          $('#divisi').val(obj.divisi_id);
          $('#tgl_join').val(obj.tanggal_join);
 
        })
      }
    </script>

</body>

</html>