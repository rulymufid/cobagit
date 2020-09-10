<?php
//Connection Database crud
	$con = mysqli_connect("localhost","root","","admin_klinik");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

// Database connection information

	$gaSql['user']     = 'root';
	$gaSql['password'] = '';
	$gaSql['db']       = 'admin_klinik';  //Database
	$gaSql['server']   = 'localhost';
	$gaSql['port']     = 3306; // 3306 is the default MySQL port

	// Input method (use $_GET, $_POST or $_REQUEST)
	$input =& $_POST;

	$gaSql['charset']  = 'utf8';


		// MySQL connection

	$db = new mysqli($gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db'], $gaSql['port']);
	if (mysqli_connect_error()) {
		die( 'Error connecting to MySQL server (' . mysqli_connect_errno() .') '. mysqli_connect_error() );
	}

	if (!$db->set_charset($gaSql['charset'])) {
		die( 'Error loading character set "'.$gaSql['charset'].'": '.$db->error );
	}
?>
