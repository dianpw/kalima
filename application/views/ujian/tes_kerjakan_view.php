<div class="container">
    
    <!-- Tambahkan style untuk mencegah seleksi teks -->
    <style>
        /* PENGAMANAN HALAMAN TES: Mencegah seleksi teks */
        body {
            -webkit-user-select: none;  /* Untuk browser Chrome, Safari, Opera */
            -moz-user-select: none;     /* Untuk browser Firefox */
            -ms-user-select: none;      /* Untuk browser Internet Explorer */
            user-select: none;          /* Standar CSS */
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Opsional: Berikan tampilan cursor default untuk elemen teks */
        .box-body, #isi-tes-soal {
            cursor: default;
        }

        /* Style untuk notifikasi screenshot */
        .screenshot-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            animation: slideInRight 0.5s ease-out;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Style untuk modal forced logout */
        .forced-logout-modal {
            background: rgba(0,0,0,0.8) !important;
        }
        .forced-logout-modal .modal-content {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 10px;
        }
        .forced-logout-modal .modal-header {
            border-bottom: 2px solid rgba(255,255,255,0.3);
        }
        .forced-logout-modal .btn {
            background: white;
            color: #dc3545;
            border: none;
            font-weight: bold;
        }

        /* Watermark untuk mobile */
        .mobile-watermark {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9998;
            background: transparent;
        }
        .watermark-text {
            position: absolute;
            font-size: 20px;
            color: red;
            transform: rotate(-45deg);
            white-space: nowrap;
            opacity: 0.1;
            font-weight: bold;
        }

        /* Mobile specific styles */
        .mobile-warning {
            display: none;
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        /* Style untuk tabel pelanggaran */
        .violations-table {
            font-size: 12px;
        }
        .violations-table th {
            background-color: #f8f9fa;
        }
        .violation-high {
            background-color: #f12727ff !important;
        }
        .violation-medium {
            background-color: #e7c997ff !important;
        }
        .violation-low {
            background-color: #e8f5e8 !important;
        }

        /* Progress bar untuk pelanggaran */
        .violation-progress {
            height: 20px;
            border-radius: 10px;
            overflow: hidden;
            margin: 10px 0;
            background-color: #088bf7ff;
        }
        
        .violation-progress-bar {
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        /* Status keamanan */
        .security-status {
            border-left: 4px solid #28a745;
            padding-left: 15px;
        }
        .security-status.warning {
            border-left-color: #ffc107;
        }
        .security-status.danger {
            border-left-color: #dc3545;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .screenshot-alert {
                min-width: 250px;
                right: 10px;
                left: 10px;
            }
            
            .violations-table {
                font-size: 10px;
            }
        }
    </style>

    <!-- Watermark Container -->
    <div class="mobile-watermark" id="mobileWatermark"></div>

	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mapel : <?php if(!empty($tes_name)){ echo $tes_name; } ?>
        </h1>
        <div class="breadcrumb">
            <img src="<?php echo base_url(); ?>public/images/zoom.png" style="cursor: pointer;" height="20" onclick="zoomnormal()" title="Klik ukuran font normal" />&nbsp;&nbsp;
            <img src="<?php echo base_url(); ?>public/images/zoom.png" style="cursor: pointer;" height="26" onclick="zoombesar()" title="Klik ukuran font lebih besar" />
        </div>
            <!-- Mobile Warning -->
            <div class="callout mobile-warning" id="mobileWarning">
                <i class="fa fa-mobile"></i> <strong>Mode Mobile Terdeteksi:</strong> 
                Segala aktivitas mencurigakan akan tercatat dan dapat mengakibatkan diskualifikasi.
            </div>
    </section>

	<!-- Main content -->
    <section class="content">
        
        <!-- IP Validation Status -->
        <div class="row">
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
        </div>

    	<div class="row">
            <?php echo form_open('tes_kerjakan/simpan_jawaban','id="form-kerjakan"')?>
                <input type="hidden" name="tes-id" id="tes-id" value="<?php if(!empty($tes_id)){ echo $tes_id; } ?>">
                <input type="hidden" name="tes-user-id" id="tes-user-id" value="<?php if(!empty($tes_user_id)){ echo $tes_user_id; } ?>">
                <input type="hidden" name="tes-soal-id" id="tes-soal-id" value="<?php if(!empty($tes_soal_id)){ echo $tes_soal_id; } ?>">
                <input type="hidden" name="tes-soal-nomor" id="tes-soal-nomor"  value="<?php if(!empty($tes_soal_nomor)){ echo $tes_soal_nomor; } ?>">
                <input type="hidden" name="tes-soal-jml" id="tes-soal-jml" value="<?php if(!empty($tes_soal_jml)){ echo $tes_soal_jml; } ?>">
                <input type="hidden" name="tes-soal-ragu" id="tes-soal-ragu" value="<?php if(!empty($tes_ragu)){ echo $tes_ragu; } ?>">
                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Soal <span id="judul-soal"><?php if(!empty($tes_soal_nomor)){ echo 'ke '.$tes_soal_nomor; } ?></span></h3>
                        <div class="box-tools pull-right">
                            <div class="pull-right">
                                <div id="sisa-waktu"></div>
                            </div>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div id="isi-tes-soal" style="font-size: 15px;">
                            <?php if(!empty($tes_soal)){ echo $tes_soal; } ?>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="button" class="btn btn-default hide" id="btn-sebelumnya">Soal Sebelumnya</button>&nbsp;&nbsp;&nbsp;
                        <div class="btn btn-warning" id="btn-ragu" onclick="ragu()">
                            <input type="checkbox" style="width:10px;height:10px;" name="btn-ragu-checkbox" id="btn-ragu-checkbox" <?php if(!empty($tes_ragu)){ echo "checked"; } ?> /> Ragu-ragu
                        </div>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-default" id="btn-selanjutnya">Soal Selanjutnya</button>
                    </div>
                </div><!-- /.box -->
            </form>
    	</div>
        <div class="row">
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Soal</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php if(!empty($tes_daftar_soal)){ echo $tes_daftar_soal; } ?>
                    <p class="help-block">Soal yang sudah dijawab akan berwarna Biru.</p>
                    <!-- Status Keamanan -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                        <h4><i class="fa fa-shield"></i> Monitoring Keamanan Tes</h4>
                            <div class="security-status card" id="securityStatus">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-shield-alt"></i> Status Keamanan</h5>
                                    <p class="card-text" id="securityStatusText">Sistem keamanan aktif dan memantau aktivitas tes.</p>
                                    <div class="violation-progress">
                                        <div id="violation-progress-bar" class="violation-progress-bar bg-success" style="width: 0%"></div>
                                    </div>
                                    <small class="text-muted">Total Poin Pelanggaran: <strong id="total-points" style="color: red;">0</strong> / 10</small>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- Tabel pelanggaran keamanan -->
                    <div id="violations-container" style="margin-top: 20px; display: none;">
                        <h4><i class="fa fa-list"></i> Catatan Pelanggaran Keamanan</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped violations-table">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="20%">Waktu</th>
                                        <th width="25%">Jenis Pelanggaran</th>
                                        <th width="35%">Deskripsi</th>
                                        <th width="15%">Poin</th>
                                    </tr>
                                </thead>
                                <tbody id="violations-body">
                                    <!-- Data pelanggaran akan diisi oleh JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        <p class="help-block text-danger">
                            <i class="fa fa-warning red"></i> 
                            <strong style="color: red;">Peringatan:</strong> Pelanggaran keamanan akan dicatat dan dapat mengakibatkan diskualifikasi.
                        </p>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <small class="text-muted">
                        <i class="fa fa-clock-o"></i> Terakhir diperbarui: <?php echo date('d/m/Y H:i:s'); ?>
                    </small>
                    <button class="btn btn-default pull-right" id="btn-hentikan">Selesaikan Tes</button>
                </div>
            </div><!-- /.box -->
        </div>
        
    </section><!-- /.content -->

    <div class="modal" style="max-height: 100%;overflow-y: auto;" id="modal-hentikan" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url.'/hentikan_tes','id="form-hentikan"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Konfirmasi Selesaikan Tes</div>
                </div>
                <div class="modal-body" >
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan"></div>
                            <div class="callout callout-info">
                                <p>Apakah anda yakin mengakhiri mata uji ini ?
								<br />Jawaban Tes yang sudah selesai tidak dapat diubah.
								</p>
								
                            </div>
                            <div class="form-group">
                                <label>Nama Tes</label>
                                <input type="hidden" name="hentikan-tes-id" id="hentikan-tes-id" >
                                <input type="hidden" name="hentikan-tes-user-id" id="hentikan-tes-user-id" >
                                <input type="text" class="form-control" id="hentikan-tes-nama" name="hentikan-tes-nama" readonly>
                            </div>

                            <div class="form-group">
                                <label>Keterangan Soal</label>
                                <input type="text" class="form-control" id="hentikan-dijawab" name="hentikan-dijawab" readonly>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="hentikan-centang" name="hentikan-centang" value="1"> Centang dan kemudian tekan tombol Selesai.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="box-footer">
					<button type="submit" id="tambah-simpan" class="btn btn-primary">Selesai</button>
					<a href="#" class="btn btn-default" data-dismiss="modal">Batal</a>
				</div>
            </div>
        </div>
    </form>
    </div>
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

<!-- Modal untuk Forced Logout -->
<div class="modal fade forced-logout-modal" id="forcedLogoutModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="fa fa-ban"></i> AKSES DIBLOKIR - PELANGGARAN KEAMANAN
                </h4>
            </div>
            <div class="modal-body text-center">
                <h3><i class="fa fa-exclamation-triangle fa-3x"></i></h3>
                <h4>TERDETEKSI PELANGGARAN KEAMANAN BERULANG</h4>
                <p>Anda telah melanggar aturan keamanan tes </p>
                <p>Akun Anda akan dikeluarkan secara otomatis dari sistem.</p>
                <div class="countdown-container">
                    <div class="alert alert-light d-inline-block px-4 py-2">
                        <h5 class="mb-1">Redirect dalam: <span id="logout-countdown" class="fw-bold">5</span> detik</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    /**
     * SISTEM TES ONLINE TEROPTIMASI DENGAN MONITORING KEAMANAN LENGKAP
     * SMK Negeri 5 Malang
     */

    // ==================== KONFIGURASI SISTEM ====================
    const VIOLATION_STORAGE_KEY = 'tes_security_violations';
    const MAX_VIOLATION_POINTS = 10.0;
    
    const VIOLATION_POINTS = {
        SCREENSHOT_ATTEMPT: 3.0,
        TAB_SWITCH: 1.0,
        NETWORK_DISCONNECT: 0.2,
        NETWORK_CHANGE: 0.5,
        DEVICE_ORIENTATION_CHANGE: 0.5,
        WINDOW_RESIZE: 0.5,
        DEVELOPER_TOOLS: 1.5,
        RIGHT_CLICK: 0.5,
        KEYBOARD_SHORTCUT: 0.8,
        MOBILE_GESTURE: 1.0,
        VISIBILITY_CHANGE: 1.0,
        SUSPICIOUS_ACTIVITY: 0.5,
        TES_STARTED: 0.0
    };

    // ==================== VARIABEL GLOBAL ====================
    let securityViolationCount = 0;
    let lastScreenshotDetection = 0;
    let isLoggingOut = false;
    let isMobileDevice = false;
    let mobileDetectionEnabled = false;
    let sisa_detik = <?php if(!empty($detik_sisa)){ echo $detik_sisa; } else { echo 3600; } ?>;
    let timerInterval;
    let securitySystemInitialized = false;

    // ==================== SISTEM PENCATATAN PELANGGARAN ====================
    
    function initializeViolations() {
        try {
            if (!sessionStorage.getItem(VIOLATION_STORAGE_KEY)) {
                const initialData = {
                    violations: [],
                    totalPoints: 0,
                    startTime: new Date().toISOString(),
                    tesUserId: document.getElementById('tes-user-id')?.value || 'unknown',
                    tesId: document.getElementById('tes-id')?.value || 'unknown',
                    violationHistory: []
                };
                sessionStorage.setItem(VIOLATION_STORAGE_KEY, JSON.stringify(initialData));
            }
            updateViolationsDisplay();
        } catch (error) {
            console.error('Error initializeViolations:', error);
        }
    }

    function addViolation(type, description, points = 0, details = {}) {
        try {
            const violationsData = getViolationsData();
            // Konversi ke number untuk memastikan perbandingan akurat
            points = parseFloat(points) || 0;
            const newTotal = parseFloat(violationsData.totalPoints) + points;
            
            console.log(`📝 Adding violation: ${type}, Points: ${points}, New Total: ${newTotal}`);
            
            const newViolation = {
                id: violationsData.violations.length + 1,
                timestamp: new Date().toLocaleTimeString('id-ID'),
                type: type,
                description: description,
                points: points,
                totalAfter: violationsData.totalPoints + points,
                isMobile: isMobileDevice,
                details: details
            };
            
            violationsData.violations.push(newViolation);
            violationsData.totalPoints += points;
            violationsData.violationHistory.push({
                type: type,
                points: points,
                timestamp: new Date().toISOString(),
                totalPoints: violationsData.totalPoints
            });
            
            sessionStorage.setItem(VIOLATION_STORAGE_KEY, JSON.stringify(violationsData));
            updateViolationsDisplay();
            securityViolationCount = violationsData.totalPoints;
            
            console.log(`📝 Pelanggaran: ${type} - ${points} poin - Total: ${violationsData.totalPoints}`);
            
            // Cek batas setelah menambah pelanggaran
            if (violationsData.totalPoints >= MAX_VIOLATION_POINTS && !isLoggingOut) { 
                console.log('🚨 TRIGGER: Poin pelanggaran mencapai batas:', violationsData.totalPoints);
                handleMultipleViolations();
            }
            
            return newViolation;
        } catch (error) {
            console.error('Error dalam addViolation:', error);
        }
    }

    function getViolationsData() {
        try {
            return JSON.parse(sessionStorage.getItem(VIOLATION_STORAGE_KEY) || '{"violations":[],"totalPoints":0,"violationHistory":[]}');
        } catch (error) {
            console.error('Error membaca data pelanggaran:', error);
            return { violations: [], totalPoints: 0, violationHistory: [] };
        }
    }

    function updateViolationsDisplay() {
        try {
            const violationsData = getViolationsData();
            const container = document.getElementById('violations-container');
            const tbody = document.getElementById('violations-body');
            const totalPointsElement = document.getElementById('total-points');
            const progressBar = document.getElementById('violation-progress-bar');
            const securityStatus = document.getElementById('securityStatus');
            const securityStatusText = document.getElementById('securityStatusText');
            
            if (!container || !tbody) return;
            
            if (violationsData.violations.length === 0) {
                container.style.display = 'none';
                return;
            }
            
            container.style.display = 'block';
            tbody.innerHTML = '';
            
            // Tampilkan 10 pelanggaran terbaru
            violationsData.violations.slice(-10).forEach(violation => {
                const row = document.createElement('tr');
                row.className = `violation-${getSeverityClass(violation.points)}`;
                
                row.innerHTML = `
                    <td>${violation.id}</td>
                    <td>${violation.timestamp}</td>
                    <td>${violation.type}</td>
                    <td>${violation.description}</td>
                    <td class="text-center">
                        <span class="badge bg-${getPointColor(violation.points)}">
                            ${violation.points.toFixed(1)}
                        </span>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
            
            // Update progress bar dan status
            const percentage = Math.min((violationsData.totalPoints / MAX_VIOLATION_POINTS) * 100, 100);
            if (progressBar) progressBar.style.width = percentage + '%';
            if (totalPointsElement) totalPointsElement.textContent = violationsData.totalPoints.toFixed(1);
            
            // Update warna progress bar dan status keamanan
            if (progressBar && securityStatus && securityStatusText) {
                if (percentage >= 80) {
                    progressBar.className = 'violation-progress-bar bg-danger';
                    securityStatus.className = 'security-status danger card';
                    securityStatusText.textContent = 'Tingkat pelanggaran KRITIS! Hindari aktivitas mencurigakan.';
                } else if (percentage >= 60) {
                    progressBar.className = 'violation-progress-bar bg-warning';
                    securityStatus.className = 'security-status warning card';
                    securityStatusText.textContent = 'Tingkat pelanggaran TINGGI. Perhatikan aktivitas Anda.';
                } else if (percentage >= 30) {
                    progressBar.className = 'violation-progress-bar bg-info';
                    securityStatus.className = 'security-status card';
                    securityStatusText.textContent = 'Terdeteksi beberapa pelanggaran. Lanjutkan dengan hati-hati.';
                } else {
                    progressBar.className = 'violation-progress-bar bg-success';
                    securityStatus.className = 'security-status card';
                    securityStatusText.textContent = 'Tidak ada pelanggaran serius yang terdeteksi.';
                }
            }
            
            securityViolationCount = violationsData.totalPoints;
            
        } catch (error) {
            console.error('Error updateViolationsDisplay:', error);
        }
    }

    function getPointColor(points) {
        if (points >= 2.0) return 'danger';
        if (points >= 1.0) return 'warning';
        if (points >= 0.5) return 'info';
        return 'success';
    }

    function getSeverityClass(points) {
        if (points >= 2.0) return 'high';
        if (points >= 1.0) return 'medium';
        return 'low';
    }

    function resetViolationData() {
        try {
            sessionStorage.removeItem(VIOLATION_STORAGE_KEY);
            securityViolationCount = 0;
            
            // Reset tampilan
            const container = document.getElementById('violations-container');
            const tbody = document.getElementById('violations-body');
            const progressBar = document.getElementById('violation-progress-bar');
            const totalPointsElement = document.getElementById('total-points');
            
            if (container) container.style.display = 'none';
            if (tbody) tbody.innerHTML = '';
            if (progressBar) {
                progressBar.style.width = '0%';
                progressBar.className = 'violation-progress-bar bg-success';
            }
            if (totalPointsElement) totalPointsElement.textContent = '0';
            
            console.log('✅ Data pelanggaran direset');
        } catch (error) {
            console.error('Error resetViolationData:', error);
        }
    }

    // ==================== SISTEM KEAMANAN TEROPTIMASI ====================

    function detectMobileDevice() {
        const userAgent = navigator.userAgent || navigator.vendor || window.opera;
        
        isMobileDevice = (
            /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(userAgent) ||
            (window.innerWidth <= 768) ||
            ('ontouchstart' in window) ||
            (navigator.maxTouchPoints > 0) ||
            (window.orientation !== undefined)
        );
        
        console.log('📱 Mobile Device:', isMobileDevice);
        return isMobileDevice;
    }

    function initSecuritySystem() {
        if (securitySystemInitialized) return;
        securitySystemInitialized = true;
        
        detectMobileDevice();
        initScreenshotDetection();
        terapkanPengamananCopy();
        
        if (isMobileDevice) {
            document.getElementById('mobileWarning').style.display = 'block';
            createMobileWatermark();
        }
    }

    function initScreenshotDetection() {
        console.log('🛡️ Sistem keamanan diaktifkan - Mobile:', isMobileDevice);
        
        // Event listeners yang efisien
        const securityEvents = {
            'keydown': handleKeySecurity,
            'visibilitychange': handleVisibilityChange,
            'resize': handleWindowResize,
            'blur': handleWindowBlur,
            'contextmenu': handleContextMenu,
            'copy': handleCopyAttempt
        };

        Object.entries(securityEvents).forEach(([event, handler]) => {
            document.addEventListener(event, handler, { passive: false });
        });

        // Event listeners khusus network
        window.addEventListener('online', handleNetworkChange);
        window.addEventListener('offline', handleNetworkChange);

        // Event listeners khusus mobile
        if (isMobileDevice) {
            initMobileSpecificDetection();
        }

        // Periodic security check
        setInterval(performSecurityCheck, isMobileDevice ? 45000 : 30000);
    }

    // Handler functions untuk performa lebih baik
    function handleKeySecurity(e) {
        // Deteksi screenshot attempts
        if (e.keyCode === 44 || e.key === 'PrintScreen' ||
            (e.metaKey && e.shiftKey && e.keyCode === 51) ||
            (e.metaKey && e.shiftKey && e.keyCode === 52) ||
            (e.altKey && e.keyCode === 44)) {
            e.preventDefault();
            handleScreenshotDetection('Tombol screenshot ditekan: ' + e.key);
        }
        
        // Deteksi developer tools
        if ((e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74)) || 
            (e.keyCode === 123)) {
            e.preventDefault();
            addViolation(
                'DEVELOPER_TOOLS',
                'Percobaan membuka Developer Tools',
                VIOLATION_POINTS.DEVELOPER_TOOLS,
                { keyCode: e.keyCode }
            );
        }

        // Deteksi kombinasi tombol mencurigakan
        if ((e.ctrlKey && e.shiftKey && (e.keyCode === 83 || e.keyCode === 88)) ||
            (e.altKey && e.keyCode === 83)) {
            e.preventDefault();
            addViolation(
                'KEYBOARD_SHORTCUT',
                'Kombinasi tombol mencurigakan: ' + e.key,
                VIOLATION_POINTS.KEYBOARD_SHORTCUT,
                { keyCode: e.keyCode, key: e.key }
            );
        }
    }

    function handleVisibilityChange() {
        if (document.hidden) {
            addViolation(
                'TAB_SWITCH',
                'Tab/aplikasi tidak aktif (berpindah dari halaman tes)',
                VIOLATION_POINTS.TAB_SWITCH,
                { mobile: isMobileDevice }
            );
        }
    }

    function handleWindowResize() {
        // Debounced resize handler
        clearTimeout(window.resizeTimeout);
        window.resizeTimeout = setTimeout(() => {
            addViolation(
                'WINDOW_RESIZE',
                'Perubahan ukuran window terdeteksi',
                VIOLATION_POINTS.WINDOW_RESIZE,
                { mobile: isMobileDevice }
            );
        }, 500);
    }

    function handleWindowBlur() {
        addViolation(
            'WINDOW_BLUR',
            'Window kehilangan fokus',
            VIOLATION_POINTS.SUSPICIOUS_ACTIVITY,
            { mobile: isMobileDevice }
        );
    }

    function handleContextMenu(e) {
        e.preventDefault();
        addViolation(
            'RIGHT_CLICK',
            'Klik kanan diblokir',
            VIOLATION_POINTS.RIGHT_CLICK,
            { x: e.clientX, y: e.clientY }
        );
    }

    function handleCopyAttempt(e) {
        e.preventDefault();
        addViolation(
            'COPY_ATTEMPT',
            'Percobaan copy content',
            VIOLATION_POINTS.KEYBOARD_SHORTCUT,
            { action: 'copy' }
        );
    }

    function handleNetworkChange(e) {
        const type = e.type === 'online' ? 'NETWORK_CHANGE' : 'NETWORK_DISCONNECT';
        const points = e.type === 'online' ? VIOLATION_POINTS.NETWORK_CHANGE : VIOLATION_POINTS.NETWORK_DISCONNECT;
        
        addViolation(
            type,
            `Koneksi internet ${e.type === 'online' ? 'kembali tersambung' : 'terputus'}`,
            points,
            { type: e.type, timestamp: new Date().toISOString() }
        );
    }

    function handleScreenshotDetection(reason) {
        const now = Date.now();
        const cooldown = isMobileDevice ? 10000 : 5000;
        
        if (now - lastScreenshotDetection < cooldown) {
            return;
        }
        
        lastScreenshotDetection = now;
        
        addViolation(
            'SCREENSHOT_ATTEMPT',
            reason + (isMobileDevice ? ' (Mobile)' : ' (Desktop)'),
            VIOLATION_POINTS.SCREENSHOT_ATTEMPT,
            { mobile: isMobileDevice, reason: reason }
        );
        
        showScreenshotAlert();
    }

    function initMobileSpecificDetection() {
        console.log('📱 Mengaktifkan sistem deteksi mobile-specific');
        
        // Deteksi multi-touch gestures
        document.addEventListener('touchstart', function(e) {
            if (e.touches.length >= 3) {
                addViolation(
                    'MOBILE_GESTURE',
                    'Three-finger touch gesture terdeteksi (kemungkinan screenshot)',
                    VIOLATION_POINTS.MOBILE_GESTURE,
                    { touchCount: e.touches.length, mobile: true }
                );
            }
        });

        // Deteksi orientation change
        window.addEventListener('orientationchange', function() {
            addViolation(
                'DEVICE_ORIENTATION_CHANGE',
                'Perubahan orientasi layar perangkat',
                VIOLATION_POINTS.DEVICE_ORIENTATION_CHANGE,
                { orientation: window.orientation, mobile: true }
            );
        });

        // Deteksi swipe gestures
        let startX = 0, startY = 0;
        document.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        });

        document.addEventListener('touchend', function(e) {
            if (!startX || !startY) return;
            
            const endX = e.changedTouches[0].clientX;
            const endY = e.changedTouches[0].clientY;
            
            // Deteksi swipe dari pojok kanan bawah (gesture screenshot)
            if (startX > window.innerWidth * 0.7 && startY > window.innerHeight * 0.7) {
                addViolation(
                    'MOBILE_GESTURE',
                    'Swipe gesture dari area screenshot terdeteksi',
                    VIOLATION_POINTS.MOBILE_GESTURE * 0.8,
                    { from: 'bottom-right', mobile: true }
                );
            }
        });
    }

    function createMobileWatermark() {
        const watermark = document.getElementById('mobileWatermark');
        if (!watermark) return;
        
        const userId = document.getElementById('tes-user-id')?.value || 'UNKNOWN';
        const tesId = document.getElementById('tes-id')?.value || 'UNKNOWN';
        const timestamp = new Date().toLocaleDateString('id-ID');
        
        const texts = [
            `DILINDUNGI - ${userId}`,
            `KONFIDENSIAL - ${timestamp}`,
            `UJIAN ONLINE - ${tesId}`,
            'SCREENSHOT DILARANG',
            'AKAN DILAPORKAN',
            'SMK NEGERI 5 MALANG',
            'UJIAN TERAWASI',
            'DILARANG MENYEBARKAN'
        ];
        
        watermark.innerHTML = '';
        
        for (let i = 0; i < 20; i++) {
            const textEl = document.createElement('div');
            textEl.className = 'watermark-text';
            textEl.textContent = texts[i % texts.length];
            textEl.style.top = (Math.random() * 100) + '%';
            textEl.style.left = (Math.random() * 100) + '%';
            textEl.style.fontSize = (Math.random() * 10 + 16) + 'px';
            textEl.style.opacity = (Math.random() * 0.05 + 0.08);
            textEl.style.transform = `rotate(${Math.random() * 360}deg)`;
            textEl.style.zIndex = '9998';
            
            watermark.appendChild(textEl);
        }
        
        console.log('✅ Mobile watermark created');
    }

    function showScreenshotAlert() {
        const existingAlert = document.querySelector('.screenshot-alert');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        const violationsData = getViolationsData();
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-warning screenshot-alert';
        
        const mobileText = isMobileDevice ? ' (Mode Mobile)' : '';
        alertDiv.innerHTML = `
            <button type="button" class="close" onclick="this.parentElement.remove()">&times;</button>
            <h4><i class="fa fa-warning"></i> Aktivitas Mencurigakan Terdeteksi${mobileText}!</h4>
            <p>Aktivitas screenshot atau pelanggaran keamanan telah tercatat.</p>
            <small>Total Poin Pelanggaran: <strong>${violationsData.totalPoints.toFixed(1)}</strong> / ${MAX_VIOLATION_POINTS}</small>
        `;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            if (alertDiv.parentElement) {
                alertDiv.remove();
            }
        }, 5000);
    }

    function performSecurityCheck() {
        // Cek developer tools (desktop only)
        if (!isMobileDevice && checkDevTools()) {
            addViolation(
                'DEVELOPER_TOOLS',
                'Developer Tools terdeteksi terbuka selama tes',
                VIOLATION_POINTS.DEVELOPER_TOOLS * 0.5,
                { periodicCheck: true }
            );
        }
        
        // Heartbeat logging
        addViolation(
            'HEARTBEAT_CHECK',
            'Periodic security check - Sistem aktif',
            0.0,
            { 
                timestamp: new Date().toISOString(),
                totalPoints: getViolationsData().totalPoints,
                mobile: isMobileDevice
            }
        );
    }

    function checkDevTools() {
        let devToolsOpen = false;
        const widthThreshold = window.outerWidth - window.innerWidth > 100;
        const heightThreshold = window.outerHeight - window.innerHeight > 100;
        
        const start = performance.now();
        debugger;
        const end = performance.now();
        
        if (end - start > 100) {
            devToolsOpen = true;
        }
        
        return devToolsOpen || widthThreshold || heightThreshold;
    }

    // ==================== FUNGSI UTAMA TES ====================

    function startTimer() {
        clearInterval(timerInterval);
        timerInterval = setInterval(function() {
            const sisa_menit = Math.floor(sisa_detik / 60);
            const sisa_detik_display = sisa_detik % 60;
            const waktuElement = document.getElementById("sisa-waktu");
            
            if (waktuElement) {
                waktuElement.textContent = 
                    `Sisa Waktu: ${sisa_menit}:${sisa_detik_display < 10 ? '0' : ''}${sisa_detik_display}`;
            }
            
            sisa_detik--;
            
            if(sisa_detik < 0){
                clearInterval(timerInterval);
                window.location.reload();
            }
        }, 1000);
    }

    function handleMultipleViolations() {
        if (isLoggingOut) return;
        isLoggingOut = true;
        
        const violationsData = getViolationsData();
        console.error('🚨 Batas pelanggaran terlampaui:', violationsData.totalPoints);
        
        // Hapus data pelanggaran
        resetViolationData();
        
        // Catat forced logout
        logSecurityEvent({
            type: 'FORCED_LOGOUT',
            reason: `Batas ${MAX_VIOLATION_POINTS} poin terlampaui`,
            finalPoints: violationsData.totalPoints,
            isMobile: isMobileDevice,
            violationsCount: violationsData.violations.length
        });
        
        showForcedLogoutModal();
        startLogoutCountdown();
    }

    function showForcedLogoutModal() {
        const violationsData = getViolationsData();
        const violationCountElement = document.getElementById('violation-count');
        
        if (violationCountElement) {
            violationCountElement.textContent = violationsData.totalPoints.toFixed(1);
        }
        // Tampilkan modal forced logout
        $('#forcedLogoutModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        
        // Tutup modal lainnya yang mungkin terbuka
        $('#ipWarningModal').modal('hide');
        $('#modal-hentikan').modal('hide');
        $('#modal-proses').modal('hide');
    }

    function startLogoutCountdown() {
        let countdown = 5;
        const countdownElement = document.getElementById('logout-countdown');
        
        const countdownInterval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                forceLogout();
            }
        }, 1000);
    }

    function forceLogout() {
        console.log('🔒 Memaksa logout...');
        
        // Pastikan data dihapus
        resetViolationData();
        
        logSecurityEvent({
            type: 'REDIRECT_TO_LOGOUT',
            action: 'forced_logout_completed'
        });
        
        window.location.href = '<?php echo site_url("welcome/logout"); ?>';
    }

    function logSecurityEvent(eventData) {
        const logData = {
            ...eventData,
            tesUserId: document.getElementById('tes-user-id')?.value,
            tesId: document.getElementById('tes-id')?.value,
            ipAddress: '<?= $_SERVER['REMOTE_ADDR'] ?? '' ?>',
            pageUrl: window.location.href,
            viewport: `${window.innerWidth}x${window.innerHeight}`,
            timestamp: new Date().toISOString()
        };
        
        // Kirim ke server untuk pencatatan
        fetch('<?php echo site_url().'/'.$url; ?>/log_security_event', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(logData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'success') {
                console.error('Gagal mencatat event keamanan:', data);
            }
        })
        .catch(error => {
            console.error('Error mencatat event keamanan:', error);
        });
    }

    // ==================== PENGAMANAN COPY-PASTE ====================

    function terapkanPengamananCopy() {
        // Blokir klik kanan
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // Blokir drag dan drop
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
        });

        // Blokir seleksi teks
        document.addEventListener('selectstart', function(e) {
            e.preventDefault();
        });

        // Blokir shortcut keyboard
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && (
                e.keyCode === 67 ||  // C - Copy
                e.keyCode === 65 ||  // A - Select All
                e.keyCode === 88 ||  // X - Cut
                e.keyCode === 83 ||  // S - Save
                e.keyCode === 85     // U - View Source
            )) {
                e.preventDefault();
            }
            
            if (e.keyCode === 123 || (e.ctrlKey && e.shiftKey && e.keyCode === 73)) {
                e.preventDefault();
            }
        });

        // Blokir event copy
        document.addEventListener('copy', function(e) {
            e.preventDefault();
        });
    }

    // ==================== FUNGSI TES EXISTING ====================

    function zoombesar(){
        $('#isi-tes-soal').css("font-size", "140%");
        $('#isi-tes-soal').css("line-height", "140%");
    }

    function zoomnormal(){
        $('#isi-tes-soal').css("font-size", "15px");
        $('#isi-tes-soal').css("line-height", "110%");
    }

    function ragu(){
        $("#modal-proses").modal('show');

        $.ajax({
            url:'<?php echo site_url().'/'.$url; ?>/get_tes_soal_by_tessoal/'+$('#tes-soal-id').val(),
            type:"POST",
            cache: false,
            timeout: 10000,
            success:function(respon){
                var data = $.parseJSON(respon);
                if(data.data==1){
                    // Mengubah nilai ragu-ragu di database
                    if($('#tes-soal-ragu').val()==0){
                        var ragu=1;
                    }else{
                        var ragu=0;
                    }
                    $.ajax({
                            url:'<?php echo site_url().'/'.$url; ?>/update_tes_soal_ragu/'+$('#tes-soal-id').val()+'/'+ragu,
                            type:"POST",
                            cache: false,
                            timeout: 5000,
                            success:function(respon){
                                var data = $.parseJSON(respon);
                                if(data.data==1){
                                    notify_success('Jawaban Ragu-ragu berhasil diubah');
                                }
                            },
                            error: function(xmlhttprequest, textstatus, message) {
                                if(textstatus==="timeout") {
                                    $("#modal-proses").modal('hide');
                                    notify_error("Gagal mengubah Soal, Silahkan Refresh Halaman");
                                }else{
                                    $("#modal-proses").modal('hide');
                                    notify_error(textstatus);
                                }
                            }
                    });

                    // Mengubah warna daftar soal dan checkbox pada tombol ragu-ragu
                    if(data.tessoal_dikerjakan==1){
                        if($('#tes-soal-ragu').val()==0){
                            // Membuat menjadi ragu-ragu
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).removeClass('btn-primary');
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).addClass('btn-warning');
                            $('#btn-ragu-checkbox').prop("checked", true);
                            $('#tes-soal-ragu').val(1);
                        }else{
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).removeClass('btn-warning');
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).addClass('btn-primary');
                            $('#btn-ragu-checkbox').prop("checked", false);
                            $('#tes-soal-ragu').val(0);
                        }
                    }else{
                        if($('#tes-soal-ragu').val()==0){
                            // Membuat menjadi ragu-ragu
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).removeClass('btn-default');
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).addClass('btn-warning');
                            $('#btn-ragu-checkbox').prop("checked", true);
                            $('#tes-soal-ragu').val(1);
                        }else{
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).removeClass('btn-warning');
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).addClass('btn-default');
                            $('#btn-ragu-checkbox').prop("checked", false);
                            $('#tes-soal-ragu').val(0);
                        }
                    }
                }
                $("#modal-proses").modal('hide');
            },
            error: function(xmlhttprequest, textstatus, message) {
                if(textstatus==="timeout") {
                    $("#modal-proses").modal('hide');
                    notify_error("Gagal mengubah soal, Silahkan Refresh Halaman");
                }else{
                    $("#modal-proses").modal('hide');
                    notify_error(textstatus);
                }
            }
        });
    }

    function soal(tessoal_id){
        $("#modal-proses").modal('show');
        $.ajax({
            url:'<?php echo site_url().'/'.$url; ?>/get_soal_by_tessoal/'+tessoal_id+'/'+$('#tes-user-id').val(),
            type:"POST",
            cache: false,
            timeout: 10000,
            success:function(respon){
                var data = $.parseJSON(respon);
                if(data.data==1){
                    $('#tes-soal-id').val(data.tes_soal_id);
                    $('#tes-soal-nomor').val(data.tes_soal_nomor);
                    $('#isi-tes-soal').html(data.tes_soal);
                    $('#tes-soal-ragu').val(data.tes_ragu);
                    $('#judul-soal').html('ke '+data.tes_soal_nomor);

                    if(data.tes_ragu==0){
                        // Menghilangkan checkbox ragu-ragu
                        $('#btn-ragu-checkbox').prop("checked", false);
                    }else{
                        // Menambah checkbox ragu-ragu
                        $('#btn-ragu-checkbox').prop("checked", true);
                    }

                    // menghilangkan tombol sebelum jika soal di nomor1
                    // dan menghilangkan tombol selanjutnya jika disoal terakhir
                    var tes_soal_nomor = parseInt($('#tes-soal-nomor').val());
                    var tes_soal_jml = parseInt($('#tes-soal-jml').val());
                    var tes_soal_tujuan = data.tes_soal_nomor;
                    if(tes_soal_tujuan==1){
                        $('#btn-sebelumnya').addClass('hide');
                        $('#btn-selanjutnya').removeClass('hide');
                    }else if(tes_soal_tujuan==tes_soal_jml){
                        $('#btn-sebelumnya').removeClass('hide');
                        $('#btn-selanjutnya').addClass('hide');
                    }else{
                        $('#btn-sebelumnya').removeClass('hide');
                        $('#btn-selanjutnya').removeClass('hide');
                    }

                }else if(data.data==2){
                    window.location.reload();
                }
                $("#modal-proses").modal('hide');
            },
            error: function(xmlhttprequest, textstatus, message) {
                if(textstatus==="timeout") {
                    $("#modal-proses").modal('hide');
                    notify_error("Gagal mengambil Soal, Silahkan Refresh Halaman");
                }else{
                    $("#modal-proses").modal('hide');
                    notify_error(textstatus);
                }
            }
        });
    }

    function audio(status){
        var audio_player_status = $('#audio-player-status').val();
        var audio_player_update = $('#audio-player-update').val();
        if(status==1){
            if(audio_player_update==0){
                $('#audio-player-update').val('1');
                /**
                 * Update status audio jika pemutaran audio dibatasi
                 */
                $.getJSON('<?php echo site_url().'/'.$url; ?>/update_status_audio/'+$('#tes-soal-id').val(), function(data){
                    if(data.data==1){
                        notify_success(data.pesan);
                    }
                });
            }
        }
        
        if(audio_player_status==0){
            $('#audio-player-status').val('1');
            $('#audio-player').trigger('play');
            $('#audio-player-judul').html('Pause');
            $('#audio-player-judul-logo').removeClass('fa-play');
            $('#audio-player-judul-logo').addClass('fa-pause');
        }else{
            $('#audio-player-status').val('0');
            $('#audio-player').trigger('pause');
            $('#audio-player-judul').html('Play');
            $('#audio-player-judul-logo').removeClass('fa-pause');
            $('#audio-player-judul-logo').addClass('fa-play');
        }
    }

    function audio_ended(status){
        if(status==1){
            $('#audio-control').addClass('hide');
        }else{
            $('#audio-player-status').val('0');
            $('#audio-player-judul').html('Play');
            $('#audio-player-judul-logo').removeClass('fa-pause');
            $('#audio-player-judul-logo').addClass('fa-play');
        }
    }

    function jawab(){
        $('#form-kerjakan').submit();
    }

    function hentikan_tes(){
        $("#modal-proses").modal('show');
        $('#hentikan-centang').prop("checked", false);
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_tes_info/'+$('#tes-id').val(), function(data){
            if(data.data==1){
                $('#hentikan-tes-id').val(data.tes_id);
                $('#hentikan-tes-user-id').val(data.tes_user_id);
                $('#hentikan-tes-nama').val(data.tes_nama);
                $('#hentikan-dijawab').val(data.tes_dijawab+" dijawab. "+data.tes_blum_dijawab+" belum dijawab.");
                $('#hentikan-belum-dijawab').val(data.tes_blum_dijawab);

                // Reset data pelanggaran ketika tes selesai normal
                resetViolationData();

                $("#modal-hentikan").modal('show');
            }else{
                window.location.reload();
            }
            $("#modal-proses").modal('hide');
        });
    }

    function soal_navigasi(navigasi){
        var tes_soal_nomor = parseInt($('#tes-soal-nomor').val());
        var tes_soal_jml = parseInt($('#tes-soal-jml').val());
        var tes_soal_tujuan = tes_soal_nomor+navigasi;

        if((tes_soal_tujuan>=1 && tes_soal_tujuan<=tes_soal_jml)){
            $('#btn-soal-'+tes_soal_tujuan).trigger('click');
        }
    }

    // ==================== INISIALISASI TEROPTIMASI ====================

    $(document).ready(function() {
        // Inisialisasi sistem
        initializeViolations();
        initSecuritySystem();
        startTimer();
        
        // Catat mulai tes
        addViolation(
            'TES_STARTED',
            `Memulai tes - ${isMobileDevice ? 'Mobile' : 'Desktop'}`,
            0.0,
            {
                deviceType: isMobileDevice ? 'mobile' : 'desktop',
                viewport: `${window.innerWidth}x${window.innerHeight}`
            }
        );
        
        console.log('✅ Sistem tes online diinisialisasi');
        
        // Setup event listeners untuk navigasi
        $('#btn-sebelumnya').click(() => soal_navigasi(-1));
        $('#btn-selanjutnya').click(() => soal_navigasi(1));
        $('#btn-hentikan').click(hentikan_tes);
        
        // Setup form submissions
        $('#form-kerjakan').submit(handleJawabanSubmit);
        $('#form-hentikan').submit(handleHentikanSubmit);

        // Tampilkan modal warning jika IP tidak dikenali
        <?php if (!$ip_allowed): ?>
        $('#ipWarningModal').modal('show');
        <?php endif; ?>
    });

    function handleJawabanSubmit(e) {
        e.preventDefault();
        $("#modal-proses").modal('show');
        
        $.ajax({
            url:"<?php echo site_url().'/'.$url; ?>/simpan_jawaban",
            type:"POST",
            data:$('#form-kerjakan').serialize(),
            cache: false,
            timeout: 10000,
            success:function(respon){
                var obj = $.parseJSON(respon);
                if(obj.status==1){
                    $("#modal-proses").modal('hide');
                    notify_success(obj.pesan);
                    $('#btn-soal-'+obj.nomor_soal).removeClass('btn-default');
                    $('#btn-soal-'+obj.nomor_soal).removeClass('btn-warning');
                    $('#btn-soal-'+obj.nomor_soal).addClass('btn-primary');
                }else if(obj.status==2){
                    window.location.reload();
                }else{
                    $("#modal-proses").modal('hide');
                    notify_error(obj.pesan);
                }
            },
            error: function(xmlhttprequest, textstatus, message) {
                if(textstatus==="timeout") {
                    $("#modal-proses").modal('hide');
                    notify_error("Gagal menyimpan jawaban, Silahkan Refresh Halaman");
                }else{
                    $("#modal-proses").modal('hide');
                    notify_error(textstatus);
                }
            }
        });
        return false;
    }

    function handleHentikanSubmit(e) {
        e.preventDefault();
        $("#modal-proses").modal('show');
        
        $.ajax({
            url:"<?php echo site_url().'/'.$url; ?>/hentikan_tes",
            type:"POST",
            data:$('#form-hentikan').serialize(),
            cache: false,
            timeout: 10000,
            success:function(respon){
                var obj = $.parseJSON(respon);
                if(obj.status==1){
                    window.location.reload();
                }else{
                    $("#modal-proses").modal('hide');
                    notify_error(obj.pesan);
                }
            },
            error: function(xmlhttprequest, textstatus, message) {
                if(textstatus==="timeout") {
                    $("#modal-proses").modal('hide');
                    notify_error("Gagal Menyelesaikan Tes, Silahkan Refresh Halaman");
                }else{
                    $("#modal-proses").modal('hide');
                    notify_error(textstatus);
                }
            }
        });
        return false;
    }
</script>