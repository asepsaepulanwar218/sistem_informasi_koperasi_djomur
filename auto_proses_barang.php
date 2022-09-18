<?php
require "koneksi.php";
$query = mysqli_query($conn,"SELECT * FROM barang WHERE kode_barang='$_GET[kode_barang]'");
$barang = mysqli_fetch_array($query);
$data = array(
      'nama_barang' => $barang['nama_barang'],
      'stok' => $barang['stok'],
      'harga_jual' => $barang['harga_jual'],
      'harga_beli' => $barang['harga_beli']
);
      echo json_encode($data);
      
 ?>