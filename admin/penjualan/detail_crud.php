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
		case "tambahjual":

				$tgl=date('Ym').".";
				$no_nota='APT'.$tgl;
				$rj=mysqli_num_rows(mysqli_query($con,"SELECT no_nota FROM penjualan where no_nota like '$no_nota%' order by no_nota desc LIMIT 1 "));
				if($rj==0)
						{
								$urut="0001";
								$no_nota=$no_nota.$urut;
						}
						else{

										$xj = mysqli_fetch_array(mysqli_query($con,"SELECT CONCAT('$no_nota', LPAD((RIGHT(MAX(no_nota),4)+1),4,'0')) as no_nota
														FROM penjualan where no_nota like '$no_nota%' "));
										$no_nota=$xj['no_nota'];
								}
					$id_penj=mysqli_query($con,"SELECT ifnull (max(id_penjualan)+1,1) as id_penjualan from penjualan");
					$idp=mysqli_fetch_array($id_penj);
					$id_penjualan=$idp['id_penjualan'];
					$id_karyawan=$_SESSION['id_karyawan'];

					$SQL=mysqli_query($con,"INSERT INTO penjualan(id_penjualan,no_nota,status_jual,id_karyawan,print_jual)
								values ('$id_penjualan','$no_nota','chart','$id_karyawan','0')");
					if($SQL){
											echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil menambahkan','id'=>$id_penjualan));
									}
					else {
											echo json_encode(array('tipe'=>'gagal', 'msg' => 'gagal menambahkan'));
									}

			break;

		case "hapus":
					$id_penjualan=mysqli_real_escape_string($con,$_POST['id_penjualan']);
					$id_detailjual=mysqli_real_escape_string($con,$_POST['id_detailjual']);
							$d=mysqli_query($con,"SELECT id_produk,qty_jual from penjualan_detail
											where id_detailjual='$id_detailjual'");
							$h=mysqli_fetch_array($d);
							$id_produk=$h['id_produk'];
							$qty_jual=$h['qty_jual'];
					$SQL = mysqli_query($con, "DELETE from penjualan_detail
												WHERE id_detailjual='$id_detailjual' and id_penjualan='$id_penjualan'");
					if($SQL){
							  //kembalikan stok
								mysqli_query($con,"UPDATE obat set stok_obat=stok_obat+$qty_jual where id_obat='$id_produk' ");
								echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil hapus'));
					}
					else {
																		echo json_encode(array('tipe'=>'gagal', 'msg' => 'gagal hapus'));
																}
			break;

		case "tambahkan":

				$id_penjualan=mysqli_real_escape_string($con,$_POST['id_penjualan']);
				$jml=mysqli_real_escape_string($con,$_POST['jml']);
				$kd_item=mysqli_real_escape_string($con,$_POST['kd_item']);
				$harga=preg_replace('/\D/', '', mysqli_real_escape_string($con,$_POST['harga']));
				$diskon=preg_replace('/\D/', '', mysqli_real_escape_string($con,$_POST['diskon']));

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
							$kurangi=$query=mysqli_query($con,"UPDATE obat set stok_obat=stok_obat-'$jml' where id_obat='$kd_item'");
						}
				}
				else{}

				$SQL = mysqli_query($con,	" INSERT into penjualan_detail set
													id_penjualan='$id_penjualan',
													hpp_jual='$hpp_obat',
													id_produk='$kd_item',
													qty_jual='$jml',
													hrg_jual='$harga',
													diskon_jual='$diskon'
													");
				$total =mysqli_query($con,"SELECT sum(hrg_jual*qty_jual) as total, sum(qty_jual*diskon_jual) as diskon
								FROM penjualan_detail where id_penjualan='$id_penjualan' group by id_penjualan");
				$t=mysqli_fetch_array($total);
				$stotal=$t['total'];
				$diskon=$t['diskon'];

				if($SQL){
										echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil menambahkan','total'=>$stotal,'diskon'=>$diskon));
								}
				else {
										echo json_encode(array('tipe'=>'gagal', 'msg' => 'gagal menambahkan','total'=>$stotal,'diskon'=>$diskon));
								}
		break;

		case "gettotal":

				$id_penjualan=mysqli_real_escape_string($con,$_POST['id_penjualan']);

				$bayar =mysqli_query($con,"SELECT bayar_customer
								FROM penjualan where id_penjualan='$id_penjualan'");
				$b=mysqli_fetch_array($bayar);
				$bayar_customer=$b['bayar_customer'];

				$total =mysqli_query($con,"SELECT sum(hrg_jual*qty_jual) as total, sum(qty_jual*diskon_jual) as diskon
								FROM penjualan_detail where id_penjualan='$id_penjualan' group by id_penjualan");
				$t=mysqli_fetch_array($total);
				$stotal=$t['total'];
				$diskon=$t['diskon'];

				if($total){
										echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil menambahkan','total'=>$stotal,'diskon'=>$diskon,'bayar_customer'=>$bayar_customer));
								}
				else {
										echo json_encode(array('tipe'=>'gagal', 'msg' => 'gagal menambahkan','total'=>$stotal,'diskon'=>$diskon,'bayar_customer'=>$bayar_customer));
								}
		break;

		case "updatepetugas":

				$id_petugas=mysqli_real_escape_string($con,$_POST['id_petugas']);
				$id_penjualan=mysqli_real_escape_string($con,$_POST['id_penjualan']);

				$cekprint=mysqli_query($con,"SELECT print_jual from penjualan where id_penjualan='$id_penjualan'");
				$hcek=mysqli_fetch_array($cekprint);
				$print_jual=$hcek['print_jual'];
				if ($print_jual=='0') {
						$SQL = mysqli_query($con,
										"UPDATE penjualan SET
												id_karyawan='$id_petugas'
												where id_penjualan='$id_penjualan'

									");
						if($SQL){
												echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil UPDATE'));
										}
						else {
												echo json_encode(array('tipe'=>'gagal', 'msg' => 'GAGAL GANTI petugas , silahkan refresh'));
										}
				}
				else {
											echo json_encode(array('tipe'=>'gagal', 'msg' => 'Sudah pernah di print, tidak bisa diganti'));
				}

		break;

		case "bayarjual":

				$id_penjualan=mysqli_real_escape_string($con,$_POST['id_penjualan']);
				$bayar=mysqli_real_escape_string($con,$_POST['nombayar']);

				$SQL=mysqli_query($con,"UPDATE penjualan set bayar_customer='$bayar' where id_penjualan='$id_penjualan'");

				if($SQL){
										echo json_encode(array('tipe'=>'sukses', 'msg' => 'Berhasil menjumlahkan'));
								}
				else {
										echo json_encode(array('tipe'=>'gagal', 'msg' => 'gagal menjumlahkan'));
								}
		break;

	}

?>
