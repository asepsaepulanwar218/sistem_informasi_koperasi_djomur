<?php

    require 'koneksi.php';

    session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
    }

    $user_id = $_SESSION["login"];
    $jabatan = $_SESSION["jabatan"];
    $username = $_SESSION["username"];

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
        if (isset($_POST['filter'])) {
            $search = htmlspecialchars($_POST["search"]);

            if ($search != null) {
                $sql=mysqli_query($conn, "SELECT sp.tanggal_simpanan tanggal, a.id id, a.nama_anggota nama, sp.nominal_simpanan nominal, u.nama_user user
                                        FROM sim_pokok sp 
                                        join simpanan s on sp.simpanan_id = s.id 
                                        join anggota a on a.id = s.anggota_id
                                        join user u on u.id = s.user_id
                                        where sp.nominal_simpanan !=0 and a.id like '%$search%' or sp.nominal_simpanan !=0 and a.nama_anggota like '%$search%' or sp.nominal_simpanan !=0 and sp.tanggal_simpanan like '%$search%'or sp.nominal_simpanan !=0 and u.nama_user like '%$search%' order by tanggal_simpanan desc limit $posisi,$batas");
            } else {
                $sql=mysqli_query($conn, "SELECT sp.tanggal_simpanan tanggal, a.id id, a.nama_anggota nama, sp.nominal_simpanan nominal, u.nama_user user
                                        FROM sim_pokok sp 
                                        join simpanan s on sp.simpanan_id = s.id 
                                        join anggota a on a.id = s.anggota_id
                                        join user u on u.id = s.user_id
                                        where sp.nominal_simpanan !=0 order by tanggal_simpanan desc, id asc limit $posisi,$batas"
                                        );
            }
        } else {
            $sql=mysqli_query($conn, "SELECT sp.tanggal_simpanan tanggal, a.id id, a.nama_anggota nama, sp.nominal_simpanan nominal, u.nama_user user
                                        FROM sim_pokok sp 
                                        join simpanan s on sp.simpanan_id = s.id 
                                        join anggota a on a.id = s.anggota_id
                                        join user u on u.id = s.user_id
                                        where sp.nominal_simpanan !=0 order by tanggal_simpanan desc, id asc limit $posisi,$batas"
                                        );
        }

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

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <img src="img/logo.png" alt="" width="50px">
                </div>
                <div class="sidebar-brand-text mx-3 mt-2">Djoyo Makmur</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Master Data
            </div>

            <li class="nav-item">
                <a class="nav-link py-1" href="anggota.php"><i class="fas fa-users mx-1"></i> <span>Anggota</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-1" href="supplier.php"><i class="fas fa-users mx-1"></i><span class="mx-1">Supplier</span> </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-1" href="barang.php"><i class="fas fa-database mx-2"></i> <span>Barang</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-1" href="customer.php"><i class="fas fa-users mx-1"></i> <span>Customer</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider mt-2">

            <!-- Heading -->
            <div class="sidebar-heading">
                Transaksi
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed py-1" href="#" data-toggle="collapse" data-target="#collapsePages1"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-shopping-cart mx-2"></i>
                    <span>Pembelian</span>
                </a>
                <div id="collapsePages1" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item py-1" href="pengajuan_pembelian.php">Pengajuan Pembelian</a>
                        <a class="collapse-item py-1" href="persetujuan_pembelian.php">Persetujuan Pembelian</a>
                        <a class="collapse-item py-1" href="penerimaan_barang.php">Penerimaan Barang</a>
                        <a class="collapse-item py-1" href="riwayat_pembelian.php">Riwayat Pembelian</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed py-1" href="penjualan.php" data-toggle="" data-target=""
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fab fa-sellsy mx-2"></i>
                    <span>Penjualan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed py-1" href="#" data-toggle="collapse" data-target="#collapsePagesSimpanan"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-money-check mx-2"></i>
                    <span>Simpanan</span>
                </a>
                <div id="collapsePagesSimpanan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item py-1" href="pokok.php">Pokok</a>
                        <a class="collapse-item py-1" href="sukarela.php">Sukarela</a>
                        <a class="collapse-item py-1" href="tabungan.php">Rekap Tabungan</a>
                        <a class="collapse-item py-1" href="pengajuan_penarikan.php">Pengajuan Penarikan</a>
                        <a class="collapse-item py-1" href="persetujuan_penarikan.php">Persetujuan Penarikan</a>
                        <a class="collapse-item py-1" href="proses_penarikan.php">Proses Penarikan</a>
                        <a class="collapse-item py-1" href="riwayat_penarikan.php">Riwayat Penarikan</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed py-1" href="#" data-toggle="collapse" data-target="#collapsePages2"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-money-check-alt mx-2"></i>
                    <span>Pinjaman</span>
                </a>
                <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item py-1" href="pengajuan_pinjaman.php">Pengajuan Pinjaman</a>
                        <a class="collapse-item py-1" href="persetujuan_pinjaman.php">Persetujuan Pinjaman</a>
                        <a class="collapse-item py-1" href="proses_pinjaman.php">Proses Pinjaman</a>
                        <a class="collapse-item py-1" href="angsuran.php">Angsuran</a>
                        <a class="collapse-item py-1" href="riwayat_pinjaman.php">Riwayat Pinjaman</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider mt-2">

            <!-- Heading -->
            <div class="sidebar-heading">
                Laporan
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed py-1" href="kas.php" data-toggle="" data-target=""
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-money-bill mx-1"></i>
                    <span>Rekap Kas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed py-1" href="mutasi_barang.php" data-toggle="" data-target=""
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-database mx-2"></i>
                    <span> Mutasi Barang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed py-1" href="hasil_usaha.php" data-toggle="" data-target=""
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-chart-line mx-2"></i>
                    <span> Hasil Usaha</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block mt-2">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline mt-2">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow row">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mx-5">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div>
                        <h3 class="mr-6 ml-4 mt-2 hitam"><i class="fas fa-user mx-2 text-dark"></i> Simpanan Pokok</h3>
                    </div>
                    <div class="col-3"></div>
                    

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append ">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <div class="nav-item active dropdown no-arrow mt-4 mx-3 hitam">
                            <h6>
                                <?php echo hari_ini().','.' '.tgl_indo(date('Y-m-d')); ?>
                            </h6>
                        </div>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow hitam">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline hitam"><?= $username ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="global_param.php">
                                    <i class="fas fa-globe fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Global Parameter
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="ganti_password.php">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Ganti Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                        <main>
                            <div class="container-fluid px-4">
                                <div class="card mb-1">
                                    <div class="card-header biru">
                                        <div class="row">
                                            <div class="col-11 mt-1 text-light">
                                                <i class="fas fa-table me-1 text-light"></i>
                                                Data Simpanan Pokok
                                            </div>
                                            <div class="col-1">
                                                <!-- Button modal Tambah Data-->
                                                <a type="button" class="text-light float-right mx-2" data-bs-toggle="modal" data-bs-target="#addtarif">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                                <!-- Button modal Tambah Data-->
                                                <a type="button" class="text-light float-right mx-2" data-bs-toggle="modal" data-bs-target="#addCairkan">
                                                <i class="fab fa-cc-amazon-pay"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body2">
                                        <div class="row">
                                            <div class="col">
                                                <form class="d-none d-md-inline-block form-inline mt-1 pt-1 mb-2 float-right" action="" method="post">
                                                    <div class="input-group">
                                                        <input class="form-control-sm" type="text" name="search" id="search" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" autocomplete="off"/>
                                                        <div class="input-group-append ml-1">
                                                            <button class="btn btn-light btn-sm" type="submit" name="filter"><i class="fas fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table-utama tabel" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr class="text-center small">
                                                        <th>No</th>
                                                        <th>Periode</th>
                                                        <th>ID Anggota</th>
                                                        <th>Nama Anggota</th>
                                                        <th>Nominal Simpanan</th>
                                                        <th>Entry By</th>
                                                    </tr>
                                                </thead>

                                                <!-- Looping Data Tarif -->
                                                <?php foreach($sql as $pokok ) : ?>
                                                    

                                                <tbody class="small">
                                                    <tr>
                                                        <td class="text-center no "><?= $no; ?></td>
                                                        <td><?= bln_indo($pokok['tanggal']); ?></td>
                                                        <td><?= $pokok["id"]; ?></td>
                                                        <td><?= $pokok["nama"]; ?></td>
                                                        <td class="text-right">Rp <?= number_format($pokok["nominal"],2,',','.'); ?></td>
                                                        <td><?= $pokok["user"]; ?></td>
                                                    </tr>
                                                </tbody>
                                            
                                                <?php $no++ ?>
                                                <?php endforeach; ?>

                                            </table>
                                        </div>
                                        <?php 
                                            $query2     = mysqli_query($conn, "select * from sim_pokok where nominal_simpanan != 0");
                                            $jmldata    = mysqli_num_rows($query2);
                                            $jmlhalaman = ceil($jmldata/$batas);
                                        ?>
                                        <div class="text-center">
                                            <ul class="pagination mb-0">
                                                <?php
                                                for($i=1;$i<=$jmlhalaman;$i++) {
                                                    if ($i != $halaman) {
                                                        echo "<li class='page-item'><a class='page-link text-dark small' href='pokok.php?halaman=$i'>$i</a></li>";
                                                    } else {
                                                        echo "<li class='page-item active'><a class='page-link biru border border-light small' href='#'>$i</a></li>";
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                            
                                    </div>
                                </div>
                            </div>
                        </main>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="pb-2 bg-light">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Smart Work Solutions 2022</div>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

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
                    <h5 class="modal-title" id="addtarifLabel">Form Tambah Data Simpanan Pokok</h5>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data"> 
                        <div class="mb-2">
                            <label for="tanggal_simpanan" class="form-label small">Tanggal Simpanan</label>
                            <input type="date" class="form-control form-control-sm" name="tanggal_simpanan" id = "tanggal_simpanan" required maxlength="100" autocomplete="off">
                        </div>   
                        <div class="mb-2">
                            <input type="hidden" class="form-control form-control-sm" name="nominal" id = "nominal" value="AAAAA">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-success btn-sm" name ="submit-pokok">Generate Simpanan Pokok</button>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Cairkan-->
    <div class="modal fade" id="addCairkan" tabindex="-1" aria-labelledby="addtarifLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content-supplier">
                <div class="modal-header">
                    <h5 class="modal-title" id="addtarifLabel">Penarikan Saldo Simpanan Pokok</h5>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" id="formCair">
                        <input class="form-control form-control-sm" id="id2" name="id2" required readonly type="hidden">
                        <input class="form-control form-control-sm" id="anggota_id2" name="anggota_id2" required readonly type="hidden">
                        <div class="mb-2">
                            <?php $anggota = mysqli_query($conn, "select * from anggota") ?>
                            <label for="anggota" class="form-label small">Nama Anggota</label>
                            <select class="custom-select" id="anggota" name="anggota"  onchange="cek_db()" required>
                                <option selected></option>
                                <!-- Looping Data anggota -->
                                <?php foreach($anggota as $anggota ) : ?>
                                    <option value="<?= $anggota["id"]; ?>"><?= $anggota["nama_anggota"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="nominal_cair" class="form-label small">Nominal</label>
                            <input type="text" class="form-control form-control-sm" name="nominal_cair" id = "nominal_cair" autocomplete="off" readonly>
                            <input type="hidden" class="form-control form-control-sm" name="nominalnya" id = "nominalnya" autocomplete="off" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary btn-sm" name ="cairkan">Cairkan</button>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"  onclick="reset()">Kembali</button>
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

<!-- Sweetalert, Fungsi dan Validasi-->
<?php
    // Tambah Data
        if(isset($_POST["submit-pokok"])) {
            //cek apakah data berhasil ditambahkan atau tidak
            if (tambah_pokok($_POST) > 0) {
                echo "
                <script>
                    Swal.fire(
                    'Berhasil!',
                    'Data simpnan pokok sudah tersimpan',
                    'success'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'pokok.php';
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
                    'Simpanan pokok bulan ini sudah di-entry, atau simpanan pokok bulan sebelumnya belum di-entry.',
                    'error'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'pokok.php';
                        } else {
                        //if no clicked => do something else
                        }
                    })
                </script>
                ";  
            }
        }

        //fungsi tambah
        function tambah_pokok ($data) {
            global $conn;
            global $user_id;
            $tanggal_simpanan = htmlspecialchars($_POST["tanggal_simpanan"]);

            $nomial2 = 0;
            $bulan2= date('m',strtotime($tanggal_simpanan));
            $tahun= date('Y',strtotime($tanggal_simpanan));
            $tahun_sebelum = $tahun - 1;
            $bulan_sebelum = $bulan2 - 1;

            $kode = 'SM'.$tahun.$bulan2;
            $tgl = $tahun.'-'.$bulan2.'-'.'28';

            //cek cutoff
            $cek_cutoff = mysqli_query ($conn,"SELECT  tanggal_simpanan tanggal from sim_pokok where nominal_simpanan !=0 ");
            $cutoff = mysqli_fetch_array($cek_cutoff);
            $cutoff = $cutoff ["tanggal"];

            //cek tahun ini
            $cek_awal = mysqli_query ($conn,"SELECT  year(tanggal_simpanan) tanggal from sim_pokok where year(tanggal_simpanan) = '$tahun'");
            $maxAwal = mysqli_fetch_array($cek_awal);
            $maxAwal = $maxAwal ["tanggal"];

            //cek bulan januari
            $cek_januari = mysqli_query ($conn,"SELECT  count(tanggal_simpanan) tanggal from sim_pokok where year(tanggal_simpanan) = '$tahun' and month(tanggal_simpanan) = 1 and nominal_simpanan != 0 ");
            $januari = mysqli_fetch_array($cek_januari);
            $januari = $januari ["tanggal"];

            //cek akhir tahun sebelumnya
            $cek_tahun_sebelum = mysqli_query ($conn,"SELECT  count(tanggal_simpanan) tanggal from sim_pokok where year(tanggal_simpanan) = '$tahun_sebelum' and month(tanggal_simpanan) = 12");
            $cekTsebelum = mysqli_fetch_array($cek_tahun_sebelum);
            $cekTsebelum = $cekTsebelum ["tanggal"];

            // cek bulan ini
            $get_bulan = mysqli_query ($conn,"SELECT  count(tanggal_simpanan) tanggal from sim_pokok where month(tanggal_simpanan) = '$bulan2' and nominal_simpanan != 0 and year(tanggal_simpanan) = '$tahun'");
            $maxBulan = mysqli_fetch_array($get_bulan);
            $maxBulan = $maxBulan ["tanggal"];

            //cek bulan sebelumnya
            $get_bulan_sebelum = mysqli_query ($conn,"SELECT  count(tanggal_simpanan) tanggal from sim_pokok where month(tanggal_simpanan) = '$bulan_sebelum' and nominal_simpanan != 0 ");
            $maxBulanSebelum = mysqli_fetch_array($get_bulan_sebelum);
            $maxBulanSebelum = $maxBulanSebelum ["tanggal"];

            if ($maxAwal > 0 and $maxBulan > 0 // jika bulan ini sudah input
                    or $maxAwal > 0 and $maxBulanSebelum == 0 // jika bulan sebelumnya belum input
                    or $cutoff > 0 and $cekTsebelum == 0 and $maxAwal == 0 //jika awal tahun tapi desember belum input
                    or $cutoff > 0 and $bulan2 != 01 and $januari == 0 and $maxAwal == 0 //jika ganti tahun tapi januari terlewat diinput
                ) {
                return false; 
            } else  {
                $get_id1 = mysqli_query ($conn,"SELECT id from anggota where tanggal_join < '$tanggal_simpanan' and status = 'Aktif'");
                foreach ($get_id1 as $get_id) {
                    $maxIdSim = mysqli_query ($conn,"SELECT  max(id) id from simpanan ");
                    $maxIdSim = mysqli_fetch_array($maxIdSim);
                    $maxIdSim = $maxIdSim ["id"];
                    $id = $maxIdSim + 1;

                    $simpanan_pokok = mysqli_query ($conn,"SELECT  nominal from global_param where nama_param = 'Simpanan Pokok' ");
                    $simpanan_pokok = mysqli_fetch_array($simpanan_pokok);
                    $simpanan_pokok = $simpanan_pokok ["nominal"];

                    $query = 'INSERT INTO simpanan (id, kode_simpanan, anggota_id, user_id)
                                    VALUES
                                    ("'.$id.'", "'.$kode.'","'.$get_id['id'].'", "'.$user_id.'")
                                    ';
                    $query1 = 'INSERT INTO sim_pokok (tanggal_simpanan, nominal_simpanan, simpanan_id)
                            VALUES
                            ("'.$tgl.'", "'.$simpanan_pokok.'","'.$id.'")
                            ';
                    $query2 = 'INSERT INTO sim_sukarela (tanggal_simpanan, nominal_simpanan, simpanan_id)
                            VALUES
                            ("'.$tgl.'", "'.$nominal2.'","'.$id.'")
                            ';
                    $query3 = 'INSERT INTO penarikan (tanggal, nominal, simpanan_id)
                            VALUES
                            ("'.$tgl.'", "'.$nominal2.'","'.$id.'")
                            ';
                    $query4 = 'INSERT INTO saldo (tanggal, saldo, simpanan_id)
                            VALUES
                            ("'.$tgl.'", "'.$simpanan_pokok.'","'.$id.'")
                            ';

                    $get_saldo = mysqli_query ($conn,'SELECT saldo from saldo_daily where anggota_id = "'.$get_id['id'].'" and tanggal in (select max(tanggal) from saldo_daily where anggota_id = "'.$get_id['id'].'" )');
                    $saldo = mysqli_fetch_array($get_saldo);
                    $saldo_awal = $saldo ["saldo"];
                    $saldo_akhir = $saldo_awal + $simpanan_pokok;

                    $query5 = 'INSERT INTO saldo_daily (tanggal, saldo, anggota_id)
                            VALUES
                            ("'.$tgl.'", "'.$saldo_akhir.'","'.$get_id['id'].'")
                            ';

                            
                    // $hapus0 = 'DELETE from sim_pokok where tanggal_simpanan = "'.$tanggal_simpanan.'" and anggota_id = "'.$get_id['id'].'" and nominal_simpanan = "'.$nominal2.'" ';

                    mysqli_query($conn, $query);
                    mysqli_query($conn, $query1);
                    mysqli_query($conn, $query2);
                    mysqli_query($conn, $query3);
                    mysqli_query($conn, $query4);
                    mysqli_query($conn, $query5);
                    // mysqli_query($conn, $hapus0);
                }
                $get_id2 = mysqli_query ($conn,"SELECT count(id) as total_id from anggota where tanggal_join < '$tanggal_simpanan' and status = 'Aktif'");
                $jumlah_anggota = mysqli_fetch_array($get_id2);
                $anggota = $jumlah_anggota['total_id'];
                $kas_masuk = $anggota * $simpanan_pokok;
                mysqli_query($conn, "INSERT INTO kas (tanggal, kas_masuk, keterangan, kode_reff)
                                                    VALUES ('$tgl', '$kas_masuk','Simpanan Pokok','$kode')");
            }

        return mysqli_affected_rows($conn);
        }


        // Tambah Data Cair
        if(isset($_POST["cairkan"])) {
            if ($jabatan != 'ketua') {
                echo "
                <script>
                    Swal.fire(
                    'Gagal!',
                    'Anda tidak berhak melakukan Pencairan Simpanan Pokok',
                    'error'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'pokok.php';
                        } else {
                        //if no clicked => do something else
                        }
                    })
                </script>
                "; 
            } else if (cairkan($_POST) < 0) {
                    echo "
                    <script>
                        Swal.fire(
                        'Gagal!',
                        'Anggota ini masih memiliki simpanan sukarela, <br> Silahkan cairkan dulu simpanan sukarela!',
                        'error'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'pokok.php';
                            } else {
                            //if no clicked => do something else
                            }
                        })
                    </script>
                    "; 
            } else {
                //cek apakah data berhasil ditambahkan atau tidak
                if (cairkan($_POST) > 0) {
                    echo "
                    <script>
                        Swal.fire(
                        'Berhasil!',
                        'Simpanan Pokok Sudah Dicairkan',
                        'success'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'pokok.php';
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
                        'Simpanan pokok gagal dicairkan',
                        'error'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'pokok.php';
                            } else {
                            //if no clicked => do something else
                            }
                        })
                    </script>
                    ";  
                }
            }
        }

        //fungsi cairkan
        function cairkan ($data) {
            global $conn;
            global $user_id;
            $anggota = htmlspecialchars($_POST["anggota"]);
            $nominal = htmlspecialchars($_POST["nominalnya"]);
            $tanggal = date('Y-m-d');
            $hari= date('d');
            $bulan= date('m');
            $tahun= date('Y');
            $kode = 'CSP'.$tahun.$bulan.$hari;

            $nom = mysqli_query($conn,"SELECT sum(nominal_simpanan) nominal from sim_sukarela where simpanan_id in (select id from simpanan where anggota_id  = '$anggota')");
            $nom1 = mysqli_fetch_array($nom);
            $nom2 = $nom1["nominal"];
            
            $tarik = mysqli_query($conn,"SELECT sum(nominal) nominal from penarikan where simpanan_id in (select id from simpanan where anggota_id  = '$anggota')");
            $tarik1 = mysqli_fetch_array($tarik);
            $tarik2 = $tarik1["nominal"];

            $salsimsuk = $nom2 - $tarik2;

            if ($salsimsuk > 0) {
                return -1;
            } else {
                // kas berkurang
                mysqli_query($conn, "INSERT INTO kas (tanggal, kas_masuk, kas_keluar, keterangan, kode_reff)
                                    VALUES ('$tanggal', 0, '$nominal','Pencairan Simpanan Pokok $anggota','$kode')");

                // update saldo
                mysqli_query($conn,"UPDATE saldo sal join simpanan s on s.id = sal.simpanan_id and s.anggota_id = '$anggota' set saldo = 0");
                mysqli_query($conn, "DELETE FROM saldo_daily WHERE anggota_id = '$anggota'");

                // hapus simpok dan simsuk
                mysqli_query($conn,"DELETE from sim_pokok where simpanan_id in (select id from simpanan where anggota_id  = '$anggota')");
                mysqli_query($conn,"DELETE from sim_sukarela where simpanan_id in (select id from simpanan where anggota_id  = '$anggota')");
                mysqli_query($conn,"DELETE from penarikan where simpanan_id in (select id from simpanan where anggota_id  = '$anggota')");
                return true;
            }
            
            return mysqli_affected_rows($conn);
        }

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>

    
    function formReset() {
        document.getElementById("formCair").reset();
    }

    function cek_db(){
    var anggota = $("#anggota").val();
    $.ajax({
        url : 'auto_proses_tarik_simpok.php',
        data : "anggota="+anggota,
    }).success(function (data){
        var json = data,
        obj = JSON.parse(json);
        $('#nominal_cair').val(obj.nominalnya);
        $('#nominalnya').val(obj.nominal);

    })
    }

</script>

</body>

</html>