<?php
	//session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT'])));
	session_start();

	if(!isset($_SESSION['level'])){
			//jika session belum di set/register
			echo"<script> document.location = '../index.php'; </script>";
	}

	//Connection Database
	include "../config/mysqliserver.php";
	$id_obat=mysqli_real_escape_string($con,$_POST['id_obat']);

	switch (mysqli_real_escape_string($con,$_POST['type'])) {

		//Tampilkan Data
		case "get":

			$SQL = mysqli_query($con, "SELECT * from obat
										WHERE id_obat='$id_obat'");
			$return = mysqli_fetch_array($SQL,MYSQLI_ASSOC);
			echo json_encode($return);
			break;

		//Tambah Data
		case "new":
			$nm_obat=mysqli_real_escape_string($con,$_POST['nm_obat']);
			$stok_obat=mysqli_real_escape_string($con,$_POST['stok_obat']);
			$hpp_obat=preg_replace('/\D/', '',mysqli_real_escape_string($con,$_POST['hpp_obat']));
			$hjual_obat=preg_replace('/\D/', '',mysqli_real_escape_string($con,$_POST['hjual_obat']));
			$jenis_obat=mysqli_real_escape_string($con,$_POST['jenis_obat']);
			$jenis_obat=strtoupper($jenis_obat);

			$SQL = mysqli_query($con,
								"INSERT INTO obat SET
										nm_obat='$nm_obat',
										hpp_obat='$hpp_obat',
										hjual_obat='$hjual_obat',
										stok_obat='$stok_obat',
										jenis_obat='$jenis_obat'

								");
			if($SQL){
					echo json_encode(array('tipe'=>'sukses', 'msg' => 'Input Berhasil'));
			}
			else {
					echo json_encode(array('tipe'=>'gagal', 'msg' => 'Input Gagal, Cek kembali data'));
			}
			break;

		//Edit Data
		case "edit":

			$nm_obat=mysqli_real_escape_string($con,$_POST['nm_obat']);
			$stok_obat=mysqli_real_escape_string($con,$_POST['stok_obat']);
			$hpp_obat=preg_replace('/\D/', '',mysqli_real_escape_string($con,$_POST['hpp_obat']));
			$hjual_obat=preg_replace('/\D/', '',mysqli_real_escape_string($con,$_POST['hjual_obat']));
			$jenis_obat=mysqli_real_escape_string($con,$_POST['jenis_obat']);
			$jenis_obat=strtoupper($jenis_obat);

			$SQL = mysqli_query($con,
									"UPDATE obat SET
											nm_obat='$nm_obat',
											hpp_obat='$hpp_obat',
											hjual_obat='$hjual_obat',
											stok_obat='$stok_obat',
											jenis_obat='$jenis_obat'

										where id_obat='$id_obat'
								");
				if($SQL){
										echo json_encode(array('tipe'=>'sukses', 'msg' => 'Edit Berhasil'));
								}
				else {
										echo json_encode(array('tipe'=>'gagal', 'msg' => 'Edit Gagal, Cek kembali data'));
								}
			break;

		//Hapus Data
		/*
		case "delete":

			$SQL = mysqli_query($con, "DELETE FROM pembelian WHERE id_pembelian='".$_POST['id']."' ");
			if($SQL){
				echo json_encode("OK");
			}
			break;
			*/
	}

?>
