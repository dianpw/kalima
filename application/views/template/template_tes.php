<!DOCTYPE html>
<html>
  <!-- REKOMENDASI: Tambahkan lang="id" untuk accessibility -->
  <head>
    <meta charset="UTF-8">
    <title><?php if(!empty($site_name)){ echo $site_name; } ?> | <?php echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=0.9, minimum-scale=0.1, maximum-scale=10, user-scalable=yes' name='viewport'>
    <!-- REKOMENDASI: Viewport scale terlalu ekstrem, pertimbangkan:
         initial-scale=1.0, minimum-scale=0.5, maximum-scale=5.0 -->
    
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- REKOMENDASI: CSP ini memaksa HTTPS, pastikan semua resource support HTTPS -->
    
    <meta name="description" content="Aplikasi KALIMA TEST">
    <meta name="keywords" content="Aplikasi KALIMA TEST">
    <meta name="author" content="Dian Purwanto">
    <!-- REKOMENDASI: Tambahkan Open Graph tags untuk social media sharing -->

    <!-- favicon -->
    <!-- REKOMENDASI: Struktur favicon sudah lengkap dan baik untuk berbagai device -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>public/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>public/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>public/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>public/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>public/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>public/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>public/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>public/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>public/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url(); ?>public/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>public/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>public/favicon/favicon-16x16.png">
    <!-- REKOMENDASI: Uncomment manifest.json untuk PWA capabilities -->
    <!--link rel="manifest" href="<?php //echo base_url(); ?>public/favicon/manifest.json"-->

    <!-- REKOMENDASI: Urutkan loading CSS berdasarkan dependencies -->
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="<?php echo base_url(); ?>public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>public/plugins/adminlte/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- REKOMENDASI: Load hanya skin yang digunakan, bukan semua skin -->
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>public/plugins/adminlte/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>public/plugins/pnotify/pnotify.custom.min.css" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="<?php echo base_url(); ?>public/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>public/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" />
    
    <!-- REKOMENDASI: Pindahkan SEMUA script ke sebelum </body> untuk performance -->
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- REKOMENDASI: jQuery 2.1.4 sudah outdated, pertimbangkan upgrade -->
    
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>public/app.js" type="text/javascript"></script>
    <!-- REKOMENDASI: app.js di-load dua kali (duplikat), hapus salah satu -->
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- REKOMENDASI: IE8 support sudah kurang relevan, pertimbangkan dihapus -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url(); ?>public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App --><!-- 
    <script src="<?php //echo base_url(); ?>public/plugins/adminlte/js/app.min.js" type="text/javascript"></script> -->

    <!-- REKOMENDASI: Script untuk plugin yang tidak digunakan di semua page bisa di-load conditional -->
    <script src="<?php echo base_url(); ?>public/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/plugins/datatables/dataTables.reload.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>public/plugins/pnotify/pnotify.custom.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/app.js" type="text/javascript"></script>
    <!-- REKOMENDASI: app.js di-load duplikat (baris 56 dan 81), hapus salah satu -->
    
    <style type="text/css">
      #isi-tes-soal img {
        display: block;
        max-width: 100%;
        height: auto;
      }
      
      /* Perbaikan untuk header dan footer */
      .main-header .navbar {
        margin-bottom: 0;
        border: none;
        min-height: 60px;
      }
      
      .navbar-brand {
        padding: 15px 15px;
        font-size: 20px;
        height: 60px;
        display: flex;
        align-items: center;
      }
      
      .navbar-custom-menu {
        margin-right: 0;
      }
      
      .user-menu-dropdown {
        min-width: 200px;
      }
      
      .timestamp-display {
        padding: 15px;
        font-weight: bold;
        color: #3c8dbc;
      }
      
      .main-footer {
        padding: 15px;
        background: #f4f4f4;
        border-top: 1px solid #d2d6de;
      }
      
      .footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      
      .footer-left {
        font-size: 14px;
      }
      
      .footer-right {
        font-size: 14px;
      }
      
      @media (max-width: 768px) {
        .footer-content {
          flex-direction: column;
          text-align: center;
        }
        
        .footer-right {
          margin-top: 10px;
        }
        
        .navbar-header {
          float: none;
        }
        
        .navbar-custom-menu {
          float: none !important;
        }
      }
      
      .content-wrapper {
        min-height: calc(100vh - 115px);
        background-color: aliceblue;
      }
    </style>

    <script type="text/javascript">
    function notify_success(pesan){
      new PNotify({
        title: 'Berhasil',
        text: pesan,
        type: 'success',
        history: false,
        delay:2000
      });
    }
        
    function notify_info(pesan){
      new PNotify({
        title: 'Informasi',
        text: pesan,
        type: 'info',
        history: false,
        delay:2000
      });
    }
    
    function notify_error(pesan){
      new PNotify({
        title: 'Error',
        text: pesan,
        type: 'error',
        history: false,
        delay:2000
      });
    } 
    // REKOMENDASI: Tambahkan fungsi pesan_err() yang digunakan di form password
    </script>
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="skin-green layout-top-nav">
    <!-- REKOMENDASI: Tambahkan skip navigation link untuk accessibility -->
    <div class="wrapper">

      <header class="main-header">               
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="<?php echo base_url(); ?>" class="navbar-brand" title="Home" alt="Home"> <b><?php if(!empty($site_name)){ echo $site_name; } ?></b></a>
              <!-- REKOMENDASI: Tambahkan alt text untuk logo -->
            </div>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <li><a href="#"><span id="timestamp"></span></a></li>
                  <!-- REKOMENDASI: Tambahkan aria-label untuk timestamp -->
                  <!-- User Account Menu -->
                  <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="<?php echo base_url(); ?>public/images/avatar.png" class="user-image" alt="User Image" />
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs"><?php if(!empty($nama)){ echo $nama; }else{ echo 'User Tes'; } ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <li class="user-header" style="max-height: 70px;">
                        <!-- REKOMENDASI: Hindari inline style, gunakan CSS class -->
                        <p>
                          <?php if(!empty($nama)){ echo $nama; }else{ echo 'User Tes'; } ?>
                          <?php if(!empty($group)){ echo ' | '.$group; } ?>
                        </p>
                      </li>
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a data-toggle="modal" href="#modal-password" class="btn btn-default btn-flat">Password</a>
                          <!-- REKOMENDASI: Tambahkan title attribute -->
                        </div>
                        <div class="pull-right">
                          <a href="<?php echo site_url(); ?>welcome/logout" class="btn btn-default btn-flat">Log out</a>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div><!-- /.navbar-custom-menu -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      
      <!-- Full Width Column -->
      <div class="content-wrapper">
            <!-- REKOMENDASI: Tambahkan main landmark role -->
            <?php 
            if(!empty($content)){
                echo $content; 
            }
            ?>
      </div><!-- /.content-wrapper -->
      
      <footer class="main-footer no-print">
        <div class="pull-right hidden-xs">          
          <?php if(!empty($nama)){ echo $nama; } ?> | <strong> <a href="<?php echo site_url(); ?>welcome/logout"   > >Log out</a></strong> 
        </div>
        <div class="container">
          <strong>&copy;KalimaTest 2023 - <?php echo date("Y"); ?></strong>
          <!-- REKOMENDASI: Gunakan &copy; entity untuk copyright symbol -->
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    <!-- Modal Ubah Password -->
    <div class="modal" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <!-- REKOMENDASI: Form sebaiknya hanya wrap content form, bukan seluruh modal -->
      <?php echo form_open('tes_dashboard/password','id="form-password"')?>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Ubah Password</h4>
          </div>
          <div class="modal-body">
                <span id="form-pesan-password"></span>
                <div class="box-body">
                  <div class="form-group">
                    <label>Old Password</label>
                    <input type="password" class="form-control" id="password-old" name="password-old" placeholder="Old Password">
                    <!-- REKOMENDASI: Tambahkan required attribute -->
                  </div>
                  <div class="form-group">
                    <label>New Password</label>
                    <input type="password" class="form-control" id="password-new" name="password-new" placeholder="New Password">
                  </div>
                  <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="password-confirm" name="password-confirm" placeholder="Confirm Password">
                  </div>
                </div>  
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="password-submit">Ubah Password</button>
            <!-- REKOMENDASI: Tambahkan loading state pada button -->
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      <?php echo form_close(); ?> 
    </div><!-- /.modal -->
    
    <!-- Modal Loading -->
    <div class="modal" id="modal-proses" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <div style="text-align: center;">
              <img width="50" src="<?php echo base_url(); ?>public/images/loading.gif" /> <br />Data Sedang diproses...              
              <!-- REKOMENDASI: Tambahkan alt text untuk gambar loading -->
            </div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- REKOMENDASI: Pindahkan semua script ke sini (setelah modal) -->
  <script type="text/javascript">
    $(function () {
        var serverTime = <?php if(!empty($timestamp)){ echo $timestamp; } ?>;
        var counterTime = 0;
        var date;

        // Array untuk nama hari dalam Bahasa Indonesia
        var hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        // Array untuk nama bulan dalam Bahasa Indonesia  
        var bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        function updateDateTime() {
            try {
                date = new Date();
                serverTime = serverTime + 1;
                date.setTime(serverTime * 1000);

                // Ambil komponen tanggal dan waktu
                var hariIndex = date.getDay(); // 0-6
                var tanggal = date.getDate(); // 1-31
                var bulanIndex = date.getMonth(); // 0-11
                var tahun = date.getFullYear();
                var jam = date.getHours(); // 0-23
                var menit = date.getMinutes(); // 0-59
                var detik = date.getSeconds(); // 0-59

                // Format waktu dengan leading zero
                var jamFormatted = jam.toString().padStart(2, '0');
                var menitFormatted = menit.toString().padStart(2, '0');
                var detikFormatted = detik.toString().padStart(2, '0');

                // Format lengkap: "Hari, Tanggal Bulan Tahun HH:MM:SS"
                var waktuLengkap = hari[hariIndex] + ', ' + 
                                 tanggal + ' ' + 
                                 bulan[bulanIndex] + ' ' + 
                                 tahun + ' ' + 
                                 jamFormatted + ':' + 
                                 menitFormatted + ':' + 
                                 detikFormatted;

                // Tampilkan di element
                $("#timestamp").html(waktuLengkap);

            } catch (error) {
                console.error('Error updating datetime:', error);
                // Fallback: tampilkan waktu sederhana jika ada error
                $("#timestamp").html(date.toLocaleString());
            }
        }

        // Update immediately pertama kali
        updateDateTime();
        
        // Update setiap detik
        setInterval(updateDateTime, 1000);

        $('#modal-password').on('shown.bs.modal', function (e) {
          $('#form-pesan-password').html('');
          $('#password-old').val('');
          $('#password-new').val('');
          $('#password-confirm').val('');
          $('#password-old').focus();
        });
        
        $('#form-password').submit(function(){        
          $.ajax({
            url:"<?php echo site_url(); ?>/tes_dashboard/password",
            type:"POST",
            data:$('#form-password').serialize(),
            cache: false,
            success:function(respon){
              var obj = $.parseJSON(respon);
              if(obj.status==1){
                $('#form-pesan-password').html('');
                $('#modal-password').modal('hide');
                notify_success('Password berhasil diubah');
              }else{
                // REKOMENDASI: Fungsi pesan_err tidak didefinisikan, gunakan notify_error
                $('#form-pesan-password').html(pesan_err(obj.error));
                // Seharusnya: notify_error(obj.error);
              }
            }
          });
          return false;
        });
        
        // REKOMENDASI: Tambahkan event handler untuk Enter key di form
        // REKOMENDASI: Tambahkan form validation sebelum submit
    });
  </script>

  </body>
</html>