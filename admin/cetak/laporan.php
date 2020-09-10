<?php
    if(!isset($_SESSION['level'])){
        echo"<script> document.location = '../index.php'; </script>";
    }
    elseif ($level!=="admin") {
        echo"<script> document.location = '?page=dashboard'; </script>";
    }
?>
<div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">CETAK LAPORAN</h3>
                </div>
                <form class="form-horizontal" method="post" action="#" target="_blank" enctype="multipart/form-data">
                   <input type="hidden" name="id" value="">
                    <div class="box-body">
                        <div class="form-group">
                          <label for="al_pasien" class="col-sm-2 control-label">Pilih Laporan</label>
                          <div class="col-sm-4">
                              <select class="form-control" id="jns_laporan" name="jns_laporan">
                                  <option value="penjualan">Penjualan Apotik</option>
                                  <option value="periksa">Pemeriksaan Klinik</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tgl_awal" class="col-sm-2 control-label">Tanggal Awal</label>
                            <div class="col-sm-4">
                                <input type="text" name="tgl_awal" id="tgl_awal" class="tanggal form-control" required="" placeholder="pilih tanggal" autocomplete="off" />
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="tgl_akhir" class="col-sm-2 control-label">Tanggal Akhir</label>
                            <div class="col-sm-4">
                                <input type="text" name="tgl_akhir" id="tgl_akhir" class="tanggal form-control" required="" placeholder="pilih tanggal" autocomplete="off" />
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="box-footer">
                        <a class="btn btn-warning" href="?page=dashboard">
                                            <span > Keluar</span>
                                          </a>
                          <!--<input onclick="change_url()" type="submit" class="btn btn-primary" value="cetak" name="cetak">-->
                          <a class="btn btn-primary" onclick="cetaklap()">
                                              <span > Cetak</span>
                                            </a>
                    </div>

                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
        <!--/.col (right) -->
    </div>

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

            function cetaklap(){
              var jns_laporan=$("#jns_laporan").val();
              var tgl_awal=$("#tgl_awal").val();
              var tgl_akhir=$("#tgl_akhir").val();
              if (tgl_awal=="") {
                  swal({text:'Pilih Tanggal Awal'});
              }
              else if (tgl_akhir=="") {
                  swal({text:'Pilih Tanggal Akhir'});
              }
              else {
                    window.open("cetak/printlap"+jns_laporan+".php?tgl_awal="+tgl_awal+"&tgl_akhir="+tgl_akhir, "_blank");
              }
            }
        </script>
