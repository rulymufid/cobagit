<?php
define('_VALID_ACCESS', true);
include('../config/mysqliserver.php');
$id_penjualan=mysqli_real_escape_string($con,$_GET['id']);

	$qklinik=mysqli_query($con,"SELECT nm_apotek,alamat_cabang from cabang");
	$qk=mysqli_fetch_array($qklinik);
	$nm_klinik=$qk['nm_apotek'];
	$alamat_klinik=$qk['alamat_cabang'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		  <link rel="shortcut icon" href="../../img/mlm.png">
			<link href="../../admin/plugins/bootstrap 4/css/bootstrap.min.css" rel="stylesheet">
			<link href="../../admin/plugins/css/print_nota.css" rel="stylesheet">

		<title>Nota Penjualan Pemeriksaan</title>
	</head>
	<body>
		<?php
		$qheader = mysqli_query($con,"SELECT no_nota,tgl_jual,nm_karyawan from penjualan
							inner join karyawan on penjualan.id_karyawan=karyawan.id_karyawan
							where id_penjualan='$id_penjualan'");
		$rh = mysqli_fetch_array($qheader);
		$no_nota=$rh['no_nota'];
		$tgl_jual=$rh['tgl_jual'];
		$nm_karyawan=$rh['nm_karyawan'];

		// <!-- ==========================TOTAL -->
		$MBAYAR = mysqli_query($con,"SELECT sum(hrg_jual*qty_jual) as total, sum(diskon_jual*qty_jual) as diskon from penjualan_detail
						 inner join obat on penjualan_detail.id_produk=obat.id_obat
						 where id_penjualan='$id_penjualan'");

		$byr = mysqli_fetch_array($MBAYAR);
			 $total =number_format($byr['total'], 0, ".", ".");
			 $diskon =number_format($byr['diskon'], 0, ".", ".");
			 $jumbayar=$byr['total']-$byr['diskon'];
			 $jbayar =number_format($jumbayar, 0, ".", ".");

		?>
			<br>
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="nota">
								<div class="header">
										<h5 class="center"><?php echo $nm_klinik."<br>";?></h5>
										<h6 class="center"><?php echo $alamat_klinik."<br>";?></h6>
								</div>
								<div class="isi">
								<table width="100%" border="0" cellpadding="1" cellspacing="1" style="font-size:14px">
									<tr>
										<td>&nbsp;</td>
										<td align="right"><?php echo $no_nota; ?></td>
									</tr>
									</table>
									<table width="100%" border="0" cellpadding="1" cellspacing="1" style="font-size:14px">
												<tr><td colspan="3"><hr /></td></tr>
												<?php
										    $mtotal=0;
										    $mdiskon = 0;

										    //JASA
												$qjasa = mysqli_query($con,"SELECT b.nm_obat,a.hjual_periksa,a.qty_periksa, b.jenis_obat
					                                    from periksa_detail as a inner join obat as b on a.id_produk=b.id_obat
					                                    where periksa_id='$id_penjualan' and b.jenis_obat!='OBAT'");
												while($rd = mysqli_fetch_array($qjasa)) {
													$nm_obat = $rd['nm_obat'];
					                $qty_periksa = $rd['qty_periksa'];
					                $hjual_periksa = $rd['hjual_periksa'];
					                $stotal_periksa = $qty_periksa*$hjual_periksa;
													echo "	<tr>
										          			<td width=\"51%\" align=\"left\">".$nm_obat."</td>
										          			<td colspan=\"2\" align=\"right\">".number_format($stotal_periksa, 0, ".", ".")."</td>
										        			</tr>";
										  	}

					              //OBAT
												$t_obat = mysqli_query($con,"SELECT b.nm_obat,a.hrg_jual,a.qty_jual,a.diskon_jual
					                          from penjualan_detail as a
					                          inner join obat as b on a.id_produk=b.id_obat
					                          where id_penjualan='$id_penjualan'");
												while($to = mysqli_fetch_array($t_obat)) {
					                $nm_obat = $to['nm_obat'];
					                $hrg_jual = $to['hrg_jual'];
					                $qty_jual = $to['qty_jual'];
													$diskon_jual = $to['diskon_jual'];
					                $total_obat=$hrg_jual*$qty_jual;
													echo "	<tr>
					                          <td align=\"left\">".$nm_obat."</td>
					                          <td width=\"24%\" align=\"left\">".$qty_jual."x".number_format($hrg_jual, 0, ".", ".")."</td>
					                          <td width=\"25%\" align=\"right\">".number_format($total_obat, 0, ".", ".")."</td>
										        			</tr>";
										  	}

										    ?>
									<!-- ==========================TOTAL -->

									<tr><td colspan="3"><hr /></td></tr>
									<tr>
									<td align="left">&nbsp;</td>
									<td width="24%" align="left">Subtotal</td>
									<td width="25%" align="right"><?php echo $total?></td>
									<!--<td width="25%" align="right"></td>-->
									</tr>
									<tr>
									<td>&nbsp;</td>
									<td>Diskon</td>
									<td align="right"> <?php echo $diskon?></td>
										<!--<td align="right"></td>-->
									</tr>
									<tr>
									<td>&nbsp;</td>
									<td colspan="2"><hr /></td>
									</tr>
									<tr>
									<td>&nbsp;</td>
									<td>Total</td>
									<td align="right"><?php echo $jbayar?></td>
												</tr>
									</table>
								</div>

								<div class="footer">
										<a><?php echo "Lembar untuk pelanggan ".$tgl_jual; ?></a>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6">
								<div class="nota">
									<div class="header">
											<h5 class="center"><?php echo $nm_klinik."<br>";?></h5>
											<h6 class="center"><?php echo $alamat_klinik."<br>";?></h6>
									</div>
									<div class="isi">
									<table width="100%" border="0" cellpadding="1" cellspacing="1" style="font-size:14px">
										<tr>
											<td>&nbsp;</td>
											<td align="right"><?php echo $no_nota; ?></td>
										</tr>
										</table>
										<table width="100%" border="0" cellpadding="1" cellspacing="1" style="font-size:14px">
													<tr><td colspan="3"><hr /></td></tr>
													<?php
											    $mtotal=0;
											    $mdiskon = 0;

											    //JASA
													$qjasa = mysqli_query($con,"SELECT b.nm_obat,a.hjual_periksa,a.qty_periksa, b.jenis_obat
						                                    from periksa_detail as a inner join obat as b on a.id_produk=b.id_obat
						                                    where periksa_id='$id_penjualan' and b.jenis_obat!='OBAT'");
													while($rd = mysqli_fetch_array($qjasa)) {
														$nm_obat = $rd['nm_obat'];
						                $qty_periksa = $rd['qty_periksa'];
						                $hjual_periksa = $rd['hjual_periksa'];
						                $stotal_periksa = $qty_periksa*$hjual_periksa;
														echo "	<tr>
											          			<td width=\"51%\" align=\"left\">".$nm_obat."</td>
											          			<td colspan=\"2\" align=\"right\">".number_format($stotal_periksa, 0, ".", ".")."</td>
											        			</tr>";
											  	}

						              //OBAT
													$t_obat = mysqli_query($con,"SELECT b.nm_obat,a.hrg_jual,a.qty_jual,a.diskon_jual
						                          from penjualan_detail as a
						                          inner join obat as b on a.id_produk=b.id_obat
						                          where id_penjualan='$id_penjualan'");
													while($to = mysqli_fetch_array($t_obat)) {
						                $nm_obat = $to['nm_obat'];
						                $hrg_jual = $to['hrg_jual'];
						                $qty_jual = $to['qty_jual'];
														$diskon_jual = $to['diskon_jual'];
						                $total_obat=$hrg_jual*$qty_jual;
														echo "	<tr>
						                          <td align=\"left\">".$nm_obat."</td>
						                          <td width=\"24%\" align=\"left\">".$qty_jual."x".number_format($hrg_jual, 0, ".", ".")."</td>
						                          <td width=\"25%\" align=\"right\">".number_format($total_obat, 0, ".", ".")."</td>
											        			</tr>";
											  	}

											    ?>
										<!-- ==========================TOTAL -->

										<tr><td colspan="3"><hr /></td></tr>
										<tr>
										<td align="left">&nbsp;</td>
										<td width="24%" align="left">Subtotal</td>
										<td width="25%" align="right"><?php echo $total?></td>
										<!--<td width="25%" align="right"></td>-->
										</tr>
										<tr>
										<td>&nbsp;</td>
										<td>Diskon</td>
										<td align="right"> <?php echo $diskon?></td>
											<!--<td align="right"></td>-->
										</tr>
										<tr>
										<td>&nbsp;</td>
										<td colspan="2"><hr /></td>
										</tr>
										<tr>
										<td>&nbsp;</td>
										<td>Total</td>
										<td align="right"><?php echo $jbayar?></td>
													</tr>
										</table>
									</div>

									<div class="footer">
											<a><?php echo $tgl_jual; ?></a>
									</div>
								</div>
							</div>

			</div>


<script>

  window.load = print_d();
  function print_d(){
   window.print();
  }

	var ok;
  function before(id){
    if (confirm('Status Cetak akan bertambah 1, tekan Ok Jika mau cetak!i')) {
          ok = true   ;
      } else {
          ok = false ;
		  document.body.style.display = "none";
		  window.location.href=window.location.pathname + "?id=" +id;
      }
  }

	function jprint(id){
  	if ( ok ) {
    $.ajax({
       type: "POST",
       url: "../cetak/jml_cetak.php",
       dataType: 'json',
       data: {id: id,type:"penjualan"},
       success: function(res) {
         if (res.msg=='gagal') {
           alert('GAGAL HITUNG PRINT :'+res.msg);
         }
         else {

          }

       }
 	 });
	} else {
		return ;
	}
  }

</script>

</body>
</html>
