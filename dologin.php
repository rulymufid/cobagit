<?php

//include "admin/config/mysqliserver.php";
  $con = $con = mysqli_connect("localhost","root","","admin_klinik");
  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$user 	= mysqli_real_escape_string($con,$_POST['tUser']);
$pwd   	= mysqli_real_escape_string($con,$_POST['tPwd']);

$hasil  = mysqli_query($con,"SELECT a.* , b.nm_karyawan FROM users as a
                      inner join karyawan as b on a.id_karyawan=b.id_karyawan
                      WHERE username = '".$user."'
											AND password = '".md5($pwd)."'");
$hitung = mysqli_num_rows($hasil);
if ($hitung > 0){
    $data   = mysqli_fetch_array($hasil);
  //session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT'])));
   //session_save_path('./sesi');
  //ini_set('session.gc_probability', 1);
  session_start();
  $_SESSION['id_karyawan'] = $data['id_karyawan'];
	$_SESSION['id_user'] = $data['id_user'];
  $_SESSION['nm_user'] = $data['nm_karyawan'];
  $_SESSION['username'] = $data['username'];
  $_SESSION['password'] = $data['password'];
  $_SESSION['level'] = $data['level_user'];
  $_SESSION['id_cabang'] = $data['id_cabang'];

  //header('Location:admin/index.php?page=dashboard');
  echo "<script>window.location = 'admin/index.php?page=dashboard'</script>";
  if(isset($_SESSION['level'])){
      echo $_SESSION['level'];echo session_save_path();
  }
  else{echo "session GAGAL"; echo session_save_path(); $_SESSION['level'];}

}else{
   echo "<script>alert('GAGAL..!!!!!, Silakan Ulangi Lagi'); window.location = 'index.php'</script>";
}
?>
