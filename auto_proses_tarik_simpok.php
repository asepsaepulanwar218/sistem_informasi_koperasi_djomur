<?php
require "koneksi.php";
$query = mysqli_query ($conn,"SELECT sum(nominal_simpanan) nominal from sim_pokok sp join simpanan s on s.id = sp.simpanan_id and s.anggota_id = '$_GET[anggota]'");
$nominal = mysqli_fetch_array($query);
$data = array(
      'nominal' => $nominal['nominal'],
      'nominalnya' => 'Rp '.number_format($nominal["nominal"],0,',','.')
);
      echo json_encode($data);
      
 ?>