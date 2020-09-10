<?php
    $id_user=$_SESSION['id_user'];
    $level=$_SESSION['level'];
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div>
                <br>
            </div>
            <!--  ICON   -->
            <div class="row" style="padding-left:20px">
              <div class="col-md-3 col-sm-6 col-xs-12">
                       <a href="index.php?page=pasien">
                        <div class="info-box bg-aqua"><span class="info-box-icon"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                               <span class="info-box-number">PASIEN</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 70%"></div>
                                 </div>
                              <span class="progress-description"> Data Pasien </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                         </a>
                        </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                           <a href="index.php?page=antrian">
                            <div class="info-box bg-aqua"><span class="info-box-icon"><i class="glyphicon glyphicon-tasks"></i></span>
                                <div class="info-box-content">
                                   <span class="info-box-number">ANTRIAN</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 70%"></div>
                                     </div>
                                  <span class="progress-description"> Urutan Antri </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                             </a>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                           <a href="index.php?page=pemeriksaan">
                            <div class="info-box bg-aqua"><span class="info-box-icon"><i class="fa fa-heart"></i></span>
                                <div class="info-box-content">
                                   <span class="info-box-number">PEMERIKSAAN</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 70%"></div>
                                     </div>
                                  <span class="progress-description"> Data Pemeriksaan </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                             </a>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                           <a href="index.php?page=penjualan">
                            <div class="info-box bg-aqua"><span class="info-box-icon"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                   <span class="info-box-number">PENJUALAN</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 70%"></div>
                                     </div>
                                  <span class="progress-description"> Data Penjualan </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                             </a>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                           <a href="#" onclick="backupdb()">
                            <div class="info-box bg-aqua"><span class="info-box-icon"><i class="fa fa-download"></i></span>
                                <div class="info-box-content">
                                   <span class="info-box-number">BACKUP</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 70%"></div>
                                     </div>
                                  <span class="progress-description"> Backup Database </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                             </a>
                    </div>

              <?php
                if ($level=="it") { ?>

                  <div class="col-md-3 col-sm-6 col-xs-12">
                     <a href="index.php?page=produkadm">
                      <div class="info-box bg-aqua"><span class="info-box-icon"><i class="fa fa-cog"></i></span>
                          <div class="info-box-content">
                             <span class="info-box-text">Produk</span><span class="info-box-number">Click</span>
                              <div class="progress">
                                  <div class="progress-bar" style="width: 70%"></div>
                               </div>
                            <span class="progress-description"> Daftar Produk </span>
                          </div>
                          <!-- /.info-box-content -->
                      </div>
                       </a>
                      </div>

                  <div class="col-md-3 col-sm-6 col-xs-12">
                       <a href="index.php?page=ittransaksi">
                            <div class="info-box bg-yellow">
                              <span class="info-box-icon"><i class="glyphicon glyphicon-book"></i></span>
                              <div class="info-box-content">
                                  <span class="info-box-text">Transaksi</span>
                                  <span class="info-box-number">APROVAL</span>

                                  <div class="progress">
                                    <div class="progress-bar" style="width: 70%"></div>
                                  </div>
                                      <span class="progress-description">DATA TRANSAKSI</span>
                              </div>
                            </div>
                        </a>
                  </div>

                  <div class="col-md-3 col-sm-6 col-xs-12">
                     <a href=# onclick="batal()">
                      <div class="info-box bg-red"><span class="info-box-icon"><i class="fa fa-cog"></i></span>
                          <div class="info-box-content">
                             <span class="info-box-text"></span><span class="info-box-number">BATAL</span>
                              <div class="progress">
                                  <div class="progress-bar" style="width: 70%"></div>
                               </div>
                            <span class="progress-description"> BATALKAN TRANSAKSI </span>
                          </div>
                          <!-- /.info-box-content -->
                      </div>
                       </a>
                      </div>

                <?php }

                ?>

            </div>


              <!-- /.row -->
            <!--  ICON   -->
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
<script>
      function backupdb(){
        window.open("backup/index.php");
      }
      function batal()
      {
        $.ajax({
                        type: 'POST',
                        url: 'batal.php',
                        dataType: 'json',
                        success: function (res) {
                            alert(res.msg);
                        }
                    });
      }
</script>
