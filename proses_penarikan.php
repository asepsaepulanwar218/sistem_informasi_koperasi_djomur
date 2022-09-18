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
                $sql=mysqli_query($conn, "SELECT pts.*, a.nama_anggota FROM pengajuan_tarik_saldo pts join anggota a on pts.anggota_id = a.id and pts.nominal !=0 and pts.status in ('Disetujui','Diproses') where pts.anggota_id like '%$search%' or a.nama_anggota like '%$search%' or pts.tanggal like '%$search%' order by tanggal desc limit $posisi,$batas");
            } else {
                $sql=mysqli_query($conn, "SELECT pts.*, a.nama_anggota FROM pengajuan_tarik_saldo pts join anggota a on pts.anggota_id = a.id where pts.nominal !=0 and pts.status in ('Disetujui','Diproses') order by tanggal desc limit $posisi,$batas");
            }
        } else {
            $sql=mysqli_query($conn, "SELECT pts.*, a.nama_anggota FROM pengajuan_tarik_saldo pts join anggota a on pts.anggota_id = a.id where pts.nominal !=0 and pts.status in ('Disetujui','Diproses') order by tanggal desc limit $posisi,$batas");
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
                        <h3 class="mr-6 ml-4 mt-2 hitam"><i class="fas fa-money-check mx-2 text-dark"></i> Proses Penarikan Tabungan</h3>
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
                                                Proses Penarikan Tabungan
                                            </div>
                                            <!-- <div class="col-1"> -->
                                                <!-- Button modal Tambah Data-->
                                                <!-- <a type="button" class="text-dark float-right" data-bs-toggle="modal" data-bs-target="#addtarif">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </div> -->
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
                                                        <th>Tanggal</th>
                                                        <th>ID Anggota</th>
                                                        <th>Nama Anggota</th>
                                                        <th>Nominal Penarikan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>

                                                <!-- Looping Data Tarif -->
                                                <?php foreach($sql as $pokok ) : ?>
                                                    

                                                <tbody class="small">
                                                    <tr>
                                                        <td class="text-center no "><?= $no; ?></td>
                                                        <td class="text-center"><?= date('d-m-Y',strtotime($pokok['tanggal'])) ?></td>
                                                        <td><?= $pokok["anggota_id"]; ?></td>
                                                        <td><?= $pokok["nama_anggota"]; ?></td>
                                                        <td class="text-right">Rp <?= number_format($pokok["nominal"],2,',','.'); ?></td>
                                                        <td class="text-center"><?= $pokok["status"]; ?></td>
                                                        <td class="text-center">
                                                            <a type="button" class="aksi text-dark" id="tombolUbah" data-toggle='modal' data-target="#kirimPengajuan" 
                                                                data-id="<?= $pokok['id']; ?>"
                                                                data-tanggal="<?= date('d-m-Y',strtotime($pokok['tanggal'])) ?>"
                                                                data-tgl_cair="<?= date('d-m-Y',strtotime($pokok['tgl_cair'])) ?>"
                                                                data-anggota_id="<?= $pokok['anggota_id']; ?>"
                                                                data-nama_anggota="<?= $pokok['nama_anggota']; ?>"
                                                                data-nominal="Rp <?= number_format($pokok["nominal"],2,',','.'); ?>"
                                                                data-status="<?= $pokok['status']; ?>"
                                                                data-keterangan="<?= $pokok['keterangan']; ?>"
                                                                ><i class="fas fa-search-plus small"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            
                                                <?php $no++ ?>
                                                <?php endforeach; ?>

                                            </table>
                                        </div>
                                        <?php 
                                            $query2     = mysqli_query($conn, "select * from pengajuan_tarik_saldo where nominal !=0");
                                            $jmldata    = mysqli_num_rows($query2);
                                            $jmlhalaman = ceil($jmldata/$batas);
                                        ?>
                                        <div class="text-center">
                                            <ul class="pagination mb-0">
                                                <?php
                                                for($i=1;$i<=$jmlhalaman;$i++) {
                                                    if ($i != $halaman) {
                                                        echo "<li class='page-item'><a class='page-link text-dark small' href='pengajuan_penarikan.php?halaman=$i'>$i</a></li>";
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
                    <h5 class="modal-title" id="addtarifLabel">Form Tambah Data Pencairan Tabungan</h5>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-2">
                            <?php $anggota = mysqli_query($conn, "select * from anggota") ?>
                            <label for="anggota" class="form-label small">Nama Anggota</label>
                            <select class="custom-select" id="anggota" name="anggota" required>
                                <option selected></option>
                                <!-- Looping Data anggota -->
                                <?php foreach($anggota as $anggota ) : ?>
                                    <option value="<?= $anggota["id"]; ?>"><?= $anggota["nama_anggota"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>   
                        <div class="mb-2">
                            <label for="nominal" class="form-label small">Nominal</label>
                            <input type="number" class="form-control form-control-sm" name="nominal" id = "nominal" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required maxlength="16" autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label for="tanggal" class="form-label small">Tanggal Pengajuan</label>
                            <input type="date" class="form-control form-control-sm" name="tanggal" id = "tanggal" required maxlength="100" autocomplete="off">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary btn-sm" name ="submit-penarikan">Simpan</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    
    <!-- Modal Persetujuan -->
    <div class="modal fade" id="kirimPengajuan" tabindex="-1" aria-labelledby="addtarifLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content-supplier">
                <div class="modal-header">
                    <h5 class="modal-title" id="addtarifLabel">Proses Penarikan Tabungan</h5>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input class="form-control form-control-sm" id="id" name="id" required readonly type="hidden">
                        <input class="form-control form-control-sm" id="anggota_id" name="anggota_id" required readonly type="hidden">

                        <table class="mb-3 mx-5 hitam" id="dataTable" width ="450px" cellspacing="0">
                            <tr>
                                <td>ID Anggota </td>
                                <td class="px-1">: </td>
                                <td><input class="border-0 hitam" id="anggota_id" name="anggota_id" required readonly></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td class="px-1">: </td>
                                <td><input class="border-0 hitam" id="anggota" name="anggota" required readonly></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pengajuan</td>
                                <td class="px-1">: </td>
                                <td><input class="border-0 hitam" id="tanggal" name="tanggal" required readonly></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pencairan</td>
                                <td class="px-1">: </td>
                                <td><input class="border-0 hitam" id="tgl_cair" name="tgl_cair" required readonly></td>
                            </tr>
                            <tr>
                                <td>Nominal Penarikan</td>
                                <td class="px-1">: </td>
                                <td><input class="border-0 hitam" id="nominal" name="nominal" required readonly></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td class="px-1">: </td>
                                <td><input class="border-0 hitam" id="status" name="status" required readonly></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td class="px-1">: </td>
                                <td><input class="border-0 hitam" id="keterangan" name="keterangan" required readonly></td>
                            </tr>
                        </table>
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-success btn-sm" name ="proses_penarikan">Proses</button>
                            <button type="submit" class="btn btn-outline-danger btn-sm" name ="selesaikan">Selesai</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Tutup</button>
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
        if(isset($_POST["submit-penarikan"])) {
            //cek apakah data berhasil ditambahkan atau tidak
            if (tambah_penarikan($_POST) > 0) {
                echo "
                <script>
                    Swal.fire(
                    'Berhasil!',
                    'Data simpnan sukarela sudah tersimpan',
                    'success'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'pengajuan_penarikan.php';
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
                    'Data pengajuan pencairan gagal disimpan, sudah ada penarikan di tanggal ini atau simpanan sukarela kurang.',
                    'error'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'pengajuan_penarikan.php';
                        } else {
                        //if no clicked => do something else
                        }
                    })
                </script>
                ";  
            }
        }

        //fungsi tambah
        function tambah_penarikan ($data) {
            global $conn;
            global $user_id;
            $anggota = htmlspecialchars($_POST["anggota"]);
            $tanggal = htmlspecialchars($_POST["tanggal"]);
            $nominal = htmlspecialchars($_POST["nominal"]);
            
            $status = 'Disetujui';

            $bulan2= date('m',strtotime($tanggal));
            $tahun= date('Y',strtotime($tanggal));

            $kode = 'TR'.$tahun.$bulan2;

            // //cek saldo
            // $cek_saldo = mysqli_query ($conn,"SELECT sum(nominal_simpanan) nominal from sim_sukarela where anggota_id = '$anggota'");
            // $saldo = mysqli_fetch_array($cek_saldo);
            // $saldo = $saldo ["nominal"];
            
            // $cek_penarikan = mysqli_query ($conn,"SELECT sum(nominal) nominal from penarikan where anggota_id = '$anggota'");
            // $penarikan = mysqli_fetch_array($cek_penarikan);
            // $penarikan = $penarikan ["nominal"];

            // $saldo_sekarang = $saldo - $penarikan;
            
            $cek_tanggal = mysqli_query ($conn,"SELECT count(tanggal) tanggal from penarikan where simpanan_id in (select id from simpanan where anggota_id = '$anggota_id') and tanggal = '$tanggal'");
            $tanggal1 = mysqli_fetch_array($cek_tanggal);
            $tanggal1 = $tanggal1 ["tanggal"];

            $cek_penarikan = mysqli_query ($conn,"SELECT count(tanggal) tanggal from penarikan where simpanan_id in (select id from simpanan where anggota_id = '$anggota_id') and tanggal = '$tanggal' and nominal = 0");
            $penarikan = mysqli_fetch_array($cek_penarikan);
            $penarikan = $penarikan ["tanggal"];

            $cek_tanggal2 = mysqli_query ($conn,"SELECT count(tanggal) tanggal2 from saldo_daily where anggota_id = '$anggota' and tanggal = '$tanggal'");
            $tanggal2 = mysqli_fetch_array($cek_tanggal2);
            $tanggal2 = $tanggal2 ["tanggal2"];

            // $cek_tanggal3 = mysqli_query ($conn,"SELECT count(tanggal) tanggal3 from kas where keterangan = 'Simpanan Sukarela' and tanggal = '$tanggal'");
            // $tanggal3 = mysqli_fetch_array($cek_tanggal3);
            // $tanggal3 = $tanggal3 ["tanggal3"];

            $get_saldo = mysqli_query ($conn,"SELECT saldo from saldo_daily where anggota_id = '$anggota' and tanggal = '$tanggal'");
            $saldo = mysqli_fetch_array($get_saldo);
            $saldo_awal = $saldo ["saldo"];
            $saldo_akhir = $saldo_awal + $nominal;

            // $get_kas = mysqli_query ($conn,"SELECT kas_keluar from kas where keterangan = 'Simpanan Sukarela' and tanggal = '$tanggal'");
            // $kas = mysqli_fetch_array($get_kas);
            // $kas_awal = $kas ["kas_masuk"];
            // $kas_akhir = $kas_awal + $nominal;

            // if ($saldo_sekarang < $nominal) { // jika saldo sukarela kurang
            //     return false;
            // }

            //mengisi tabel penarikan
            if ($tanggal1 == 0) { //jika tanggal belum ada
                $maxIdSim = mysqli_query ($conn,"SELECT  max(id) id from simpanan ");
                $maxIdSim = mysqli_fetch_array($maxIdSim);
                $maxIdSim = $maxIdSim ["id"];
                $id = $maxIdSim + 1;

                $query0 = mysqli_query ($conn,'INSERT INTO simpanan (id, kode_simpanan, anggota_id, user_id)
                                VALUES
                                ("'.$id.'", "'.$kode.'","'.$anggota.'", "'.$user_id.'")
                                ');
                $query = mysqli_query ($conn,"INSERT INTO penarikan (tanggal, nominal, simpanan_id)
                        VALUES
                        ('$tanggal', '$nominal','$id')
                        ");
                $simpok = mysqli_query ($conn,"INSERT INTO sim_pokok (tanggal_simpanan, nominal_simpanan, simpanan_id)
                        VALUES
                        ('$tanggal', 0,'$id')
                        ");
                $simsuk = mysqli_query ($conn,"INSERT INTO sim_sukarela (tanggal_simpanan, nominal_simpanan, simpanan_id)
                        VALUES
                        ('$tanggal', 0,'$id')
                        ");

                //update status
                $query = mysqli_query ($conn,"UPDATE pengajuan_tarik_saldo set status = '$status' where id = '$id'");

                //menisi tabel kas
                    $simpan_kas = mysqli_query($conn, "INSERT INTO kas (tanggal, kas_keluar, keterangan, kode_reff)
                                                    VALUES ('$tanggal', '$nominal','Penarikan Simpanan Sukarela','$kode')");

                //update saldo
                if ($tanggal2 == 0) {
                    $get_saldo2 = mysqli_query ($conn,"SELECT saldo from saldo_daily where anggota_id = '$anggota' and tanggal in (select max(tanggal) from saldo_daily where anggota_id ='$anggota' and tanggal < '$tanggal' or  anggota_id ='$anggota' and tanggal = '$tanggal')");
                    $saldo2 = mysqli_fetch_array($get_saldo2);
                    $saldo_awal2 = $saldo2 ["saldo"];
                    $saldo_akhir2 = $saldo_awal2 - $nominal;

                    $query2 = mysqli_query ($conn,"INSERT INTO saldo_daily (tanggal, saldo, anggota_id)
                            VALUES
                            ('$tanggal', '$saldo_akhir2','$anggota')
                            ");

                    $get_id = mysqli_query($conn,"SELECT id from saldo_daily where anggota_id = '$anggota' and tanggal > '$tanggal'");
                    foreach ($get_id as $get_id) {
                        $get_saldo3 = mysqli_query ($conn,'SELECT saldo from saldo_daily where id = "'.$get_id["id"].'" and tanggal > "$tanggal" ');
                        $saldo3 = mysqli_fetch_array($get_saldo3);
                        $saldo_awal3 = $saldo3 ["saldo"];
                        $saldo_akhir3 = $saldo_awal3 - $nominal;
                        
                        $update = mysqli_query ($conn,'UPDATE saldo_daily set saldo = "'.$saldo_akhir3.'" where id = "'.$get_id["id"].'"');
                    }

                } else {
                    $get_id = mysqli_query($conn,"SELECT id from saldo_daily where anggota_id = '$anggota' and tanggal >= '$tanggal'");
                    foreach ($get_id as $get_id) {
                        $get_saldo3 = mysqli_query ($conn,'SELECT saldo from saldo_daily where id = "'.$get_id["id"].'" and tanggal > "$tanggal" ');
                        $saldo3 = mysqli_fetch_array($get_saldo3);
                        $saldo_awal3 = $saldo3 ["saldo"];
                        $saldo_akhir3 = $saldo_awal3 - $nominal;
                        
                        $update = mysqli_query ($conn,'UPDATE saldo_daily set saldo = "'.$saldo_akhir3.'" where id = "'.$get_id["id"].'"');
                    }
                }

                return true;

            } else if ($penarikan > 1 ) { //jika penarikan tgl 28
                return true;

            } else {
                return false;
            }
        return mysqli_affected_rows($conn);
        }


    // Kirim Persetujuan
    if(isset($_POST["proses_penarikan"])) {
        //cek apakah data berhasil ditambahkan atau tidak
        if (proses($_POST) > 0) {
            echo "
            <script>
                Swal.fire(
                'Berhasil!',
                'Pengajuan Tarik Saldo sukarela sudah terkirim',
                'success'
                ).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = 'proses_penarikan.php';
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
                'Data pengajuan pencairan gagal disimpan, sudah ada penarikan di tanggal ini atau simpanan sukarela kurang.',
                'error'
                ).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = 'proses_penarikan.php';
                    } else {
                    //if no clicked => do something else
                    }
                })
            </script>
            ";  
        }
    }

    //fungsi kirim Persetujuan
    function proses($data) {
            global $conn;
            global $user_id;
            $id = htmlspecialchars($_POST["id"]);
            $anggota_id = htmlspecialchars($_POST["anggota_id"]);
            $anggota = htmlspecialchars($_POST["anggota"]);
            $tanggal = htmlspecialchars($_POST["tanggal"]);
            $nominal = htmlspecialchars($_POST["nominal"]);
            $catatan = htmlspecialchars($_POST["catatan"]);
            $proses = 'Diproses';

            $bulan2= date('m',strtotime($tanggal));
            $tahun= date('Y',strtotime($tanggal));

            $kode = 'TR'.$tahun.$bulan2;

            // //cek saldo
            // $cek_saldo = mysqli_query ($conn,"SELECT sum(nominal_simpanan) nominal from sim_sukarela where anggota_id = '$anggota'");
            // $saldo = mysqli_fetch_array($cek_saldo);
            // $saldo = $saldo ["nominal"];
            
            // $cek_penarikan = mysqli_query ($conn,"SELECT sum(nominal) nominal from penarikan where anggota_id = '$anggota'");
            // $penarikan = mysqli_fetch_array($cek_penarikan);
            // $penarikan = $penarikan ["nominal"];

            // $saldo_sekarang = $saldo - $penarikan;
            
            $cek_tanggal = mysqli_query ($conn,"SELECT count(tanggal) tanggal from penarikan where simpanan_id in (select id from simpanan where anggota_id = '$anggota_id') and tanggal = '$tanggal'");
            $tanggal1 = mysqli_fetch_array($cek_tanggal);
            $tanggal1 = $tanggal1 ["tanggal"];

            $cek_penarikan = mysqli_query ($conn,"SELECT count(tanggal) tanggal from penarikan where simpanan_id in (select id from simpanan where anggota_id = '$anggota_id') and tanggal = '$tanggal' and nominal = 0");
            $penarikan = mysqli_fetch_array($cek_penarikan);
            $penarikan = $penarikan ["tanggal"];

            $cek_tanggal2 = mysqli_query ($conn,"SELECT count(tanggal) tanggal2 from saldo_daily where anggota_id = '$anggota_id' and tanggal = '$tanggal'");
            $tanggal2 = mysqli_fetch_array($cek_tanggal2);
            $tanggal2 = $tanggal2 ["tanggal2"];

            // $cek_tanggal3 = mysqli_query ($conn,"SELECT count(tanggal) tanggal3 from kas where keterangan = 'Simpanan Sukarela' and tanggal = '$tanggal'");
            // $tanggal3 = mysqli_fetch_array($cek_tanggal3);
            // $tanggal3 = $tanggal3 ["tanggal3"];

            $get_saldo = mysqli_query ($conn,"SELECT saldo from saldo_daily where anggota_id = '$anggota_id' and tanggal = '$tanggal'");
            $saldo = mysqli_fetch_array($get_saldo);
            $saldo_awal = $saldo ["saldo"];
            $saldo_akhir = $saldo_awal + $nominal;

            // $get_kas = mysqli_query ($conn,"SELECT kas_keluar from kas where keterangan = 'Simpanan Sukarela' and tanggal = '$tanggal'");
            // $kas = mysqli_fetch_array($get_kas);
            // $kas_awal = $kas ["kas_masuk"];
            // $kas_akhir = $kas_awal + $nominal;

            // if ($saldo_sekarang < $nominal) { // jika saldo sukarela kurang
            //     return false;
            // }

            //mengisi tabel penarikan
            // if ($penarikan == 0) { //jika tanggal belum ada
                $maxIdSim = mysqli_query ($conn,"SELECT  max(id) id from simpanan ");
                $maxIdSim = mysqli_fetch_array($maxIdSim);
                $maxIdSim = $maxIdSim ["id"];
                $idSimpan = $maxIdSim + 1;

                // $query0 = mysqli_query ($conn,"INSERT INTO simpanan (id, kode_simpanan, anggota_id, user_id)
                //                 VALUES
                //                 ('$idSimpan', '$kode','$anggota_id', '$user_id')
                //                 ");
                // $query = mysqli_query ($conn,"INSERT INTO penarikan (tanggal, nominal, simpanan_id)
                //         VALUES
                //         ('$tanggal', '$nominal','$idSimpan')
                //         ");
                // $simpok = mysqli_query ($conn,"INSERT INTO sim_pokok (tanggal_simpanan, nominal_simpanan, simpanan_id)
                //         VALUES
                //         ('$tanggal', 0,'$idSimpan')
                //         ");
                // $simsuk = mysqli_query ($conn,"INSERT INTO sim_sukarela (tanggal_simpanan, nominal_simpanan, simpanan_id)
                //         VALUES
                //         ('$tanggal', 0,'$idSimpan')
                //         ");
                // $sal = mysqli_query ($conn,"INSERT INTO saldo (tanggal, saldo, simpanan_id)
                //         VALUES
                //         ('$tanggal', '$nominal','$idSimpan')
                //         ");

                //update status
                $updateStatus = mysqli_query ($conn,"UPDATE pengajuan_tarik_saldo set status = '$proses' where id = '$id'");

                //menisi tabel kas
                    // $simpan_kas = mysqli_query($conn, "INSERT INTO kas (tanggal, kas_keluar, keterangan, kode_reff)
                    //                                 VALUES ('$tanggal', '$nominal','Penarikan Sim_Sukarela','$kode')");

                //update saldo
                // if ($tanggal2 == 0) {
                //     $get_saldo2 = mysqli_query ($conn,"SELECT saldo from saldo_daily where anggota_id = '$anggota_id' and tanggal in (select max(tanggal) from saldo_daily where anggota_id ='$anggota_id' and tanggal < '$tanggal' or  anggota_id ='$anggota_id' and tanggal = '$tanggal')");
                //     $saldo2 = mysqli_fetch_array($get_saldo2);
                //     $saldo_awal2 = $saldo2 ["saldo"];
                //     $saldo_akhir2 = $saldo_awal2 - $nominal;

                //     $query2 = mysqli_query ($conn,"INSERT INTO saldo_daily (tanggal, saldo, anggota_id)
                //             VALUES
                //             ('$tanggal', '$saldo_akhir2','$anggota_id')
                //             ");

                //     $get_id = mysqli_query($conn,"SELECT id from saldo_daily where anggota_id = '$anggota_id' and tanggal > '$tanggal'");
                //     foreach ($get_id as $get_id) {
                //         $get_saldo3 = mysqli_query ($conn,'SELECT saldo from saldo_daily where id = "'.$get_id["id"].'" and tanggal > "$tanggal" ');
                //         $saldo3 = mysqli_fetch_array($get_saldo3);
                //         $saldo_awal3 = $saldo3 ["saldo"];
                //         $saldo_akhir3 = $saldo_awal3 - $nominal;
                        
                //         $update = mysqli_query ($conn,'UPDATE saldo_daily set saldo = "'.$saldo_akhir3.'" where id = "'.$get_id["id"].'"');
                //     }
                //     return true;

                // } else {
                //     $get_id = mysqli_query($conn,"SELECT id from saldo_daily where anggota_id = '$anggota_id' and tanggal >= '$tanggal'");
                //     foreach ($get_id as $get_id) {
                //         $get_saldo3 = mysqli_query ($conn,'SELECT saldo from saldo_daily where id = "'.$get_id["id"].'" and tanggal > "$tanggal" ');
                //         $saldo3 = mysqli_fetch_array($get_saldo3);
                //         $saldo_awal3 = $saldo3 ["saldo"];
                //         $saldo_akhir3 = $saldo_awal3 - $nominal;
                        
                //         $update = mysqli_query ($conn,'UPDATE saldo_daily set saldo = "'.$saldo_akhir3.'" where id = "'.$get_id["id"].'"');
                //     }
                    
                //     return true;
                // }

                // return true;

            // } else {
                // return false;
            // }
        
        return mysqli_affected_rows($conn);
    }


    // Selesai
    if(isset($_POST["selesaikan"])) {
        //cek apakah data berhasil ditambahkan atau tidak
        if (selesaikan($_POST) > 0) {
            echo "
            <script>
                Swal.fire(
                'Berhasil!',
                'Transaksi Penarikan Selesai',
                'success'
                ).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = 'proses_penarikan.php';
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
                'Data pengajuan pencairan gagal ditolak.',
                'error'
                ).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = 'proses_penarikan.php';
                    } else {
                    //if no clicked => do something else
                    }
                })
            </script>
            ";  
        }
    }

    function selesaikan($data) {
        global $conn;
        $id = htmlspecialchars($_POST['id']);
        $catatan = htmlspecialchars($_POST["catatan"]);
        $status = 'Selesai';

        mysqli_query($conn,"UPDATE pengajuan_tarik_saldo set status = '$status' where id = '$id'");

        return mysqli_affected_rows($conn);
    }


?>
<script>
    // Kirim Pengajuan Data
    $(document).on("click", "#tombolUbah", function() {
        let id = $(this).data("id");
        let anggota_id = $(this).data("anggota_id");
        let nama_anggota = $(this).data("nama_anggota");
        let tanggal = $(this).data("tanggal");
        let nominal = $(this).data("nominal");
        let status = $(this).data("status");
        let tgl_cair = $(this).data("tgl_cair");
        let keterangan = $(this).data("keterangan");

        $(".modal-body #id").val(id);
        $(".modal-body #anggota_id").val(anggota_id);
        $(".modal-body #anggota").val(nama_anggota);
        $(".modal-body #nominal").val(nominal);
        $(".modal-body #tanggal").val(tanggal);
        $(".modal-body #status").val(status);
        $(".modal-body #tgl_cair").val(tgl_cair);
        $(".modal-body #keterangan").val(keterangan);
    });

    function formReset() {
        document.getElementById("formUbah").reset();
    }
</script>
   
</body>

</html>