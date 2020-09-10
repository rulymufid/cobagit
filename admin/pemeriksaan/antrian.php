<?php
      if(!isset($_SESSION['level'])){
          //jika session belum di set/register
          echo"<script> document.location = '../index.php'; </script>";
      }
        include "./config/mysqliserver.php";
?>

    <HEAD>
      <script type="text/javascript" src="../bootstrap/js/autoNumeric.js"></script>
      <script type="text/javascript">
          jQuery(function($) {
          $('.autorp').autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
          });
      </script>

        <script type="text/javascript" language="javascript" >

            var dTable;
            // #Example adalah id pada table
            $(document).ready(function() {
                dTable = $('#example').DataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bJQueryUI": false,
                    "responsive": true,
                    "sAjaxSource": "pemeriksaan/antrian_server.php", // Load Data
                    "sServerMethod": "POST",
                    "columnDefs": [
                    { "orderable": false, "targets": 0, "searchable": false },
                    { "orderable": true, "targets": 1, "searchable": false },
                    { "orderable": true, "targets": 2, "searchable": true },
                    { "orderable": true, "targets": 3, "searchable": true },
                    { "orderable": true, "targets": 4, "searchable": true },
                    { "orderable": true, "targets": 4, "searchable": false },
                  ],
                  "pageLength": 25,
                  "language": {
                        "lengthMenu": "Tampil _MENU_ Data",
                        "info": "Tampil _START_ sampai _END_ dari _TOTAL_ Data",
                        "sInfoFiltered": " - klik <i class='glyphicon glyphicon-chevron-right'></i> untuk lanjut",
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
                <h3 class="box-title">Data antrian</h3>&nbsp;&nbsp;&nbsp;
                <!--<a class="btn btn-default" href="#" onclick="showmodals()"> <span class="glyphicon glyphicon-plus"></span>  Tambah antrian </a>-->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                    <thead>
                        <tr>
                            <th>ACTION</th>
                            <th>urut</th>
                            <th>Nama</th>
                            <th>No. RM</th>
                            <th>Alamat</th>
                            <th>Poli</th>
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

<!-- Modal Edit Antrian-->
    <div class="modal fade" id="modal_antri" tabindex="-1" role="dialog" aria-labelledby="label_input" aria-hidden="true" style="overflow-y: auto;height: auto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="judul_modal">Tambah antrian</h4>
                    </div>
                    <div class="modal-body" >
                        <form class="form-horizontal" id="forminput">

                             <input type="hidden" class="form-control" id="id_antrian" name="id_antrian">
                             <input type="hidden" class="form-control" id="type" name="type">

                             <div class="form-group">
                                 <label for="noksystem" class="col-sm-2 control-label">No.Rm :</label>
                                 <div class="col-sm-10">
                                     <input type="text" class="form-control" id="norm_antrian" name="norm_antrian" placeholder="Input NO. RM" disabled>
                                 </div>
                             </div>
                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">Nama :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nm_antrian" name="nm_antrian" placeholder="Input Nama" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                              <label for="kelamin" class="col-sm-2 control-label">Pilih Poli :</label>
                              <div class="col-sm-10">
                                <select class="form-control" id="poli" name="poli">
                                  <?php
                                     $sql=mysqli_query($con,"SELECT kode_poli,nama_poli from poli order by urut asc ");
                                     while ($h=mysqli_fetch_array($sql)) { ?>
                                       <option value="<?php echo $h['kode_poli'];?>"><?php echo $h['nama_poli'];?></option>
                                 <?php    }
                                  ?>


                              </select>
                              </div>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" onClick="simpan_edit()" class="btn btn-default" data-dismiss="modal">OK</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
    </div>

    <script>

        function showmodals(){
            $("#modal_antri").modal("show");
        }

        function edi_antrian(id,nama,norm,poli)
            {
              $("#modal_antri").modal("show");
              $("#judul_modal").html("Edit "+nama);
              $("#id_antrian").val(id);
              $("#type").val("edit_antrian");

              $("#norm_antrian").val(norm);
              $("#nm_antrian").val(nama);
              $("#poli").val(poli);

            }
        function hapus(id,nama,norm,poli)
                {
                  $("#modal_antri").modal("show");
                  $("#judul_modal").html("Hapus "+nama);
                  $("#id_antrian").val(id);
                  $("#type").val("hapus_antrian");

                  $("#norm_antrian").val(norm);
                  $("#nm_antrian").val(nama);
                  $("#poli").val(poli);

                }
        function proses(id,norm,poli)
            {

              waitingDialog.show();
              $.ajax({
                  type: "POST",
                  url: "pemeriksaan/antrian_crud.php",

                  dataType: 'json',
                  data: {id_antrian:id, type:"periksa", norm:norm,poli:poli},
                  success: function(data) {
                      dTable.ajax.reload();
                      waitingDialog.hide();
                  }
              });
            }

        function simpan_edit()
            {
                //var formData = $("#forminput").serialize();
                var id_antrian=$("#id_antrian").val();
                var type=$("#type").val();
                var poli=$("#poli").val();

                waitingDialog.show();
                $.ajax({
                    type: "POST",
                    url: "pemeriksaan/antrian_crud.php",

                    dataType: 'json',
                    data: {id_antrian:id_antrian, type:type ,poli:poli},
                    success: function(data) {
                        dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
                        waitingDialog.hide();
                    }
                });
            }




    </script>
