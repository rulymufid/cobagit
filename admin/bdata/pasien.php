    <HEAD>

        <!-- JQUERY -->


        <!-- DataTables -->

        <script type="text/javascript" language="javascript" >

            var dTable;
            // #Example adalah id pada table
            $(document).ready(function() {
                dTable = $('#example').DataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bJQueryUI": false,
                    "responsive": true,
                    "sAjaxSource": "bdata/pasien_server.php", // Load Data
                    "sServerMethod": "POST",
                    "columnDefs": [
                    { "orderable": false, "targets": 0, "searchable": false },
                    { "orderable": true, "targets": 1, "searchable": true },
                    { "orderable": true, "targets": 2, "searchable": true },
                    { "orderable": true, "targets": 3, "searchable": true },
                    { "orderable": true, "targets": 4, "searchable": true },
                    { "orderable": true, "targets": 5, "searchable": false },
                    ]
                } );

                $('#example').removeClass( 'display' ).addClass('table table-striped table-bordered');


                // Untuk Pencarian, di kolom paling bawah
              /*  dTable.columns().every( function () {
                    var that = this;

                    $( 'input', this.footer() ).on( 'keyup change', function () {
                        that
                        .search( this.value )
                        .draw();
                    } );
                } );
                    */

            } );


        </script>
    </HEAD>



<?php
if(isset($_GET['ps'])=='true2')
{
    $norm=$_GET['norm'];
    echo "<div class='alert alert-success' role='alert'>Data Di Simpan NO.RM =<strong> $norm</strong></div>";


}
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Pasien <a id="tambah" href="?page=editpasien"><button type="button" class=" btn btn-block btn-info btn-xs">Tambah</button></a></h3>
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
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
</div>
    <!-- /.col -->

    <!-- Modal Antrian -->
    <div class="modal fade" id="modal_antrian" tabindex="-1" role="dialog" aria-labelledby="label_antrian" aria-hidden="true" style="overflow-y: auto;height: auto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="judulm_antrian">Daftarkan Antrian</h4>
                    </div>
                    <div class="modal-body" >
                        <form class="form-horizontal" id="forminput">

                             <input type="hidden" class="form-control" id="norm_antri" name="norm_antri">
                             <input type="hidden" class="form-control" id="type" name="type">


                            <div class="form-group">
                                <label for="poli" class="col-sm-2 control-label">Poli</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="poli" name="poli" >
                                      <?php
                                      $brg=mysqli_query($con,"SELECT * from poli order by urut asc");
                                      while($b=mysqli_fetch_array($brg)){
                                          ?>
                                          <option value="<?php echo $b['kode_poli']; ?>"><?php echo $b['nama_poli'] ?></option>
                                          <?php
                                          }
                                          ?>
                                      </select>
                                    </div>

                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" onClick="masukantrian()" class="btn btn-default" data-dismiss="modal">Daftarkan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
    </div>

    <script>

          function antrian(norm)
              {
                    $("#modal_antrian").modal("show");
                    $('#norm_antri').val(''+norm);
                    $('#type').val('daftar_antrian');

              }

          function masukantrian() {

              var formData = $("#forminput").serialize();
              waitingDialog.show();
              $.ajax({
                  type: "POST",
                  url: "pemeriksaan/pemeriksaan_crud.php",

                  dataType: 'json',
                  data: formData,
                  success: function(data) {
                      dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
                      waitingDialog.hide();
                  }
              });
          }


    </script>
