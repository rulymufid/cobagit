<?php
	//session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT'])));
	session_start();

	if(!isset($_SESSION['level'])){
			//jika session belum di set/register
			echo"<script> document.location = '../index.php'; </script>";
	}

	//Connection Database
	include "../config/mysqliserver.php";


	switch (mysqli_real_escape_string($con,$_POST['type'])) {

		//Tampilkan Data
		case "get_antrian":
			$id_antrian=mysqli_real_escape_string($con,$_POST['id_antrian']);

			$SQL = mysqli_query($con, "SELECT * from antrian
										WHERE id_antrian='$id_antrian'");
			$return = mysqli_fetch_array($SQL,MYSQLI_ASSOC);
			echo json_encode($return);
			break;

		//edit antrian
		case "edit_antrian":
			$id_antrian=mysqli_real_escape_string($con,$_POST['id_antrian']);
			$poli=mysqli_real_escape_string($con,$_POST['poli']);

			$SQL = mysqli_query($con,
								"UPDATE antrian SET
										poli='$poli' where id='$id_antrian'

								");
			if($SQL){
					echo json_encode(array('tipe'=>'sukses', 'msg' => 'Input Berhasil'));
			}
			else {
					echo json_encode(array('tipe'=>'gagal', 'msg' => 'Input Gagal, Cek kembali data'));
			}
			break;

			//hapus anrian
			case "hapus_antrian":
				$id_antrian=mysqli_real_escape_string($con,$_POST['id_antrian']);
				$poli=mysqli_real_escape_string($con,$_POST['poli']);

				$SQL = mysqli_query($con,
									"DELETE from antrian where id='$id_antrian'

									");
				if($SQL){
						echo json_encode(array('tipe'=>'sukses', 'msg' => 'Input Berhasil'));
				}
				else {
						echo json_encode(array('tipe'=>'gagal', 'msg' => 'Input Gagal, Cek kembali data'));
				}
				break;

			//proses periksa
			case "periksa":
				$id_antrian=mysqli_real_escape_string($con,$_POST['id_antrian']);
				$norm=mysqli_real_escape_string($con,$_POST['norm']);
				$poli=mysqli_real_escape_string($con,$_POST['poli']);

				$SQL = mysqli_query($con,
									"UPDATE antrian SET
											status_antri='2' where id='$id_antrian'

									");
				if($SQL){


					$tgl=date('Ym').".";
				  $rj=mysqli_num_rows(mysqli_query($con,"SELECT id_periksa FROM periksa where id_periksa like '$tgl%' order by id_periksa desc LIMIT 1 "));
					if($rj==0)
							{
									$urut="0001";
									$id_periksa=$tgl.$urut;
							}
							else{

											$xj = mysqli_fetch_array(mysqli_query($con,"SELECT CONCAT('$tgl', LPAD((RIGHT(MAX(id_periksa),4)+1),4,'0')) as id_periksa
															FROM periksa where id_periksa like '$tgl%' "));
											$id_periksa=$xj['id_periksa'];
									}

						$periksa = mysqli_query($con,
											"INSERT INTO periksa set
												id_periksa='$id_periksa',
												pasien_norm='$norm',
												poli_id='$poli'
											");
						echo json_encode(array('tipe'=>'sukses', 'msg' => 'Input Berhasil'));
				}
				else {
						echo json_encode(array('tipe'=>'gagal', 'msg' => 'Input Gagal, Cek kembali data'));
				}
				break;


	}

?>
