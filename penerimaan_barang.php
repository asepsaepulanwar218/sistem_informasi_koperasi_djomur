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
    $maxId = mysqli_query($conn, "SELECT max(id) as idTerbesar FROM supplier");
    $data = mysqli_fetch_array($maxId);
    $idSupplier = $data['idTerbesar'];
    $idSupplier++;
    $idSupplier = sprintf("%03s", $idSupplier);
    

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
        //$sql="select * from supplier order by id_supplier asc limit $posisi,$batas";
        //$supplier0 = mysqli_query($conn,$sql);

        // Filter data 
        if (isset($_POST['filter'])) {
            $search = htmlspecialchars($_POST["search"]);

            if ($search != null) {
                $sql=mysqli_query($conn,"SELECT p.*, s.nama_supp, u.nama_user from pembelian p join supplier s on p.supplier_id = s.id and p.status = 'Disetujui' join user u on u.id = p.user_id where s.nama_supp like '%$search%' or kode_beli like '%$search%' or keterangan like '%$search%' or tanggal like '%$search%' or u.nama_user like '%$search%' order by id asc limit $posisi,$batas");
            } else {
                $sql=mysqli_query($conn,"SELECT p.*, s.nama_supp, u.nama_user from pembelian p join supplier s on p.supplier_id = s.id and p.status = 'Disetujui' join user u on u.id = p.user_id order by id asc limit $posisi,$batas");
            }
        } else {
            $sql=mysqli_query($conn, "SELECT p.*, s.nama_supp, u.nama_user from pembelian p join supplier s on p.supplier_id = s.id and p.status = 'Disetujui' join user u on u.id = p.user_id  order by id asc limit $posisi,$batas");
        }

        // $detailJual=mysqli_query($conn, "SELECT dj.kode_barang, b.nama_barang, b.harga_jual, dj.kuantitas, (b.harga_jual * dj.kuantitas) total
        //                             from detail_jual dj 
        //                             join barang b on b.kode_barang = dj.kode_barang
        //                             join penjualan p on p.id = dj.penjualan_id
        //                             where p.id is null order by dj.id asc limit $posisi,$batas");

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
                        <h3 class="mr-6 ml-4 mt-2 hitam"><i class="fas fa-shopping-cart mx-2 text-dark"></i>Konfirmasi Pembelian</h3>
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
                                            <div class="col-11 mt-1  text-light">
                                                <i class="fas fa-table me-1 text-light"></i>
                                                Data Konfirmasi Pembelian
                                            </div>
                                            <div class="col-1">
                                                <!-- Button modal Tambah Data-->
                                                <!-- <a type="button" class=" text-light float-right" data-bs-toggle="" data-bs-target="" href="tambah_pembelian.php">
                                                    <i class="fas fa-plus"></i>
                                                </a> -->
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body2">
                                        <div class="row">
                                            <div class="col-9"></div>
                                            <div class="col-3">
                                                <form class="d-none d-md-inline-block form-inline mt-1 pt-1 mb-1 float-right" action="" method="post">
                                                    <div class="input-group">
                                                        <input class="form-control-sm" type="text" name="search" id="search" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" autocomplete="off"/>
                                                        <div class="input-group-append ml-1">
                                                            <button class="btn btn-light btn-sm" type="submit" name="filter"><i class="fas fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="table-responsive mt-2">
                                            <table class="table-utama tabel" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr class="text-center small">
                                                        <th>No</th>
                                                        <th>Nama Supplier</th>
                                                        <th>Tanggal</th>
                                                        <th>Kode Beli</th>
                                                        <th>Total Pembelian</th>
                                                        <th>Keterangan</th>
                                                        <th>Status</th>
                                                        <th>Entry By</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>

                                                <!-- Looping Data Tarif -->
                                                <?php foreach($sql as $pembelian ) : ?>
                                                    

                                                <tbody class="small">
                                                    <tr>
                                                        <td class="text-center no "><?= $no; ?></td>
                                                        <td><?= $pembelian["nama_supp"]; ?></td>
                                                        <td class="text-center"><?= tgl_indo(date('Y-m-d',strtotime($pembelian['tanggal']))); ?></td>
                                                        <td><?= $pembelian["kode_beli"]; ?></td>
                                                        <td class="text-right">Rp <?= number_format($pembelian["total"],2,',','.'); ?></td>
                                                        <td><?= $pembelian["keterangan"]; ?></td>
                                                        <td class="text-center"><?= $pembelian["status"]; ?></td>
                                                        <td class="text-center"><?= $pembelian["nama_user"]; ?></td>
                                                        <td class="text-center">
                                                            <!-- <a type="button" class="aksi text-dark" id="tombolUbah" data-toggle='modal' data-target="#editpembelian" 
                                                                data-id="<?= $pembelian['id']; ?>"
                                                                data-nama_pembelian="<?= $pembelian['nama_pembelian']; ?>"
                                                                data-ktp="<?= $pembelian['ktp']; ?>"
                                                                data-alamat="<?= $pembelian['alamat']; ?>"
                                                                data-no_hp="<?= $pembelian['no_hp']; ?>"
                                                                data-divisi="<?= $pembelian['divisi_id']; ?>"
                                                                data-tanggal_join="<?= $pembelian['tanggal_join']; ?>"
                                                                data-status="<?= $pembelian['status']; ?>"
                                                                data-karyawan="<?= $pembelian['id_karyawan']; ?>"
                                                                ><i class="fas fa-solid fa-pen small"></i>
                                                            </a> -->
                                                            <a class="aksi text-dark" href="konfirmasi_beli.php?pembelian_id=<?= $pembelian["id"]; ?>"><i class="fas fa-search-plus small"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            
                                                <?php $no++ ?>
                                                <?php endforeach; ?>

                                            </table>
                                        </div>

                                        <?php 
                                            $query2     = mysqli_query($conn, "select * from penjualan");
                                            $jmldata    = mysqli_num_rows($query2);
                                            $jmlhalaman = ceil($jmldata/$batas);
                                        ?>
                                        <div class="text-center">
                                            <ul class="pagination mb-0">
                                                <?php
                                                for($i=1;$i<=$jmlhalaman;$i++) {
                                                    if ($i != $halaman) {
                                                        echo "<li class='page-item'><a class='page-link text-dark small' href='penjualan.php?halaman=$i'>$i</a></li>";
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

    <!-- Modal Tambah Data Supplier-->
    <div class="modal fade" id="addtarif" tabindex="-1" aria-labelledby="addtarifLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content-supplier">
                <div class="modal-header">
                    <h5 class="modal-title" id="addtarifLabel">Form Tambah Data Supplier</h5>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" class="form-control form-control-sm small" name="id_supp" id="id_supp" required value="<?php echo $idSupplier ?>" readonly>
                        <div class="mb-2">
                            <label for="nama_supplier" class="form-label small">Nama Supplier</label>
                            <input type="text" class="form-control form-control-sm" name="nama_supplier" id = "nama_supplier" required>
                        </div>   
                        <div class="mb-2">
                            <label for="alamat" class="form-label small">Alamat</label>
                            <input type="textarea" class="form-control form-control-sm" name="alamat" id = "alamat" required>
                        </div>
                        <div class="mb-2">
                            <label for="telepon" class="form-label small">Telepon</label>
                            <input type="number" class="form-control form-control-sm" name="telepon" id = "telepon" required>
                        </div>
                        <div class="mb-2">
                            <label for="email" class="form-label small">Email</label>
                            <input type="text" class="form-control form-control-sm" name="email" id = "email" required>
                        </div>
                        <div class="mb-2">
                            <?php $tipe_bayar = mysqli_query($conn, "select * from tipe_bayar") ?>
                            <label for="tipe_bayar" class="form-label small">Tipe Bayar</label>
                            <select class="custom-select" id="tipe_bayar" name="tipe_bayar" required>
                                <option selected></option>
                                <!-- Looping Data Tipe Bayar -->
                                <?php foreach($tipe_bayar as $tipe ) : ?>
                                    <option value="<?= $tipe["id"]; ?>"><?= $tipe["tipe_bayar"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="outstanding" class="form-label small">Outstanding</label>
                            <input type="number" class="form-control form-control-sm" name="outstanding" id = "outstanding" required>    
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary btn-sm" name ="submit-supp">Simpan</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Data Supplier-->
    <div class="modal fade" id="editSupplier" tabindex="-1" aria-labelledby="editSupplierLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content-supplier">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSupplierLabel">Form Edit Data Supplier</h5>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" id="formUbahSupplier">
                            <input type="hidden" class="form-control form-control-sm small" name="id_supp_2" id="id_supp_2" required value="<?php echo $idSupplier ?>" readonly>
                            <div class="mb-2">
                                <label for="nama_supplier" class="form-label small">Nama Supplier</label>
                                <input type="text" class="form-control form-control-sm" name="nama_supplier_2" id = "nama_supplier_2" required>
                            </div>   
                            <div class="mb-2">
                                <label for="alamat" class="form-label small">Alamat</label>
                                <input type="textarea" class="form-control form-control-sm" name="alamat_2" id = "alamat_2" required>
                            </div>
                            <div class="mb-2">
                                <label for="telepon" class="form-label small">Telepon</label>
                                <input type="number" class="form-control form-control-sm" name="telepon_2" id = "telepon_2" required>
                            </div>
                            <div class="mb-2">
                                <label for="email" class="form-label small">Email</label>
                                <input type="text" class="form-control form-control-sm" name="email_2" id = "email_2" required>
                            </div>
                            <div class="mb-2">
                                <?php $tipe_bayar = mysqli_query($conn, "select * from tipe_bayar") ?>
                                <label for="tipe_bayar" class="form-label small">Tipe Bayar</label>
                                <select class="custom-select" id="tipe_bayar_2" name="tipe_bayar_2" required>
                                    <option selected></option>
                                    <!-- Looping Data Tipe Bayar -->
                                    <?php foreach($tipe_bayar as $tipe ) : ?>
                                        <option  value="<?= $tipe["id"]; ?>"><?= $tipe["tipe_bayar"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="outstanding" class="form-label small">Outstanding</label>
                                <input type="number" class="form-control form-control-sm" name="outstanding" id = "outstanding_2" required readonly>    
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary btn-sm" name ="ubah-supp">Simpan</button>
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="formReset()">Batal</button>
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
    
?>
        <script>
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
                    //jika klik ya maka arahkan ke proses.php
                    if(result.isConfirmed){
                        Swal.fire(
                        'Berhasil !',
                        'Data Berhasil Dihapus',
                        'success'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                window.location.href = getLink;
                            } 
                        })
                    }
                })
                return false;
            });

            // Ubah Data
            $(document).on("click", "#tombolUbah", function() {
                let id = $(this).data("id");
                let nama_supplier = $(this).data("nama");
                let alamat = $(this).data("alamat");
                let telepon = $(this).data("telepon");
                let email = $(this).data("email");
                let tipe_bayar = $(this).data("tipe_bayar");
                let outstanding = $(this).data("outstanding");

                $(".modal-body #id_supp_2").val(id);
                $(".modal-body #nama_supplier_2").val(nama_supplier);
                $(".modal-body #alamat_2").val(alamat);
                $(".modal-body #telepon_2").val(telepon);
                $(".modal-body #email_2").val(email);
                $(".modal-body #tipe_bayar_2").val(tipe_bayar);
                $(".modal-body #outstanding_2").val(outstanding);
            });

            function formReset() {
                document.getElementById("formUbahSupplier").reset();
            }
        </script>

</body>

</html>