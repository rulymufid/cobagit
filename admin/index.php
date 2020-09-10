<?php
//session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT'])));
session_start();
//$id_user = $_SESSION['id_user'];
include "./config/mysqliserver.php";
if(!isset($_SESSION['level'])){
    //jika session belum di set/register
    echo"<script> document.location = '../index.php'; </script>";
}
extract($_POST);


?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>KLINIK & APOTIK by FIDDROID</title>


        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shortcut icon" href="../img/mlm.png">
        <!-- Font Awesome -->

        <!-- Ionicons -->
        <link rel="stylesheet" href="dist/css/ionicons.min.css">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../bootstrap/css/btn.css">
                <link rel="stylesheet" href="plugins/select2-master/dist/css/select2.min.css"/>
                <link rel="stylesheet" href="plugins/datepicker/dist/css/bootstrap-datepicker.css">
                <link rel="stylesheet" href="plugins/css/tableservice.css"/>
                <link rel="stylesheet" href="plugins/css/style.css"/>
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <link href="dist/css/font-awesome.min.css" rel="stylesheet" >
        <link href="dist/css/product-image.css" rel="stylesheet" >
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="plugins/js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="plugins/media/css/dataTables.bootstrap.css">
        <link rel="stylesheet" type="text/css" href="plugins/media/css/dataTables.responsive.css">
        <script type="text/javascript" language="javascript" src="plugins/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="plugins/media/js/dataTables.responsive.js"></script>
        <script type="text/javascript" language="javascript" src="plugins/media/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" language="javascript" src="plugins/media/js/common.js"></script>



        <link rel="stylesheet" href="dist/css/summernote.css">
        <script src="dist/js/summernote.js"></script>


    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="?page=dashboard" class="logo">
                  <?php
                    if ($_SESSION['level']=="it") { ?>
                          <span class="logo-mini"><b>SLS</b></span>
                          <!-- logo for regular state and mobile devices -->
                          <span class="logo-lg"><b>HALAMAN IT</b></span>

                    <?php }
                    else {
                          ?>
                            <!-- mini logo for sidebar mini 50x50 pixels -->
                            <span class="logo-mini"><b>APL</b></span>
                            <!-- logo for regular state and mobile devices -->
                            <span class="logo-lg"><b>APLIKASI KLINIK</b></span>

                        <?php
                      }

                   ?>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="glyphicon glyphicon-th-large"></span>
                    </a>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include'menu.php'; ?>
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->

                    <!-- Main content -->
                    <section class="content">
                        <?php
                            if(isset($_GET['page']))
                            {
                             switch($_GET['page'])
                            {
                                case 'dashboard': include'dashboard.php'; break;
                                case 'berita': include'form_b.php'; break;
                                case 'profil': include'bdata/profil.php'; break;
                                case 'pasien': include'pasien/pasien.php'; break;
                                case 'antrian': include'pemeriksaan/antrian.php'; break;
                                case 'pemeriksaan': include'pemeriksaan/periksa.php'; break;
                                case 'detail': include'pemeriksaan/detail.php'; break;
                                case 'obat': include'bdata/obat.php'; break;
                                case 'jasa': include'bdata/jasa.php'; break;
                                case 'karyawan': include'bdata/karyawan.php'; break;
                                case 'penjualan': include'penjualan/penjualan.php'; break;
                                case 'detailpj': include'penjualan/detail.php'; break;
                                case 'laporan': include'cetak/laporan.php'; break;

                            }
                            }
                        ?>
                    </section>
                </div>
                <!-- /.content-wrapper -->
                <footer class="main-footer">
                    <div class="pull-right hidden-xs">
                        <b>Version</b> 1
                    </div>

                     <strong><?php echo "CUSTOM APLIKASI BY"; ?> &copy;  <a href="http://facebook.com/fiddroid" target="_blank">FIDDROID</a>
                </footer>
                <div class="control-sidebar-bg"></div>
        </div>

        <!-- Modal warning -->
            <div class="modal fade" id="modal_warning" tabindex="-1" role="dialog" aria-labelledby="label_lihatcatatan" aria-hidden="true" style="overflow-y: auto;height: auto">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalwarning">WARNING</h4>
                            </div>
                            <div class="modal-body" >
                                <h3 id='isi_warning' name='isi_warning' style="text-align:center;"></h3>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
            </div>

        <!-- ./wrapper -->
        <!-- Bootstrap 3.3.5 -->
        <script src="../bootstrap/js/bootstrap.min.js"></script>

        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- Sparkline -->
        <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="plugins/knob/jquery.knob.js"></script>
        <!-- daterangepicker -->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>-->
        <script src="plugins/daterangepicker/daterangepicker.js"></script>
        <!-- datepicker -->
        <script src="plugins/datepicker/js/bootstrap-datepicker.js"></script>
        <script src="plugins/select2-master/dist/js/select2.min.js"></script>
        <!-- Slimscroll -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="dist/js/pages/dashboard.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>

        <script>
            $(window).on('load', function() {

           //     var hasil = $('.dataTables_filter input').val();
           //     // var hasil = "okok";
           //   var hCari = document.cookie="tCari="+hasil;
           //     console.log(hCari);
              document.cookie="tCari=";

              $('.dataTables_filter input').focusout(function(){

                   var hasil = $('.dataTables_filter input').val();

                  var hCari = document.cookie="tCari="+hasil;

                   console.log(hCari);
               });

                $('.dataTables_filter input').focus();

            });
          </script>
    </body>
    </html>
