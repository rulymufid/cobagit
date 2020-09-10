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
                    "sAjaxSource": "pasien/pasien_server.php", // Load Data
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
                <h3 class="box-title">Data Pasien</h3>&nbsp;&nbsp;&nbsp;
                <a class="btn btn-default" href="#" onclick="showmodals()"> <span class="glyphicon glyphicon-plus"></span>  Tambah Pasien </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                    <thead>
                        <tr>
                          <th>Action</th>
                          <th>Norm</th>
                          <th>Nama Pasien</th>
                          <th>Alamat</th>
                          <th>KK</th>
                          <th>Tanggal Lahir</th>
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
    <div class="modal fade" id="modal_pasien" tabindex="-1" role="dialog" aria-labelledby="label_input" aria-hidden="true" style="overflow-y:
      auto;height: auto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="judul_modalpasien">Tambah pasien</h4>
                    </div>
                    <div class="modal-body" >
                        <form class="form-horizontal" id="forminput">

                             <input type="hidden" class="form-control" id="id_pasien" name="id_pasien">
                             <input type="hidden" class="form-control" id="type" name="type">

                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">Nama :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nm_pasien" name="nm_pasien" placeholder="Input Nama Pasien">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">KK :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="kk_pasien" name="kk_pasien" placeholder="Nama Kepala Keluarga">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">Alamat :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="alamat_pasien" name="alamat_pasien" placeholder="isi Alamat Pasien">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">No. HP :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="hp_pasien" name="hp_pasien" placeholder="isi no,hp pasien">
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="kelamin" class="col-sm-2 control-label">Jns Kelamin :</label>
                              <div class="col-sm-4">
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>

                              </select>
                              </div>
                            </div>

                            <div class="form-group">
                                <label for="tgllahir_pasien" class="col-sm-2 control-label">Tanggal Lahir</label>
                                <div class="col-sm-4">
                                    <input type="text" name="tgllahir_pasien" id="tgllahir_pasien" class="tanggal form-control" required=""
                                    placeholder="pilih tanggal" autocomplete="off" />
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

    <!-- MODAL Daftar Antrian   -->
    <div class="modal fade" id="modal_antrian" tabindex="-1" role="dialog" aria-labelledby="label_antrian" aria-hidden="true" style="overflow-y: auto;height: auto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="judul_modalantrian">Daftarkan Antrian</h4>
                    </div>
                    <div class="modal-body" >
                        <form class="form-horizontal" id="forminput">

                             <input type="hidden" class="form-control" id="norm_antri" name="norm_antri">
                             <input type="hidden" class="form-control" id="type_antri" name="type_antri">

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
                        <button type="button" onClick="daftar()" class="btn btn-default" data-dismiss="modal">Daftarkan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
    </div>

    <script src="plugins/datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
            $(document).ready(function () {

                $('#tgllahir_pasien').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose:true
                });
            });
        </script>


    <script>

        function antrian(id){
          $("#modal_antrian").modal("show");
          $("#norm_antri").val(id);
          $("#type_antri").val("daftarantrian");
        }

        function daftar() {
            var norm=$("#norm_antri").val();
            var type=$("#type_antri").val();
            var poli=$("#poli").val();
            waitingDialog.show();
            $.ajax({
                type: "POST",
                url: "pasien/pasien_crud.php",
                dataType: 'json',
                data: {norm:norm, type:type,poli:poli},
                success: function(data) {
                    dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
                    waitingDialog.hide();
                }
            });
        }

        function showmodals(id)
            {
              if( id )
              {

                  waitingDialog.show();
                  $.ajax({
                      type: "POST",
                      url: "pasien/pasien_crud.php",
                      dataType: 'json',
                      data: {norm:id,type:"get"},
                      success: function(res) {

                              waitingDialog.hide();
                              $("#modal_pasien").modal("show");
                              $("#judul_modalpasien").html("Edit "+res.nm_pasien);
                              $("#id_pasien").val(res.norm);
                              $("#type").val("edit");
                              $("#nm_pasien").val(res.nm_pasien);
                              $("#kk_pasien").val(res.kk_pasien);
                              $("#alamat_pasien").val(res.alamat_pasien);
                              $("#hp_pasien").val(res.hp_pasien);
                              $("#jenis_kelamin").val(res.jenis_kelamin);
                              $("#tgllahir_pasien").val(res.tgllahir_pasien);
                      }
                  });
              }
              else {
                $("#modal_pasien").modal("show");
                $('#type').val('new');
                $("#id_pasien").val('');
                $("#nm_pasien").val('');
                $("#kk_pasien").val('');
                $("#alamat_pasien").val('');
                $("#hp_pasien").val('');
                $("#jenis_kelamin").val('');
                $("#tgllahir_pasien").val('');
              }
            }

        function simpan()
            {
                //var formData = $("#forminput").serialize();
                var norm=$("#id_pasien").val();
                var type=$("#type").val();
                var nm_pasien=$("#nm_pasien").val();
                var kk_pasien=$("#kk_pasien").val();
                var alamat_pasien=$("#alamat_pasien").val();
                var hp_pasien=$("#hp_pasien").val();
                var jenis_kelamin=$("#jenis_kelamin").val();
                var tgllahir_pasien=$("#tgllahir_pasien").val();

                waitingDialog.show();
                $.ajax({
                    type: "POST",
                    url: "pasien/pasien_crud.php",
                    dataType: 'json',
                    data: {norm:norm, type:type, nm_pasien:nm_pasien, kk_pasien:kk_pasien, alamat_pasien:alamat_pasien,hp_pasien:hp_pasien, jenis_kelamin:jenis_kelamin,tgllahir_pasien:tgllahir_pasien},
                    success: function(data) {
                        dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
                        waitingDialog.hide();
                    }
                });
            }




    </script>
