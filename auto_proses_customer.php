<?php
require "koneksi.php";
$query = mysqli_query($conn,"SELECT * FROM customer WHERE id='$_GET[customer_id]'");
$customer = mysqli_fetch_array($query);
$data = array(
      'nama_customer' => $customer['nama_customer']
);
      echo json_encode($data);
      
 ?>