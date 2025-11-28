<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php if(!empty($site_name)){ echo $site_name; } ?> | <?php echo $title; ?></title>
    <!-- REKOMENDASI: Tambahkan lang attribute untuk accessibility -->
    
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=10, user-scalable=yes' name='viewport'>
    <!-- REKOMENDASI: maximum-scale=10 terlalu tinggi, bisa diset 5 saja untuk mencegah zoom berlebihan -->
    
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- REKOMENDASI: CSP ini memaksa HTTPS untuk semua resource, pastikan semua resource support HTTPS -->
	  
	  <meta name="description" content="Aplikasi KALIMA TEST">
	  <meta name="keywords" content="Aplikasi KALIMA TEST">
    <meta name="author" content="Dian Purwanto">
    <!-- REKOMENDASI: Tambahkan Open Graph meta tags untuk social media sharing -->
    
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
    
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>public/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

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

    <link href="<?php echo base_url(); ?>public/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <!-- REKOMENDASI: Pertimbangkan untuk load CSS non-kritis secara async -->
  
    
    <!-- jQuery 2.1.4 -->
    <!-- REKOMENDASI: jQuery versi 2.1.4 sudah outdated, pertimbangkan upgrade -->
    <script src="<?php echo base_url(); ?>public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- REKOMENDASI: Load JavaScript di sebelum closing body tag untuk performance -->
    
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>public/plugins/adminlte/js/app.min.js" type="text/javascript"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- REKOMENDASI: IE8 support sudah kurang relevan, pertimbangkan untuk dihapus -->
    
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url(); ?>public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>public/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>public/app.js" type="text/javascript"></script>
    <!-- REKOMENDASI: Gunakan defer/async attribute untuk script non-kritis -->
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
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="skin-green layout-top-nav">
    <!-- REKOMENDASI: Tambahkan skip navigation link untuk accessibility -->
    <div class="wrapper">

      <header class="main-header">               
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="<?php echo base_url(); ?>" class="navbar-brand"> <b><?php if(!empty($site_name)){ echo $site_name; } ?></b></a>
              <!-- REKOMENDASI: Tambahkan alt text untuk logo -->
            </div>
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <li><a href="#"><span id="timestamp"></span></a></li>
                <!-- REKOMENDASI: Tambahkan aria-label untuk timestamp -->
              </ul>
            </div>
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper" >
            <!-- REKOMENDASI: Tambahkan main landmark role untuk accessibility -->
            <?php 
            if(!empty($content)){
                echo $content; 
            }
            ?>
      </div><!-- /.content-wrapper -->
      <footer class="main-footer no-print">
        <div class="pull-right hidden-xs">
          <?php
            if(!empty($link_login_operator)){
              if($link_login_operator=='ya'){
                ?>
                  <strong> <a href="<?php echo site_url(); ?>manager/" >Log In Operator</a></strong>
                  <!-- REKOMENDASI: Tambahkan title attribute untuk link -->
                <?php
              }
            }else{
              ?>
                <strong> <a href="<?php echo site_url(); ?>manager/" >Log In Operator</a></strong>
              <?php
            }
          ?>
        </div>
        <div class="container">
          <strong>&copy;KalimaTest 2023 - <?php echo date("Y"); ?></strong>
          <!-- REKOMENDASI: Gunakan &copy; entity untuk copyright symbol -->
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    <!-- REKOMENDASI: Modal loading sudah baik untuk UX -->
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
    });
</script>
  </body>
</html>