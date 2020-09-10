<?php
	//session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT'])));
	session_start();

	if(!isset($_SESSION['level'])){
			//jika session belum di set/register
			echo"<script> document.location = '../index.php'; </script>";
	}

	//Connection Database
	include "../config/mysqliserver.php";
	$id=mysqli_real_escape_string($con,$_POST['id']);

	switch (mysqli_real_escape_string($con,$_POST['type'])) {

		// print pemeriksaan
		case "periksa":
						$update = mysqli_query($con,
									"UPDATE periksa set jml_print=jml_print+1 where id_periksa='$id' ");
						if($update){
												echo json_encode(array('msg' => 'sukses'));
						}
						else {
									echo json_encode(array('msg' => 'gagal'));
						}
			break;

		// print penjualan
		case "penjualan":
						$update = mysqli_query($con,
									"UPDATE penjualan set print_jual=print_jual+1 where id_penjualan='$id' ");
						if($update){
												echo json_encode(array('msg' => 'sukses'));
						}
						else {
									echo json_encode(array('msg' => 'gagal'));
						}
			break;


	}

?>
