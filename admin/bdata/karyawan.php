<?php
      if(!isset($_SESSION['level'])){
          //jika session belum di set/register
          echo"<script> document.location = '../index.php'; </script>";
      }
        include "./config/mysqliserver.php";
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
                    "sAjaxSource": "bdata/karyawan_server.php", // Load Data
                    "sServerMethod": "POST",
                    "columnDefs": [
                    { "orderable": false, "targets": 0, "searchable": false },
                    { "orderable": true, "targets": 1, "searchable": true },
                    { "orderable": true, "targets": 2, "searchable": true },
                    { "orderable": true, "targets": 3, "searchable": true },
                    { "orderable": true, "targets": 4, "searchable": true },
                    { "orderable": true, "targets": 5, "searchable": false },
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
                <h3 class="box-title">Data karyawan</h3>&nbsp;&nbsp;&nbsp;
                <a class="btn btn-default" href="#" onclick="showmodals()"> <span class="glyphicon glyphicon-plus"></span>  Tambah karyawan </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                    <thead>
                        <tr>
                          <th>ID Karyawan</th>
                          <th>Nama </th>
                          <th>NO.HP</th>
                          <th>Jabatan</th>
                          <th>Tanggal Lahir</th>
                          <th>Action</th>
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

<!-- Modal input nomor-->
    <div class="modal fade" id="modal_karyawan" tabindex="-1" role="dialog" aria-labelledby="label_input" aria-hidden="true"
    style="overflow-y: auto;height: auto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="judul_modalkaryawan">Tambah karyawan</h4>
                    </div>
                    <div class="modal-body" >
                        <form class="form-horizontal" id="forminput">

                             <input type="hidden" class="form-control" id="id_karyawanold" name="id_karyawanold">
                             <input type="hidden" class="form-control" id="type" name="type">
                             <div class="form-group">
                                 <label for="noksystem" class="col-sm-2 control-label">ID Karyawan :</label>
                                 <div class="col-sm-10">
                                     <input type="text" class="form-control" id="id_karyawan" name="id_karyawan" placeholder="Input ID karyawan">
                                 </div>
                             </div>
                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">Nama :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nm_karyawan" name="nm_karyawan" placeholder="Input Nama karyawan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">Alamat :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="alamat_karyawan" name="alamat_karyawan" placeholder="isi Alamat karyawan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">No. HP :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="hp_karyawan" name="hp_karyawan" placeholder="isi no,hp karyawan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir" class="col-sm-2 control-label">Tanggal Lahir</label>
                                <div class="col-sm-4">
                                    <input type="text" name="tgl_lahir" id="tgl_lahir" class="tanggal form-control" required=""
                                    placeholder="pilih tanggal" autocomplete="off" />
                                </div>

                            </div>
                            <div class="form-group">
                              <label for="kelamin" class="col-sm-2 control-label">Jabatan :</label>
                              <div class="col-sm-4">
                                <select class="form-control" id="jabatan" name="jabatan">
                                        <option value="admin">admin</option>
                                        <option value="apoteker">apoteker</option>
                                        <option value="dokter">dokter</option>
                                        <option value="perawat">perawat</option>
                              </select>
                              </div>
                            </div>


                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" onClick="simpan()" class="btn btn-default" data-dismiss="modal">Simpan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
    </div>

  <script src="plugins/datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
            $(document).ready(function () {

                $('#tgl_lahir').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose:true
                });
            });
        </script>


    <script>

        function showmodals(id)
            {
              if( id )
              {

                  waitingDialog.show();
                  $.ajax({
                      type: "POST",
                      url: "bdata/karyawan_crud.php",
                      dataType: 'json',
                      data: {id_karyawan:id,type:"get"},
                      success: function(res) {

                              waitingDialog.hide();
                              $("#modal_karyawan").modal("show");
                              $("#judul_modalkaryawan").html("Edit "+res.nm_karyawan);
                              $("#id_karyawanold").val(res.id_karyawan);
                              $("#id_karyawan").val(res.id_karyawan);
                              $("#type").val("edit");
                              $("#nm_karyawan").val(res.nm_karyawan);
                              $("#alamat_karyawan").val(res.alamat_karyawan);
                              $("#hp_karyawan").val(res.hp_karyawan);
                              $("#jabatan").val(res.jabatan);
                              $("#tgl_lahir").val(res.tgl_lahir);
                      }
                  });
              }
              else {
                $("#modal_karyawan").modal("show");
                $('#type').val('new');
                $("#id_karyawan").val('');
                $("#nm_karyawan").val('');
                $("#alamat_karyawan").val('');
                $("#hp_karyawan").val('');
                $("#tgl_lahir").val('');
                $("#jabatan").val('');
              }
            }

        function simpan()
            {
                //var formData = $("#forminput").serialize();
                var id_karyawanold=$("#id_karyawanold").val();
                var id_karyawan=$("#id_karyawan").val();
                var type=$("#type").val();
                var nm_karyawan=$("#nm_karyawan").val();
                var alamat_karyawan=$("#alamat_karyawan").val();
                var hp_karyawan=$("#hp_karyawan").val();
                var jabatan=$("#jabatan").val();
                var tgl_lahir=$("#tgl_lahir").val();

                waitingDialog.show();
                $.ajax({
                    type: "POST",
                    url: "bdata/karyawan_crud.php",
                    dataType: 'json',
                    data: {id_karyawanold:id_karyawanold,id_karyawan:id_karyawan, type:type, nm_karyawan:nm_karyawan, alamat_karyawan:alamat_karyawan,hp_karyawan:hp_karyawan, jabatan:jabatan,tgl_lahir:tgl_lahir},
                    success: function(data) {
                        dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
                        waitingDialog.hide();
                    }
                });
            }




    </script>
