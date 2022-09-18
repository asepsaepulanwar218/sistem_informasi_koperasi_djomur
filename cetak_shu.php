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
    <title>Cetak Hasil Usaha</title>
    <link href="assets/css/cetak.css" rel="stylesheet" />
    <link href="img/logo.png" rel="shortcut icon" />
</head>
<body>
<img src="assets/img/header.jpg" width="3480px">
<h3 class="text-center"> Rekap Hasil Usaha </h3> 
<table class="small mb-3 hitam" id="dataTable" width ="350px" cellspacing="0">
    <tr>
        <td>Periode</td>
        <td>: '.$periode.'</td>
    </tr>
    <tr>
        <td>SHU Awal</td>
        <td>: Rp '.number_format($awal,0,',','.').'</td>
    </tr>
    <tr>
        <td>Mutasi </td>
        <td>: Rp '.number_format($mutasi,0,',','.').'</td>
    </tr>
    <tr>
        <td>SHU Akhir </td>
        <td>: Rp '.number_format($akhir,0,',','.').'</td>
    </tr>
</table>
<br>
    <table border="1" width="100%" cellspacing="0">
    <thead>
        <tr class="text-center small">
            <th>No</th>
            <th>Tanggal</th>
            <th>Kode Referensi</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Keterangan</th>
        </tr>
    </thead>';


        $i = 1;
        foreach($ambil_shu as $kas ) {
                                        

$html .=    '
                <tbody class="small">
                    <tr>
                        <td class="text-center no ">'.$i++.'</td>
                        <td class="text-center">'.date('d-m-Y',strtotime($kas['tanggal'])).'</td>
                        <td>'.$kas["kode_reff"].'</td>
                        <td class="text-right">Rp '.number_format($kas["debet"],2,',','.').'</td>
                        <td class="text-right">Rp '.number_format($kas["kredit"],2,',','.').'</td>
                        <td>'.$kas["keterangan"].'</td>
                    </tr>
                </tbody>
                    ';
        }

$html .='    </table> <br>
<h5 class="oleh">';
$html .= hari_ini().','.' '.tgl_indo(date('Y-m-d'));
$html .='<br><br>'.$user.'
</h5></body>
</html>';
$mpdf->WriteHTML($html);

$mpdf->Output('Hasil-Usaha.pdf','I');