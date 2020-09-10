
<?php
//
session_start();
include "../config/mysqliserver.php";

$type=mysqli_real_escape_string($con,$_POST['type']);

switch ($type) {

	case 'get_obat':       //detail_periksa
			$kd_item=mysqli_real_escape_string($con,$_POST['kd_item']);

			$query = mysqli_query ($con,"SELECT hjual_obat,stok_obat
						from obat where id_obat='$kd_item'");

			$hsl = mysqli_fetch_array ($query);
			$hjual_obat=$hsl['hjual_obat'];
			$stok_obat=$hsl['stok_obat'];
			$hjual=number_format($hjual_obat, 0, ".", ".");

			echo json_encode(array('type' => 'sukses','qty' => $stok_obat, 'harga' => $hjual));
		break;

	case 'value':
			// code...
		break;
}



?>
