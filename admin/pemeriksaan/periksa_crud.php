<?php
	//session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT'])));
	session_start();

	if(!isset($_SESSION['level'])){
			//jika session belum di set/register
			echo"<script> document.location = '../index.php'; </script>";
	}

	//Connection Database
	include "../config/mysqliserver.php";
	$norm=mysqli_real_escape_string($con,$_POST['norm']);

	switch (mysqli_real_escape_string($con,$_POST['type'])) {

		//Tampilkan Data
		case "get":

			$SQL = mysqli_query($con, "SELECT * from pasien
										WHERE norm='$norm'");
			$return = mysqli_fetch_array($SQL,MYSQLI_ASSOC);
			echo json_encode($return);
			break;

		//Tambah Data
		case "new":
			$nm_pasien=mysqli_real_escape_string($con,$_POST['nm_pasien']);
			$kk_pasien=mysqli_real_escape_string($con,$_POST['kk_pasien']);
			$alamat_pasien=mysqli_real_escape_string($con,$_POST['alamat_pasien']);
			$hp_pasien=mysqli_real_escape_string($con,$_POST['hp_pasien']);
			$jenis_kelamin=mysqli_real_escape_string($con,$_POST['jenis_kelamin']);
			$tgllahir_pasien=mysqli_real_escape_string($con,$_POST['tgllahir_pasien']);

			//buat norm
			$huruf=strtoupper (substr($nm_pasien, 0,1));
			$mj = mysqli_query($con,"SELECT norm FROM pasien where nm_pasien like '$huruf%' order by norm desc LIMIT 1 ");
			$rj = mysqli_num_rows($mj);
			if($rj>0)
				{
						$huruf2=$huruf."-";
						$sj = mysqli_query($con,"SELECT CONCAT('$huruf2', LPAD((RIGHT(MAX(norm),4)+1),4,'0')) as norm1 FROM pasien where norm like '$huruf%' ");
						$xj = mysqli_fetch_assoc($sj);
						$norm=$xj['norm1'];

				}
				else{
						$urut_antri="0001";
						$norm=$huruf."-".$urut_antri;
						}

			$SQL = mysqli_query($con,
								"INSERT INTO pasien SET
										norm='$norm',
										nm_pasien='$nm_pasien',
										kk_pasien='$kk_pasien',
										alamat_pasien='$alamat_pasien',
										hp_pasien='$hp_pasien',
										jenis_kelamin='$jenis_kelamin',
										tgllahir_pasien='$tgllahir_pasien'

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

			$nm_pasien=mysqli_real_escape_string($con,$_POST['nm_pasien']);
			$kk_pasien=mysqli_real_escape_string($con,$_POST['kk_pasien']);
			$alamat_pasien=mysqli_real_escape_string($con,$_POST['alamat_pasien']);
			$hp_pasien=mysqli_real_escape_string($con,$_POST['hp_pasien']);
			$jenis_kelamin=mysqli_real_escape_string($con,$_POST['jenis_kelamin']);
			$tgllahir_pasien=mysqli_real_escape_string($con,$_POST['tgllahir_pasien']);

			$SQL = mysqli_query($con,
									"UPDATE pasien SET
											nm_pasien='$nm_pasien',
											kk_pasien='$kk_pasien',
											alamat_pasien='$alamat_pasien',
											hp_pasien='$hp_pasien',
											jenis_kelamin='$jenis_kelamin',
											tgllahir_pasien='$tgllahir_pasien'

										where norm='$norm'
								");
				if($SQL){
										echo json_encode(array('tipe'=>'sukses', 'msg' => 'Edit Berhasil'));
								}
				else {
										echo json_encode(array('tipe'=>'gagal', 'msg' => 'Edit Gagal, Cek kembali data'));
								}
			break;


		case "daftarantrian":

		$norm=mysqli_real_escape_string($con,$_POST['norm']);
		$poli=mysqli_real_escape_string($con,$_POST['poli']);
		$tgl_now=date("Y-m-d");

		//get no. urut_antri
		$x = mysqli_query($con,"SELECT IFNULL(MAX(urut_antri),0) AS urut_antri FROM antrian WHERE poli= '$poli'
										AND DATE(tgl_antri) = '$tgl_now' ");
						if(mysqli_num_rows($x)) {
							$rslt = mysqli_fetch_array($x);
							$klinikAntri = intval($rslt["urut_antri"]);
							$klinikAntri++;
						}
						else {
							$klinikAntri = 1;
						}
				$SQL = mysqli_query($con,
								"INSERT INTO antrian SET
										norm_antri='$norm',
										poli='$poli',
										urut_antri='$klinikAntri',
										tgl_antri='$tgl_now',
										status_antri=1

							");
			if($SQL){
									echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil Dafatr'));
							}
			else {
									echo json_encode(array('tipe'=>'gagal', 'msg' => 'GAGAL DAFTAR'));
							}
		break;

	}

?>
