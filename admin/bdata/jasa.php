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
                    "sAjaxSource": "bdata/jasa_server.php", // Load Data
                    "sServerMethod": "POST",
                    "columnDefs": [
                    { "orderable": true, "targets": 0, "searchable": true },
                    { "orderable": true, "targets": 1, "searchable": true },
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
                <h3 class="box-title">Data jasa</h3>&nbsp;&nbsp;&nbsp;
                <a class="btn btn-default" href="#" onclick="showmodals()"> <span class="glyphicon glyphicon-plus"></span>  Tambah jasa </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama jasa</th>
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
    <div class="modal fade" id="modal_jasa" tabindex="-1" role="dialog" aria-labelledby="label_input" aria-hidden="true" style="overflow-y: auto;height: auto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="judul_jasa">Tambah jasa</h4>
                    </div>
                    <div class="modal-body" >
                        <form class="form-horizontal" id="forminput">

                             <input type="hidden" class="form-control" id="id_jasa" name="id_jasa">
                             <input type="hidden" class="form-control" id="type_jasa" name="type_jasa">

                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">Nama :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nm_jasa" name="nm_jasa" placeholder="Input Nama">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">Stok :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="stok_jasa" name="stok_jasa" placeholder="Input Stok atau di isi 0 (nol)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">Hrg Modal :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control autorp" id="hpp_jasa" name="hpp_jasa" placeholder="Input Harga Beli atau di isi 0 (nol)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="noksystem" class="col-sm-2 control-label">Hrg Jual/tarif :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control autorp" id="hjual_jasa" name="hjual_jasa" placeholder="Input Harga Jual / Tarif">
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="kelamin" class="col-sm-2 control-label">Kategori :</label>
                              <div class="col-sm-10">
                                <select class="form-control" id="jenis_obat" name="jenis_obat">
                                       <option value="JASA">JASA</option>
                                       <option value="OBAT">OBAT</option>
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

        function showmodals(id)
            {
              if( id )
              {
                  waitingDialog.show();
                  $.ajax({
                      type: "POST",
                      url: "bdata/jasa_crud.php",
                      dataType: 'json',
                      data: {id_jasa:id,type:"get"},
                      success: function(res) {

                              waitingDialog.hide();
                              $("#modal_jasa").modal("show");
                              $("#judul_jasa").html("Edit "+res.nm_obat);
                              $("#id_jasa").val(res.id_obat);
                              $("#type_jasa").val("edit");
                              $("#nm_jasa").val(res.nm_obat);
                              $("#hpp_jasa").val(res.hpp_obat);
                              $("#hjual_jasa").val(res.hjual_obat);
                              $("#stok_jasa").val(res.stok_obat);
                              $("#jenis_obat").val(res.jenis_obat);
                      }
                  });
              }
              else {
                $("#modal_jasa").modal("show");
                $('#type_jasa').val('new');
              }
            }

        function simpan()
            {
                //var formData = $("#forminput").serialize();
                var id_jasa=$("#id_jasa").val();
                var type=$("#type_jasa").val();
                var nm_jasa=$("#nm_jasa").val();
                var stok_jasa=$("#stok_jasa").val();
                var hpp_jasa=$("#hpp_jasa").val();
                var hjual_jasa=$("#hjual_jasa").val();
                var jenis_obat=$("#jenis_obat").val();

                waitingDialog.show();
                $.ajax({
                    type: "POST",
                    url: "bdata/jasa_crud.php",

                    dataType: 'json',
                    data: {id_jasa:id_jasa, type:type, nm_jasa:nm_jasa, stok_jasa:stok_jasa, hpp_jasa:hpp_jasa,hjual_jasa:hjual_jasa,jenis_obat:jenis_obat},
                    success: function(data) {
                        dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
                        waitingDialog.hide();
                    }
                });
            }




    </script>
