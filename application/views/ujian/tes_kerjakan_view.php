<div class="container">
    
    <!-- Tambahkan style untuk mencegah seleksi teks -->
    <style>
        /* PENGAMANAN HALAMAN TES: Mencegah seleksi teks */
        body {
            -webkit-user-select: none;  /* Untuk browser Chrome, Safari, Opera */
            -moz-user-select: none;     /* Untuk browser Firefox */
            -ms-user-select: none;      /* Untuk browser Internet Explorer */
            user-select: none;          /* Standar CSS */
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
        }
        .forced-logout-modal .modal-header {
            border-bottom: 2px solid rgba(255,255,255,0.3);
        }
        .forced-logout-modal .btn {
            background: white;
            color: #dc3545;
            border: none;
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
    </style>

    <!-- Watermark Container -->
    <div class="mobile-watermark" id="mobileWatermark"></div>

    <!-- Mobile Warning -->
    <div class="mobile-warning" id="mobileWarning">
        <i class="fa fa-mobile"></i> <strong>Mode Mobile Terdeteksi:</strong> 
        Segala aktivitas mencurigakan akan tercatat dan dapat mengakibatkan diskualifikasi.
    </div>

	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mapel : <?php if(!empty($tes_name)){ echo $tes_name; } ?>
        </h1>
        <div class="breadcrumb">
            <img src="<?php echo base_url(); ?>public/images/zoom.png" style="cursor: pointer;" height="20" onclick="zoomnormal()" title="Klik ukuran font normal" />&nbsp;&nbsp;
            <img src="<?php echo base_url(); ?>public/images/zoom.png" style="cursor: pointer;" height="26" onclick="zoombesar()" title="Klik ukuran font lebih besar" />
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                <p>Anda telah melanggar aturan keamanan tes sebanyak <strong id="violation-count">3</strong> kali.</p>
                <p>Akun Anda akan dikeluarkan secara otomatis dari sistem.</p>
                <div class="countdown-container">
                    <p>Redirect dalam: <span id="logout-countdown">5</span> detik</p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="welcome/logout" class="btn btn-lg btn-block">
                    <i class="fa fa-sign-out"></i> KELUAR SEKARANG
                </a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    /**
     * SISTEM DETEKSI SCREENSHOT DAN PENGAMANAN TES - MOBILE COMPATIBLE
     * Kode ini berfungsi untuk mendeteksi aktivitas mencurigakan di mobile dan desktop
     */

    // Variabel untuk melacak status keamanan
    let securityViolationCount = 0;
    let lastScreenshotDetection = 0;
    let isLoggingOut = false;
    let isMobileDevice = false;
    let mobileDetectionEnabled = false;

    /**
     * FUNGSI DETEKSI DEVICE - Mendeteksi apakah user menggunakan perangkat mobile
     */
    function detectMobileDevice() {
        const userAgent = navigator.userAgent || navigator.vendor || window.opera;
        
        // Deteksi berbagai jenis perangkat mobile
        isMobileDevice = (
            /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(userAgent) ||
            (window.innerWidth <= 768) ||
            ('ontouchstart' in window) ||
            (navigator.maxTouchPoints > 0) ||
            (window.orientation !== undefined)
        );
        
        console.log('Mobile Device Detected:', isMobileDevice);
        return isMobileDevice;
    }

    /**
     * FUNGSI INISIALISASI DETEKSI MOBILE - Pendekatan khusus untuk mobile
     */
    function initMobileDetection() {
        if (!isMobileDevice) return;
        
        console.log('Mengaktifkan sistem deteksi mobile-friendly');
        mobileDetectionEnabled = true;
        
        // Tampilkan warning untuk mobile
        document.getElementById('mobileWarning').style.display = 'block';
        
        // 1. BUAT WATERMARK DINAMIS
        createMobileWatermark();
        
        // 2. DETEKSI PERUBAHAN ORIENTASI (Mobile-specific)
        window.addEventListener('orientationchange', function() {
            handleSuspiciousActivity('Perubahan orientasi layar terdeteksi', 0.3);
        });
        
        // 3. DETEKSI PERUBAHAN UKURAN LAYAR (lebih sensitif di mobile)
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                handleSuspiciousActivity('Perubahan ukuran layar mobile terdeteksi', 0.2);
            }, 500);
        });
        
        // 4. DETEKSI MULTI-TOUCH GESTURES (kemungkinan screenshot gesture)
        let touchCount = 0;
        let touchTimer;
        
        document.addEventListener('touchstart', function(e) {
            touchCount = e.touches.length;
            
            // Deteksi three-finger touch (gesture umum untuk screenshot di beberapa device)
            if (e.touches.length >= 3) {
                handleScreenshotDetection('Three-finger touch gesture terdeteksi', 0.8);
            }
            
            // Reset touch counter setelah 2 detik
            clearTimeout(touchTimer);
            touchTimer = setTimeout(() => {
                touchCount = 0;
            }, 2000);
        });
        
        // 5. DETEKSI SWIPE GESTURES DARI SISI LAYAR
        let startX = 0;
        let startY = 0;
        
        document.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        });
        
        document.addEventListener('touchend', function(e) {
            if (!startX || !startY) return;
            
            const endX = e.changedTouches[0].clientX;
            const endY = e.changedTouches[0].clientY;
            
            // Deteksi swipe dari pojok kanan bawah (gesture screenshot di beberapa OEM)
            if (startX > window.innerWidth * 0.7 && startY > window.innerHeight * 0.7) {
                handleSuspiciousActivity('Swipe gesture dari area screenshot terdeteksi', 0.8);
            }
        });

        // 6. DETEKSI APLIKASI BACKGROUND/BLUR (indikasi screenshot)
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                handleSuspiciousActivity('Aplikasi berpindah ke background', 0.8);
            }
        });

        // 7. DETEKSI PERUBAHAN ZOOM/PINCH GESTURE
        let initialDistance = 0;
        
        document.addEventListener('touchstart', function(e) {
            if (e.touches.length === 2) {
                initialDistance = Math.hypot(
                    e.touches[0].clientX - e.touches[1].clientX,
                    e.touches[0].clientY - e.touches[1].clientY
                );
            }
        });

        document.addEventListener('touchmove', function(e) {
            if (e.touches.length === 2) {
                const currentDistance = Math.hypot(
                    e.touches[0].clientX - e.touches[1].clientX,
                    e.touches[0].clientY - e.touches[1].clientY
                );
                
                // Deteksi pinch gesture yang signifikan
                if (Math.abs(currentDistance - initialDistance) > 50) {
                    handleSuspiciousActivity('Pinch/zoom gesture terdeteksi', 0.3);
                }
            }
        });
    }

    /**
     * FUNGSI MEMBUAT WATERMARK UNTUK MOBILE
     * Watermark membuat screenshot tidak berguna untuk kecurangan
     */
    function createMobileWatermark() {
        const watermark = document.getElementById('mobileWatermark');
        if (!watermark) return;
        
        const userId = $('#tes-user-id').val() || 'UNKNOWN';
        const tesId = $('#tes-id').val() || 'UNKNOWN';
        const timestamp = new Date().toLocaleDateString('id-ID');
        
        const texts = [
            `DILINDUNGI - ${userId}`,
            `KONFIDENSIAL - ${timestamp}`,
            `TES ONLINE KALIMA TEST - ${tesId}`,
            'SCREENSHOT DILARANG',
            'AKAN DILAPORKAN'
        ];
        
        // Clear existing watermarks
        watermark.innerHTML = '';
        
        // Buat multiple watermark text
        for (let i = 0; i < 15; i++) {
            const textEl = document.createElement('div');
            textEl.className = 'watermark-text';
            textEl.textContent = texts[i % texts.length];
            textEl.style.top = (Math.random() * 100) + '%';
            textEl.style.left = (Math.random() * 100) + '%';
            textEl.style.fontSize = (Math.random() * 8 + 16) + 'px';
            textEl.style.opacity = (Math.random() * 0.05 + 0.08);
            textEl.style.transform = `rotate(${Math.random() * 360}deg)`;
            textEl.style.zIndex = '9998';
            
            watermark.appendChild(textEl);
        }
        
        console.log('Mobile watermark created');
    }

    /**
     * FUNGSI DETEKSI SCREENSHOT UNIFIED - Bekerja untuk desktop dan mobile
     */
    function initScreenshotDetection() {
        // Deteksi device type terlebih dahulu
        detectMobileDevice();
        
        console.log('Sistem deteksi screenshot diaktifkan - Mobile:', isMobileDevice);
        
        /**
         * 1. DETEKSI KEYBOARD & GESTURES (Desktop + Mobile WebView)
         */
        document.addEventListener('keydown', function(e) {
            // Deteksi Print Screen dan kombinasi tombol
            if (e.keyCode === 44 || // Print Screen
                (e.ctrlKey && e.keyCode === 44) || // Ctrl + Print Screen
                (e.key === 'PrintScreen') || // Print Screen key
                (e.metaKey && e.shiftKey && e.keyCode === 51) || // Cmd + Shift + 3 (Mac)
                (e.metaKey && e.shiftKey && e.keyCode === 52) || // Cmd + Shift + 4 (Mac)
                (e.altKey && e.keyCode === 44) // Alt + Print Screen
            ) {
                e.preventDefault();
                handleScreenshotDetection('Tombol screenshot ditekan: ' + e.key, 1);
            }
            
            // Kombinasi tombol mencurigakan
            if ((e.ctrlKey && e.shiftKey && (e.keyCode === 83 || e.keyCode === 88)) ||
                (e.altKey && e.keyCode === 83)) {
                handleSuspiciousActivity('Kombinasi tombol mencurigakan: ' + e.key, 0.5);
            }
        });

        /**
         * 2. DETEKSI PERUBAHAN VISIBILITAS (Universal)
         */
        let visibilityChangeCount = 0;
        let visibilityTimer;
        
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                visibilityChangeCount++;
                
                // Reset counter setelah 10 detik
                clearTimeout(visibilityTimer);
                visibilityTimer = setTimeout(() => {
                    visibilityChangeCount = 0;
                }, 10000);
                
                // Jika terlalu sering dalam waktu singkat, anggap mencurigakan
                if (visibilityChangeCount >= 3) {
                    handleScreenshotDetection('Perubahan visibilitas terlalu sering', 0.7);
                } else {
                    const penalty = isMobileDevice ? 0.3 : 0.5;
                    handleSuspiciousActivity('Tab/aplikasi tidak aktif', penalty);
                }
            }
        });

        /**
         * 3. DETEKSI PERUBAHAN UKURAN WINDOW (Universal)
         */
        let originalSize = { 
            width: window.innerWidth, 
            height: window.innerHeight 
        };
        
        window.addEventListener('resize', function() {
            setTimeout(() => {
                const currentSize = {
                    width: window.innerWidth,
                    height: window.innerHeight
                };
                
                // Tolerance lebih besar untuk mobile
                const tolerance = isMobileDevice ? 100 : 50;
                
                if (Math.abs(currentSize.width - originalSize.width) > tolerance ||
                    Math.abs(currentSize.height - originalSize.height) > tolerance) {
                    const penalty = isMobileDevice ? 0.5 : 0.8;
                    handleSuspiciousActivity('Perubahan ukuran window signifikan', penalty);
                }
                
                originalSize = currentSize;
            }, 100);
        });

        /**
         * 4. DETEKSI FOCUS OUT (Universal)
         */
        window.addEventListener('blur', function() {
            const penalty = isMobileDevice ? 0.2 : 0.5;
            handleSuspiciousActivity('Window kehilangan fokus', penalty);
        });

        /**
         * 5. DETEKSI MOUSE MENUJUK AREA SPECIFIC (Desktop)
         */
        if (!isMobileDevice) {
            document.addEventListener('mousemove', function(e) {
                if (e.clientY < 10) { // Mouse di area title bar
                    handleSuspiciousActivity('Aktivitas mouse di area title bar', 0.3);
                }
            });
        }

        /**
         * 6. INISIALISASI DETEKSI MOBILE KHUSUS
         */
        initMobileDetection();

        /**
         * 7. PERIODIC SECURITY CHECK (Universal)
         */
        setInterval(() => {
            performSecurityCheck();
        }, isMobileDevice ? 45000 : 30000); // Interval lebih lama untuk mobile
    }

    /**
     * FUNGSI PENANGANAN DETEKSI SCREENSHOT - DIMODIFIKASI UNTUK MOBILE
     * @param {string} reason - Alasan terdeteksinya screenshot
     * @param {number} penaltyMultiplier - Pengali penalty (0-1)
     */
    function handleScreenshotDetection(reason, penaltyMultiplier = 1) {
        const now = Date.now();
        
        // Cegah deteksi berulang dalam waktu singkat
        const cooldown = isMobileDevice ? 10000 : 5000;
        if (now - lastScreenshotDetection < cooldown) {
            return;
        }
        
        lastScreenshotDetection = now;
        
        // Penalty lebih ringan untuk mobile (mengurangi false positive)
        const basePenalty = isMobileDevice ? 0.7 : 1;
        const effectivePenalty = basePenalty * penaltyMultiplier;
        securityViolationCount += effectivePenalty;
        
        console.warn('Aktivitas mencurigakan terdeteksi:', reason, 
                    'Total pelanggaran:', securityViolationCount.toFixed(1),
                    'Mobile:', isMobileDevice);
        
        // Tampilkan notifikasi
        showScreenshotAlert();
        
        // Catat aktivitas ke server
        logSecurityEvent({
            type: 'SECURITY_VIOLATION',
            reason: reason,
            violationCount: securityViolationCount,
            isMobile: isMobileDevice,
            penalty: effectivePenalty,
            timestamp: new Date().toISOString(),
            userAgent: navigator.userAgent,
            url: window.location.href
        });
        
        // Jika violation melebihi batas, paksa logout
        if (securityViolationCount >= 3) {
            handleMultipleViolations();
        }
    }

    /**
     * FUNGSI PENANGANAN AKTIVITAS MENCURIGAKAN - DIMODIFIKASI UNTUK MOBILE
     * @param {string} activity - Deskripsi aktivitas mencurigakan
     * @param {number} penaltyMultiplier - Pengali penalty (0-1)
     */
    function handleSuspiciousActivity(activity, penaltyMultiplier = 0.8) {
        console.log('Aktivitas mencurigakan:', activity, 'Mobile:', isMobileDevice);
        
        // Penalty lebih ringan untuk aktivitas mencurigakan
        const basePenalty = isMobileDevice ? 0.3 : 0.5;
        const effectivePenalty = basePenalty * penaltyMultiplier;
        
        // Untuk aktivitas mencurigakan, tambahkan penalty kecil
        securityViolationCount += effectivePenalty;
        
        // Catat aktivitas mencurigakan
        logSecurityEvent({
            type: 'SUSPICIOUS_ACTIVITY',
            activity: activity,
            penalty: effectivePenalty,
            isMobile: isMobileDevice,
            timestamp: new Date().toISOString()
        });
        
        // Cek jika perlu logout
        if (securityViolationCount >= 3) {
            handleMultipleViolations();
        }
    }

    /**
     * FUNGSI MENAMPILKAN ALERT SCREENSHOT
     * Menampilkan notifikasi visual bahwa screenshot terdeteksi
     */
    function showScreenshotAlert() {
        // Hapus alert sebelumnya jika ada
        const existingAlert = document.querySelector('.screenshot-alert');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        // Buat element alert baru
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-warning screenshot-alert';
        
        const mobileText = isMobileDevice ? ' (Mode Mobile)' : '';
        alertDiv.innerHTML = `
            <button type="button" class="close" onclick="this.parentElement.remove()">&times;</button>
            <h4><i class="fa fa-warning"></i> Aktivitas Mencurigakan Terdeteksi${mobileText}!</h4>
            <p>Aktivitas mencurigakan telah tercatat. Tindakan ini dapat mengakibatkan diskualifikasi.</p>
            <small>Pelanggaran keamanan: ${securityViolationCount.toFixed(1)}/3</small>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Hapus otomatis setelah 5 detik
        setTimeout(() => {
            if (alertDiv.parentElement) {
                alertDiv.remove();
            }
        }, 5000);
    }

    /**
     * FUNGSI PENCATATAN EVENT KEAMANAN
     * @param {object} eventData - Data event keamanan yang akan dicatat
     */
    function logSecurityEvent(eventData) {
        // Tambahkan data tambahan
        const logData = {
            ...eventData,
            tesUserId: $('#tes-user-id').val(),
            tesId: $('#tes-id').val(),
            ipAddress: '<?= $_SERVER['REMOTE_ADDR'] ?? '' ?>',
            pageUrl: window.location.href,
            viewport: `${window.innerWidth}x${window.innerHeight}`
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

    /**
     * FUNGSI PENANGANAN MULTIPLE VIOLATIONS - MEMAKSA LOGOUT
     * Dijalankan ketika pelanggaran keamanan mencapai batas tertentu (3 kali)
     */
    function handleMultipleViolations() {
        if (isLoggingOut) return; // Prevent multiple executions
        isLoggingOut = true;
        
        console.error('Multiple security violations detected:', securityViolationCount, ' - Memaksa logout...');
        
        // Tampilkan modal forced logout
        showForcedLogoutModal();
        
        // Catat forced logout ke server
        logSecurityEvent({
            type: 'FORCED_LOGOUT',
            reason: 'Multiple security violations',
            violationCount: securityViolationCount,
            isMobile: isMobileDevice,
            timestamp: new Date().toISOString()
        });
        
        // Otomatis redirect setelah countdown
        startLogoutCountdown();
    }

    /**
     * FUNGSI MENAMPILKAN MODAL FORCED LOGOUT
     * Menampilkan modal yang memberitahu user akan di-logout paksa
     */
    function showForcedLogoutModal() {
        // Update violation count di modal
        document.getElementById('violation-count').textContent = securityViolationCount.toFixed(1);
        
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

    /**
     * FUNGSI COUNTDOWN UNTUK LOGOUT OTOMATIS
     * Menghitung mundur sebelum redirect ke halaman logout
     */
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

    /**
     * FUNGSI MEMAKSA LOGOUT
     * Redirect user ke halaman logout
     */
    function forceLogout() {
        console.log('Memaksa logout karena pelanggaran keamanan...');
        
        // Catat final logout event
        logSecurityEvent({
            type: 'REDIRECT_TO_LOGOUT',
            timestamp: new Date().toISOString()
        });
        
        // Redirect ke halaman logout
        window.location.href = '<?php echo site_url("welcome/logout"); ?>';
    }

    /**
     * FUNGSI PEMERIKSAAN KEAMANAN BERKALA
     * Melakukan berbagai pemeriksaan keamanan secara periodik
     */
    function performSecurityCheck() {
        // Cek jika developer tools terbuka (hanya desktop)
        if (!isMobileDevice) {
            const devToolsOpened = checkDevTools();
            if (devToolsOpened) {
                handleScreenshotDetection('Developer Tools terdeteksi terbuka', 0.8);
            }
        }
        
        // Cek perubahan pada DOM yang mencurigakan
        checkDOMTampering();
        
        // Cek aktivitas network yang tidak biasa
        checkNetworkAnomalies();
        
        // Heartbeat logging
        logSecurityEvent({
            type: 'HEARTBEAT',
            isMobile: isMobileDevice,
            timestamp: new Date().toISOString(),
            viewport: `${window.innerWidth}x${window.innerHeight}`,
            orientation: window.orientation || 'not available'
        });
    }

    /**
     * FUNGSI PENDETEKSI DEVELOPER TOOLS
     * @returns {boolean} - Status apakah dev tools terbuka
     */
    function checkDevTools() {
        let devToolsOpen = false;
        
        // Metode 1: Cek perbedaan ukuran window
        const widthThreshold = window.outerWidth - window.innerWidth > 100;
        const heightThreshold = window.outerHeight - window.innerHeight > 100;
        
        // Metode 2: Cek waktu execution (dev tools memperlambat)
        const start = performance.now();
        debugger;
        const end = performance.now();
        
        if (end - start > 100) {
            devToolsOpen = true;
        }
        
        return devToolsOpen || widthThreshold || heightThreshold;
    }

    /**
     * FUNGSI PENGECEKAN PERUBAHAN DOM
     * Mendeteksi perubahan tidak wajar pada DOM
     */
    function checkDOMTampering() {
        // Cek jika ada element tersembunyi yang mencurigakan
        const hiddenElements = document.querySelectorAll('*[style*="display: none"], *[style*="visibility: hidden"]');
        if (hiddenElements.length > 10) {
            handleSuspiciousActivity('Banyak element DOM tersembunyi terdeteksi', 0.8);
        }
    }

    /**
     * FUNGSI PENGECEKAN ANOMALI NETWORK
     * Mendeteksi aktivitas network yang mencurigakan
     */
    function checkNetworkAnomalies() {
        // Basic network check - bisa dikembangkan lebih lanjut
        if (!navigator.onLine) {
            handleSuspiciousActivity('Koneksi jaringan terputus', 0.8);
        }
    }

    /**
     * FUNGSI PENGAMANAN HALAMAN TES: Mencegah tindakan copy-paste
     * Kode ini bertujuan untuk melindungi konten soal dari tindakan penyalinan
     * oleh peserta tes selama ujian berlangsung.
     */

    // Fungsi untuk menerapkan pengamanan copy
    function terapkanPengamananCopy() {
        /**
         * 1. BLOKIR KLIK KANAN (CONTEXT MENU)
         * Mencegah akses menu klik kanan yang bisa digunakan untuk copy
         */
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            console.log('Klik kanan dinonaktifkan untuk keamanan tes');
        });

        /**
         * 2. BLOKIR DRAG DAN DROP
         * Mencegah drag teks yang bisa digunakan untuk seleksi dan copy
         */
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
        });

        /**
         * 3. BLOKIR SELEKSI TEKS
         * Mencegah seleksi teks melalui mouse atau keyboard
         */
        document.addEventListener('selectstart', function(e) {
            e.preventDefault();
        });

        /**
         * 4. BLOKIR SHORTCUT KEYBOARD
         * Mencegah penggunaan shortcut keyboard untuk copy, select all, dll.
         */
        document.addEventListener('keydown', function(e) {
            // Deteksi kombinasi Ctrl+C, Ctrl+A, Ctrl+X, Ctrl+S, Ctrl+U
            if (e.ctrlKey && (
                e.keyCode === 67 ||  // C - Copy
                e.keyCode === 65 ||  // A - Select All
                e.keyCode === 88 ||  // X - Cut
                e.keyCode === 83 ||  // S - Save
                e.keyCode === 85     // U - View Source
            )) {
                e.preventDefault();
                console.log('Shortcut keyboard diblokir untuk keamanan tes');
            }
            
            // Blokir F12 (Developer Tools)
            if (e.keyCode === 123) {
                e.preventDefault();
                console.log('Developer Tools diblokir untuk keamanan tes');
            }
            
            // Blokir Ctrl+Shift+I (Developer Tools)
            if (e.ctrlKey && e.shiftKey && e.keyCode === 73) {
                e.preventDefault();
                console.log('Developer Tools diblokir untuk keamanan tes');
            }
        });

        /**
         * 5. BLOKIR EVENT COPY EXPLICIT
         * Mencegah aksi copy meskipun berhasil diseleksi
         */
        document.addEventListener('copy', function(e) {
            e.preventDefault();
            // Opsional: Tampilkan pesan peringatan
            alert('Tindakan copy tidak diizinkan selama tes berlangsung.');
        });
    }

    // Tampilkan modal warning jika IP tidak dikenali
    <?php if (!$ip_allowed): ?>
    $('#ipWarningModal').modal('show');
    <?php endif; ?>
    
    // Check setiap 10 detik
    setInterval(checkNetworkStatus, 10000);

    function checkNetworkStatus() {
        const status = navigator.onLine ? 'online' : 'offline';
        
        // Kirim status ke server
        fetch('network_check.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'network_check=1&status=' + status
        })
        .then(response => response.text())
        .then(data => {
            if (status === 'offline') {
                window.location.reload(true);
            }
        });
    }

    // Event listener untuk perubahan jaringan
    window.addEventListener('online', checkNetworkStatus);
    window.addEventListener('offline', checkNetworkStatus);

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

    $(function () {
        /**
         * INISIALISASI SISTEM KEAMANAN
         * Menjalankan semua sistem pengamanan saat halaman dimuat
         */
        terapkanPengamananCopy(); // Pengamanan copy-paste
        initScreenshotDetection(); // Deteksi screenshot

        var sisa_detik = <?php if(!empty($detik_sisa)){ echo $detik_sisa; } ?>;
        setInterval(function() {
            var sisa_menit = Math.round(sisa_detik/60);
            sisa_detik = sisa_detik-1;
            $("#sisa-waktu").html("Sisa Waktu : "+sisa_menit+" menit");

            if(sisa_detik<1){
                window.location.reload();
            }
        }, 1000);

        $('#btn-sebelumnya').click(function(){
            soal_navigasi(-1);
        });

        $('#btn-selanjutnya').click(function(){
            soal_navigasi(1);
        });

        $('#btn-hentikan').click(function(){
            hentikan_tes();
        });
        /**
         * Submit form soal saat sudah menjawab
         */
        $('#form-kerjakan').submit(function(){
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
        });

        /**
         * Submit form menyelesaikan tes
         */
        $('#form-hentikan').submit(function(){
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
        });

        $( document ).ready(function() {
            // Log aktivitas mulai tes dengan info device
            logSecurityEvent({
                type: 'TES_STARTED',
                isMobile: isMobileDevice,
                deviceInfo: {
                    userAgent: navigator.userAgent,
                    viewport: `${window.innerWidth}x${window.innerHeight}`,
                    touchPoints: navigator.maxTouchPoints || 0,
                    platform: navigator.platform
                },
                timestamp: new Date().toISOString()
            });
        });
    });
</script>