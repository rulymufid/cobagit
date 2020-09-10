
<?php
date_default_timezone_set('Asia/Jakarta');
$data[5]='';
if(isset($_POST['save']))
{


}
elseif(isset($_POST['update']))
{
    mysqli_query($con,"UPDATE karyawan set nm_karyawan='$nm_user',hp_karyawan='$hp_user'
                where id_karyawan='$id_karyawan'");
    mysqli_query($con,"UPDATE users set username='$username'
                where id_user=".$id_user."");

    if ($password!="") {
      $pwd=md5($password);
      mysqli_query($con,"UPDATE users set password='$pwd'
                  where id_user=".$id_user."");
    }
                            #INSERT GAMBAR 3
                              if(isset($_FILES['foto'])){

                                              $file_name = $_FILES['foto']['name'];
                                              $file_size = $_FILES['foto']['size'];
                                              $file_tmp  = $_FILES['foto']['tmp_name'];

                                              $t = explode(".", $file_name);
                                              $t1 = end($t);
                                              $file_ext = strtolower(end($t));

                                              $ext_boleh = array("jpg");

                                              if(in_array($file_ext, $ext_boleh)) {
                                                  $sumber = $file_tmp;
                                                  $tujuan = "img/".$id_user."_user.jpg";

                                                  list($width, $height) = getimagesize($sumber);

                                                      move_uploaded_file($sumber, $tujuan);


                                              }else  {
                                              }
                                  }else{}
                                  #END INSERT GAMBAR 3

                                  echo "<script>location.assign('index.php?page=dashboard');</script>";
}




if(isset($id_user))

$data=mysqli_fetch_row(mysqli_query($con,"SELECT a.id_karyawan, b.nm_karyawan,b.hp_karyawan,a.username
from users as a
inner join karyawan as b on a.id_karyawan=b.id_karyawan
where id_user=".mysqli_real_escape_string($con,$id_user).""));

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


    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Profil</h3>
                </div>
                <form class="form-horizontal" method="post" enctype="multipart/form-data" name="forminput">
                   <input type="hidden" name="id" value="<?php echo isset($id_user)?$id_user:''; ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nm_user" class="col-sm-2 control-label">Nama </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control  hidden" name="id_karyawan" id="id_karyawan" value="<?php echo isset($data[0])?$data[0]:''; ?>" >
                                <input type="text" class="form-control" placeholder="Input Nama Lengkap" name="nm_user" id="nm_user" value="<?php echo isset($data[1])?$data[1]:''; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hp_user" class="col-sm-2 control-label">No. HP</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" placeholder="input no. hp contoh : 08572692XXXX" name="hp_user" id="hp_user" value="<?php echo isset($data[2])?$data[2]:''; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hp_user" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="username untuk login" name="username" id="username" value="<?php echo isset($data[3])?$data[3]:''; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hp_user" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="isi jika ingin di ubah" name="password" id="password" value="">
                            </div>
                        </div>

                        <!-- UPLOAD foto-->
                        <div class="form-group">
                            <label for="foto" class="col-sm-2 control-label">foto</label>
                            <div class="col-sm-6">
                                <input type="file" name="foto" id="foto" />
                            </div>
                        </div>
                        <?php
                            if(isset($id_user)){ ?>
                                <div class="form-group">
                                    <label for="gb" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-6">
                                            <img src="img/<?php echo $id_user."_user.jpg"; ?>" width="90">
                                    </div>
                                </div>
                           <?php }
                        ?>

                    <div class="box-footer pull-right">
                        <a class="btn btn-warning" href="?page=dashboard">
                                            <span > Batal</span>
                                          </a>
                        <input onclick="change_url()" type="submit" class="btn btn-primary" value="Simpan" name="<?php echo isset($id_user)?'update':'save'; ?>">


                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
        <!--/.col (right) -->
    </div>
  </div>
