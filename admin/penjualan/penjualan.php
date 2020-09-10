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
                    "sAjaxSource": "penjualan/penjualan_server.php", // Load Data
                    "sServerMethod": "POST",
                    "search": {"search": "<?php echo $cari; ?>"},
                    "columnDefs": [
                    { "orderable": true, "targets": 0, "searchable": false },
                    { "orderable": true, "targets": 1, "searchable": true },
                    { "orderable": true, "targets": 2, "searchable": true },
                    { "orderable": true, "targets": 3, "searchable": true },
                    { "orderable": true, "targets": 4, "searchable": true },
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
                <h3 class="box-title">DATA PENJUALAN</h3>
                <a class="btn btn-default" href="#" onclick="tambah()"> <span class="glyphicon glyphicon-plus"></span>  Tambah </a>
                &nbsp;&nbsp;&nbsp;

                <!--<a class="btn btn-default" href="#" onclick="showmodals()"> <span class="glyphicon glyphicon-plus"></span>  Tambah Pasien </a>-->
            </div>
            <div class="box-biru col-sm-12">
                <div class="form-group">
                    <label for="tgl_awal" class="col-sm-2 control-label">Tanggal Awal</label>
                    <div class="col-sm-3">
                        <input type="text" name="tgl_awal" id="tgl_awal" class="tanggal form-control" required="" placeholder="pilih tanggal" autocomplete="off" />
                    </div>
                    <label for="tgl_akhir" class="col-sm-2 control-label">Tanggal Akhir</label>
                    <div class="col-sm-3">
                        <input type="text" name="tgl_akhir" id="tgl_akhir" class="tanggal form-control" required="" placeholder="pilih tanggal" autocomplete="off" />
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-primary" href="#" onclick="tampilkan()"> <span class="fa fa-calendar"></span>  Tampilkan </a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <br>
                <table id="example"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                    <thead>
                        <tr>
                          <th>Action</th>
                          <th>No.Nota</th>
                          <th>Petugas</th>
                          <th>Item</th>
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
    <script type="text/javascript">
            $(document).ready(function () {

                $('#tgl_awal').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose:true
                });
                $('#tgl_akhir').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose:true
                });
            });
        </script>
    <script>
        function tampilkan(){
            var tgl_awal=$("#tgl_awal").val();
            var tgl_akhir=$("#tgl_akhir").val();
            if (tgl_awal=="") {
                swal({text:'Pilih Tanggal Awal'});
            }
            else if (tgl_akhir=="") {
                swal({text:'Pilih Tanggal Akhir'});
            }
            else {
              waitingDialog.show();
              var dTable;
              $("#example").dataTable().fnDestroy();
              dTable = $('#example').DataTable( {
                  "bProcessing": true,
                  "bServerSide": true,
                  "bJQueryUI": false,
                  "responsive": true,
                  "sAjaxSource": "penjualan/penjualan_server.php?tgl_awal="+tgl_awal+"&tgl_akhir="+tgl_akhir, // Load Data
                  "sServerMethod": "POST",
                  "search": {"search": "<?php echo $cari; ?>"},
                  "columnDefs": [
                  { "orderable": true, "targets": 0, "searchable": false },
                  { "orderable": true, "targets": 1, "searchable": true },
                  { "orderable": true, "targets": 2, "searchable": true },
                  { "orderable": true, "targets": 3, "searchable": true },
                  { "orderable": true, "targets": 4, "searchable": false },
                  { "orderable": true, "targets": 5, "searchable": true },
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
              waitingDialog.hide();
            }
        }

        function print(id)
            {
              window.open("cetak/cetak_apotik.php?id="+id);
            }

        function tambah()
          {
            $.ajax({
                type: "POST",
                url: "penjualan/detail_crud.php",
                dataType: 'json',
                data: {type:"tambahjual"},
                success: function(res) {
                    if (res.tipe=='sukses') {
                        window.location.href = "index.php?page=detailpj&id="+res.id;
                    }
                    else {
                        swal({text:''+res.msg, icon:'warning'});
                    }
                }
            });
          }

    </script>
