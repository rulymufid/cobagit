<?php
define('_VALID_ACCESS', true);
include('../config/mysqliserver.php');
$id_periksa=mysqli_real_escape_string($con,$_GET['id']);

	$qklinik=mysqli_query($con,"SELECT nm_cabang,alamat_cabang from cabang");
	$qk=mysqli_fetch_array($qklinik);
	$nm_klinik=$qk['nm_cabang'];
	$alamat_klinik=$qk['alamat_cabang'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			.isi{
					height: 450px;
			}
			#content{
				margin-left: 40px;
				width:21.5cm;
				background-color:transparent;
				font-family:"arial";
				font-size:13px;
			}

			#tbb{
				border: solid 1px #333333;
				font-family:"arial";
				font-size:13px;
			}

			#logo {
				position:absolute;
				left:10px;
				top:15px;
				height:79px;
				width:171px;
			}
			.col-print-1 {width:8%;  float:left;padding-left: 15px;}
	    .col-print-2 {width:16%; float:left;padding-left: 15px;}
	    .col-print-3 {width:25%; float:left;padding-left: 15px;}
	    .col-print-4 {width:33%; float:left;padding-left: 15px;}
	    .col-print-5 {width:42%; float:left;padding-left: 15px;}
	    .col-print-6 {width:50%; float:left;}
	    .col-print-7 {width:58%; float:left;padding-left: 15px;}
	    .col-print-8 {width:66%; float:left;}
	    .col-print-9 {width:75%; float:left;}
	    .col-print-10{width:83%; float:left;}
	    .col-print-11{width:92%; float:left;}
	    .col-print-12{width:100%; float:left;}
			.fcenter{
				font-family:"arial";
				font-size:13px;
				margin:5px 10px 0 10px;
				padding:2px 6px;
				text-align:center;
			}
			h1{
				font-size:18px;
				margin:0px 10px 0 10px;
				padding:2px 6px;
				text-align:center;
			}
			.center{
				text-align: center;
				margin-top: 5px;
    		margin-bottom: 5px;
			}
			.table {
				border-collapse:collapse;
				width:97%;
			  margin-top:5px;
			}
			.table th{
				border: 1px solid #110f0b;
				font-family:arial;
				font-size:12px;
				padding-left:2px;
				text-align:center;
				line-height: 15px;
				padding:4px 2px 2px 2px;
			}
			.table td{
				border: 1px solid #333333;
				font-family:arial;
				font-size:11px;
				padding-left:2px;
				text-align:justify;
				line-height: 13px;
			}
			.style1 {
				font-size: 14px;
				font-weight: bold;
			}
			#container {
		    background-color:transparent;
		    width:21.5cm;
		    height:14cm;
		    font-size:8px;
		    padding:5px 5px 5px 5px;
		    border:0px solid #ccc;
			}

			#huruf {
				font-size:8px;
			}
		</style>
		<title>Nota Penjualan Pemeriksaan</title>
	</head>
	<body>
		<?php
		//------
		echo "<div id='container'>";
		$qheader = mysqli_query($con,"SELECT a.id_periksa,a.pasien_norm,b.nm_pasien,b.alamat_pasien, c.nm_karyawan, a.tgl_periksa
                from periksa as a inner join pasien as b on a.pasien_norm=b.norm
                inner join karyawan as c on a.dokter_id=c.id_karyawan
                where a.id_periksa='$id_periksa'");
		$rh = mysqli_fetch_array($qheader);

		// <!-- ==========================TOTAL -->
		 $MBAYAR = mysqli_query($con,"SELECT sum(hjual_periksa*qty_periksa) as total,sum(diskon_detail) as diskon
								from periksa_detail
								where periksa_id='$id_periksa'");

		 $byr = mysqli_fetch_array($MBAYAR);
				$total =number_format($byr['total'], 0, ".", ".");
				$diskon =number_format($byr['diskon'], 0, ".", ".");
				$jumbayar=$byr['total']-$byr['diskon'];
				$jbayar =number_format($jumbayar, 0, ".", ".");

		?>
		<div id="content">
			<div class="header">
					<div class="col-print-6">
									<h3 class="center"><?php echo $nm_klinik."<br>";?></h3>
									<h5 class="center"><?php echo $alamat_klinik."<br>";?></h5>
					</div>
					<div class="col-print-6">
									<h3 class="center"><?php echo $nm_klinik."<br>";?></h3>
									<h5 class="center"><?php echo $alamat_klinik."<br>";?></h5>
					</div>
			</div>
			<div class="isi">
					<div class="col-print-6" style="height:400px!important;">
						<table width="100%" border="0" cellpadding="1" cellspacing="1" style="font-size:12px">
							<tr>
								<td>&nbsp;</td>
								<td align="right"><?php echo $id_periksa; ?></td></tr>
							<tr>
								<tr>
									<td width="28%">NO.RM</td>
									<td width="72%">: &nbsp;<?php echo"(". $rh['pasien_norm'].") - ".$rh['nm_pasien']; ?></td>
								</tr>
								<tr>
									<td>ALAMAT</td>
									<td>: &nbsp;<?php echo $rh['alamat_pasien'];?></td>
								</tr>
								<tr>
									<td>DOKTER</td>
									<td>: &nbsp;<?php echo $rh['nm_karyawan'];?></td>
								</tr>
							</table>
							<table width="100%" border="0" cellpadding="1" cellspacing="1" style="font-size:12px">
									  	<tr><td colspan="3">BIAYA<br /><hr /></td></tr>
							              <?php
							             $mtotal=0;
							             $mdiskon = 0;

													 //JASA
													 $qjasa = mysqli_query($con,"SELECT b.nm_obat,a.hjual_periksa,a.qty_periksa, b.jenis_obat
																								 from periksa_detail as a inner join obat as b on a.id_produk=b.id_obat
																								 where periksa_id='$id_periksa' and b.jenis_obat!='OBAT'");
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
													 $t_obat = mysqli_query($con,"SELECT sum(hjual_periksa*qty_periksa) as total_obat from periksa_detail
																								 where periksa_id='$id_periksa' and jenis_detail='OBAT' ");
													 while($to = mysqli_fetch_array($t_obat)) {
														 $total_obat = $to['total_obat'];
														 echo "	<tr>
																			 <td width=\"51%\" align=\"left\">BIAYA OBAT</td>
																			 <td colspan=\"2\" align=\"right\">".number_format($total_obat, 0, ".", ".")."</td>
																		 </tr>";
													 }
							             ?>
				             <!-- ==========================TOTAL -->

				             <tr><td colspan="3"><hr /></td></tr>
				             <tr>
				               <td align="left">&nbsp;Petugas Klinik,</td>
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
							<?php
							echo"<table style=\"font-size:10px\">";
							$rsCtr = 1;
						$rowDivide = 1;
						$beginRow = 1;
							$qd3=mysqli_query($con,"SELECT b.nm_obat,a.hjual_periksa,a.qty_periksa, b.jenis_obat
	                                  from periksa_detail as a inner join obat as b on a.id_produk=b.id_obat
	                                  where periksa_id='$id_periksa' and b.jenis_obat='OBAT' and id_obat!=0");

								while($rq3 = mysqli_fetch_array($qd3)) {
									$items3 = $rq3['nm_obat'].'('.$rq3['qty_periksa'].') ';
									if($beginRow == 1) {
										echo "<tr>";
										echo"<td align='left'>- $items3</td><td colspan='2'>&nbsp;</td>";
										$beginRow = 0;
									}
									else {
										echo"<td align='left'>- $items3</td>";
									}
									$rsCtr++;
									if($rsCtr > $rowDivide) {
										echo "</tr>";
										$beginRow = 1;
										$rsCtr = 1;
									}
									//echo"<tr><td>$items3</td></tr>";
								}
							echo"</table>";
							//end left
							//right begin
							?>
					</div>
					<div class="col-print-6" style="height:400px!important;">
						<table width="100%" border="0" cellpadding="1" cellspacing="1" style="font-size:12px">
							<tr>
								<td>&nbsp;</td>
								<td align="right"><?php echo $id_periksa; ?></td></tr>
							<tr>
								<tr>
									<td width="28%">NO.RM</td>
									<td width="72%">: &nbsp;<?php echo"(". $rh['pasien_norm'].") - ".$rh['nm_pasien']; ?></td>
								</tr>
								<tr>
									<td>ALAMAT</td>
									<td>: &nbsp;<?php echo $rh['alamat_pasien'];?></td>
								</tr>
								<tr>
									<td>DOKTER</td>
									<td>: &nbsp;<?php echo $rh['nm_karyawan'];?></td>
								</tr>
							</table>
							<table width="100%" border="0" cellpadding="1" cellspacing="1" style="font-size:12px">
									  	<tr><td colspan="3">BIAYA<br /><hr /></td></tr>
							              <?php
							             $mtotal=0;
							             $mdiskon = 0;

													 //JASA
													 $qjasa = mysqli_query($con,"SELECT b.nm_obat,a.hjual_periksa,a.qty_periksa, b.jenis_obat
																								 from periksa_detail as a inner join obat as b on a.id_produk=b.id_obat
																								 where periksa_id='$id_periksa' and b.jenis_obat!='OBAT'");
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
													 $t_obat = mysqli_query($con,"SELECT sum(hjual_periksa*qty_periksa) as total_obat from periksa_detail
																								 where periksa_id='$id_periksa' and jenis_detail='OBAT' ");
													 while($to = mysqli_fetch_array($t_obat)) {
														 $total_obat = $to['total_obat'];
														 echo "	<tr>
																			 <td width=\"51%\" align=\"left\">BIAYA OBAT</td>
																			 <td colspan=\"2\" align=\"right\">".number_format($total_obat, 0, ".", ".")."</td>
																		 </tr>";
													 }
							             ?>
				             <!-- ==========================TOTAL -->

				             <tr><td colspan="3"><hr /></td></tr>
				             <tr>
				               <td align="left">&nbsp;Petugas Klinik,</td>
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
							<?php
							echo"<table style=\"font-size:10px\">";
							$rsCtr = 1;
							$rowDivide = 1;
							$beginRow = 1;
							$qd3=mysqli_query($con,"SELECT b.nm_obat,a.hjual_periksa,a.qty_periksa, b.jenis_obat
	                                  from periksa_detail as a inner join obat as b on a.id_produk=b.id_obat
	                                  where periksa_id='$id_periksa' and b.jenis_obat='OBAT' and id_obat!=0");

								while($rq3 = mysqli_fetch_array($qd3)) {
									$items3 = $rq3['nm_obat'].'('.$rq3['qty_periksa'].') ';
									if($beginRow == 1) {
										echo "<tr>";
										echo"<td align='left'>- $items3</td><td colspan='2'>&nbsp;</td>";
										$beginRow = 0;
									}
									else {
										echo"<td align='left'>- $items3</td>";
									}
									$rsCtr++;
									if($rsCtr > $rowDivide) {
										echo "</tr>";
										$beginRow = 1;
										$rsCtr = 1;
									}
									//echo"<tr><td>$items3</td></tr>";
								}
							echo"</table>";
							//end left
							//right begin
							?>
					</div>
			</div>
			<div id="footer" style="font-size:12px">
				<p><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;
				<?php echo"Lembar Untuk Pelanggan         ". $rh['tgl_periksa']; ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php echo"". $rh['tgl_periksa']; ?>
			 </i></p></div>
		</div>

<script>

  //window.load = print_d();
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
       data: {id: id,type:"periksa"},
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
