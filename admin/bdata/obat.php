<?php
      if(!isset($_SESSION['level'])){
          //jika session belum di set/register
          echo"<script> document.location = '../index.php'; </script>";
      }
        include "./config/mysqliserver.php";
        $level=$_SESSION['level'];
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
                    "sAjaxSource": "bdata/obat_server.php", // Load Data
                    "sServerMethod": "POST",
                    "columnDefs": [
                    { "orderable": true, "targets": 0, "searchable": true },
                    { "orderable": true, "targets": 1, "searchable": false },
                    { "orderable": true, "targets": 2, "searchable": false },
                    { "orderable": true, "targets": 3, "searchable": false },
                    { "orderable": false, "targets": 4, "searchable": false },
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
                <h3 class="box-title">Data Obat</h3>&nbsp;&nbsp;&nbsp;
                <a class="btn btn-default" href="#" onclick="showmodals()"> <span class="glyphicon glyphicon-plus"></span>  Tambah Obat </a>
                <a class="btn btn-default" href="#" onclick="stok_opname()"> <span class="fa fa-download"></span>  STOK OPNAME </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                    <thead>
                        <tr>
                            <th>Nama Obat</th>
                            <th>Stok</th>
                            <th>Hrg Beli</th>
                            <th>Hrg Jual</th>
                            <th>Edit</th>
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
    <div class="modal fade" id="modal_input" tabindex="-1" role="dialog" aria-labelledby="label_input" aria-hidden="true" style="overflow-y: auto;height: auto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="judul_modal">Tambah Obat</h4>
                    </div>
                    <div class="modal-body" >
                        <form class="form-horizontal" id="forminput">

                             <input type="hidden" class="form-control" id="id_obat" name="id_obat">
                             <input type="hidden" class="form-control" id="type" name="type">

                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">Nama :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nm_obat" name="nm_obat" placeholder="Input Nama">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">Stok :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="stok_obat" name="stok_obat" placeholder="Input Stok">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">Hrg Beli :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control autorp" id="hpp_obat" name="hpp_obat" placeholder="Input Harga Beli">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">Hrg Jual :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control autorp" id="hjual_obat" name="hjual_obat" placeholder="Input Harga Jual">
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="kelamin" class="col-sm-2 control-label">Kategori :</label>
                              <div class="col-sm-10">
                                <select class="form-control" id="jenis_obat" name="jenis_obat">
                                       <option value="OBAT">OBAT</option>
                                       <option value="JASA">JASA</option>
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

    <script>
        function stok_opname()
        {
          window.open("cetak/stok_opname.php");
        }
        function showmodals(id)
            {
              if( id )
              {

                  waitingDialog.show();
                  $.ajax({
                      type: "POST",
                      url: "bdata/obat_crud.php",
                      dataType: 'json',
                      data: {id_obat:id,type:"get"},
                      success: function(res) {

                              waitingDialog.hide();
                              $("#modal_input").modal("show");
                              $("#judul_modal").html("Edit "+res.nm_obat);
                              $("#id_obat").val(res.id_obat);
                              $("#type").val("edit");
                              $("#nm_obat").val(res.nm_obat);
                              $("#hpp_obat").val(res.hpp_obat);
                              $("#hjual_obat").val(res.hjual_obat);
                              $("#stok_obat").val(res.stok_obat);
                              $("#jenis_obat").val(res.jenis_obat);
                      }
                  });
              }
              else {
                $("#id_obat").val("");
                $('#type').val('new');
                $("#nm_obat").val("");
                $("#hpp_obat").val("");
                $("#hjual_obat").val("");
                $("#stok_obat").val("");
                $("#jenis_obat").val("obat");
                $("#modal_input").modal("show");
              }
            }

        function simpan()
            {
                //var formData = $("#forminput").serialize();
                var id_obat=$("#id_obat").val();
                var type=$("#type").val();
                var nm_obat=$("#nm_obat").val();
                var stok_obat=$("#stok_obat").val();
                var hpp_obat=$("#hpp_obat").val();
                var hjual_obat=$("#hjual_obat").val();
                var jenis_obat=$("#jenis_obat").val();

                waitingDialog.show();
                $.ajax({
                    type: "POST",
                    url: "bdata/obat_crud.php",

                    dataType: 'json',
                    data: {id_obat:id_obat, type:type, nm_obat:nm_obat, stok_obat:stok_obat, hpp_obat:hpp_obat,hjual_obat:hjual_obat,jenis_obat:jenis_obat},
                    success: function(data) {
                        dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
                        waitingDialog.hide();
                    }
                });
            }




    </script>
