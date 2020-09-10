	<?php
		/**
			* Script:    DataTables server-side script for PHP 5.2+ and MySQL 4.1+
			* Notes:     Based on a script by Allan Jardine that used the old PHP mysql_* functions.
			*            Rewritten to use the newer object oriented mysqli extension.
			* Copyright: 2010 - Allan Jardine (original script)
			*            2012 - Kari Söderholm, aka Haprog (updates)
			* License:   GPL v2 or BSD (3-point)
		*/
		//session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT'])));
		session_start();
		$id_user=$_SESSION['id_user'];

		mb_internal_encoding('UTF-8');
		include "../config/mysqliserver.php";

			$aColumns = array( 'id_penjualan','no_nota', 'nm_karyawan', 'tgl_jual' , 'print_jual' ); //Kolom Pada Tabel

		// Indexed column (used for fast and accurate table cardinality)
		$sIndexColumn = 'id_penjualan';

		$sTable = 'penjualan'; // Nama Tabel

		if (isset($_GET['tgl_awal'])) {
					$tgl_awal=$_GET['tgl_awal'];
					$tgl_akhir=$_GET['tgl_akhir'];
					$where_tgl=" WHERE date(tgl_jual) between '$tgl_awal' and '$tgl_akhir'";
		}
		else {
			   $where_tgl=" ";
				/* $where_tgl="WHERE date(tgl_jual)=curdate()"; */
		}



		/**
			* Paging
		*/
		$sLimit = "";
		if ( isset( $input['iDisplayStart'] ) && $input['iDisplayLength'] != '-1' ) {
			$sLimit = " LIMIT ".intval( $input['iDisplayStart'] ).", ".intval( $input['iDisplayLength'] );
		}


		/**
			* Ordering
		*/
		$aOrderingRules = array();
		if ( isset( $input['iSortCol_0'] ) ) {
			$iSortingCols = intval( $input['iSortingCols'] );
			for ( $i=0 ; $i<$iSortingCols ; $i++ ) {
				if ( $input[ 'bSortable_'.intval($input['iSortCol_'.$i]) ] == 'true' ) {
					$aOrderingRules[] =
	                "`".$aColumns[ intval( $input['iSortCol_'.$i] ) ]."` "
	                .($input['sSortDir_'.$i]==='desc' ? 'asc' : 'desc');
				}
			}
		}

		if (!empty($aOrderingRules)) {
			$sOrder = " ORDER BY ".implode(", ", $aOrderingRules);
			} else {
			$sOrder = "";
		}


		/**
			* Filtering
			* NOTE this does not match the built-in DataTables filtering which does it
			* word by word on any field. It's possible to do here, but concerned about efficiency
			* on very large tables, and MySQL's regex functionality is very limited
		*/
		$iColumnCount = count($aColumns);

		if ( isset($input['sSearch']) && $input['sSearch'] != "" ) {
			$aFilteringRules = array();
			for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
				if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' ) {
					$aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$db->real_escape_string( $input['sSearch'] )."%'";
				}
			}
			if (!empty($aFilteringRules)) {
				$aFilteringRules = array('('.implode(" OR ", $aFilteringRules).')');
			}
		}


//filter
		if (!empty($aFilteringRules)) {
			$sWhere = $where." ".implode(" AND ", $aFilteringRules);
			} else {
			$sWhere = $where_tgl." ";
		}



		/**
			* SQL queries
			* Get data to display
		*/
		$aQueryColumns = array();
		foreach ($aColumns as $col) {
			if ($col != ' ') {
				$aQueryColumns[] = $col;
			}
		}

		$sQuery = "SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", $aQueryColumns)."`
					from penjualan as a inner join karyawan as b on a.id_karyawan=b.id_karyawan
			    ".$sWhere.$sOrder.$sLimit;

		$rResult = $db->query( $sQuery ) or die($db->error);

		// Data set length after filtering
		$sQuery = "SELECT FOUND_ROWS()";
		$rResultFilterTotal = $db->query( $sQuery ) or die($db->error);
		list($iFilteredTotal) = $rResultFilterTotal->fetch_row();

		// Total data set length
		$sQuery = "SELECT COUNT(`".$sIndexColumn."`)
					from penjualan as a inner join karyawan as b on a.id_karyawan=b.id_karyawan";
		$rResultTotal = $db->query( $sQuery ) or die($db->error);
		list($iTotal) = $rResultTotal->fetch_row();


		/**
			* Output
		*/
		$output = array(
	    "sEcho"                => intval($input['sEcho']),
	    "iTotalRecords"        => $iTotal,
	    "iTotalDisplayRecords" => $iFilteredTotal,
	    "aaData"               => array(),
		);
		// Looping Data
		while ( $aRow = $rResult->fetch_assoc() ) {
			$row = array();
			$id_penjualan=$aRow['id_penjualan'];
			$obat="";
			$qdetail=mysqli_query($con,"SELECT nm_obat
							from penjualan_detail as a inner join obat as b on a.id_produk=b.id_obat
							 where id_penjualan='$id_penjualan'");
			while ($detail=mysqli_fetch_array($qdetail)) {
				  $nm_obat=$detail['nm_obat'];
					$obat=$obat."".$nm_obat.", ";
			}
			$btn = '
					<span data-placement="top" data-toggle="tooltip" title="Detail">
																						<a class="btn btn-success btn-xs" href="index.php?page=detailpj&id='.$aRow['id_penjualan'].'">
																							<span class="glyphicon glyphicon-th-list"></span>
																						</a>
																					 </span>


									<span data-placement="top" data-toggle="tooltip" title="Print">
																						<a class="btn btn-info btn-xs" onClick="print(\''.$aRow['id_penjualan'].'\')">
																							<span class="glyphicon glyphicon-print"></span>
																						</a>
																					 </span>

									';


			for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
				$row[] = $aRow[ $aColumns[$i] ];
			}
			$row = array( $btn, $aRow['no_nota'], $aRow['nm_karyawan'], $obat,$aRow['print_jual'],$aRow['tgl_jual'] );
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );

	?>
