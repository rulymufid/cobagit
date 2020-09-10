<?php
    $id_user=$_SESSION['id_user'];
    $level=$_SESSION['level'];
?>
<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
                <img src="img/<?php echo $id_user."_user";?>.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">

              <p><?php echo $_SESSION['nm_user']; ?></p>
              <a href="../logout.php"><i class="fa fa-circle text-warning"></i> LOG OUT</a>
            </div>
          </div>
          <!-- search form -->

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

                  <li><a href="index.php?page=pasien"><i class="fa fa-users"></i> <span>Pasien</span></a></li>
                  <li><a href="index.php?page=antrian"><i class="glyphicon glyphicon-tasks"></i> <span>Antrian</span></a></li>
                  <li><a href="index.php?page=pemeriksaan"><i class="fa fa-heart"></i> <span>Pemeriksaan</span></a></li>
                  <li class="treeview">
                    <a href="#">
                      <i class="fa fa-tags"></i> <span>DATA-DATA</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="index.php?page=obat"><i class="glyphicon glyphicon-list"></i> <span>Data Obat</span></a></li>
                      <li><a href="index.php?page=jasa"><i class="glyphicon glyphicon-list"></i> <span>Data Jasa/Tindakan</span></a></li>
                      <li><a href="index.php?page=karyawan"><i class="glyphicon glyphicon-list"></i> <span>Data Karyawan</span></a></li>
                    </ul>
                  </li>
                  <li><a href="index.php?page=penjualan"><i class="fa fa-money"></i> <span>Penjualan Obat</span></a></li>
                  <li><a href="index.php?page=profil"><i class="fa fa-user"></i> <span>Profil</span></a></li>
              <?php
                if ($level=="admin") { ?>

                          <li class="treeview">
                            <a href="#">
                              <i class="glyphicon glyphicon-book"></i> <span>MENU OWNER</span>
                              <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                              <li><a href="index.php?page=laporan"><i class="glyphicon glyphicon-list"></i> <span>DATA LAPORAN</span></a></li>
                            </ul>
                          </li>

                          <?php
                    }
              ?>

          </ul>
        </section>
        <!-- /.sidebar -->
</aside>
