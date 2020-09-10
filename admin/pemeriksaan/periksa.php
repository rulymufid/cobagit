<?php
      if(!isset($_SESSION['level'])){
          //jika session belum di set/register
          echo"<script> document.location = '../index.php'; </script>";
      }
        include "./config/mysqliserver.php";
        if(isset($_GET["vdata"])){
            $cari=$_GET["vdata"];
        }
        else {
            $cari="";
        }
?>

    <HEAD>


        <script type="text/javascript" language="javascript" >

            var dTable;
            // #Example adalah id pada table
            $(document).ready(function() {
                dTable = $('#example').DataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bJQueryUI": false,
                    "responsive": true,
                    "sAjaxSource": "pemeriksaan/periksa_server.php", // Load Data
                    "sServerMethod": "POST",
                    "search": {"search": "<?php echo $cari; ?>"},
                    "columnDefs": [
                    { "orderable": true, "targets": 0, "searchable": false },
                    { "orderable": true, "targets": 1, "searchable": true },
                    { "orderable": true, "targets": 2, "searchable": true },
                    { "orderable": true, "targets": 3, "searchable": true },
                    { "orderable": true, "targets": 4, "searchable": true },
                    { "orderable": true, "targets": 5, "searchable": false },
                    { "orderable": true, "targets": 6, "searchable": false },
                  ],
                    "pageLength": 25,
                    "language": {
                          "lengthMenu": "Tampil _MENU_ Data",
                          "info": "Tampil _START_ sampai _END_ dari _TOTAL_ Data - klik <i class='glyphicon glyphicon-chevron-right'></i> untuk lanjut",
                          'paginate': {
                            'previous': '<i class="glyphicon glyphicon-chevron-left"></i>',
                            'next': '<i class="glyphicon glyphicon-chevron-right"></i>'
                          }
                        }
                } );

                $('#example').removeClass( 'display' ).addClass('table table-striped table-bordered');


            } );


        </script>
    </HEAD>
<!-- TASKBAR -->

<?php
//ALERT
if(isset($_GET['ps'])=='true2')
{

    echo "<div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-check'></i> SUKSES!</h4>
                Proses Berhasil Di Eksekusi
              </div>";

}
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">DATA PERIKSA</h3>&nbsp;&nbsp;&nbsp;
                <!--<a class="btn btn-default" href="#" onclick="showmodals()"> <span class="glyphicon glyphicon-plus"></span>  Tambah Pasien </a>-->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                    <thead>
                        <tr>
                          <th>Action</th>
                          <th>id_periksa</th>
                          <th>Nama Pasien</th>
                          <th>Norm</th>
                          <th>Dokter</th>
                          <th>jml print</th>
                          <th>Tanggal</th>
                        </tr>
                    </thead>
                </table>

                <br>
                <div class="col-lg-12 no-padding" style="padding-left:6px!important;">
                      <button onclick="location.href='?page=dashboard';"> kembali </button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
</div>
    <!-- /.col -->



    <script src="plugins/datepicker/js/bootstrap-datepicker.js"></script>
    <script>


        function print(id)
            {
              alert("print "+id);
            }



    </script>
