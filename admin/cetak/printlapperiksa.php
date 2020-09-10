<?php
		session_start();
    if(!isset($_SESSION['level'])){
        echo"<script> document.location = '../index.php'; </script>";
    }
    elseif ($_SESSION['level']!=="admin") {
        echo"<script> document.location = '../index.php?page=dashboard'; </script>";
    }

define('_VALID_ACCESS', true);
include('../config/mysqliserver.php');
$id_cabang=$_SESSION['id_cabang'];
$tgl_awal=mysqli_real_escape_string($con,$_GET['tgl_awal']);
$tgl_akhir=mysqli_real_escape_string($con,$_GET['tgl_akhir']);
$tampil_tawal=date("d-m-Y",strtotime($tgl_awal));
$tampil_takhir=date("d-m-Y",strtotime($tgl_akhir));

	$klinik=mysqli_query($con,"SELECT nm_cabang,alamat_cabang from cabang where id_cabang=$id_cabang");
	$kl=mysqli_fetch_array($klinik);
	$nm_cabang=$kl['nm_cabang'];
	$alamat_cabang=$kl['alamat_cabang'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		  <link rel="shortcut icon" href="../../img/mlm.png">
			<link href="../../admin/plugins/bootstrap 4/css/bootstrap.min.css" rel="stylesheet">
			<link href="../../admin/plugins/css/style.css" rel="stylesheet">
				<!--
				<style>
						#content{
							margin:20px auto;
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
				</style> -->
		<title>Laporan Periksa <?php echo $tgl_awal." - ".$tgl_akhir?></title>
	</head>
	<body>
	<div id="container" class="container">
		<div id="content" class="center">
			<br>
			<h3><?php echo $nm_cabang;?></h3>
			<p class="center"><?php echo $alamat_cabang;?></p>
			<h3><?php echo "Laporan Periksa ".$tampil_tawal." s/d ".$tampil_takhir;?></h3>
					<?php
							$poli=mysqli_query($con,"SELECT poli_id,nama_poli from periksa as a inner join poli as b on a.poli_id=b.kode_poli
										where (date(tgl_periksa) between '$tgl_awal' and '$tgl_akhir')
							 			group by poli_id
										order by urut asc ");
							while ($pol=mysqli_fetch_array($poli)) {
									$poli_id=$pol['poli_id'];
									$nama_poli=$pol['nama_poli'];
									?>
									<h3 class="left"><?php echo $nama_poli?></h3>
									<table border='1' style="width: 100%;">
								      <h3>
								      <thead><tr>
										      <td align="center" width=30><b>No.</b></td>
										      <td align="center" width=100><b>NO.NOTA</b></td>
										      <td align="center" width=90><b>Tanggal</b></td>
										      <td align="center" width=280><b>ITEM</b></td>
										      <td align="center" width=30><b>QTY</b></td>
										      <td align="center" width=30><b>Harga</b></td>
										      <td align="center" width=90><b>Diskon</b></td>
										      <td align="center" width=90><b>Subtotal</b></td>
													<td align="center" width=90><b>HPP</b></td>
										      <td align="center" width=90><b>Laba</b></td>

										      </tr>
												</thead>

								      <tbody >

								      <?php

								      $nomor=1;
								      $d = mysqli_query($con,"SELECT id_periksa,tgl_periksa,jenis_detail, nm_obat,hpp_periksa, hjual_periksa,qty_periksa,diskon_detail
																			from periksa as a
																			inner join periksa_detail as b on a.id_periksa=b.periksa_id
																			inner join obat as c on b.id_produk=c.id_obat
																			where (date(tgl_periksa) between '$tgl_awal' and '$tgl_akhir') and poli_id='$poli_id'
																			order by tgl_periksa asc");
								      while($fieldtable=mysqli_fetch_array($d)){
											      $id_periksa= $fieldtable['id_periksa'];
											      $tgl_periksa= $fieldtable['tgl_periksa'];
											      $tgl=date("d-m-Y",strtotime($tgl_periksa));
											      $jenis_detail=$fieldtable['jenis_detail'];
											      $nm_obat=$fieldtable['nm_obat'];
														$hjual_periksa=$fieldtable['hjual_periksa'];
											      $hpp_periksa=$fieldtable['hpp_periksa'];
											      $qty_periksa=$fieldtable['qty_periksa'];
											      $diskon_detail=$fieldtable['diskon_detail'];
														$hpp=$qty_periksa*$hpp_periksa;
											      $total_jual=($hjual_periksa-$diskon_detail)*$qty_periksa;
														$laba=$total_jual-$hpp;
								      ?>
								      <tr>
								          <td align="center"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3> <?php echo $nomor; ?></FONT></td>
								          <td align="left"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3> <?php echo $id_periksa; ?></FONT></td>
								          <td align="center"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3> <?php echo $tgl; ?></FONT></td>
								          <td align="left"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3> <?php echo $nm_obat; ?></FONT></td>
								          <td align="center"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3> <?php echo $qty_periksa; ?></FONT></td>
								          <td align="right"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3> <?php echo number_format($hjual_periksa,0,".","."); ?></FONT></td>
								          <td align="right"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3> <?php echo number_format($diskon_detail,0,".","."); ?></FONT></td>
													<td align="right"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3> <?php echo number_format($total_jual,0,".","."); ?></FONT></td>
													<td align="right"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3> <?php echo number_format($hpp,0,".","."); ?></FONT></td>
								          <td align="right"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3> <?php echo number_format($laba,0,".","."); ?></FONT></td>
								          </tr>
								      <?php
								      $nomor=$nomor+1;
								      }
								      ?>
								      <!-- TOTAL   -->
								      <?php
								      $totalp = mysqli_query($con,"SELECT
																						sum(b.hpp_periksa*b.qty_periksa) as thpp,
																						sum(b.hjual_periksa*b.qty_periksa) as stotal,
																						sum(b.diskon_detail*b.qty_periksa) as sdiskon
																			from periksa as a
																			inner join periksa_detail as b on a.id_periksa=b.periksa_id
																			inner join obat as c on b.id_produk=c.id_obat
																			where (date(tgl_periksa) between '$tgl_awal' and '$tgl_akhir') and poli_id='$poli_id'
																			order by id_periksadetail asc; ");
								      $total_p = mysqli_fetch_array($totalp);
											$thpp= $total_p['thpp'];
											$stotal= $total_p['stotal'];
											$sdiskon= $total_p['sdiskon'];
											$laba= $stotal-$sdiskon-$thpp;
								      ?>
								      <tr>
								          <td colspan="5" align="center"><b>Jumlah</b></td>
								          <td align="center"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3><b></b></FONT></td>
													<td align="right"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3><b></FONT></td>
													<td align="right"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3><b><?php echo "Rp ".number_format($stotal-$sdiskon,0,".","."); ?> </b></FONT></td>
													<td align="right"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3><b><?php echo "Rp ".number_format($thpp,0,".","."); ?> </b></FONT></td>
								          <td align="right"><FONT COLOR=BLACK FACE="Times New Roman" SIZE=3><b><?php echo "Rp ".number_format($laba,0,".","."); ?> </b></FONT></td>
								          </tr>
								      </tbody>
										</table>
										<br>
						<?php	}
					 ?>
			</div>

<script>

  window.load = print_d();
  function print_d(){
   //window.print();
  }
/*
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
       url: "../bdata/j_cetak.php",
       dataType: 'json',
       data: {id: id},
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
	*/
</script>

</body>
</html>
