<?php

    require 'koneksi.php';

    session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
    }

    $user = $_SESSION["login"];
    $jabatan = $_SESSION["jabatan"];
    $username = $_SESSION["username"];

    @$penjualan_id = $_GET["penjualan_id"];

    //ambil id paling besar
    $maxId = mysqli_query($conn, "SELECT max(id) as idTerbesar FROM penjualan");
    $data = mysqli_fetch_array($maxId);
    $idPenjualan = $data['idTerbesar'] + 1;

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

        
            $sql=mysqli_query($conn, "SELECT dj.id, dj.kode_barang, b.nama_barang, b.harga_jual, dj.kuantitas, (b.harga_jual * dj.kuantitas) total, b.stok
                                    from detail_jual dj 
                                    join barang b on b.kode_barang = dj.kode_barang
                                    where dj.penjualan_id is null order by dj.id asc limit $posisi,$batas");
            $sql2=mysqli_query($conn, "SELECT sum(b.harga_jual * dj.kuantitas) total_all, sum(b.harga_beli * dj.kuantitas) beli, sum((b.harga_jual * dj.kuantitas)-(b.harga_beli * dj.kuantitas)) laba
                                        from detail_jual dj 
                                        join barang b on b.kode_barang = dj.kode_barang
                                        where dj.penjualan_id is null order by dj.id asc limit $posisi,$batas");
                                    
            $data_sql = mysqli_fetch_array($sql2);
            @$total_all = $data_sql['total_all'];
            @$laba = $data_sql['laba'];

        

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
                        <h3 class="mr-6 ml-4 mt-2 hitam"><i class="fab fa-sellsy mx-2 text-dark"></i> Tambah Data Penjualan</h3>
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
                                                <i class="fas fa-table mx-2 text-light"></i>
                                                Tambah Data Penjualan
                                            </div>
                                            <div class="col-1">
                                                <!-- Button modal Tambah Data -->
                                                <a type="button" class="text-light float-right" href="penjualan.php">
                                                    <i class="far fa-times-circle"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body2">
                                        <div class="row">
                                            <div class="col-11">
                                                <table class="small mb-1 mt-3 hitam" id="dataTable" width ="100%" cellspacing="0">
                                                <form action="" method="post" enctype="multipart/form-data" id="formPenjualan" name="formTambahPenjualan">
                                                        <tr>
                                                            <th>
                                                                <label for="id_customer" class="form-label hitam">ID Customer</label>
                                                                <select class="custom-select hitam" name="id_customer" id="id_customer" onchange="cek_db2()" readonly>
                                                                    <option value=""> </option>
                                                                    <?php
                                                                    $dataCustomer=mysqli_query($conn,"SELECT * FROM customer order by id ");
                                                                    while ($data = mysqli_fetch_array($dataCustomer)){
                                                                        echo '<option name="id_customer" value="'.$data['id'].'" class=" hitam">'.$data['id']." - ".$data['nama_customer'].'</option>';
                                                                    }?>
                                                                </select>
                                                            </th>   
                                                            <th class="px-2"></th>
                                                            <th>
                                                                <label for="nama_customer" class="form-label hitam">Nama Customer</label>
                                                                <input type="text" class="form-control form-control-sm hitam" name="nama_customer" id = "nama_customer" required maxlength="100" autocomplete="off" readonly>
                                                            </th>
                                                            <th class="px-2"></th>
                                                            <th>
                                                                <label for="tanggal" class="form-label hitam">Tanggal</label>
                                                                <input type="date" class="form-control form-control-sm hitam" name="tanggal" id = "tanggal" required maxlength="100" autocomplete="off">
                                                            </th>   
                                                            <th class="px-2"></th>
                                                            <th>
                                                                <label for="total_bayar" class="form-label hitam">Total Bayar</label>
                                                                <input type="text" class="form-control form-control-sm hitam" name="total_bayar" id = "total_bayar" autocomplete="off" readonly value="Rp <?= number_format($total_all,2,',','.'); ?>">
                                                                <input type="hidden" class="form-control form-control-sm hitam" name="laba" id = "laba" autocomplete="off" readonly value="<?= $laba ?>">
                                                            </th>
                                                            <th class="px-2"></th>
                                                            <th>
                                                                <button type="submit" class="btn btn-outline-primary btn-sm mt-4" name ="simpan-penjualan">Simpan</button>
                                                            </th>
                                                            <th class="px-"></th>
                                                            <th>
                                                                <a type="button" class="btn btn-outline-danger btn-sm mt-4 alert_batalkan" href="batal_penjualan.php">Batalkan</a>
                                                            </th>
                                                            <th class="px-"></th>
                                                            <th>
                                                                <button type="button" class="btn btn-outline-warning btn-sm mt-4 alert_batalkan" href="reset_penjualan.php">Reset</button>
                                                            </th>
                                                        </tr>
                                                    </form>
                                                </table>
                                            </div>
                                            <div class="col">
                                                <!-- <form class="d-none d-md-inline-block form-inline mt-1 pt-1 mb-2 float-right" action="" method="post">
                                                    <div class="input-group">
                                                        <input class="form-control-sm" type="text" name="search" id="search" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" autocomplete="off"/>
                                                        <div class="input-group-append ml-1">
                                                            <button class="btn btn-light btn-sm" type="submit" name="filter"><i class="fas fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                </form> -->
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col-12">
                                                <!-- Button modal Tambah Data-->
                                                <a type="button" class="text-dark float-right mx-2" data-bs-toggle="modal" data-bs-target="#addtarif">
                                                    <i class="fas fa-plus text-dark"></i>
                                                </a>
                                            </div>
                                            <div class="table-responsive scroll">
                                                <table class="table-utama tabel" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr class="text-center small">
                                                            <th>No</th>
                                                            <th>Kode Barang</th>
                                                            <th>Nama Barang</th>
                                                            <th>Harga</th>
                                                            <th>Kuantitas</th>
                                                            <th>Jumlah</th>
                                                            <th>Aksi</th>
                                                            <!-- <th>Aksi</th> -->
                                                        </tr>
                                                    </thead>

                                                    <!-- Looping Data Tarif -->
                                                    <?php foreach($sql as $detail ) : ?>
                                                        
                                                    <tbody class="small">
                                                        <tr>
                                                            <td class="text-center no "><?= $no; ?></td>
                                                            <td><?= $detail["kode_barang"]; ?></td>
                                                            <td><?= $detail["nama_barang"]; ?></td>
                                                            <td class="text-right"><?= number_format($detail["harga_jual"],2,',','.'); ?></td>
                                                            <td class="text-center"><?= $detail["kuantitas"]; ?></td>
                                                            <td class="text-right"><?= number_format($detail["total"],2,',','.'); ?></td>
                                                            <td class="text-center">
                                                                <a type="submit" class="aksi text-dark" id="tombolUbah" data-toggle='modal' data-target="#ubahDetail" 
                                                                    data-id="<?= $detail['id']; ?>"
                                                                    data-kode_barang="<?= $detail['kode_barang']; ?>"
                                                                    data-nama_barang="<?= $detail['nama_barang']; ?>"
                                                                    data-harga_jual="<?= $detail['harga_jual']; ?>"
                                                                    data-kuantitas="<?= $detail['kuantitas']; ?>"
                                                                    data-stok="<?= $detail['stok']; ?>"
                                                                    ><i class="far fa-edit small"></i>
                                                                </a>
                                                                <a class="aksi text-dark alert_notif" href="hapus.php?detail_jual_id=<?= $detail["id"]; ?>"><i class="fas fa-solid fa-trash small"></i></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>

                                                    
                                                
                                                    <?php $no++ ?>
                                                    <?php endforeach; ?>

                                                    <tfoot>
                                                        <tr class="text-center small">
                                                            <th colspan='5' class="text-right">Total</th>
                                                            <th class="text-right">Rp <?= number_format($total_all,2,',','.'); ?></th>
                                                            <!-- <th>Aksi</th> -->
                                                        </tr>
                                                    </tfoot>

                                                </table>
                                            </div>
                                        </div>
                                        <!-- <?php 
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
                                        </div> -->
                                            
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
                        <span aria-hidden="true">??</span>
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
                    <h5 class="modal-title hitam" id="addtarifLabel">Tambah Data Penjualan</h5>
                </div>
                <div class="modal-body hitam">
                    <form action="" method="post" enctype="multipart/form-data" id="formTambah" name="formTambahData">
                        <div class="mb-2">
                            <label for="kode_barang" class="form-label small">Kode Barang</label>
                            <select class="custom-select hitam" name="kode_barang" id="kode_barang" onchange="cek_db()" readonly>
                                <option value=""> </option>
                                <?php
                                $sql=mysqli_query($conn,"SELECT * FROM barang where stok > 0 order by kode_barang DESC");
                                while ($data = mysqli_fetch_array($sql)){
                                    echo '<option name="kode_barang" value="'.$data['kode_barang'].'" class=" hitam">'.$data['kode_barang']." - ".$data['nama_barang'].'</option>';
                                }?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="nama_barang" class="form-label small">Nama Barang</label>
                            <input type="text" class="form-control form-control-sm hitam" name="nama_barang" id = "nama_barang" required maxlength="100" autocomplete="off" readonly>
                        </div>   
                        <div class="mb-2">
                            <label for="stok" class="form-label small">Stok</label>
                            <input type="number" class="form-control form-control-sm hitam" name="stok" id = "stok" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required maxlength="16" autocomplete="off" readonly>
                        </div>   
                        <div class="mb-2">
                            <label for="harga_jual" class="form-label small">Harga</label>
                            <input type="number" class="form-control form-control-sm hitam" name="harga_jual" id = "harga_jual" required maxlength="100" autocomplete="off" readonly onFocus="startCalc();" onBlur="stopCalc();">
                        </div>   
                        <div class="mb-2">
                            <label for="kuantitas" class="form-label small">Jumlah Beli</label>
                            <input type="number" class="form-control form-control-sm hitam" name="kuantitas" id = "kuantitas" required maxlength="100" autocomplete="off" onFocus="startCalc();" onBlur="stopCalc();">
                        </div>    
                        <div class="mb-2">
                            <label for="tot_harga" class="form-label small">Total Harga</label>
                            <input type="number" class="form-control form-control-sm hitam" name="tot_harga" id = "tot_harga" required maxlength="100" autocomplete="off" readonly onFocus="startCalc();" onBlur="stopCalc();">
                        </div>  
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary btn-sm" name ="tambah-barang">Tambah</button>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="reset()">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Data -->
    <div class="modal fade" id="ubahDetail" tabindex="-1" aria-labelledby="addtarifLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content-supplier">
                <div class="modal-header">
                    <h5 class="modal-title hitam" id="addtarifLabel">Ubah Data Penjualan</h5>
                </div>
                <div class="modal-body hitam">
                    <form action="" method="post" enctype="multipart/form-data" id="formTambah" name="formUbahData">
                        <input type="hidden" class="form-control form-control-sm hitam" name="id2" id = "id2" required maxlength="100" autocomplete="off" readonly>
                        <div class="mb-2">
                            <label for="kode_barang2" class="form-label small">Kode Barang</label>
                            <input type="text" class="form-control form-control-sm hitam" name="kode_barang2" id = "kode_barang2" required maxlength="100" autocomplete="off" readonly>
                        </div> 
                        <div class="mb-2">
                            <label for="nama_barang2" class="form-label small">Nama Barang</label>
                            <input type="text" class="form-control form-control-sm hitam" name="nama_barang2" id = "nama_barang2" required maxlength="100" autocomplete="off" readonly>
                        </div>   
                        <div class="mb-2">
                            <label for="stok2" class="form-label small">Stok</label>
                            <input type="number" class="form-control form-control-sm hitam" name="stok2" id = "stok2" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required maxlength="16" autocomplete="off" readonly>
                        </div>   
                        <div class="mb-2">
                            <label for="harga_jual2" class="form-label small">Harga</label>
                            <input type="number" class="form-control form-control-sm hitam" name="harga_jual2" id = "harga_jual2" required maxlength="100" autocomplete="off" readonly onFocus="startCalc2();" onBlur="stopCalc2();">
                        </div>   
                        <div class="mb-2">
                            <label for="kuantitas2" class="form-label small">Jumlah Beli</label>
                            <input type="number" class="form-control form-control-sm hitam" name="kuantitas2" id = "kuantitas2" required maxlength="100" autocomplete="off" onFocus="startCalc2();" onBlur="stopCalc2();">
                        </div>    
                        <div class="mb-2">
                            <label for="tot_harga2" class="form-label small">Total Harga</label>
                            <input type="number" class="form-control form-control-sm hitam" name="tot_harga2" id = "tot_harga2" required maxlength="100" autocomplete="off" readonly onFocus="startCalc2();" onBlur="stopCalc2();">
                        </div>  
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-success btn-sm" name ="ubah-barang">Ubah</button>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal" onclick="reset()">Batal</button>
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
     if(isset($_POST["tambah-barang"])) {
        //cek apakah data berhasil ditambahkan atau tidak
        if (tambah_barang($_POST) > 0) {
            echo "<script>document.location.href = 'tambah_penjualan.php';</script>"; 
        } else {
            echo "
            <script>
                Swal.fire(
                'Gagal!',
                'Barang ini sudah diinput Atau Stok kurang !',
                'error'
                ).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = 'tambah_penjualan.php';
                    } else {
                    //if no clicked => do something else
                    }
                })
            </script>
            ";  
        }
    }

    //fungsi tambah
    function tambah_barang ($data) {
        global $conn;
        $kode_barang = htmlspecialchars($_POST["kode_barang"]);
        $nama_barang = htmlspecialchars($_POST["nama_barang"]);
        $stok = htmlspecialchars($_POST["stok"]);
        $harga = htmlspecialchars($_POST["harga"]);
        $kuantitas = htmlspecialchars($_POST["kuantitas"]);
        $tot_harga = htmlspecialchars($_POST["tot_harga"]);

        $cekstok = mysqli_query($conn,"SELECT stok FROM barang WHERE kode_barang='$kode_barang'");
        $cekstok = mysqli_fetch_array($cekstok);
        $cekstokgak = $cekstok['stok'];

        $cekjual = mysqli_query($conn,"SELECT count(kode_barang) barang FROM detail_jual WHERE kode_barang='$kode_barang' and penjualan_id is null");
        $cekjual = mysqli_fetch_array($cekjual);
        $cekjualgak = $cekjual['barang'];

        $stokAkhir = $cekstokgak - $kuantitas;

        if ($cekstokgak < $kuantitas or $cekjualgak > 0) {
            return false;
        } else {
            $query = "INSERT INTO detail_jual (kode_barang, kuantitas)
                    VALUES
                    ('$kode_barang', '$kuantitas')
                    ";
            $query2 = "UPDATE barang set stok = '$stokAkhir' where kode_barang = '$kode_barang'";
                mysqli_query($conn, $query);
                mysqli_query($conn, $query2);
        }

        
    return mysqli_affected_rows($conn);
    }  

    

    // ubah Data
    if(isset($_POST["ubah-barang"])) {
       //cek apakah data berhasil diubahkan atau tidak
       if (ubah_barang($_POST) > 0) {
           echo "<script>
                    Swal.fire(
                        'Berhasil !',
                        'Data Berhasil Diubah',
                        'success'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'tambah_penjualan.php';
                            } 
                    });
                </script>"; 
       } else {
           echo "
           <script>
               Swal.fire(
               'Gagal!',
               '',
               'error'
               ).then(function(isConfirm) {
                   if (isConfirm) {
                       document.location.href = 'tambah_penjualan.php';
                   } else {
                   //if no clicked => do something else
                   }
               })
           </script>
           ";  
       }
   }

   //fungsi ubah
   function ubah_barang ($data) {
       global $conn;
       $id = htmlspecialchars($_POST["id2"]);
       $kode_barang = htmlspecialchars($_POST["kode_barang2"]);
       $nama_barang = htmlspecialchars($_POST["nama_barang2"]);
       $stok = htmlspecialchars($_POST["stok2"]);
       $harga = htmlspecialchars($_POST["harga2"]);
       $kuantitas = htmlspecialchars($_POST["kuantitas2"]);
       $tot_harga = htmlspecialchars($_POST["tot_harga2"]);

       $ambilDetail = mysqli_query($conn, "SELECT * from detail_jual where id = '$id'");
       $ambilDetail2 = mysqli_fetch_array($ambilDetail);
       $kobar = $ambilDetail2["kode_barang"];
       $qty = $ambilDetail2["kuantitas"];

       $ambilStok = mysqli_query($conn, "SELECT stok from barang where kode_barang = '$kobar'");
       $ambilStok2 = mysqli_fetch_array($ambilStok);
       $stok2 = $ambilStok2["stok"];

       $stokAwal = $stok2 + $qty;

       $stokAkhir = $stokAwal - $kuantitas;

       if ($stokAwal < $kuantitas) {
           return false;
       } else {
           $query = "UPDATE detail_jual set kuantitas = '$kuantitas' where id = '$id'";
           $query2 = "UPDATE barang set stok = '$stokAkhir' where kode_barang = '$kode_barang'";
               mysqli_query($conn, $query);
               mysqli_query($conn, $query2);
       }

       
   return mysqli_affected_rows($conn);
   }


   // Simpan Penjualan
   if(isset($_POST["simpan-penjualan"])) {
        //cek apakah data berhasil ditambahkan atau tidak
        if (simpan_penjualan($_POST) > 0) {
            echo "<script>
                    Swal.fire(
                        'Berhasil !',
                        'Data Penjualan Berhasil Disimpan',
                        'success'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'penjualan.php';
                            } 
                    });
                </script>"; 
        } else {
            echo "
            <script>
                Swal.fire(
                'Gagal!',
                '',
                'error'
                ).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = 'penjualan.php';
                    } else {
                    //if no clicked => do something else
                    }
                })
            </script>
            ";  
        }
    }

    //fungsi simpan penjualan
    function simpan_penjualan ($data) {
        global $conn;
        global $idPenjualan;
        global $user;
        global $total_all;
        $id_customer = htmlspecialchars($_POST["id_customer"]);
        $nama_customer = htmlspecialchars($_POST["nama_customer"]);
        $tanggal = htmlspecialchars($_POST["tanggal"]);
        $laba = htmlspecialchars($_POST["laba"]);
        $ket = 'Dibeli oleh '.$nama_customer;
        $idCus = substr($id_customer,5,3);

        $hari= date('d',strtotime($tanggal));
        $bulan= date('m',strtotime($tanggal));
        $tahun= date('Y',strtotime($tanggal));
        $kode = 'PJ'.$tahun.$bulan.$hari.'-'.$idCus;


        $query = "INSERT INTO penjualan (id, customer_id, user_id, kode_jual, tanggal, total, keterangan,laba)
                    VALUES
                    ('$idPenjualan', '$id_customer', '$user', '$kode', '$tanggal', '$total_all', '$ket','$laba')
                    ";
        $query2 = "UPDATE detail_jual set penjualan_id = '$idPenjualan' where penjualan_id is null ";
        mysqli_query($conn, $query);
        mysqli_query($conn, $query2);
        mysqli_query($conn, "INSERT INTO kas (tanggal, kas_masuk, keterangan, kode_reff)
                                                    VALUES ('$tanggal', '$total_all','Penjualan kepada $nama_customer','$kode')");
        mysqli_query($conn, "INSERT INTO hasil_usaha (tanggal, debet, kredit, keterangan, kode_reff)
                                                    VALUES ('$tanggal', '$laba', 0,'Laba Penjualan dari $nama_customer','$kode')");
        
    return mysqli_affected_rows($conn);
    }


?>
<script>
    // Hapus
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

    // Batalkan
    $('.alert_batalkan').on('click',function(){
                var getLink = $(this).attr('href');
                Swal.fire({
                    title: "Yakin !",
                    text: "Akan Membatalkan atau Reset Data Ini ?",            
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya',
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
        let kode_barang = $(this).data("kode_barang");
        let nama_barang = $(this).data("nama_barang");
        let harga_jual = $(this).data("harga_jual");
        let kuantitas = $(this).data("kuantitas");
        let stok = $(this).data("stok");

        $(".modal-body #id2").val(id);
        $(".modal-body #kode_barang2").val(kode_barang);
        $(".modal-body #nama_barang2").val(nama_barang);
        $(".modal-body #harga_jual2").val(harga_jual);
        $(".modal-body #kuantitas2").val(kuantitas);
        $(".modal-body #stok2").val(stok);
    });

    function formReset() {
        document.getElementById("formUbah").reset();
    }
</script>

<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script>
    $('.modal-dialog').draggable();
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
    function cek_db(){
    var kode_barang = $("#kode_barang").val();
    $.ajax({
        url : 'auto_proses_barang.php',
        data : "kode_barang="+kode_barang,
    }).success(function (data){
        var json = data,
        obj = JSON.parse(json);
        $('#nama_barang').val(obj.nama_barang);
        $('#stok').val(obj.stok);
        $('#harga_jual').val(obj.harga_jual);

    })
    }

    function cek_db2(){
    var customer_id = $("#id_customer").val();
    $.ajax({
        url : 'auto_proses_customer.php',
        data : "customer_id="+customer_id,
    }).success(function (data){
        var json = data,
        obj = JSON.parse(json);
        $('#nama_customer').val(obj.nama_customer);

    })
    }
</script>

<script>
    function startCalc() {
        interval = setInterval("calc()",1);
    }

    function calc() {
        one = document.formTambahData.harga_jual.value;
        two = document.formTambahData.kuantitas.value;
        document.formTambahData.tot_harga.value = (one * 1) * (two * 1);
    }

    function stopCalc() {
        clearInterval(interval);
    }


    function startCalc2() {
        interval = setInterval("calc2()",1);
    }

    function calc2() {
        one = document.formUbahData.harga_jual2.value;
        two = document.formUbahData.kuantitas2.value;
        document.formUbahData.tot_harga2.value = (one * 1) * (two * 1);
    }

    function stopCalc2() {
        clearInterval(interval);
    }

</script>
   
</body>

</html>