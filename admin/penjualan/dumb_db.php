<?php

	//Connection Database
	include "../config/mysqliserver.php";

	$x=834;

	while ($x <= 1000) {
		//buat norm
		$mj = mysqli_query($con,"SELECT CONCAT('APT202002.', LPAD((RIGHT(MAX(no_nota),4)+1),4,'0')) as no_nota FROM penjualan where no_nota like 'APT202002.%' ");
		$xj = mysqli_fetch_assoc($mj);
		$no_nota=$xj['no_nota'];

		$insert = mysqli_query($con,
							"INSERT INTO penjualan SET
									id_penjualan=$x,
									no_nota='$no_nota',
									id_karyawan='PERAWAT002'
							");

		if ($insert) {
				$d=1;
				while ($d <= 3) {
					$insertd = mysqli_query($con,
										"INSERT INTO penjualan_detail SET
												id_penjualan='$x',
												id_produk='$d+4',
												hpp_jual='1000',
												hrg_jual='1500',
												qty_jual='$d'
										");
										$d++;
				}
			// code...
		}
		else {
			// code...
		}
		$x++;
	}

?>
