<div class="container">
	<!-- Content Header (Page header) -->
    <section class="content-header">
    	<h1>
    		SELAMAT DATANG <?php if(!empty($nama)){ echo $nama; } if(!empty($group)){ echo ' | '.$group; } ?>
            <small>di Ujian Online Berbasis Komputer</small>
        </h1>
        <ol class="breadcrumb">
        	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">dashboard</li>
        </ol>
	</section>

	<!-- Main content -->
    <section class="content">
        <!-- IP Validation Status -->
        <div class="callout <?php echo $ip_allowed ? 'callout-success' : 'callout-warning'; ?>">
            <h4>
                <i class="fa <?php echo $ip_allowed ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?>"></i> 
                IP <?php echo $ip_allowed ? 'Valid' : 'Tidak Dikenal'; ?>
            </h4>
            <p>
                Alamat IP Anda: <strong><?= $_SERVER['REMOTE_ADDR'] ?? '' ?></strong><br>
                Terdeteksi melalui Cloudflare: <strong>
                <?php 
                    if($cloudflare_detected) {
                        echo 'Ya (' . $cloudflare_ip . ')';
                    } else {
                        echo 'Tidak';
                    }
                ?></strong>
            </p>
            <?php if (!$ip_allowed): ?>
            <p><strong>Perhatian:</strong> <?php echo $ip_validation_message; ?></p>
            <?php endif; ?>
        </div>

		<?php
			if(!empty($informasi)){
				?>
				<div class="callout callout-info">
                    <h4><i class="fa fa-info-circle"></i> Informasi</h4>
                    <?php 
					echo $informasi;
					?>
                </div>
				<?php
			}else{
				?>
				<div class="callout callout-info">
					<h4><i class="fa fa-info-circle"></i> Informasi</h4>
					<p>Silahkan pilih Tes yang diikuti dari daftar tes yang tersedia dibawah ini. Apabila tes tidak muncul, silahkan menghubungi Operator yang bertugas.</p>
				</div>
				<?php
			}
		?>

        <div class="box box-success box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-list"></i> Daftar Tes Tersedia</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="table-tes" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th class="all">Nama Tes</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Status/Nilai</th>
                                <th class="all">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center">Memuat data...</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Nama Tes</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Status/Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>   
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <small class="text-muted">
                    <i class="fa fa-clock-o"></i> Terakhir diperbarui: <?php echo date('d/m/Y H:i:s'); ?>
                </small>
            </div>
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.container -->

<!-- Modal Popup untuk IP Warning -->
<?php if (!$ip_allowed): ?>
<div class="modal fade" id="ipWarningModal" tabindex="-1" role="dialog" aria-labelledby="ipWarningModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title" id="ipWarningModalLabel">
                    <i class="fa fa-exclamation-triangle"></i> Peringatan - IP Tidak Dikenal
                </h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h4><i class="fa fa-warning"></i> Perhatian!</h4>
                    <p><?php echo $ip_validation_message; ?></p>
                </div>
                
                <div class="well">
                    <h5><i class="fa fa-list"></i> Range IP yang Diizinkan:</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th>Range CIDR</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 1; ?>
                                <?php foreach ($allowed_ranges as $range_item): ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td><code><?php echo htmlspecialchars($range_item['range']); ?></code></td>
                                    <td><?php echo $range_item['description']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <h5><i class="fa fa-info-circle"></i> Informasi:</h5>
                    <p>Anda tetap dapat menggunakan sistem, namun jika ini adalah kesalahan, silakan:</p>
                    <ul>
                        <li>Pastikan terhubung ke jaringan yang benar</li>
                        <li>Gunakan access point yang ditentukan</li>
                        <li>Hubungi Pengawas Ujian untuk bantuan lebih lanjut</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <a href="welcome/logout" class="btn btn-default">
                    <i class="fa fa-times"></i> Tutup
                </a>
                <button type="button" class="btn btn-primary" onclick="window.location.reload(true)">
                    <i class="fa fa-refresh"></i> Coba Lagi
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script type="text/javascript">
    $(function () {
        // Tampilkan modal warning jika IP tidak dikenali
        <?php if (!$ip_allowed): ?>
        $('#ipWarningModal').modal('show');
        <?php endif; ?>

        $('#table-tes').DataTable({
            "paging": true,
            "iDisplayLength": 25,
            "bProcessing": false,
            "bServerSide": true, 
            "searching": false,
            "aoColumns": [
                {"bSearchable": false, "bSortable": false, "sWidth":"20px"},
                {"bSearchable": false, "bSortable": false},
                {"bSearchable": false, "bSortable": false, "sWidth":"150px"},
                {"bSearchable": false, "bSortable": false, "sWidth":"150px"},
                {"bSearchable": false, "bSortable": false, "sWidth":"100px"},
                {"bSearchable": false, "bSortable": false, "sWidth":"30px"}
            ],
            "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable/",
            "autoWidth": false,
            "responsive": true
        });

        // Update real-time clock
        function updateClock() {
            var now = new Date();
            var time = now.getHours().toString().padStart(2, '0') + ':' + 
                       now.getMinutes().toString().padStart(2, '0') + ':' + 
                       now.getSeconds().toString().padStart(2, '0');
            $('.current-time').text(time);
        }
        setInterval(updateClock, 1000);
    });

    // Auto close modal setelah 30 detik
    /* <?php if (!$ip_allowed): ?>
    setTimeout(function() {
        $('#ipWarningModal').modal('hide');
    }, 30000);
    <?php endif; ?> */
</script>

<style>
    .table > thead > tr > th {
        background-color: #f5f5f5;
        font-weight: bold;
    }
    .box-success {
        border-top-color: #00a65a;
    }
    .info-box {
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .callout {
        border-left-width: 5px;
    }
    .dataTables_wrapper {
        position: relative;
    }
    #table-tes tbody tr:hover {
        background-color: #f9f9f9;
    }
    .modal-header.bg-warning {
        background-color: #f39c12 !important;
        color: white;
    }
</style>