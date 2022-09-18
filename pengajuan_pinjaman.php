<?php

    require 'koneksi.php';

    session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
    }

    $user_id = $_SESSION["login"];
    $jabatan = $_SESSION["jabatan"];
    $username = $_SESSION["username"];

    $namaUser = mysqli_query($conn, "SELECT * from user where id = '$user_id'");
    $user = mysqli_fetch_array($namaUser);
    $user = $user["nama_user"];

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
                $sql=mysqli_query($conn, "SELECT p.*, a.nama_anggota, u.nama_user FROM pinjaman p join anggota a on p.anggota_id = a.id join user u on u.id = p.user_id and p.nominal !=0 and p.status = 'Draft' where p.anggota_id like '%$search%' or a.nama_anggota like '%$search%' or p.tanggal_pengajuan like '%$search%' order by tanggal_pengajuan desc limit $posisi,$batas");
            } else {
                $sql=mysqli_query($conn, "SELECT p.*, a.nama_anggota, u.nama_user FROM pinjaman p join anggota a on p.anggota_id = a.id join user u on u.id = p.user_id where p.nominal !=0 and p.status = 'Draft' order by tanggal_pengajuan desc limit $posisi,$batas");
            }
        } else {
            $sql=mysqli_query($conn, "SELECT p.*, a.nama_anggota, u.nama_user FROM pinjaman p join anggota a on p.anggota_id = a.id join user u on u.id = p.user_id where p.nominal !=0 and p.status = 'Draft' order by tanggal_pengajuan desc limit $posisi,$batas");
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
                        <h3 class="mr-6 ml-4 mt-2 hitam"><i class="fas fa-money-check-alt mx-2 text-dark"></i> Pengajuan Pinjaman</h3>
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
                                                Pengajuan Pinjaman
                                            </div>
                                            <div class="col-1">
                                                <!-- Button modal Tambah Data-->
                                                <a type="button" class=" text-light float-right" data-bs-toggle="modal" data-bs-target="#addtarif">
                                                    <i class="fas fa-plus"></i>
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
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>ID Anggota</th>
                                                        <th>Nama Anggota</th>
                                                        <th>Kode Pinjaman</th>
                                                        <th>Nominal Pinjaman</th>
                                                        <th>Tenor</th>
                                                        <th>Entry By</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>

                                                <!-- Looping Data Tarif -->
                                                <?php foreach($sql as $pinjam ) : ?>
                                                    

                                                <tbody class="small">
                                                    <tr>
                                                        <td class="text-center no "><?= $no; ?></td>
                                                        <td class="text-center"><?= date('d-m-Y',strtotime($pinjam['tanggal_pengajuan'])) ?></td>
                                                        <td><?= $pinjam["anggota_id"]; ?></td>
                                                        <td><?= $pinjam["nama_anggota"]; ?></td>
                                                        <td><?= $pinjam["kode_pinjam"]; ?></td>
                                                        <td class="text-right">Rp <?= number_format($pinjam["nominal"],2,',','.'); ?></td>
                                                        <td class="text-center"><?= $pinjam["tenor"]; ?></td>
                                                        <td class="text-center"><?= $pinjam["nama_user"]; ?></td>
                                                        <td class="text-center"><?= $pinjam["status"]; ?></td>
                                                        <td class="text-center">
                                                            <a type="button" class="aksi text-dark" id="tombolUbah" data-toggle='modal' data-target="#edit_pengajuan" 
                                                                data-id="<?= $pinjam['id']; ?>"
                                                                data-tanggal="<?= $pinjam['tanggal_pengajuan']; ?>"
                                                                data-anggota_id="<?= $pinjam['anggota_id']; ?>"
                                                                data-nama_anggota="<?= $pinjam['nama_anggota']; ?>"
                                                                data-nominal="<?= $pinjam['nominal']; ?>"
                                                                data-status="<?= $pinjam['status']; ?>"
                                                                data-tenor="<?= $pinjam['tenor']; ?>"
                                                                data-kopin="<?= $pinjam['kode_pinjam']; ?>"
                                                                ><i class="fas fa-solid fa-pen small"></i>
                                                            </a>
                                                            <a class="aksi text-dark alert_notif" href="hapus.php?id_pinjaman=<?= $pinjam["id"]; ?>"><i class="fas fa-solid fa-trash small"></i></a>
                                                            <a type="button" class="aksi text-dark" id="tombolUbah" data-toggle='modal' data-target="#kirimPengajuan" 
                                                                data-id="<?= $pinjam['id']; ?>"
                                                                data-tanggal="<?= tgl_indo($pinjam['tanggal_pengajuan']) ?>"
                                                                data-anggota_id="<?= $pinjam['anggota_id']; ?>"
                                                                data-nama_anggota="<?= $pinjam['nama_anggota']; ?>"
                                                                data-nominal="Rp <?= number_format($pinjam["nominal"],2,',','.'); ?>"
                                                                data-status="<?= $pinjam['status']; ?>"
                                                                data-tenor="<?= $pinjam['tenor'].' '.'Bulan'; ?>"
                                                                data-kopin="<?= $pinjam['kode_pinjam']; ?>"
                                                                ><i class="fas fa-solid fa-paper-plane small"></i>
                                                            </a>
                                                            <a class="aksi text-dark " href="preview.php?file=<?= $pinjam["dokumen"]; ?>"><i class="fas fa-file-pdf"></i></a>
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
                    <h5 class="modal-title" id="addtarifLabel">Form Tambah Data Pinjaman</h5>
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
                            <label for="tanggal" class="form-label small">Tanggal Pengajuan</label>
                            <input type="date" class="form-control form-control-sm" name="tanggal" id = "tanggal" required maxlength="100" autocomplete="off">
                        </div> 
                        <div class="mb-2">
                            <label for="nominal" class="form-label small">Nominal Pinjaman</label>
                            <input type="number" class="form-control form-control-sm" name="nominal" id = "nominal" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required maxlength="16" autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label for="tenor" class="form-label small">Tenor (Bulan)</label>
                            <input type="number" class="form-control form-control-sm" name="tenor" id = "tenor" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required maxlength="16" autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label for="dokumen" class="form-label small">Dokumen Perjanjian Pinjaman</label>
                            <input type="file" class="form-control form-control-sm" name="dokumen" id = "dokumen" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required maxlength="16" autocomplete="off">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary btn-sm" name ="submit-pengajuan">Simpan</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    
    <!-- Modal Kirim Pengajuan -->
    <div class="modal fade" id="kirimPengajuan" tabindex="-1" aria-labelledby="addtarifLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content-supplier">
                <div class="modal-header">
                    <h5 class="modal-title" id="addtarifLabel">Kirim Data Pengajuan Pinjaman</h5>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" id="formUbah">
                        <input type="hidden" class="border-0 hitam" id="id2" name="id2" required readonly>
                        <table class="mb-3 mx-5 hitam" id="dataTable" width ="450px" cellspacing="0">
                                <td>Kode Pinjaman</td>
                                <td class="px-1">: </td>
                                <td><input class="border-0 hitam" id="kode" name="kode" required readonly></td>
                            </tr>
                            <tr>
                                <td>ID Anggota </td>
                                <td class="px-1">: </td>
                                <td><input class="border-0 hitam" id="anggota_id2" name="anggota_id2" required readonly></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td class="px-1">: </td>
                                <td><input class="border-0 hitam" id="anggota2" name="anggota2" required readonly></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pengajuan</td>
                                <td class="px-1">: </td>
                                <td><input class="border-0 hitam" id="tanggal2" name="tanggal2" required readonly></td>
                            </tr>
                            <tr>
                                <td>Nominal</td>
                                <td class="px-1">: </td>
                                <td><input class="border-0 hitam" id="nominal2" name="nominal2" required readonly></td>
                            <tr>
                                <td>Tenor</td>
                                <td class="px-1">: </td>
                                <td><input class="border-0 hitam" id="tenor2" name="tenor2" required readonly></td>
                            </tr>
                        </table>
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" name ="kirim_pengajuan">Kirim</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="formUbah">Kembali</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    
    <!-- Modal Edit -->
    <div class="modal fade" id="edit_pengajuan" tabindex="-1" aria-labelledby="addtarifLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content-supplier">
                <div class="modal-header">
                    <h5 class="modal-title" id="addtarifLabel">Edit Data Pinjaman</h5>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" id="formUbah">
                        <input class="form-control form-control-sm" id="id2" name="id2" required readonly type="hidden">
                        <input class="form-control form-control-sm" id="anggota_id2" name="anggota_id2" required readonly type="hidden">
                        <div class="mb-2">
                            <label for="anggota" class="form-label small">Nama Anggota</label>
                            <input class="form-control form-control-sm" id="anggota2" name="anggota2" required readonly>
                        </div>   
                        <div class="mb-2">
                            <label for="tanggal" class="form-label small">Tanggal Pengajuan</label>
                            <input type="date" class="form-control form-control-sm" name="tanggal2" id = "tanggal2" required maxlength="100" autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label for="nominal" class="form-label small">Nominal</label>
                            <input type="number" class="form-control form-control-sm" name="nominal2" id = "nominal2" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required maxlength="16" autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label for="tenor" class="form-label small">Tenor</label>
                            <input type="number" class="form-control form-control-sm" name="tenor2" id = "tenor2" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required maxlength="16" autocomplete="off">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success btn-sm" name ="edit_pengajuan">Ubah</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="formUbah">Kembali</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview -->
    <div class="modal fade" id="lihatDokumen" tabindex="-1" aria-labelledby="addtarifLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content-supplier">
                <div class="modal-header">
                    <h5 class="modal-title" id="addtarifLabel">Dokumen Pengajuan</h5><br><br>
                    <embed type="application/pdf" src="assets/doc/6325d36d658e7.pdf" width="600" height="400"></embed>
                </div>
                <div class="modal-body">
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
        if(isset($_POST["submit-pengajuan"])) {

            //cek apakah data berhasil ditambahkan atau tidak
            if (tambah_pengajuan($_POST) > 0) {
                echo "
                <script>
                    Swal.fire(
                    'Berhasil!',
                    'Data pengajuan pinjaman sudah tersimpan',
                    'success'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'pengajuan_pinjaman.php';
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
                    'Anggota ini masih memiliki Pinjaman atau Sedang mengajukan pinjaman.',
                    'error'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'pengajuan_pinjaman.php';
                        } else {
                        //if no clicked => do something else
                        }
                    })
                </script>
                ";  
            }
        }

        //fungsi tambah
        function tambah_pengajuan ($data) {
            global $conn;
            global $user_id;
            $anggota = htmlspecialchars($_POST["anggota"]);
            $tanggal = htmlspecialchars($_POST["tanggal"]);
            $nominal = htmlspecialchars($_POST["nominal"]);
            $tenor = htmlspecialchars($_POST["tenor"]);
            $status = 'Draft';
            $urut = substr($anggota,5,3);

            $bulan2= date('m',strtotime($tanggal));
            $tahun= date('Y',strtotime($tanggal));

            $kode = 'PN'.$tahun.$bulan2.'-'.$urut;

            $tgl = $tahun.'-'.$bulan2.'-'.'28';

            //cek pinjaman
            $cek_pinjaman = mysqli_query ($conn,"SELECT count(id) id from pinjaman where anggota_id = '$anggota' and status in ('Pengajuan','Progres','Disetujui','Draft')");
            $pinjaman = mysqli_fetch_array($cek_pinjaman);
            $pinjaman = $pinjaman ["id"];

            $dokumen = upload();
            if(!$dokumen) {
                return false;
            }
            
            

            if ($pinjaman > 0) { // jika masih mempunyai angsuran
                return false;
            } else {
                mysqli_query($conn,"INSERT INTO pinjaman
                                (tanggal_pengajuan, nominal, tenor, status, user_id, anggota_id, kode_pinjam,nominal_bayar,dokumen)
                                VALUES
                                ('$tanggal','$nominal','$tenor','$status','$user_id','$anggota','$kode',0, '$dokumen')
                ");
            }

        return mysqli_affected_rows($conn);
        }

    //fungsi upload
    function upload () {
        $namaFile = $_FILES['dokumen']['name'];
        $ukuranFile = $_FILES['dokumen']['size'];
        $error = $_FILES['dokumen']['error'];
        $tmpName = $_FILES['dokumen']['tmp_name'];

        //cek apakah tidak ada dokumen yg diupload
        if($error ===4) {
            echo "<script>
                    alert('Upload dokumen terlebih dahulu');
                </script>";
            return false;
        }

        //cek apakah yg di upload adalah dokumen
        $ekstensiDokumenValid = ['jpg', 'jpeg', 'png','pdf'];
        $ekstensiDokumen = explode('.', $namaFile);
        $ekstensiDokumen = strtolower(end($ekstensiDokumen));
        if(!in_array($ekstensiDokumen, $ekstensiDokumenValid)) {
            echo "<script>
                    alert('Yang Anda Upload bukan dokumen');
                </script>";
            return false;
        }

        //cek ukuran file
        if($ukuranFile > 1000000) {
            echo "<script>
                    alert('Ukuran dokumen terlalu besar, dokumen tidak boleh lebih dari 1 MB');
                </script>";
            return false;
        }

        //lolos pengecekan dokumen siap diupload
        //generate nama dokumen
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiDokumen;

        move_uploaded_file($tmpName, 'assets/doc/'.$namaFileBaru);

        return $namaFileBaru;

    }


    // Kirim Data
    if(isset($_POST["kirim_pengajuan"])) {
        //cek apakah data berhasil ditambahkan atau tidak
        if (kirim_pengajuan($_POST) > 0) {
            echo "
            <script>
                Swal.fire(
                'Berhasil!',
                'Pengajuan pinjaman sudah terkirim',
                'success'
                ).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = 'pengajuan_pinjaman.php';
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
                'Data pengajuan pinjaman gagal dikirim.',
                'error'
                ).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = 'pengajuan_pinjaman.php';
                    } else {
                    //if no clicked => do something else
                    }
                })
            </script>
            ";  
        }
    }

    //fungsi kirim
    function kirim_pengajuan ($data) {
        global $conn;
        $id = htmlspecialchars($_POST["id2"]);
        $status = 'Pengajuan';

        //update status
        mysqli_query ($conn,"UPDATE pinjaman set status = '$status' where id = '$id'");

    return mysqli_affected_rows($conn);
    }

    // Edit Data
    if(isset($_POST["edit_pengajuan"])) {
        //cek apakah data berhasil ditambahkan atau tidak
        if (edit_pengajuan($_POST) > 0) {
            echo "
            <script>
                Swal.fire(
                'Berhasil!',
                'Pengajuan Tarik Saldo sukarela berhasil diedit',
                'success'
                ).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = 'pengajuan_pinjaman.php';
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
                'Data pengajuan pencairan gagal diedit, simpanan sukarela lebih kecil dari pengajuan pencairan',
                'error'
                ).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = 'pengajuan_pinjaman.php';
                    } else {
                    //if no clicked => do something else
                    }
                })
            </script>
            ";  
        }
    }

    //fungsi edit
    function edit_pengajuan ($data) {
        global $conn;
        $id = htmlspecialchars($_POST["id2"]);
        $anggota_id = htmlspecialchars($_POST["anggota_id2"]);
        $nominal = htmlspecialchars($_POST["nominal2"]);
        $tanggal = htmlspecialchars($_POST["tanggal2"]);
        $tenor = htmlspecialchars($_POST["tenor2"]);

        //cek pinjaman
        $cek_pinjaman = mysqli_query ($conn,"SELECT count(id) id from pinjaman where anggota_id = '$anggota' and status = 'Lunas'");
        $pinjaman = mysqli_fetch_array($cek_pinjaman);
        $pinjaman = $pinjaman ["id"];
        
        

        if ($pinjaman > 0) { // jika masih mempunyai angsuran
            return false;
        } else {
            mysqli_query($conn,"UPDATE pinjaman SET 
                            tanggal_pengajuan = '$tanggal',
                            nominal = '$nominal',
                            tenor = '$tenor' 
                            WHERE id = '$id'
                        ");
        }

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

    
    // Kirim Pengajuan Data
    $(document).on("click", "#tombolUbah", function() {
        let id = $(this).data("id");
        let anggota_id = $(this).data("anggota_id");
        let nama_anggota = $(this).data("nama_anggota");
        let tanggal = $(this).data("tanggal");
        let nominal = $(this).data("nominal");
        let status = $(this).data("status");
        let tenor = $(this).data("tenor");
        let kode = $(this).data("kopin");


        $(".modal-body #id2").val(id);
        $(".modal-body #anggota_id2").val(anggota_id);
        $(".modal-body #anggota2").val(nama_anggota);
        $(".modal-body #nominal2").val(nominal);
        $(".modal-body #tanggal2").val(tanggal);
        $(".modal-body #tenor2").val(tenor);
        $(".modal-body #nama").val(nama_anggota);
        $(".modal-body #kode").val(kode);
    });

    function formReset() {
        document.getElementById("formUbah").reset();
    }
</script>
   
</body>

</html>