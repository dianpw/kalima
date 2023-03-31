<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php if(!empty($site_name)){ echo $site_name; } ?> | <?php echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=10, user-scalable=yes' name='viewport'>
    <meta name="description" content="Aplikasi KALIMA TEST">
    <meta name="keywords" content="Aplikasi KALIMA TEST">
    <meta name="author" content="Dian Purwanto">
    <!-- favicon -->
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
    <link rel="manifest" href="<?php echo base_url(); ?>public/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>public/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="<?php echo base_url(); ?>public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>public/plugins/adminlte/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>public/plugins/adminlte/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>public/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
  
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
    
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url(); ?>public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>public/plugins/adminlte/js/app.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>public/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>public/app.js" type="text/javascript"></script>
    
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="skin-green layout-top-nav">
    <div class="wrapper">

      <header class="main-header">               
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="<?php echo base_url(); ?>" class="navbar-brand"> <b><?php if(!empty($site_name)){ echo $site_name; } ?></b></a>
            </div>
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <li><a href="#"><span id="timestamp"></span></a></li>
              </ul>
            </div>
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
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
							<strong> <a href="<?php echo site_url(); ?>/manager/" >Log In Operator</a></strong>
						<?php
					}
				}else{
					?>
						<strong> <a href="<?php echo site_url(); ?>/manager/" >Log In Operator</a></strong>
					<?php
				}
			?>
        </div>
        <div class="container">
          <strong>&copy;KalimaTest</strong>
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    <div class="modal" id="modal-proses" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <div style="text-align: center;">
              <img width="50" src="<?php echo base_url(); ?>public/images/loading.gif" /> <br />Data Sedang diproses...              
            </div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

  <script type="text/javascript">
    $(function () {
        var serverTime = <?php if(!empty($timestamp)){ echo $timestamp; } ?>;
        var counterTime=0;
        var date;

        setInterval(function() {
          date = new Date();

          serverTime = serverTime+1;

          date.setTime(serverTime*1000);
          time = date.toLocaleTimeString();
          $("#timestamp").html(time);
        }, 1000);
    });
  </script>
  </body>
</html>
