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


		/**
			* Array of database columns which should be read and sent back to DataTables. Use a space where
			* you want to insert a non-database field (for example a counter or static image)
		*/
		$aColumns = array( 'id_obat','nm_obat','stok_obat','hpp_obat','hjual_obat' ); //Kolom Pada Tabel

		// Indexed column (used for fast and accurate table cardinality)
		$sIndexColumn = 'id_obat';

		// DB table to use
		$sTable = 'obat'; // Nama Tabel




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
			$sWhere = " WHERE (jenis_obat='JASA' or jenis_obat='TINDAKAN') and ".implode(" AND ", $aFilteringRules);
			} else {
			$sWhere = " WHERE (jenis_obat='JASA' or jenis_obat='TINDAKAN') ";
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

		$sQuery = "
	    SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", $aQueryColumns)."`
			from obat
			    ".$sWhere.$sOrder.$sLimit;

		$rResult = $db->query( $sQuery ) or die($db->error);

		// Data set length after filtering
		$sQuery = "SELECT FOUND_ROWS()";
		$rResultFilterTotal = $db->query( $sQuery ) or die($db->error);
		list($iFilteredTotal) = $rResultFilterTotal->fetch_row();

		// Total data set length
		$sQuery = "SELECT COUNT(`".$sIndexColumn."`)
		from obat";
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

		// Looping Data window.open(" adata/cetak.php?id='.$aRow['id_transaksi'].')
		while ( $aRow = $rResult->fetch_assoc() ) {
			$row = array();
			$btn = '
							<span data-placement="top" data-toggle="tooltip" title="EDIT">
								<a class="btn btn-success btn-xs" onclick="showmodals('.$aRow['id_obat'].')" >
											<span class="glyphicon glyphicon-pencil"></span>
										</a>
																									 </span
	            ';


			for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
				$row[] = $aRow[ $aColumns[$i] ];
			}


			$row = array( $aRow['id_obat'],$aRow['nm_obat'],$aRow['stok_obat'], number_format($aRow['hpp_obat'], 0, ".", "."),
							number_format($aRow['hjual_obat'], 0, ".", ".") ,$btn);
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );

	?>
