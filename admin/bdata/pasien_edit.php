<?php
date_default_timezone_set('Asia/Jakarta');
$data[5]='';
if(isset($_POST['save']))
{    
    
                $huruf=strtoupper (substr($nm_pasien, 0,1)); 
                $rj=mysqli_num_rows(mysqli_query($con,"SELECT norm FROM pasien_001 where nm_pasien like '$huruf%' order by norm desc LIMIT 1 "));
                if($rj==0)
                    {                        
                        $urut="0001";
                        $norm=$huruf."-".$urut;
                    }
                    else{
                            $huruf2=$huruf."-";                           
                            $xj = mysqli_fetch_array(mysqli_query($con,"SELECT CONCAT('$huruf2', LPAD((RIGHT(MAX(norm),4)+1),4,'0')) as norm1 
                                    FROM pasien_001 where norm like '$huruf%' "));
                            $norm=$xj['norm1'];
                        }                
    
    mysqli_query($con,"INSERT into pasien_001(norm,nm_pasien,kk,alamat,ktp,jns_kelamin,tempat_lahir,tgl_lahir,no_hp,info) 
                      values('$norm','$nm_pasien',' $kk','$al_pasien','$ktp','$jns_kelamin','$tempat_lahir','$tgl_lahir','$no_hp','$info' )");
    
      echo "
    <script>
    location.assign('index.php?page=pasien&ps=true2&norm=$norm');
    </script>
    ";
}
elseif(isset($_POST['update']))
{
    $norm=$_GET['id'];
    mysqli_query($con,"UPDATE pasien_001 set nm_pasien='$nm_pasien',kk='$kk',alamat='$al_pasien',ktp='$ktp',jns_kelamin='$jns_kelamin',
                tempat_lahir='$tempat_lahir',tgl_lahir='$tgl_lahir',no_hp='$no_hp',info='$info'
                where norm='".$_GET['id']."'");
    
    echo "
    <script>
    location.assign('index.php?page=pasien&ps=true2&norm=$norm');
    </script>
    ";
}
elseif(isset($_POST['delete']))
{
    //$norm=$_GET['id'];
    mysqli_query($con,"DELETE from pasien_001 where norm='".$_GET['id']."'");
    
    echo "
    <script>
    location.assign('index.php?page=pasien');
    </script>
    ";
}
/*pesan berhasil UPDATE*/
if(isset($_GET['ps'])=='true2')
{
    $norm=$_GET['norm'];
    echo "<div class='alert alert-success' role='alert'>Data Di Simpan NO.RM =<strong> $norm</strong></div>";
   
}
    
elseif(isset($_GET['ps'])=='true1')
    echo "<div class='alert alert-success' role='alert'>Data Berhasil Tersimpan</div>";

if(isset($_GET['id']))

$data=mysqli_fetch_row(mysqli_query($con,"SELECT * from pasien_001 where norm='".$_GET['id']."'"));

?>
    <style>
        #image-holder {
            margin-top: 8px;
        }
        
        #image-holder img {
            border: 8px solid #DDD;
            max-width:100%;
        }
    </style>
<!-- TASKBAR -->
<div class="row-fluid">
    <div class="span12">
        <ul class="breadcrumb">
            <li><a href="?page=dashboard">Home</a></li>
            <li><a href="?page=pasien">Data Pasien</a></li>
            <li class="pull-right">
                <div class="btn-group">                   
                    <a class="btn btn-success btn-xs" href="?page=pasien">
                                            <span class="fa fa-arrow-circle-o-left "> Kembali</span>
                                          </a>
                </div>
            </li>
        </ul>
     <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Pasien</h3>
                </div>
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="id" value="<?php echo isset($_GET['id'])?$_GET['id']:''; ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nm_pasien" class="col-sm-2 control-label">Nama Pasien</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Nama Pasien" name="nm_pasien" id="nm_pasien" value="<?php echo isset($data[1])?$data[1]:''; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kk" class="col-sm-2 control-label">Kepala Keluarga</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Kepala Keluarga" name="kk" id="kk" value="<?php echo isset($data[2])?$data[2]:''; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="al_pasien" class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Alamat Pasien" name="al_pasien" id="al_pasien" value="<?php echo isset($data[3])?$data[3]:''; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ktp" class="col-sm-2 control-label">NO.KTP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Nomor KTP" name="ktp" id="ktp" value="<?php echo isset($data[4])?$data[4]:''; ?>">
                            </div>
                        </div>                        

                        <div class="form-group">
                            <label for="jns_kelamin" class="col-sm-2 control-label">Jenis Kelamin</label>
                            <div class="col-sm-10"> 
                                <select name="jns_kelamin" id="jns_kelamin" class="form-control" data-placeholder="Gender">
                                    <option value=""></option>
                                    <option value="L" <?php if($data[5]=='L')echo 'SELECTED';?> >LAKI - LAKI</option>
                                    <option value="P" <?php if($data[5]=='P') echo 'SELECTED';?> >PEREMPUAN</option>
                                </select>
                            </div>                          
                          </div>
                        <div class="form-group">
                            <label for="tempat_lahir" class="col-sm-2 control-label">Tempat Lahir</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir" id="tempat_lahir" value="<?php echo isset($data[6])?$data[6]:''; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir" class="col-sm-2 control-label">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Tanggal Lahir" name="tgl_lahir" id="tgl_lahir" value="<?php echo isset($data[7])?$data[7]:''; ?>">
                            </div>
                        </div>                       

                        <div class="form-group">
                            <label for="no_hp" class="col-sm-2 control-label">NO. HP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Nomor Handphone" name="no_hp" id="no_hp" value="<?php echo isset($data[8])?$data[8]:''; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="info" class="col-sm-2 control-label">Info</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Informasi Lain" name="info" id="info" value="<?php echo isset($data[12])?$data[12]:''; ?>">
                            </div>
                        </div>
                          <!--
                        <div class="form-group ">
                                    <label for="agama" class="col-sm-2 control-label">Agama</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="agama" name="agama" data-placeholder="Pilih Agama" tabindex="1">
                                        <option value=""></option>
                                        <?php $ar_agama=array("islam"=>"ISLAM","kristen"=>"KRISTEN","katholik"=>"KHATOLIK","hindu"=>"HINDU","budha"=>"BUDHA","konghuchu"=>"KONGHUCHU");
                                        foreach($ar_agama as $key=>$val):
                                            if($key==$agama){
                                                echo "<option value=$key selected>$val</option>";
                                            }else{
                                            echo "<option value=$key>$val</option>";
                                            }
                                        endforeach;?>
                                    </select>                                        
                                    </div>
                                </div>

                        </div> -->
                    <!-- /.box-body -->
                    <div class="box-footer pull-right">
                        <a class="btn btn-warning" href="?page=pasien">
                                            <span > Batal</span>
                                          </a>
                        <input onclick="change_url()" type="submit" class="btn btn-primary" value="Simpan" name="<?php echo isset($_GET['id'])?'update':'save'; ?>">

                        
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
    <script src="plugins/datepicker/js/bootstrap-datepicker.js"></script>
     <script>
            $(document).ready(function () {
                $("#agama").select2({
                    placeholder: "Pilih"
                });
                $("#jns_kelamin").select2({
                    placeholder: "Gender"
                });

            });
        </script>
    <script type="text/javascript">
    $('#tgl_lahir').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });
    </script>