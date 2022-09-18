<?php

require_once __DIR__ . '/vendor/autoload.php';

require 'koneksi.php';

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}

$user = $_SESSION["login"];
$jabatan = $_SESSION["jabatan"];
$username = $_SESSION["username"];

$namaUser = mysqli_query($conn, "SELECT * from user where id = '$user'");
$user = mysqli_fetch_array($namaUser);
$user = $user["nama_user"];

// Filter data 
if (isset($_POST['print'])) {
    $t_awal = htmlspecialchars($_POST["t_awal"]);
    $t_akhir = htmlspecialchars($_POST["t_akhir"]);

    if ($t_awal != 0 or $t_akhir != 0) {
        $sql  = mysqli_query ($conn, "SELECT s.kode_barang, s.nama_barang, s.awal, s.beli, s.jual, 
        case when beli is null and jual is null then s.awal 
        when beli is null and jual is not null then s.awal-jual
        when beli is not null and jual is null then s.awal+beli
        else s.awal+beli-jual end as akhir
        from
        (SELECT b.kode_barang, b.nama_barang,
        case when k_beli_sebelum is null and k_jual_sebelum is null then stok_awal 
        when k_beli_sebelum is null and k_jual_sebelum is not null then stok_awal-k_jual_sebelum
        when k_beli_sebelum is not null and k_jual_sebelum is null then stok_awal+k_beli_sebelum
        else stok_awal+k_beli_sebelum-k_jual_sebelum end as awal,
        case when k_beli is null then 0 else k_beli end as beli, 
        case when k_jual is null then 0 else k_jual end as jual
        from barang b 
        left join (select kode_barang, sum(kuantitas) k_beli from pembelian p join detail_beli db on p.id = db.pembelian_id where p.status = 'Selesai' and tanggal between '$t_awal' and '$t_akhir' group by kode_barang) beli on b.kode_barang = beli.kode_barang
        left join (select kode_barang, sum(kuantitas) k_jual from penjualan pen join detail_jual dj on pen.id = dj.penjualan_id where tanggal between '$t_awal' and '$t_akhir' group by kode_barang) jual on b.kode_barang = jual.kode_barang
        left join (select kode_barang, sum(kuantitas) k_beli_sebelum from pembelian p join detail_beli db on p.id = db.pembelian_id where p.status = 'Selesai' and tanggal < '$t_awal' group by kode_barang) beli_sebelum on b.kode_barang = beli_sebelum.kode_barang
        left join (select kode_barang, sum(kuantitas) k_jual_sebelum from penjualan pen join detail_jual dj on pen.id = dj.penjualan_id where tanggal < '$t_awal' group by kode_barang) jual_sebelum on b.kode_barang = jual_sebelum.kode_barang order by b.kode_barang asc) s order by s.kode_barang asc"
                            );
        $periode = tgl_indo($t_awal).' - '.tgl_indo($t_akhir);

    } else {
        $sql = mysqli_query ($conn, "SELECT b. kode_barang, b.nama_barang, awal, beli, jual, akhir from barang b join
                        (SELECT b.kode_barang, b.nama_barang,
                        case when k_beli_sebelum is null and k_jual_sebelum is null then stok_awal 
                        when k_beli_sebelum is null and k_jual_sebelum is not null then stok_awal-k_jual_sebelum
                        when k_beli_sebelum is not null and k_jual_sebelum is null then stok_awal+k_beli_sebelum
                        else stok_awal+k_beli_sebelum-k_jual_sebelum end as awal,
                        case when k_beli is null then 0 else k_beli end as beli, 
                        case when k_jual is null then 0 else k_jual end as jual,
                        case when k_beli is null and k_jual is null then stok_awal 
                        when k_beli is null and k_jual is not null then stok_awal-k_jual
                        when k_beli is not null and k_jual is null then stok_awal+k_beli
                        else stok_awal+k_beli-k_jual end as akhir
                        from barang b 
                        left join (select kode_barang, sum(kuantitas) k_beli from pembelian p join detail_beli db on p.id = db.pembelian_id where p.status = 'Selesai' and tanggal between '0000-00-00' and '0000-00-00' group by kode_barang) beli on b.kode_barang = beli.kode_barang
                        left join (select kode_barang, sum(kuantitas) k_jual from penjualan pen join detail_jual dj on pen.id = dj.penjualan_id where tanggal between '0000-00-00' and '0000-00-00' group by kode_barang) jual on b.kode_barang = jual.kode_barang
                        left join (select kode_barang, sum(kuantitas) k_beli_sebelum from pembelian p join detail_beli db on p.id = db.pembelian_id where p.status = 'Selesai' and tanggal < '0000-00-00' group by kode_barang) beli_sebelum on b.kode_barang = beli.kode_barang
                        left join (select kode_barang, sum(kuantitas) k_jual_sebelum from penjualan pen join detail_jual dj on pen.id = dj.penjualan_id where tanggal < '0000-00-00' group by kode_barang) jual_sebelum on b.kode_barang = jual.kode_barang order by b.kode_barang asc) mutasi on b.kode_barang = mutasi.kode_barang and mutasi.awal = 9999999999"
                    );
        $periode = '-';

    }
} else {
        $sql = mysqli_query ($conn, "SELECT b. kode_barang, b.nama_barang, awal, beli, jual, akhir from barang b join
                        (SELECT b.kode_barang, b.nama_barang,
                        case when k_beli_sebelum is null and k_jual_sebelum is null then stok_awal 
                        when k_beli_sebelum is null and k_jual_sebelum is not null then stok_awal-k_jual_sebelum
                        when k_beli_sebelum is not null and k_jual_sebelum is null then stok_awal+k_beli_sebelum
                        else stok_awal+k_beli_sebelum-k_jual_sebelum end as awal,
                        case when k_beli is null then 0 else k_beli end as beli, 
                        case when k_jual is null then 0 else k_jual end as jual,
                        case when k_beli is null and k_jual is null then stok_awal 
                        when k_beli is null and k_jual is not null then stok_awal-k_jual
                        when k_beli is not null and k_jual is null then stok_awal+k_beli
                        else stok_awal+k_beli-k_jual end as akhir
                        from barang b 
                        left join (select kode_barang, sum(kuantitas) k_beli from pembelian p join detail_beli db on p.id = db.pembelian_id where p.status = 'Selesai' and tanggal between '0000-00-00' and '0000-00-00' group by kode_barang) beli on b.kode_barang = beli.kode_barang
                        left join (select kode_barang, sum(kuantitas) k_jual from penjualan pen join detail_jual dj on pen.id = dj.penjualan_id where tanggal between '0000-00-00' and '0000-00-00' group by kode_barang) jual on b.kode_barang = jual.kode_barang
                        left join (select kode_barang, sum(kuantitas) k_beli_sebelum from pembelian p join detail_beli db on p.id = db.pembelian_id where p.status = 'Selesai' and tanggal < '0000-00-00' group by kode_barang) beli_sebelum on b.kode_barang = beli.kode_barang
                        left join (select kode_barang, sum(kuantitas) k_jual_sebelum from penjualan pen join detail_jual dj on pen.id = dj.penjualan_id where tanggal < '0000-00-00' group by kode_barang) jual_sebelum on b.kode_barang = jual.kode_barang order by b.kode_barang asc) mutasi on b.kode_barang = mutasi.kode_barang and mutasi.awal = 9999999999"
                    );
        $periode = '-';
}



$mpdf = new \Mpdf\Mpdf();
$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Mutasi Barang</title>
    <link href="assets/css/cetak.css" rel="stylesheet" />
    <link href="img/logo.png" rel="shortcut icon" />
</head>
<body>
<img src="assets/img/header.jpg" width="3480px">
<h3 class="text-center"> Data Mutasi Barang Koperasi Djoyo Makmur </h3> 
<table class="" id="dataTable" width ="300px" cellspacing="0" border="0">
        <tr>
            <td width = "25%" class="text-center"><h5>Periode</h5></td>
            <td colspan="3"><h5>: ' .$periode.'</h5></td>
        </tr>
</table>
<br>
    <table border="1" width="100%" cellspacing="0">
        <thead>
            <tr class="text-center small">
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Stok Awal</th>
                <th>Pembelian</th>
                <th>Penjualan</th>
                <th>Stok Akhir</th>
            </tr>
        </thead>';


        $no = 1;
        foreach($sql as $mutbang ) {
                                        

$html .=    '<tbody>
                <tr>
                    <td align="center">'.$no++.'</td>
                    <td>'.$mutbang['kode_barang'].'</td>
                    <td>'.$mutbang["nama_barang"].'</td>
                    <td align="right">'.$mutbang["awal"].'</td>
                    <td align="right">'.$mutbang["beli"].'</td>
                    <td align="right">'.$mutbang["jual"].'</td>
                    <td align="right">'.$mutbang["akhir"].'</td>
                    ';
        }

$html .='    </table> <br>
<h5 class="oleh">';
$html .= hari_ini().','.' '.tgl_indo(date('Y-m-d'));
$html .='<br><br>'.$user.'
</h5></body>
</html>';
$mpdf->WriteHTML($html);

$mpdf->Output('Data-Barang.pdf','I');