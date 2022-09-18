<?php
require "koneksi.php";
$simsuk = mysqli_query($conn, "SELECT sum(nominal_simpanan) simsuk from sim_sukarela where simpanan_id in (select id from simpanan where anggota_id = '$_GET[anggota]')");
$simsuk = mysqli_fetch_array($simsuk);
$simsuk = $simsuk['simsuk'];

$penarikan = mysqli_query($conn, "SELECT sum(nominal) penarikan from penarikan where simpanan_id in (select id from simpanan where anggota_id = '$_GET[anggota]')");
$penarikan = mysqli_fetch_array($penarikan);
$penarikan = $penarikan['penarikan'];

$saldo_simsuk = $simsuk - $penarikan;

$data = array(
      'simsuk' => $saldo_simsuk,
      'simsuk2' => 'Rp '.number_format($saldo_simsuk,0,',','.')
);
      echo json_encode($data);
      
 ?>