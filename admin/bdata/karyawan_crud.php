<?php
	//session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT'])));
	session_start();

	if(!isset($_SESSION['level'])){
			//jika session belum di set/register
			echo"<script> document.location = '../index.php'; </script>";
	}

	//Connection Database
	include "../config/mysqliserver.php";
	$id_karyawan=mysqli_real_escape_string($con,$_POST['id_karyawan']);

	switch (mysqli_real_escape_string($con,$_POST['type'])) {

		//Tampilkan Data
		case "get":

			$SQL = mysqli_query($con, "SELECT * from karyawan
										WHERE id_karyawan='$id_karyawan'");
			$return = mysqli_fetch_array($SQL,MYSQLI_ASSOC);
			echo json_encode($return);
			break;

		//Tambah Data
		case "new":
			$nm_karyawan=mysqli_real_escape_string($con,$_POST['nm_karyawan']);
			$id_karyawan=mysqli_real_escape_string($con,$_POST['id_karyawan']);
			$alamat_karyawan=mysqli_real_escape_string($con,$_POST['alamat_karyawan']);
			$hp_karyawan=mysqli_real_escape_string($con,$_POST['hp_karyawan']);
			$jabatan=mysqli_real_escape_string($con,$_POST['jabatan']);
			$tgl_lahir=mysqli_real_escape_string($con,$_POST['tgl_lahir']);

			$SQL = mysqli_query($con,
								"INSERT INTO karyawan SET
										id_karyawan='$id_karyawan',
										nm_karyawan='$nm_karyawan',
										alamat_karyawan='$alamat_karyawan',
										hp_karyawan='$hp_karyawan',
										jabatan='$jabatan',
										tgl_lahir='$tgl_lahir'

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
			$id_karyawanold=mysqli_real_escape_string($con,$_POST['id_karyawanold']);
			$id_karyawan=mysqli_real_escape_string($con,$_POST['id_karyawan']);
			$nm_karyawan=mysqli_real_escape_string($con,$_POST['nm_karyawan']);
			$alamat_karyawan=mysqli_real_escape_string($con,$_POST['alamat_karyawan']);
			$hp_karyawan=mysqli_real_escape_string($con,$_POST['hp_karyawan']);
			$jabatan=mysqli_real_escape_string($con,$_POST['jabatan']);
			$tgl_lahir=mysqli_real_escape_string($con,$_POST['tgl_lahir']);

			$SQL = mysqli_query($con,
									"UPDATE karyawan SET
											id_karyawan='$id_karyawan',
											nm_karyawan='$nm_karyawan',
											alamat_karyawan='$alamat_karyawan',
											hp_karyawan='$hp_karyawan',
											jabatan='$jabatan',
											tgl_lahir='$tgl_lahir'

										where id_karyawan='$id_karyawanold'
								");
				if($SQL){
										echo json_encode(array('tipe'=>'sukses', 'msg' => 'Edit Berhasil'));
								}
				else {
										echo json_encode(array('tipe'=>'gagal', 'msg' => 'Edit Gagal, Cek kembali data'));
								}
			break;


	}

?>
