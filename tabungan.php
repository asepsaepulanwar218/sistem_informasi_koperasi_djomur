<?php

    require 'koneksi.php';

    session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
    }

    $user = $_SESSION["login"];
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
            $anggota = htmlspecialchars($_POST["anggota"]);

            if ($anggota != null) {
                $sql=mysqli_query($conn, "SELECT a.nama_anggota nama, sp.tanggal_simpanan tanggal, sp.nominal_simpanan pokok, ss.nominal_simpanan sukarela, p.nominal penarikan, sal.saldo, u.  nama_user user
                        from simpanan s 
                        join sim_pokok sp on s.id = sp.simpanan_id
                        join sim_sukarela ss on s.id = ss.simpanan_id and sp.tanggal_simpanan = ss.tanggal_simpanan
                        join penarikan p on s.id = p.simpanan_id and sp.tanggal_simpanan = p.tanggal
                        join anggota a on a.id = s.anggota_id
                        join user u on u.id = s.user_id
                        join saldo_daily sal on a.id = sal.anggota_id and sp.tanggal_simpanan = sal.tanggal
                        where a.id = '$anggota'
                        GROUP BY tanggal order by tanggal asc");

                $sum = mysqli_query($conn, "SELECT sum(sp.nominal_simpanan) pokok, sum(ss.nominal_simpanan) sukarela, max(sd.saldo) saldo, a.nama_anggota nama, sum(p.nominal) penarikan
                        from sim_pokok sp 
                        join simpanan s on s.id = sp.simpanan_id
                        left join sim_sukarela ss on sp.tanggal_simpanan = ss.tanggal_simpanan
                        left join anggota a on a.id = s.anggota_id
                        left join saldo_daily sd on a.id = sd.anggota_id
                        left join penarikan p on a.id = s.anggota_id
                        where sp.simpanan_id = ss.simpanan_id and ss.tanggal_simpanan = sp.tanggal_simpanan and sd.tanggal = sp.tanggal_simpanan and s.anggota_id = sd.anggota_id and p.tanggal = sp.tanggal_simpanan and p.simpanan_id = sp.simpanan_id and a.id ='$anggota'
                        group by a.id");

                $nama = mysqli_query($conn, "SELECT nama_anggota nama from anggota where id = '$anggota'");
                $nama = mysqli_fetch_array($nama);
                $nama = $nama['nama'];

                $simpok = mysqli_query($conn, "SELECT sum(nominal_simpanan) simpok from sim_pokok where simpanan_id in (select id from simpanan where anggota_id = '$anggota')");
                $simpok = mysqli_fetch_array($simpok);
                $simpok = $simpok['simpok'];

                $simsuk = mysqli_query($conn, "SELECT sum(nominal_simpanan) simsuk from sim_sukarela where simpanan_id in (select id from simpanan where anggota_id = '$anggota')");
                $simsuk = mysqli_fetch_array($simsuk);
                $simsuk = $simsuk['simsuk'];

                $penarikan = mysqli_query($conn, "SELECT sum(nominal) penarikan from penarikan where simpanan_id in (select id from simpanan where anggota_id = '$anggota')");
                $penarikan = mysqli_fetch_array($penarikan);
                $penarikan = $penarikan['penarikan'];

                $saldo = mysqli_query($conn, "SELECT saldo from saldo_daily where anggota_id = '$anggota' and tanggal in (select max(tanggal) from saldo_daily where anggota_id = '$anggota')");
                $saldo = mysqli_fetch_array($saldo);
                @$saldo = $saldo['saldo'];

            } else {
                $sql=mysqli_query($conn, "SELECT a.nama_anggota nama, sp.tanggal_simpanan tanggal, sp.nominal_simpanan pokok, ss.nominal_simpanan sukarela, p.nominal penarikan, sal.saldo, u.  nama_user user
                        from simpanan s 
                        join sim_pokok sp on s.id = sp.simpanan_id
                        join sim_sukarela ss on s.id = ss.simpanan_id and sp.tanggal_simpanan = ss.tanggal_simpanan
                        join penarikan p on s.id = p.simpanan_id and sp.tanggal_simpanan = p.tanggal
                        join anggota a on a.id = s.anggota_id
                        join user u on u.id = s.user_id
                        join saldo_daily sal on a.id = sal.anggota_id and sp.tanggal_simpanan = sal.tanggal
                        where a.id = '0'
                        GROUP BY tanggal order by tanggal asc");

                $sum = mysqli_query($conn, "SELECT sum(sp.nominal_simpanan) pokok, sum(ss.nominal_simpanan) sukarela, max(sd.saldo) saldo, a.nama_anggota nama, sum(p.nominal) penarikan
                        from sim_pokok sp 
                        join simpanan s on s.id = sp.simpanan_id
                        left join sim_sukarela ss on sp.tanggal_simpanan = ss.tanggal_simpanan
                        left join anggota a on a.id = s.anggota_id
                        left join saldo_daily sd on a.id = sd.anggota_id
                        left join penarikan p on a.id = s.anggota_id
                        where sp.simpanan_id = ss.simpanan_id and ss.tanggal_simpanan = sp.tanggal_simpanan and sd.tanggal = sp.tanggal_simpanan and s.anggota_id = sd.anggota_id and p.tanggal = sp.tanggal_simpanan and p.simpanan_id = sp.simpanan_id and a.id ='0'
                        group by a.id");

                $nama = '-';
                $simpok = 0;
                $simsuk = 0;
                $penarikan = 0;
                $saldo = 0;
            }
        } else {
            $sql=mysqli_query($conn, "SELECT a.nama_anggota nama, sp.tanggal_simpanan tanggal, sp.nominal_simpanan pokok, ss.nominal_simpanan sukarela, p.nominal penarikan, sal.saldo, u.  nama_user user
                    from simpanan s 
                    join sim_pokok sp on s.id = sp.simpanan_id
                    join sim_sukarela ss on s.id = ss.simpanan_id and sp.tanggal_simpanan = ss.tanggal_simpanan
                    join penarikan p on s.id = p.simpanan_id and sp.tanggal_simpanan = p.tanggal
                    join anggota a on a.id = s.anggota_id
                        join user u on u.id = s.user_id
                    join saldo_daily sal on a.id = sal.anggota_id and sp.tanggal_simpanan = sal.tanggal
                    where a.id = '0'
                    GROUP BY tanggal order by tanggal asc");

            $sum = mysqli_query($conn, "SELECT sum(sp.nominal_simpanan) pokok, sum(ss.nominal_simpanan) sukarela, max(sd.saldo) saldo, a.nama_anggota nama, sum(p.nominal) penarikan
                    from sim_pokok sp 
                    join simpanan s on s.id = sp.simpanan_id
                    left join sim_sukarela ss on sp.tanggal_simpanan = ss.tanggal_simpanan
                    left join anggota a on a.id = s.anggota_id
                    left join saldo_daily sd on a.id = sd.anggota_id
                    left join penarikan p on a.id = s.anggota_id
                    where sp.simpanan_id = ss.simpanan_id and ss.tanggal_simpanan = sp.tanggal_simpanan and sd.tanggal = sp.tanggal_simpanan and s.anggota_id = sd.anggota_id and p.tanggal = sp.tanggal_simpanan and p.simpanan_id = sp.simpanan_id and a.id = '0'
                    group by a.id");

            $nama = '-';
            $simpok = 0;
            $simsuk = 0;
            $penarikan = 0;
            $saldo = 0;
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
                        <h3 class="mr-6 ml-4 mt-2 hitam"><i class="fas fa-money-check mx-2 text-dark"></i> Rekap Tabungan</h3>
                    </div>
                    <div class="col-3"></div>
                    

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto hitam">

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
                            <div class="container-fluid px-4 hitam">
                                <div class="card mb-1">
                                    <div class="card-header biru">
                                        <div class="row">
                                            <div class="col-11 mt-1 text-light">
                                                <i class="fas fa-table me-1 text-light"></i>
                                                Data Rekap Tabungan
                                            </div>
                                            <div class="col-1">
                                                <!-- Button modal Tambah Data-->
                                                <!-- <a type="button" class="text-dark float-right" data-bs-toggle="modal" data-bs-target="#addtarif">
                                                    <i class="fas fa-plus"></i>
                                                </a> -->
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body2">
                                        <div class="row">
                                            <div class="col-7">
                                                <table class="small mb-3 hitam" id="dataTable" width ="550px" cellspacing="0">
                                                        <tr>
                                                            <th>Nama</th>
                                                            <th>: <?= $nama;?></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Simpanan Pokok</th>
                                                            <th>: Rp <?= number_format($simpok,0,',','.'); ?></th>
                                                            <th></th>
                                                            <th>Simpanan Sukarela</th>
                                                            <th>: Rp <?= number_format($simsuk,0,',','.'); ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Saldo</th>
                                                            <th>: Rp <?= number_format($saldo,0,',','.'); ?></th>
                                                            <th></th>
                                                            <th>Penarikan Saldo</th>
                                                            <th>: Rp <?= number_format($penarikan,0,',','.'); ?></th>
                                                        </tr>
                                                </table>
                                            </div>

                                            <div class="col-5 mb-2">
                                                <form action="" method="post" class="form-inline float-right">
                                                    <?php $anggota = mysqli_query($conn, "select * from anggota where status = 'Aktif'") ?>
                                                    <select class="custom-select hitam" id="anggota" name="anggota" aria-label="Small">
                                                            <option selected></option>
                                                        <!-- Looping Data  -->
                                                        <?php foreach($anggota as $anggota ) : ?>
                                                            <option value="<?= $anggota["id"]; ?>"><?= $anggota["nama_anggota"]; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                        <button type="submit" class="btn btn-primary btn-sm mx-2" name ="filter">Filter</button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive scroll">
                                            <table class="table-utama tabel" id="dataTable" width="100%" cellspacing="0" border>
                                                <thead>
                                                    <tr class="text-center small">
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Simpanan Pokok</th>
                                                        <th>Simpanan Sukarela</th>
                                                        <th>Penarikan Saldo</th>
                                                        <th>Saldo</th>
                                                        <th>Entry By</th>
                                                    </tr>
                                                </thead>

                                                <!-- Looping Data Tarif -->
                                                <?php foreach($sql as $tabungan ) : ?>
                                                    

                                                <tbody class="small">
                                                    <tr>
                                                        <td class="text-center no "><?= $no; ?></td>
                                                        <td class="text-center"><?= date('d-m-Y',strtotime($tabungan['tanggal'])) ?></td>
                                                        <td class="text-right">Rp <?= number_format($tabungan["pokok"],2,',','.'); ?></td>
                                                        <td class="text-right">Rp <?= number_format($tabungan["sukarela"],2,',','.'); ?></td>
                                                        <td class="text-right">Rp <?= number_format($tabungan["penarikan"],2,',','.'); ?></td>
                                                        <td class="text-right">Rp <?= number_format($tabungan["saldo"],2,',','.'); ?></td>
                                                        <td class="text-center"><?= $tabungan['user']; ?></td>
                                                    </tr>
                                                </tbody>
                                            
                                                <?php $no++ ?>
                                                <?php endforeach; ?>

                                            </table>
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
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-2">
                            <?php $anggota = mysqli_query($conn, "select * from anggota") ?>
                            <label for="anggota" class="form-label small">anggota</label>
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
                            <label for="tanggal_simpanan" class="form-label small">Tanggal Simpanan</label>
                            <input type="date" class="form-control form-control-sm" name="tanggal_simpanan" id = "tanggal_simpanan" required maxlength="100" autocomplete="off">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary btn-sm" name ="submit-sukarela">Simpan</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batal</button>
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
        if(isset($_POST["submit-sukarela"])) {
            //cek apakah data berhasil ditambahkan atau tidak
            if (tambah_sukarela($_POST) > 0) {
                echo "
                <script>
                    Swal.fire(
                    'Berhasil!',
                    'Data simpnan sukarela sudah tersimpan',
                    'success'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'sukarela.php';
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
                    'Data simpanan sukarela gagal disimpan',
                    'error'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'sukarela.php';
                        } else {
                        //if no clicked => do something else
                        }
                    })
                </script>
                ";  
            }
        }

        //fungsi tambah
        function tambah_sukarela ($data) {
            global $conn;
            $anggota = htmlspecialchars($_POST["anggota"]);
            $tanggal_simpanan = htmlspecialchars($_POST["tanggal_simpanan"]);
            $nominal = htmlspecialchars($_POST["nominal"]);

            $query = mysqli_query ($conn,"INSERT INTO sim_sukarela (tanggal_simpanan, nominal_simpanan, anggota_id)
                        VALUES
                        ('$tanggal_simpanan', '$nominal','$anggota')
                        ");
            $simpan_kas = mysqli_query($conn, "INSERT INTO kas (tanggal, kas_masuk, keterangan)
                                                VALUES ('$tanggal_simpanan', '$nominal','Simpanan sukarela')");
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
        </script>

</body>

</html>