<script type="text/javascript" src="../bootstrap/js/autoNumeric.js"></script>
<script type="text/javascript">
jQuery(function($) {
    $('.autorp').autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
});
</script>
<?php
      if(!isset($_SESSION['level'])){
          //jika session belum di set/register
          echo"<script> document.location = '../index.php'; </script>";
      }
        include "./config/mysqliserver.php";
      $id_penjualan=mysqli_real_escape_string($con,$_GET['id']);

      $query=mysqli_query($con,"SELECT id_karyawan,bayar_customer from penjualan where id_penjualan='$id_penjualan'");
      $h=mysqli_fetch_array($query);
      $id_karyawan=$h["id_karyawan"];
      $bayar_customer=$h["bayar_customer"];
      if ($bayar_customer>0) {
          $bayar_customer=$h["bayar_customer"];
      }
      else {
            $bayar_customer="";
      }

?>

    <HEAD>
<link rel="stylesheet" href="plugins/css/style.css"/>

        <script type="text/javascript" language="javascript" >

            var tableobat;
            var id_penjualan=<?php echo $id_penjualan ?>;
            // #tbdetail adalah id pada table
            $(document).ready(function() {
                tableobat = $('#tbdetail').DataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bJQueryUI": false,
                    "responsive": true,
                    "sAjaxSource": "penjualan/detail_obat_server.php?id="+id_penjualan, // Load Data
                    "sServerMethod": "POST",
                    "columnDefs": [
                    { "orderable": false, "targets": 0, "searchable": false },
                    { "orderable": true, "targets": 1, "searchable": true },
                    { "orderable": true, "targets": 2, "searchable": true },
                    { "orderable": true, "targets": 3, "searchable": true },
                    { "orderable": true, "targets": 4, "searchable": true },
                    { "orderable": true, "targets": 5, "searchable": true },
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

                $('#tbdetail').removeClass( 'display' ).addClass('table table-striped table-bordered');


            } );


        </script>
        <style type="text/css">
          .select2-container {
            margin-bottom: 5px;
          }
        </style>
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
<div class="row bg-white">
  <div>
      <h3 class="box-title" style="margin-left:5px;">DETAIL PENJUALAN <?php echo $id_penjualan; ?> </h3>&nbsp;&nbsp;&nbsp;
  </div>

    <div class="col-xs-12">

        <div>

            <!-- /.box-header -->
            <div class="col-lg-6">
              <div class="form-group" style="min-height:30px">
                    <label for="petugas" class="col-sm-3 control-label">Petugas</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="petugas" name="petugas" style="line-height:20px">
                            <option value="">PILIH PETUGAS</option>

                            <?php
                            $brg=mysqli_query($con,"SELECT id_karyawan, nm_karyawan from karyawan
                                  order by nm_karyawan asc");
                            while($b=mysqli_fetch_array($brg)){
                                ?>
                                <option value="<?php echo $b['id_karyawan']; ?>"
                                                <?php
                                                    if(isset($id_karyawan)){
                                                        if($b['id_karyawan']==$id_karyawan){echo "selected";}else{}
                                                    }
                                                ?>
                                    ><?php echo $b['nm_karyawan'] ?></option>
                                <?php
                                }
                            ?>

                        </select>
                      </div>
                </div>
                      <div class="form-group" style="min-height:30px;padding-bottom: 30px">
                            <label for="item" class="col-sm-3 control-label">ITEM</label>
                            <div class="col-sm-9">
                              <select class="form-control" id="kd_item" name="kd_item" style="width:200px;line-height:20px">
                                    <option value="">PILIH OBAT/JASA/TINDAKAN</option>

                                    <?php
                                    $brg=mysqli_query($con,"SELECT id_obat, nm_obat from obat
                                                            order by nm_obat asc");
                                    while($b=mysqli_fetch_array($brg)){
                                        ?>
                                        <option value="<?php echo $b['id_obat']; ?>" ><?php echo $b['nm_obat'] ?></option>
                                        <?php
                                        }
                                    ?>

                                </select>
                              </div>
                              <div class="col-lg-3">
                              </div>
                              <div class="col-lg-9 col-xs-12">
                                <div class="col-xs-6" style="padding-left:0px!important;padding-bottom:5px;">
                                  <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="jumlah">
                                </div>
                                <div class="col-xs-6" style="padding-left:0px!important;padding-bottom:5px;">
                                  <input type="number" class="form-control" id="stok" name="stok" placeholder="Stok" readonly>
                                </div>
                                <div class="col-xs-6" style="padding-left:0px!important;padding-bottom:5px;">
                                  <input type="text" class="form-control" id="harga" name="harga" placeholder="harga">
                                </div>
                                <div class="col-xs-6" style="padding-left:0px!important;padding-bottom:5px;">
                                  <div class="col-xs-6" style="padding-left:0px!important;padding-bottom:5px;">
                                    <select class="form-control" id="tipe_diskon" name="tipe_diskon" style="line-height:20px">
                                          <option value="1">%</option>
                                          <option value="2">Rp</option>
                                    </select>
                                  </div>
                                  <div class="col-xs-6" style="padding-left:0px!important;padding-bottom:5px;padding-right:0px!important;">
                                    <input type="text" class="form-control" id="diskon" name="diskon" placeholder="diskon">
                                  </div>
                                </div>

                              </div>

                        </div>
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-9">
                          <div class="form-group" style="min-height:30px;padding-top:10px;padding-bottom: 30px">
                            <button class="btn-success" href="#" onclick="tambahkan()" id="btn-tambah" name="btn-tambah">
                              <span class="glyphicon glyphicon-plus"></span>  Tambahkan
                            </button>
                          </div>
                        </div>
            </div>

            <div class="col-lg-6" style="padding:0px!important;margin:0px!important">
              <div class="box-body">
                  <table id="tbdetail"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                      <thead>
                          <tr>
                            <th>Action</th>
                            <th>Obat</th>
                            <th>Jml</th>
                            <th>hrg</th>
                            <th>diskon</th>
                            <th>Total</th>
                          </tr>
                      </thead>
                  </table>


              </div>
            </div>


              <div class="col-lg-6 box-biru no-padding">
                  <div class="form-group" style="padding-top:10px;">
                        <label for="petugas" class="col-sm-2 control-label">Subtotal </label>
                        <div class="col-sm-10">
                          : <label id="stotalb">0</label>
                          <label id="stotalbh" hidden="">0</label>
                        </div>
                    </div>
                    <div class="form-group" style="padding-top:10px;">
                          <label for="petugas" class="col-sm-2 control-label">Diskon </label>
                          <div class="col-sm-10">
                            : <label id="tdiskon">0</label>
                            <label id="tdiskonh" hidden="">0</label>
                          </div>
                      </div>
                      <div class="form-group" style="padding-top:10px;">
                            <label for="petugas" class="col-sm-2 control-label">Total </label>
                            <div class="col-sm-10">
                              : <label id="totalb">0</label>
                              <label id="totalbh" hidden="">0</label>
                            </div>
                        </div>
                      <div class="form-group" style="padding-top:10px;">
                              <label for="bayar" class="col-sm-2 control-label">Bayar </label>
                              <div class="col-sm-10">
                                <input onchange="nombayar()" type="text" class="form-control autorp" id="nombayar" name="nombayar" placeholder="nominal uang" value="<?php echo $bayar_customer?>" >
                              </div>
                      </div>
                      <div class="form-group" style="padding-top:10px;">
                            <label for="petugas" class="col-sm-2 control-label">Kembalian </label>
                            <div class="col-sm-10">
                              : <label id="kembalian">0</label>
                            </div>
                        </div>
                </div>

            <br>
            <?php
              if (isset($_GET["vdata"])) {
                  $dataCari = $_GET["vdata"];
              }
              else{$dataCari = "";}
            ?>
            <div class="col-lg-12 " style="padding-left:6px!important;">
                  <button onclick="print('<?php echo $id_penjualan;?>')"> CETAK </button>
                  <button onclick="location.href='?page=penjualan&<?php echo $dataCari; ?>&vdata=<?php echo $_COOKIE['tCari']; ?>';"> kembali </button>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
</div>
    <!-- /.col -->



    <script src="plugins/datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
            $(document).ready(function () {
              gettotal();
              $("#petugas").select2({
                  placeholder: "Pilih Petugas..."
              });
              $("#kd_item").select2({
                  placeholder: "Pilih OBAT/JASA..."
              });

              $('#kd_item').change(function(){
                   var kd_item = $('#kd_item').val();
                   var type='get_obat';
                   $.ajax({
                       type: "POST",
                       url: "pemeriksaan/get_data.php",
                       dataType: 'json',
                       data: {kd_item: kd_item,type:type},
                       success: function(res) {
                            $("#stok").val(''+res.qty);
                            $("#harga").val(''+res.harga);
                            $("#diskon").val('0');
                       }
                   });
              });
              $('#petugas').change(function(){
          			   var id_petugas = $('#petugas').val();
                   var id_penjualan= <?php echo $id_penjualan;?>;
                   var type='updatepetugas';

                    $.ajax({
                        type: "POST",
                        url: "penjualan/detail_crud.php",
                        dataType: 'json',
                        data: {id_penjualan: id_penjualan,type:type,id_petugas:id_petugas},
                        success: function(res) {
                            if (res.tipe=='gagal') {
                              swal({text:''+res.msg, icon:'warning'});
                            }
                            else{}
                        }
                    });
          		});

            });

            function print(id)
                {
                  window.open("cetak/cetak_apotik.php?id="+id);
                }

        function gettotal(){
            var id_penjualan=<?php echo $id_penjualan ?>;
            var type='gettotal';
            $.ajax({
                type: "POST",
                url: "penjualan/detail_crud.php",
                dataType: 'json',
                data: {id_penjualan: id_penjualan,type:type},
                success: function(res) {
                    if (res.tipe=='sukses') {
                        if(res.total==null){var total='0'}else{var total=res.total;}
                        if(res.diskon==null){var diskon='0'}else{var diskon=res.diskon;}
                        var bayar_customer=res.bayar_customer;
                        var totalb=res.total;
                        var diskonn=res.diskon;
                        var totalbayar=res.total-res.diskon;
                        if(res.bayar_customer>0){var kembalian=bayar_customer-totalbayar;}else{var kembalian=0;}


                        $('#totalbh').text(''+totalbayar);
                                                      //format rupiah
                        var	number_string = totalb.toString(),
                           sisa 	= number_string.length % 3,
                           subtotal 	= number_string.substr(0, sisa),
                           ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                          if (ribuan) {
                           separator = sisa ? '.' : '';
                           subtotal += separator + ribuan.join('.');
                          }

                        var	number_diskon = diskonn.toString(),
                             sisa2 	= number_diskon.length % 3,
                             ndiskon 	= number_diskon.substr(0, sisa2),
                             ribuan2 	= number_diskon.substr(sisa2).match(/\d{3}/g);

                            if (ribuan2) {
                             separator2 = sisa2 ? '.' : '';
                             ndiskon += separator2 + ribuan2.join('.');
                            }
                       var	number_totalbayar = totalbayar.toString(),
                                 sisa3 	= number_totalbayar.length % 3,
                                 totalbayar 	= number_totalbayar.substr(0, sisa3),
                                 ribuan3 	= number_totalbayar.substr(sisa3).match(/\d{3}/g);

                                if (ribuan3) {
                                 separator3 = sisa3 ? '.' : '';
                                 totalbayar += separator3 + ribuan3.join('.');
                                }

                        $('#stotalb').text(''+subtotal);
                        $('#tdiskon').text(''+ndiskon);
                        $('#totalb').text(''+totalbayar);
                        $('#nombayar').val(''+bayar_customer);
                        $('#kembalian').text(''+kembalian);
                    }
                    else{
                    }
                }
            });
        }

        function tambahkan(){
           var id_penjualan=<?php echo $id_penjualan ?>;
           var jml=$('#jumlah').val();
           var stok=$('#stok').val();
           var harga=$('#harga').val();
           var tipe_diskon=$('#tipe_diskon').val();
           var diskon=$('#diskon').val();
           var kd_item=$('#kd_item').val();
           var type='tambahkan';

           $("#btn-tambah").addClass('disabled');
           // kasih filter jml>stok

           if (kd_item=='') {
                swal({text:'PILIH ITEM'});
           }
           else if (jml=='') {
              swal({text:'ISI JUMLAH ITEM'});
           }
          /* else if (jml>stok){
              swal({text:'Stok tidak mencukupi', icon:'warning'});
           } */
           else {
                   if (tipe_diskon=='1') {
                     var harga= harga.replace(".","");
                      var jdiskon=harga*(diskon/100);
                   }
                   else{ var jdiskon=diskon; }
                 waitingDialog.show();
                 $.ajax({
                     type: "POST",
                     url: "penjualan/detail_crud.php",
                     dataType: 'json',
                     data: {id_penjualan: id_penjualan,type:type, kd_item:kd_item, jml:jml, harga:harga,diskon:jdiskon},
                     success: function(res) {
                        $("#btn-tambah").removeClass('disabled');

                         if (res.tipe=='sukses') {
                           tableobat.ajax.reload(); // Untuk Reload Tables secara otomatis
                           gettotal();
                           waitingDialog.hide();

                         }
                         else{
                           waitingDialog.hide();
                           swal({text:''+res.msg});
                         }
                     }
                 });
           }
        }

        function hapus(id_detailjual)
        {
            var id_penjualan=<?php echo $id_penjualan; ?>;
            swal({
                  title: "Apakah Anda Yakin?",
                  text: "setelah di hapus tidak dapat di batalkan lagi",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    waitingDialog.show();
                    $.ajax({
                        type: "POST",
                        url: "penjualan/detail_crud.php",
                        dataType: 'json',
                        data: {id_penjualan: id_penjualan,type:'hapus', id_detailjual:id_detailjual},
                        success: function(res) {
                           $("#btn-tambah").removeClass('disabled');

                            if (res.tipe=='sukses') {
                              tableobat.ajax.reload(); // Untuk Reload Tables secara otomatis
                              gettotal();
                              waitingDialog.hide();

                            }
                            else{
                              tableobat.ajax.reload(); // Untuk Reload Tables secara otomatis
                              waitingDialog.hide();
                              swal({text:''+res.msg, icon:'warning'});
                            }
                        }
                    });
                  }
                  else {
                      tableobat.ajax.reload();
                  }
                });

        }

        function nombayar()
        {
              var id_penjualan=<?php echo $id_penjualan ?>;
              var totalbayar1=document.getElementById("totalbh").textContent;
              var totalbayar = parseInt(totalbayar1);
              var nombayar= $('#nombayar').val();
              var nombayar= nombayar.replace(".","");
              var kembalian=nombayar-totalbayar;

              var	number_kembalian = kembalian.toString(),
                   sisak 	= number_kembalian.length % 3,
                   kembalian 	= number_kembalian.substr(0, sisak),
                   ribuank 	= number_kembalian.substr(sisak).match(/\d{3}/g);

                  if (ribuank) {
                   separatork = sisak ? '.' : '';
                   kembalian += separatork + ribuank.join('.');
                  }

              $.ajax({
                    type: "POST",
                    url: "penjualan/detail_crud.php",
                    dataType: 'json',
                    data: {id_penjualan: id_penjualan,type:'bayarjual',nombayar:nombayar},
                    success: function(res) {
                        if (res.tipe=='sukses') {
                                        $('#kembalian').text(''+kembalian);
                        }
                        else {
                            swal({text:''+res.msg, icon:'warning'});
                        }
                    }
                });
        }

    </script>
