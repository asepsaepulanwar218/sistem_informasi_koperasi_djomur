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

        session_start();
    
        if (!isset($_SESSION["login"])) {
            header("Location: login.php");
        }
    
        $user = $_SESSION["login"];
        $jabatan = $_SESSION["jabatan"];
        $username = $_SESSION["username"];

        @$id_supp = $_GET["id_supp"];
        @$kode = $_GET["kode_barang"];
        @$anggota = $_GET["kode_anggota"];
        @$penarikan = $_GET["id_penarikan"];
        @$pinjaman = $_GET["id_pinjaman"];
        @$detail_jual = $_GET["detail_jual_id"];
        @$detail_beli = $_GET["detail_beli_id"];

        // Hapus Supplier
        @$arap = mysqli_query ($conn,"Select sum(outstanding_nominal) as outstanding from arap where reff_id = '$id_supp'");
        @$row = mysqli_fetch_array($arap);
        @$outstanding = $row["outstanding"];
        @$o_nominal = (int) $outstanding;
        function hapusSupplier($id_supplier) {
            global $conn;
            mysqli_query($conn, "DELETE FROM supplier WHERE id = '$id_supplier'");

            return mysqli_affected_rows($conn);  
        }


        if (isset($_GET["id_supp"])) {
            if ($o_nominal == 0) {
                if (hapusSupplier($id_supp) > 0) {
                    echo "
                        <script>
                            Swal.fire(
                            'Berhasil !',
                            'Data Berhasil Dihapus',
                            'success'
                            ).then(function(isConfirm) {
                                if (isConfirm) {
                                    document.location.href = 'supplier.php'
                                } 
                            });
                        </script>
                    ";
                
                } else {
                    echo "
                        <script>
                            Swal.fire(
                            'Gagal !',
                            'Data Gagal Dihapus',
                            'error'
                            ).then(function(isConfirm) {
                                if (isConfirm) {
                                    document.location.href = 'supplier.php'
                                } 
                            });
                        </script>
                    ";
                            
                }
            } else {
                echo "
                    <script>
                        Swal.fire(
                        'Gagal !',
                        'Data Gagal Dihapus, karena outstanding supplier ini lebih dari 0',
                        'error'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'supplier.php'
                            } 
                        });
                    </script>
                ";        
            }
        } 

        // Hapus Barang
        function hapusBarang($kode_barang) {
            global $conn;
            mysqli_query($conn, "DELETE FROM barang WHERE kode_barang = '$kode_barang' and stok = 0 ");

            return mysqli_affected_rows($conn);  
        }


        if (isset($_GET["kode_barang"])) {
            if (hapusBarang($kode) > 0) {
                echo "
                    <script>
                        Swal.fire(
                            'Berhasil !',
                            'Data Berhasil Dihapus',
                            'success'
                            ).then(function(isConfirm) {
                                if (isConfirm) {
                                    document.location.href = 'barang.php';
                                } 
                        });
                    </script>
                ";
            
            } else {
                echo "
                <script>
                    Swal.fire(
                    'Gagal !',
                    'Data Gagal Dihapus, Stok barang ini masih ada',
                    'error'
                    ).then(function(isConfirm) {
                        if (isConfirm) {
                            document.location.href = 'barang.php';
                        } 
                    });
                </script>
                ";
                        
            }
        } 



        // Hapus Anggota
        function hapusAnggota($anggota) {
            global $conn;
            $id_cust = substr($anggota,1,7);
            $id_customer = 'C'.$id_cust;
            mysqli_query($conn, "DELETE FROM anggota WHERE id = '$anggota' and status = 'Pasif'");
            mysqli_query($conn, "DELETE FROM customer WHERE id = '$id_customer'");

            return mysqli_affected_rows($conn);  
        }


        if (isset($_GET["kode_anggota"])) {
            @$simpok = mysqli_query ($conn,"SELECT sum(nominal_simpanan) nominal from sim_pokok sp join simpanan s on s.id = sp.simpanan_id and s.anggota_id = '$anggota'");
            @$row = mysqli_fetch_array($simpok);
            @$nominal = $row["nominal"];
            @$nominal_0 = (int) $nominal;

            @$simsuk = mysqli_query ($conn,"SELECT sum(nominal_simpanan) nominal from sim_sukarela ss join simpanan s on s.id = ss.simpanan_id and s.anggota_id = '$anggota'");
            @$sim_suk = mysqli_fetch_array($simsuk);
            @$simsuk0 = $sim_suk["nominal"];
            @$simsuk1 = (int) $simsuk0;

            @$status = mysqli_query ($conn,"SELECT * FROM anggota WHERE id = '$anggota'");
            @$statusnya = mysqli_fetch_array($status);
            @$status0 = $statusnya["status"];

            @$pinjaman = mysqli_query ($conn,"SELECT count(id) id FROM pinjaman WHERE anggota_id = '$anggota' and status = 'Progres'");
            @$pinjamannya = mysqli_fetch_array($pinjaman);
            @$pinjaman0 = $pinjamannya["id"];

            $tabungan = $nominal_0 + $simsuk1;
            
            if ($pinjaman0 != 0) {
                echo "
                    <script>
                        Swal.fire(
                        'Gagal !',
                        'Data Gagal Dihapus, <br> Anggota ini masih mempunyai pinjaman',
                        'error'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'anggota.php';
                            } 
                        });
                    </script>
                    ";
            } else if ($tabungan != 0) {
                echo "
                    <script>
                        Swal.fire(
                        'Gagal !',
                        'Data Gagal Dihapus, Anggota ini masih mempunyai tabungan',
                        'error'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'anggota.php';
                            } 
                        });
                    </script>
                    ";
            } else if ($status0 == 'Aktif') {
                echo "
                    <script>
                        Swal.fire(
                        'Gagal !',
                        'Data Gagal Dihapus, Anggota ini statusnya aktif',
                        'error'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'anggota.php';
                            } 
                        });
                    </script>
                    ";

            } else {
                if (hapusAnggota($anggota) > 0) {
                    mysqli_query($conn, "DELETE FROM saldo_daily WHERE anggota_id = '$anggota'");
                    mysqli_query($conn, "DELETE FROM simpanan WHERE anggota_id is null");
                    echo "
                        <script>
                            Swal.fire(
                                'Berhasil !',
                                'Data Berhasil Dihapus',
                                'success'
                                ).then(function(isConfirm) {
                                    if (isConfirm) {
                                        document.location.href = 'anggota.php';
                                    } 
                            });
                        </script>
                    ";
                
                } else {
                    echo "
                    <script>
                        Swal.fire(
                        'Gagal !',
                        'Data Gagal Dihapus, Anggota ini statusnya aktif',
                        'error'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'anggota.php';
                            } 
                        });
                    </script>
                    ";
                            
                }
            } 
        }

        // Hapus Penarikan
        function hapusPenarikan($penarikan) {
            global $conn;
            $hapusPenarikan = mysqli_query($conn, "DELETE FROM pengajuan_tarik_saldo WHERE id = '$penarikan' and status = 'Draft'");

            return mysqli_affected_rows($conn);  
        }


        if (isset($_GET["id_penarikan"])) {
                if (hapusPenarikan($penarikan) > 0) {
                    echo "
                        <script>
                            Swal.fire(
                                'Berhasil !',
                                'Data Berhasil Dihapus',
                                'success'
                                ).then(function(isConfirm) {
                                    if (isConfirm) {
                                        document.location.href = 'pengajuan_penarikan.php';
                                    } 
                            });
                        </script>
                    ";
                
                } else {
                    echo "
                    <script>
                        Swal.fire(
                        'Gagal !',
                        'Data Pengajuan Penarikan Gagal Dihapus,
                        'error'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'pengajuan_penarikan.php';
                            } 
                        });
                    </script>
                    ";
                            
                }
        }

        // Hapus Pinjaman
        function hapusPinjaman($pinjaman) {
            global $conn;
            mysqli_query($conn, "DELETE FROM pinjaman WHERE id = '$pinjaman' and status = 'Draft'");

            return mysqli_affected_rows($conn);  
        }


        if (isset($_GET["id_pinjaman"])) {
                if (hapusPinjaman($pinjaman) > 0) {
                    echo "
                        <script>
                            Swal.fire(
                                'Berhasil !',
                                'Data Berhasil Dihapus',
                                'success'
                                ).then(function(isConfirm) {
                                    if (isConfirm) {
                                        document.location.href = 'pengajuan_pinjaman.php';
                                    } 
                            });
                        </script>
                    ";
                
                } else {
                    echo "
                    <script>
                        Swal.fire(
                        'Gagal !',
                        'Data Gagal Dihapus,
                        'error'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'pengajuan_pinjaman.php';
                            } 
                        });
                    </script>
                    ";
                            
                }
        }

        // Hapus Detail Jual
        function hapusDetailJual($detail_jual) {
            global $conn;
            $ambilDetail = mysqli_query($conn, "SELECT * from detail_jual where id = '$detail_jual'");
            $ambilDetail2 = mysqli_fetch_array($ambilDetail);
            $kobar = $ambilDetail2["kode_barang"];
            $kuantitas = $ambilDetail2["kuantitas"];

            $ambilStok = mysqli_query($conn, "SELECT stok from barang where kode_barang = '$kobar'");
            $ambilStok2 = mysqli_fetch_array($ambilStok);
            $stok = $ambilStok2["stok"];

            $stokAkhir = $stok + $kuantitas;

            mysqli_query($conn, "UPDATE barang set stok = '$stokAkhir' where kode_barang = '$kobar' ");
            mysqli_query($conn, "DELETE FROM detail_jual WHERE id = '$detail_jual'");

            return mysqli_affected_rows($conn);  
        }


        if (isset($_GET["detail_jual_id"])) {
                if (hapusDetailJual($detail_jual) > 0) {
                    echo "
                        <script>
                            Swal.fire(
                                'Berhasil !',
                                'Data Berhasil Dihapus',
                                'success'
                                ).then(function(isConfirm) {
                                    if (isConfirm) {
                                        document.location.href = 'tambah_penjualan.php';
                                    } 
                            });
                        </script>
                    ";
                
                } else {
                    echo "
                    <script>
                        Swal.fire(
                        'Gagal !',
                        'Data Gagal Dihapus,
                        'error'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'tambah_penjualan.php';
                            } 
                        });
                    </script>
                    ";
                            
                }
        }


        // Hapus Detail Beli
        function hapusDetailBeli($detail_beli) {
            global $conn;
            $ambilDetail = mysqli_query($conn, "SELECT * from detail_beli where id = '$detail_beli'");
            $ambilDetail2 = mysqli_fetch_array($ambilDetail);
            $kobar = $ambilDetail2["kode_barang"];
            $kuantitas = $ambilDetail2["kuantitas"];

            // $ambilStok = mysqli_query($conn, "SELECT stok from barang where kode_barang = '$kobar'");
            // $ambilStok2 = mysqli_fetch_array($ambilStok);
            // $stok = $ambilStok2["stok"];

            // $stokAkhir = $stok + $kuantitas;

            // mysqli_query($conn, "UPDATE barang set stok = '$stokAkhir' where kode_barang = '$kobar' ");
            mysqli_query($conn, "DELETE FROM detail_beli WHERE id = '$detail_beli'");

            return mysqli_affected_rows($conn);  
        }

        if (isset($_GET["detail_beli_id"])) {
                if (hapusDetailBeli($detail_beli) > 0) {
                    echo "
                        <script>
                            Swal.fire(
                                'Berhasil !',
                                'Data Berhasil Dihapus',
                                'success'
                                ).then(function(isConfirm) {
                                    if (isConfirm) {
                                        document.location.href = 'pengajuan_pembelian.php';
                                    } 
                            });
                        </script>
                    ";
                
                } else {
                    echo "
                    <script>
                        Swal.fire(
                        'Gagal !',
                        'Data Gagal Dihapus,
                        'error'
                        ).then(function(isConfirm) {
                            if (isConfirm) {
                                document.location.href = 'pengajuan_pembelian.php';
                            } 
                        });
                    </script>
                    ";
                            
                }
        }

        ?>

            
    </body>
</html>