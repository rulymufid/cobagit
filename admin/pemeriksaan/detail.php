<?php
      if(!isset($_SESSION['level'])){
          //jika session belum di set/register
          echo"<script> document.location = '../index.php'; </script>";
      }
        include "./config/mysqliserver.php";
      $id_periksa=mysqli_real_escape_string($con,$_GET['id']);

      $query=mysqli_query($con,"SELECT a.pasien_norm, a.dokter_id, a.perawat_id, b.nm_pasien , b.alamat_pasien, b.tgllahir_pasien,
              a.jml_print
              from periksa as a
              inner join pasien as b on a.pasien_norm=b.norm
              where a.id_periksa='$id_periksa'");
      $h=mysqli_fetch_array($query);
      $norm=$h["pasien_norm"];
      $nm_pasien=$h["nm_pasien"];
      $alamat_pasien=$h["alamat_pasien"];
      $dokter_id=$h["dokter_id"];
      $perawat_id=$h["perawat_id"];
      $tgllahir_pasien=$h["tgllahir_pasien"];
      $jml_print=$h["jml_print"];

?>

    <HEAD>
        <link rel="stylesheet" href="plugins/css/style.css"/>
        <script type="text/javascript" src="../bootstrap/js/autoNumeric.js"></script>
        <script type="text/javascript">
            jQuery(function($) {
            $('.autorp').autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'});
            });
        </script>

        <script type="text/javascript" language="javascript" >

            var tableobat;
            var id_periksa=<?php echo $id_periksa ?>;
            // #tbdetail adalah id pada table
            $(document).ready(function() {
                tableobat = $('#tbdetail').DataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bJQueryUI": false,
                    "responsive": true,
                    "sAjaxSource": "pemeriksaan/detail_obat_server.php?id="+id_periksa, // Load Data
                    "sServerMethod": "POST",
                    "columnDefs": [
                    { "orderable": false, "targets": 0, "searchable": false },
                    { "orderable": true, "targets": 1, "searchable": true },
                    { "orderable": true, "targets": 2, "searchable": true },
                    { "orderable": true, "targets": 3, "searchable": true },
                    { "orderable": true, "targets": 4, "searchable": true },
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
    <div class="col-xs-12" style="margin-bottom:10px;background: #ebebf5;padding:5px;">
      <div class="col-md-6">
              <div class="form-group">
                  <label for="nm_produk" class="col-sm-4 control-label">ID PERIKSA </label>
                  <div class="col-sm-8">
                      <label for="nm_produk" class="control-label"> : <?php echo $id_periksa;?> </label>
                  </div>
              </div>
              <div class="form-group">
                  <label for="nm_produk" class="col-sm-4 control-label">Pasien </label>
                  <div class="col-sm-8">
                      <label for="nm_produk" class="control-label"> : <?php echo $norm.' - '.$nm_pasien;?> </label>
                  </div>
              </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
              <label for="nm_produk" class="col-sm-4 control-label">Alamat </label>
              <div class="col-sm-8">
                  <label for="nm_produk" class="control-label"> : <?php echo $alamat_pasien;?> </label>
              </div>
          </div>

          <div class="form-group">
              <label for="nm_produk" class="col-sm-4 control-label">Tgl Lahir </label>
              <div class="col-sm-8">
                  <label for="nm_produk" class="control-label"> : <?php echo $tgllahir_pasien;?> </label>
              </div>
          </div>
      </div>
    </div>

    <div class="col-xs-12">

        <div>

            <!-- /.box-header -->
            <div class="col-lg-6">
                  <div class="form-group" style="min-height:30px">
                        <label for="dokter" class="col-sm-3 control-label">Dokter</label>
                        <div class="col-sm-9">
                          <select class="form-control" id="dokter" name="dokter" style="width:200px;line-height:20px">
                                <option value="">PILIH DOKTER</option>

                                <?php
                                $brg=mysqli_query($con,"SELECT id_karyawan, nm_karyawan from karyawan
                                      where jabatan='dokter' order by nm_karyawan asc");
                                while($b=mysqli_fetch_array($brg)){
                                    ?>
                                    <option value="<?php echo $b['id_karyawan']; ?>"
                                                    <?php
                                                        if(isset($dokter_id)){
                                                            if($b['id_karyawan']==$dokter_id){echo "selected";}else{}
                                                        }
                                                    ?>
                                        ><?php echo $b['nm_karyawan'] ?></option>
                                    <?php
                                    }
                                ?>

                            </select>
                          </div>
                    </div>
                    <div class="form-group" style="min-height:30px">
                          <label for="perawat" class="col-sm-3 control-label">Perawat</label>
                          <div class="col-sm-9">
                            <select class="form-control" id="perawat" name="perawat" style="width:200px;line-height:20px">
                                  <option value="">PILIH PERAWAT</option>

                                  <?php
                                  $brg=mysqli_query($con,"SELECT id_karyawan, nm_karyawan from karyawan
                                        where jabatan='perawat' order by nm_karyawan asc");
                                  while($b=mysqli_fetch_array($brg)){
                                      ?>
                                      <option value="<?php echo $b['id_karyawan']; ?>"
                                                      <?php
                                                          if(isset($perawat_id)){
                                                              if($b['id_karyawan']==$perawat_id){echo "selected";}else{}
                                                          }
                                                      ?>
                                          ><?php echo $b['nm_karyawan'] ?></option>
                                      <?php
                                      }
                                  ?>

                              </select>
                            </div>
                      </div>
                      <div class="form-group" style="min-height:30px;padding-top:30px;padding-bottom:10px">
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
                                  <input type="text" class="form-control autorp" id="harga" name="harga" placeholder="harga">
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
                <div class="row form-group" style="padding-top:10px;padding-left:10px">
                      <label for="petugas" class="col-xs-3 col-sm-2 control-label">Subtotal </label>
                      <div class="col-xs-9 col-sm-10 ">
                        : <label id="stotalb">0</label>
                        <label id="stotalbh" hidden="">0</label>
                      </div>
                        <label for="petugas" class="col-xs-3 col-sm-2 control-label">Diskon </label>
                        <div class="col-xs-9 col-sm-10 ">
                          : <label id="tdiskon">0</label>
                          <label id="tdiskonh" hidden="">0</label>
                        </div>
                          <label for="petugas" class="col-xs-3 col-sm-2 control-label">Total </label>
                          <div class="col-xs-4 col-sm-3 ">
                            : <label id="totalb">0</label>
                            <label id="totalbh" hidden="">0</label>
                          </div>
                          <div class="col-xs-4 col-sm-3 ">
                            <a class="btn btn-primary btn-xs" onclick="bulatkan()">
                              <span class="glyphicon glyphicon-refresh"></span> BULATKAN
                            </a>
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
                  <button onclick="print(<?php echo $id_periksa ?>)"> CETAK </button>
                  <button onclick="location.href='?page=pemeriksaan&<?php echo $dataCari; ?>&vdata=<?php echo $_COOKIE['tCari']; ?>';"> kembali </button>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
</div>
    <!-- /.col -->
    <div class="modal fade" id="modal_obat" tabindex="-1" role="dialog" aria-labelledby="label_input" aria-hidden="true" style="overflow-y: auto;height: auto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="judul_modal">Edit Obat</h4>
                    </div>
                    <div class="modal-body" >
                        <form class="form-horizontal" id="forminput">

                             <input type="hidden" class="form-control" id="id_obat" name="id_obat">
                             <input type="hidden" class="form-control" id="type" name="type">

                             <div class="form-group">
                                  <h3 class="col-sm-12" id="nm_obat" name="nm_obat">Nama Obat</h3>
                             </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" onClick="submit()" class="btn btn-default" data-dismiss="modal">OK</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
    </div>



    <script src="plugins/datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
            $(document).ready(function () {
              gettotalp();
              $("#dokter").select2({
                  placeholder: "Pilih Dokter"
              });

              $("#perawat").select2({
                  placeholder: "Pilih Perawat"
              });

              $("#kd_item").select2({
                  placeholder: "Pilih OBAT/JASA..."
              });

              $('#dokter').change(function(){
          			   var id_dokter = $('#dokter').val();
                   var id_periksa= <?php echo $id_periksa;?>;
                   var type='updatedokter';

                    $.ajax({
                        type: "POST",
                        url: "pemeriksaan/detail_crud.php",
                        dataType: 'json',
                        data: {id_periksa: id_periksa,type:type,id_dokter:id_dokter},
                        success: function(res) {
                            if (res.tipe=='gagal') {
                                alert(''+res.msg);
                            }
                            else{}
                        }
                    });
          		});

              $('#perawat').change(function(){
          			   var id_perawat = $('#perawat').val();
                   var id_periksa= <?php echo $id_periksa;?>;
                   var type='updateperawat';

                    $.ajax({
                        type: "POST",
                        url: "pemeriksaan/detail_crud.php",
                        dataType: 'json',
                        data: {id_periksa: id_periksa,type:type,id_perawat:id_perawat},
                        success: function(res) {
                            if (res.tipe=='gagal') {
                                alert(''+res.msg);
                            }
                            else{}
                        }
                    });
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


            });

            function hapus(id_detail,type,nm_obat)
                    {
                        /*
                      //var jml_print=;
                      if (jml_print>0) {
                        swal({text:'Sudah Pernah Di Print Tidak Bisa Dihapus', icon:'warning'});
                      }
                      else {

                        $("#modal_obat").modal("show");
                        $("#judul_modal").html("HAPUS ");
                        $("#id_obat").val(id_detail);
                        $("#type").val("hapusobat");
                        $("#nm_obat").html("Yakin Hapus "+nm_obat+" ?");
                      }
                      */
                      $("#modal_obat").modal("show");
                      $("#judul_modal").html("HAPUS ");
                      $("#id_obat").val(id_detail);
                      $("#type").val("hapusobat");
                      $("#nm_obat").html("Yakin Hapus "+nm_obat+" ?");
                    }
        function submit()  //hapus
                        {

                                  //var formData = $("#forminput").serialize();
                                  var id_detail=$("#id_obat").val();
                                  var type=$("#type").val();
                                  var id_periksa= <?php echo $id_periksa;?>;

                                  $.ajax({
                                      type: "POST",
                                      url: "pemeriksaan/detail_crud.php",
                                      dataType: 'json',
                                      data: {id_detail:id_detail,id_periksa:id_periksa, type:type },
                                      success: function(res) {
                                          if (res.tipe=='sukses') {
                                              tableobat.ajax.reload(); // Untuk Reload Tables secara otomatis
                                              gettotalp();
                                          }
                                          else {
                                            tableobat.ajax.reload();
                                            waitingDialog.hide();
                                            swal({text:''+res.msg, icon:'warning'});

                                          }
                                      }
                                  });
                        }

        function print(id)
            {
              window.open("cetak/cetak_periksa.php?id="+id);
            }

            function gettotalp(){
                var id_periksa=<?php echo $id_periksa; ?>;
                var type='gettotal';
                $.ajax({
                    type: "POST",
                    url: "pemeriksaan/detail_crud.php",
                    dataType: 'json',
                    data: {id_periksa: id_periksa,type:type},
                    success: function(res) {
                        if (res.tipe=='sukses') {
                            if(res.total==null){var total='0'}else{var total=res.total;}
                            if(res.diskon==null){var diskon='0'}else{var diskon=res.diskon;}
                            var totalb=res.total;
                            var diskonn=res.diskon;
                            var bayar_pasien=res.bayar_pasien;
                            var nbayar=res.total-res.diskon;
                            var totalbayar=res.total-res.diskon;
                            if(res.bayar_pasien>0){var kembalian=bayar_pasien-totalbayar;}else{var kembalian=0;}
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
                            $('#totalbh').text(''+nbayar);
                            $('#nombayar').val(''+bayar_pasien);
                            $('#kembalian').text(''+kembalian);
                        }
                        else{
                        }
                    }
                });
            }
        function bulatkan(){
                    var id_periksa= <?php echo $id_periksa;?>;
                    var type="bulatkan";
                    $.ajax({
                        type: "POST",
                        url: "pemeriksaan/detail_crud.php",
                        dataType: 'json',
                        data: {id_periksa:id_periksa, type:type },
                        success: function(res) {
                            if (res.tipe=='sukses') {
                                tableobat.ajax.reload(); // Untuk Reload Tables secara otomatis
                                gettotalp();
                                waitingDialog.hide();
                            }
                            else {
                              tableobat.ajax.reload();
                              waitingDialog.hide();
                              swal({text:''+res.msg, icon:'warning'});

                            }
                        }
                    });

        }

        function tambahkan(){

                 var id_periksa=<?php echo $id_periksa ?>;
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
                    $("#modal_warning").modal("show");
                    $("#isi_warning").text('Pilih Item');
                 }

                 else if (jml=='') {
                    $("#modal_warning").modal("show");
                    $("#isi_warning").text('Isi Jumlah Item');
                 }
                 /*
                 else if (jml>stok) {
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
                           url: "pemeriksaan/detail_crud.php",
                           dataType: 'json',
                           data: {id_periksa: id_periksa,type:type, kd_item:kd_item, jml:jml, harga:harga, diskon:jdiskon},
                           success: function(res) {
                              $("#btn-tambah").removeClass('disabled');

                               if (res.tipe=='sukses') {
                                 tableobat.ajax.reload(); // Untuk Reload Tables secara otomatis
                                 gettotalp();
                                 waitingDialog.hide();

                               }
                               else{
                                 waitingDialog.hide();
                                 $("#modal_warning").modal("show");
                                 $("#modal_warning").modal("show");
                                 $("#isi_warning").text(''+res.msg);
                               }
                           }
                       });
                 }


        }

        function nombayar()
        {
              var id_periksa=<?php echo $id_periksa ?>;
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
                    url: "pemeriksaan/detail_crud.php",
                    dataType: 'json',
                    data: {id_periksa: id_periksa,type:'bayarperiksa',nombayar:nombayar},
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
