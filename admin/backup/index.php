<?php
include('../config/mysqliserver.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$tgl=date('d-M-Y');
$nama_db='backup_'.$tgl.'.sql';
$dir = 'D:/backup/'.$nama_db; 
/*
$database = 'admin_klinik';
$user = 'root';
$pass = '';
$host = 'localhost';*/

$mysqlDir = 'D:/xampp/mysql/bin';    // Paste your mysql directory here and be happy
$mysqldump = $mysqlDir.'/mysqldump';

echo "<h3>Backing up database to `<code>{$dir}</code>`</h3>";
exec("{$mysqldump} --user={$gaSql['user']} --password={$gaSql['password']} --host={$gaSql['server']} {$gaSql['db']} --result-file={$dir} 2>&1", $output);

var_dump($output);
?>
