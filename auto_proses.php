<?php
require "koneksi.php";
$query = mysqli_query($conn,"SELECT * FROM karyawan WHERE id='$_GET[id]'");
$user = mysqli_fetch_array($query);
$data = array(
      'nama' => $user['nama_karyawan'],
      'ktp' => $user['ktp'],
      'alamat' => $user['alamat'],
      'no_hp' => $user['no_hp'],
      'divisi_id' => $user['divisi_id'],
      'tanggal_join' => $user['tanggal_join']
);
      echo json_encode($data);
      
 ?>