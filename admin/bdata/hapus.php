<?php 
include '../config/mysqli.php';
$id=$_GET['id'];
mysqli_query($koneksi,"DELETE from pasien_001 where norm='$id'");
header("location:../../admin/index.php?page=pasien");

?>