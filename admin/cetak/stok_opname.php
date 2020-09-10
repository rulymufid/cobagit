<?php
		define('_VALID_ACCESS', true);
		include('../config/mysqliserver.php');
		$tgl=date('d-m-Y  h:i:s a');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		  <link rel="shortcut icon" href="../../img/mlm.png">
			<link href="../../admin/plugins/bootstrap 4/css/bootstrap.min.css" rel="stylesheet">
			<link href="../../admin/plugins/css/print_nota.css" rel="stylesheet">

		<title>STOK OPNAME <?php echo $tgl;?></title>
	</head>
	<body>
			<br>
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
							<h3 class="center">STOK OPNAME <?php echo $tgl;?></h3><br>
							<table border='1' style="width:100%;">
											<thead><tr>
											<td align="center" width="10%">NO</td>
											<td align="center" width="50%">NAMA OBAT</td>
											<td align="center" width="10%">QTY</td>
											<td align="center" width="20%">Harga Jual</td>
											</tr></thead>
											<?php
													$stok=mysqli_query($con,"SELECT * FROM obat where stok_obat!=0 order by nm_obat asc ");
													$no=0;
													while($s=mysqli_fetch_array($stok)){
														  $no++;
															$nm_obat=$s['nm_obat'];
															$stok_obat=$s['stok_obat'];
															$hjual_obat=$s['hjual_obat'];
															echo '<tr>
															<td align="center" width="10%">'.$no.'</td>
															<td align="left" width="50%">'.$nm_obat.'</td>
															<td align="right" width="10%">'.$stok_obat.'</td>
															<td align="right" width="20%">'.number_format($hjual_obat,0,".",".").'</td>
														</tr>';
													}
											?>

							</table>
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
