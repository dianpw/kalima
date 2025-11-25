<!-- Main content -->
<section class="content">
    <div class="error-page">
        <div class="error-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="box box-danger box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-ban"></i> Akses Ditolak</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="text-center">
                                    <h1><i class="fa fa-wifi" style="font-size: 80px; color: #dd4b39;"></i></h1>
                                    <h2 style="margin-top: 0; color: #dd4b39;">Akses Dibatasi</h2>
                                    <h3>Alamat IP Anda Tidak Diizinkan</h3>
                                </div>

                                <!-- Informasi IP -->
                                <div class="ip-info">
                                    <h4><i class="fa fa-info-circle"></i> Informasi Koneksi</h4>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Alamat IP Anda</th>
                                            <td><strong><?php echo htmlspecialchars($user_ip); ?></strong></td>
                                        </tr>
                                        <tr>
                                            <th>Waktu Akses</th>
                                            <td><?php echo $current_time; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td><span class="label label-danger">Ditolak</span></td>
                                        </tr>
                                    </table>
                                </div>

                               

                                <!-- Solusi -->
                                <div class="contact-info">
                                    <h4><i class="fa fa-life-ring"></i> Solusi</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="callout callout-info">
                                                <h5>Hubungi Administrator</h5>
                                                <p>Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator sistem:</p>
                                                <p>
                                                    <i class="fa fa-envelope"></i> 
                                                    <strong><?php echo htmlspecialchars($contact_admin); ?></strong>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="callout callout-warning">
                                                <h5>Tips Akses</h5>
                                                <ul>
                                                    <li>Pastikan terhubung ke jaringan yang benar</li>
                                                    <li>Gunakan access point yang ditentukan</li>
                                                    <li>Restart koneksi jaringan Anda</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Action -->
                                <div class="text-center" style="margin-top: 30px;">
                                    <button onclick="window.location.reload()" class="btn btn-primary">
                                        <i class="fa fa-refresh"></i> Coba Lagi
                                    </button>
                                    <button onclick="history.back()" class="btn btn-default">
                                        <i class="fa fa-arrow-left"></i> Kembali
                                    </button>
                                    <a href="<?php echo site_url('login/logout'); ?>" class="btn btn-danger">
                                        <i class="fa fa-sign-out"></i> Logout
                                    </a>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <small class="text-muted">
                                    <i class="fa fa-shield"></i> Sistem dilindungi oleh validasi keamanan IP
                                </small>
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
</section>
<!-- /.content -->

<script>
    // Auto refresh setelah 30 detik
    setTimeout(function() {
        window.location.reload();
    }, 30000);

    // Tambahkan fungsi untuk copy IP
    function copyIP() {
        const ip = "<?php echo $user_ip; ?>";
        navigator.clipboard.writeText(ip).then(function() {
            alert('IP berhasil disalin: ' + ip);
        }, function(err) {
            console.error('Gagal menyalin IP: ', err);
        });
    }
</script>