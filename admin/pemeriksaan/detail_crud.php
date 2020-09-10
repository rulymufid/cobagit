<?php
	//session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT'])));
	session_start();

	if(!isset($_SESSION['level'])){
			//jika session belum di set/register
			echo"<script> document.location = '../index.php'; </script>";
	}

	//Connection Database
	include "../config/mysqliserver.php";
	$id_periksa=mysqli_real_escape_string($con,$_POST['id_periksa']);

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


		case "updatedokter":

				$id_dokter=mysqli_real_escape_string($con,$_POST['id_dokter']);


				$SQL = mysqli_query($con,
								"UPDATE periksa SET
										dokter_id='$id_dokter'
										where id_periksa='$id_periksa'

							");
				if($SQL){
										echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil UPDATE'));
								}
				else {
										echo json_encode(array('tipe'=>'gagal', 'msg' => 'GAGAL GANTI DOKTER , silahkan refresh'));
								}
		break;

		case "updateperawat":

				$id_perawat=mysqli_real_escape_string($con,$_POST['id_perawat']);


				$SQL = mysqli_query($con,
								"UPDATE periksa SET
										perawat_id='$id_perawat'
										where id_periksa='$id_periksa'

							");
				if($SQL){
										echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil UPDATE'));
								}
				else {
										echo json_encode(array('tipe'=>'gagal', 'msg' => 'GAGAL GANTI perawat , silahkan refresh'));
								}
		break;

		case "tambahkan":

				$id=mysqli_real_escape_string($con,$_POST['id_periksa']);
				$jml=mysqli_real_escape_string($con,$_POST['jml']);
				$kd_item=mysqli_real_escape_string($con,$_POST['kd_item']);
				$diskon=mysqli_real_escape_string($con,$_POST['diskon']);
				$harga=preg_replace('/\D/', '', mysqli_real_escape_string($con,$_POST['harga']));

					$query=mysqli_query($con,"SELECT nm_obat,hpp_obat,stok_obat,jenis_obat from obat where id_obat='$kd_item'");
					$hasil=mysqli_fetch_array($query);
					$nm_obat=$hasil['nm_obat'];
					$hpp_obat=$hasil['hpp_obat'];
					$stok_obat=$hasil['stok_obat'];
					$jenis_obat=$hasil['jenis_obat'];

				if ($jenis_obat=="OBAT") {
						if ($jml>$stok_obat) {
									echo json_encode(array('tipe'=>'gagal', 'msg' => 'stok tidak mencukupi'));
									exit();
						}
						else {
							//kurangi stok OBAT
							$kurangi=mysqli_query($con,"UPDATE obat set stok_obat=stok_obat-'$jml' where id_obat='$kd_item'");
						}
				}
				else{}

				$SQL = mysqli_query($con,	" INSERT into periksa_detail set
													periksa_id='$id',
													id_produk='$kd_item',
													qty_periksa='$jml',
													hpp_periksa='$hpp_obat',
													hjual_periksa='$harga',
													jenis_detail='$jenis_obat',
													diskon_detail='$diskon'
													");

							//kurangi stok
				if($SQL){
										echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil menambahkan'));
								}
				else {
										echo json_encode(array('tipe'=>'gagal', 'msg' => 'gagal menambahkan'));
								}
		break;

		case "hapusobat":
					$id_detail=mysqli_real_escape_string($con,$_POST['id_detail']);
					$id_periksa=mysqli_real_escape_string($con,$_POST['id_periksa']);

							$d=mysqli_query($con,"SELECT id_produk,qty_periksa from periksa_detail
											where id_periksadetail='$id_detail'");
							$h=mysqli_fetch_array($d);
							$id_produk=$h['id_produk'];
							$qty_periksa=$h['qty_periksa'];
					$SQL = mysqli_query($con, "DELETE from periksa_detail
												WHERE id_periksadetail='$id_detail' and periksa_id='$id_periksa'");
					if($SQL){
							  //kembalikan stok
								if(mysqli_query($con,"UPDATE obat set stok_obat=stok_obat+$qty_periksa where id_obat='$id_produk' ")){
									echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil hapus'));
								}
								else{
								echo json_encode(array('tipe'=>'gagal', 'msg' => 'gagal kembalikan stok'.$qty_periksa.' '.$id_produk));
							}
					}
					else {
																		echo json_encode(array('tipe'=>'gagal', 'msg' => 'gagal hapus'));
																}
			break;

			case "gettotal":

					$id_periksa=mysqli_real_escape_string($con,$_POST['id_periksa']);

					$bayar =mysqli_query($con,"SELECT bayar_pasien
									FROM periksa where id_periksa='$id_periksa'");
					$b=mysqli_fetch_array($bayar);
					$bayar_pasien=$b['bayar_pasien'];

					$total =mysqli_query($con,"SELECT sum(hjual_periksa*qty_periksa) as total, sum(qty_periksa*diskon_detail) as diskon
									FROM periksa_detail where periksa_id='$id_periksa' group by periksa_id");
					$t=mysqli_fetch_array($total);
					$stotal=$t['total'];
					$diskon=$t['diskon'];

					if($total){
											echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil menambahkan','total'=>$stotal,'diskon'=>$diskon,'bayar_pasien'=>$bayar_pasien));
									}
					else {
											echo json_encode(array('tipe'=>'gagal', 'msg' => 'gagal menambahkan','total'=>$stotal,'diskon'=>$diskon,'bayar_pasien'=>$bayar_pasien));
									}
			break;

			case "bulatkan":

								$id_periksa=mysqli_real_escape_string($con,$_POST['id_periksa']);
										//cek apakah ada sudah ada obat pembulatan
								$cek=mysqli_query($con,"SELECT id_obat from obat where nm_obat='PEMBULATAN'");
								$t=mysqli_num_rows($cek);
								if ($t>0) {
								}
								else{
										//insert pembulatan ke tabel obat
										$SQL = mysqli_query($con,	" INSERT into obat set
																			id_obat='0',
																			nm_obat='PEMBULATAN',
																			hpp_obat='0',
																			hjual_obat='0',
																			stok_obat='0',
																			jenis_obat='OBAT',
																			barcode=''
																			");
									$SQL = mysqli_query($con,	" UPDATE obat set id_obat='0' WHERE nm_obat='PEMBULATAN'
																												");
								}
										// total
										$total =mysqli_query($con,"SELECT sum(hjual_periksa*qty_periksa) as total, sum(qty_periksa*diskon_detail) as diskon
														FROM periksa_detail where periksa_id='$id_periksa' group by periksa_id");
										$t=mysqli_fetch_array($total);
										$stotal=$t['total'];
										$diskon=$t['diskon'];
										$total=$stotal-$diskon;

										$ratusan = substr($total, -3);
										$bulat = (1000-$ratusan);

										$SQL = mysqli_query($con,	" INSERT into periksa_detail set
																	periksa_id='$id_periksa',
																	id_produk='0',
																	qty_periksa='1',
																	hjual_periksa='$bulat',
																	jenis_detail='OBAT',
																	diskon_detail='0'
																			");
							if($total){
											echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil menambahkan','total'=>$stotal,'diskon'=>$diskon));
							}
							else {
											echo json_encode(array('tipe'=>'gagal', 'msg' => 'gagal menambahkan','total'=>$stotal,'diskon'=>$diskon));
							}

						break;

						case "bayarperiksa":

								$id_periksa=mysqli_real_escape_string($con,$_POST['id_periksa']);
								$bayar=mysqli_real_escape_string($con,$_POST['nombayar']);

								$SQL=mysqli_query($con,"UPDATE periksa set bayar_pasien='$bayar' where id_periksa='$id_periksa'");

								if($SQL){
														echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil menjumlahkan'));
												}
								else {
														echo json_encode(array('tipe'=>'gagal', 'msg' => 'gagal menjumlahkan'));
												}
						break;

	}

?>
