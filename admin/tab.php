      <div class="tabbable" id="tabs-455327">
    <ul class="nav nav-tabs">
     <li class="active">
      <a href="#1" data-toggle="tab">Home</a>
     </li>
     <li>
      <a href="#2" data-toggle="tab">Data Pasien</a>
     </li>
                    <li>
      <a href="#3" data-toggle="tab">Data Antrian</a>
     </li>
                    <li>
      <a href="#4" data-toggle="tab">Data Siswa</a>
     </li>
                    <li>
      <a href="#5" data-toggle="tab">Data Guru</a>
     </li>
                    <li>
      <a href="#6" data-toggle="tab">Point Panishment</a>
     </li>
                    <li>
      <a href="#7" data-toggle="tab">Point Reward</a>
     </li>
                      <li>
      <a href="#8" data-toggle="tab">Data Admin</a>
     </li>
                    <li>
      <a href="../logout.php" data-toggle="tab">Logout</a>
     </li>
    </ul>
    <div class="tab-content">
     <div class="tab-pane active" id="1">
      <p> <?php include('dashboard.php'); ?>
      </p>
     </div>
     <div class="tab-pane" id="2">
      <p> <?php include('pasien/pasien.php'); ?>
      </p>
     </div>
                    <div class="tab-pane" id="3">
      <p> <?php include('../pemeriksaan/antrian.php'); ?>
      </p>
     </div>
                    <div class="tab-pane" id="4">
      <p> Data Siswa
                            <?php include('inputsiswa.php'); ?>
      </p>
     </div>
                    <div class="tab-pane" id="5">
      <p> Data Guru
      </p>
     </div>
                    <div class="tab-pane" id="6">
      <p> Point Panishment
      </p>
     </div>
                    <div class="tab-pane" id="7">
      <p> Point Reward
      </p>
     </div>
                    <div class="tab-pane" id="8">
      <p> Data Admin
      </p>
     </div>
                 
    </div>
                <script>
    $('#tabs-455327 a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });

    // store the currently selected tab in the hash value
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
    });

    // on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('#tabs-455327 a[href="' + hash + '"]').tab('show');
</script>
             
             
             
   </div>