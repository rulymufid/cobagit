<?php
	//Connection Database
	$con = mysqli_connect("localhost","root","klinikita","admin_atkom");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	switch ($_POST['type']) {
		
		//Tampilkan Data 
		case "get":
			
			$SQL = mysqli_query($con, "SELECT * FROM pasien_001 WHERE norm='".$_POST['id']."'");
			$return = mysqli_fetch_array($SQL,MYSQLI_ASSOC);
			echo json_encode($return);
			break;
		
		//Tambah Data	
		case "new":
			
			$userid = date("ymdhis")."_".rand(0,10);
			$SQL = mysqli_query($con, 
									"INSERT INTO pasien_001 SET 
										userid='".$userid."', 
										real_name='".$_POST['real_name']."', 
										npm='".$_POST['npm']."', 
										kelas='".$_POST['kelas']."'
								");
			if($SQL){
				echo json_encode("OK");
			}
			break;
			
		//Edit Data	
		case "edit":
			
			$SQL = mysqli_query($con, 
									"UPDATE pasien_001 SET 
										poli='".$_POST['poli']."', 
										urut='".$_POST['urut']."'
									WHERE id='".$_POST['id']."'
								");
			if($SQL){
				echo json_encode("OK");
			}			
			break;
			
		//Hapus Data	
		case "delete":
			
			$SQL = mysqli_query($con, "DELETE FROM pasien_001 WHERE norm='".$_POST['id']."' ");
			if($SQL){
				echo json_encode("OK");
			}			
			break;
	} 
	
?>