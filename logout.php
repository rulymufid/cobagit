<?php
  //session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT'])));
  session_start();
  session_unset();
  session_destroy();
  echo"<script> document.location = 'index.php'; </script>";
?>
