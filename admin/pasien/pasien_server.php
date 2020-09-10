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
			$aColumns = array( 'hp_pasien','norm', 'nm_pasien','alamat_pasien', 'kk_pasien', 'tgllahir_pasien' ); //Kolom Pada Tabel

		// Indexed column (used for fast and accurate table cardinality)
		$sIndexColumn = 'norm';

		// DB table to use
		$sTable = 'pasien'; // Nama Tabel




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
			$sWhere = " WHERE ".implode(" AND ", $aFilteringRules);
			} else {
			$sWhere = "";
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
			from pasien
			    ".$sWhere.$sOrder.$sLimit;

		$rResult = $db->query( $sQuery ) or die($db->error);

		// Data set length after filtering
		$sQuery = "SELECT FOUND_ROWS()";
		$rResultFilterTotal = $db->query( $sQuery ) or die($db->error);
		list($iFilteredTotal) = $rResultFilterTotal->fetch_row();

		// Total data set length
		$sQuery = "SELECT COUNT(`".$sIndexColumn."`)
		from pasien";
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
			$btn = '
					<span data-placement="top" data-toggle="tooltip" title="Edit">
																						<a class="btn btn-success btn-xs" onClick="showmodals(\''.$aRow['norm'].'\')">
																							<span class="glyphicon glyphicon-pencil"></span>
																						</a>
																					 </span>


									<span data-placement="top" data-toggle="tooltip" title="Daftarkan Antrian">
																						<a class="btn btn-info btn-xs" onClick="antrian(\''.$aRow['norm'].'\')">
																							<span class="glyphicon glyphicon-hand-right"></span>
																						</a>
																					 </span>

									';


			for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
				$row[] = $aRow[ $aColumns[$i] ];
			}
			$row = array( $btn, $aRow['norm'], $aRow['nm_pasien'],$aRow['alamat_pasien'], $aRow['kk_pasien'], $aRow['tgllahir_pasien'] );
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );

	?>
