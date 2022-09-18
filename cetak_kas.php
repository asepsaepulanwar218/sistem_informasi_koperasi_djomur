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

$mpdf = new \Mpdf\Mpdf();
$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rekap Kas</title>
    <link href="assets/css/cetak.css" rel="stylesheet" />
    <link href="img/logo.png" rel="shortcut icon" />
</head>
<body>
<img src="assets/img/header.jpg" width="3480px">
<h3 class="text-center"> Rekap Kas Koperasi Djoyo Makmur </h3> 
<table class="" id="dataTable" width ="450px" cellspacing="0" border="0">
        <tr>
            <td><h5>Periode</h5></td>
            <td colspan="3"><h5>: ' .$periode.'</h5></td>
        </tr>
        <tr>
            <td><h5>Kas Masuk</h5></td>
            <td><h5>: Rp '.number_format($masuk,0,',','.').'</h5></td>
            <td><h5>Kas Keluar</td>
            <td><h5>: Rp '.number_format($keluar,0,',','.').'</h5></td>
        </tr>
        <tr>
            <td><h5>Saldo Awal </td>
            <td><h5>: Rp '.number_format($awal,0,',','.').'</h5></td>
            <td><h5>Saldo Akhir </td>
            <td><h5>: Rp '.number_format($akhir,0,',','.').'</h5></td>
        </tr>
</table>
<br>
    <table border="1" width="100%" cellspacing="0">
        <thead>
            <tr class="text-center small">
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Referensi</th>
                <th>Kas Masuk</th>
                <th>Kas Keluar</th>
                <th>Keterangan</th>
            </tr>
        </thead>';


        $i = 1;
        foreach($ambil as $kas ) {
                                        

$html .=    '<tbody>
                <tr>
                    <td align="center">'. $i++ .'</td>
                    <td align="center">'. date('d-m-Y',strtotime($kas['tanggal'])) .'</td>
                    <td>'. $kas["kode_reff"] .'</td>
                    <td align="right"> Rp '. number_format($kas["kas_masuk"],0,',','.').'</td>
                    <td align="right"> Rp '. number_format($kas["kas_keluar"],0,',','.') .'</td>
                    <td>'. $kas["keterangan"] .'</td>
                    ';
        }

$html .='    </table> <br>
<h5 class="oleh">';
$html .= hari_ini().','.' '.tgl_indo(date('Y-m-d'));
$html .='<br><br>'.$user.'
</h5></body>
</html>';
$mpdf->WriteHTML($html);

$mpdf->Output('Laporan-Kas.pdf','I');