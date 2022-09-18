<?php

require 'koneksi.php';

if (batal_jual () > 0) {
    echo "<script>
            document.location.href = 'penjualan.php';
        </script>"; 
} else {
    echo "
    <script>
        document.location.href = 'tambah_penjualan.php';
    </script>
    ";  
}

function batal_jual() {
    global $conn;
    $getKodeBarang = mysqli_query ($conn,"SELECT kode_barang from detail_jual where penjualan_id is null ");
    foreach ($getKodeBarang as $get_kode) {
        $ambilDetail = mysqli_query($conn, 'SELECT * from detail_jual where kode_barang = "'.$get_kode['kode_barang'].'" AND penjualan_id is null');
        $ambilDetail2 = mysqli_fetch_array($ambilDetail);
        $qty = $ambilDetail2["kuantitas"];

        $ambilStok = mysqli_query($conn, 'SELECT stok from barang where kode_barang = "'.$get_kode['kode_barang'].'"');
        $ambilStok2 = mysqli_fetch_array($ambilStok);
        $stok2 = $ambilStok2["stok"];

        $stokAwal = $stok2 + $qty;
        
        mysqli_query($conn,'UPDATE barang set stok = "'.$stokAwal.'" where kode_barang = "'.$get_kode['kode_barang'].'" ');
    }
    mysqli_query($conn, "DELETE from detail_jual where penjualan_id is null");

    return mysqli_affected_rows($conn);
}
