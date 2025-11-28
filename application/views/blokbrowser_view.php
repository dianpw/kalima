<!DOCTYPE html>
<html lang="id">
<head>
    <!-- REKOMENDASI: Tambahkan meta tags penting -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Browser yang Didukung - KALIMA TEST</title>
    
    <!-- REKOMENDASI: Load CSS Bootstrap jika belum ada -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
    <style>
        .browser-list { margin: 20px 0; }
        .browser-item { 
            padding: 15px; 
            border-left: 4px solid #3c8dbc;
            margin-bottom: 10px;
        }
        .download-btn { margin-top: 10px; }
        .current-browser { background-color: #f9f9f9; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Browser yang Didukung
            <small>Daftar browser yang kompatibel dengan aplikasi KALIMA TEST</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info Browser Saat Ini -->
        <div id="current-browser-info" class="current-browser alert alert-warning" style="display:none;">
            <h4>Browser Anda: <span id="browser-name"></span></h4>
            <p id="browser-message"></p>
        </div>

        <div class="callout callout-info">
            <h4>Informasi Penting</h4>
            <p>Untuk pengalaman terbaik dalam menggunakan Aplikasi KALIMA TEST, gunakan salah satu browser berikut melalui perangkat komputer PC atau Laptop:</p>
            
            <!-- Daftar Browser yang Didukung -->
            <div class="browser-list">
                <div class="browser-item">
                    <strong>Google Chrome</strong> (versi 70+)<br>
                    <small>Browser yang paling direkomendasikan untuk performa optimal</small>
                    <div class="download-btn">
                        <a href="https://www.google.com/chrome/" target="_blank" class="btn btn-success btn-xs">
                            Download Chrome
                        </a>
                    </div>
                </div>
                
                <div class="browser-item">
                    <strong>Mozilla Firefox</strong> (versi 60+)<br>
                    <small>Browser open-source dengan fitur keamanan terbaik</small>
                    <div class="download-btn">
                        <a href="https://www.mozilla.org/firefox/" target="_blank" class="btn btn-success btn-xs">
                            Download Firefox
                        </a>
                    </div>
                </div>
                
                <div class="browser-item">
                    <strong>Microsoft Edge</strong> (versi 79+)<br>
                    <small>Browser modern dari Microsoft berbasis Chromium</small>
                    <div class="download-btn">
                        <a href="https://www.microsoft.com/edge" target="_blank" class="btn btn-success btn-xs">
                            Download Edge
                        </a>
                    </div>
                </div>
                
                <div class="browser-item">
                    <strong>Safari</strong> (versi 12+)<br>
                    <small>Untuk pengguna macOS</small>
                </div>
                
                <div class="browser-item">
                    <strong>Opera</strong> (versi 60+)<br>
                    <small>Browser dengan fitur built-in VPN</small>
                    <div class="download-btn">
                        <a href="https://www.opera.com/" target="_blank" class="btn btn-success btn-xs">
                            Download Opera
                        </a>
                    </div>
                </div>
            </div>

            <div class="alert alert-warning">
                <h5>Mengapa Internet Explorer Tidak Didukung?</h5>
                <p>Internet Explorer telah dihentikan oleh Microsoft dan tidak menerima update keamanan. Beberapa fitur modern yang digunakan oleh KALIMA TEST tidak bekerja dengan baik di Internet Explorer.</p>
            </div>

            <div class="alert alert-success">
                <h5>Tips:</h5>
                <ul>
                    <li>Pastikan browser Anda selalu diperbarui ke versi terbaru</li>
                    <li>Enable JavaScript untuk fungsi penuh aplikasi</li>
                    <li>Gunakan koneksi internet yang stabil</li>
                    <li>Clear cache browser secara berkala</li>
                </ul>
            </div>
        </div>

        <!-- Tombol Coba Lagi -->
        <div class="text-center">
            <button id="retry-button" class="btn btn-primary">
                Coba Akses Kembali
            </button>
            <p class="text-muted" style="margin-top: 10px;">
                <small>Setelah menginstall browser yang didukung, klik tombol di atas</small>
            </p>
        </div>
    </section>
</div>

<!-- REKOMENDASI: Load JavaScript yang diperlukan -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(function () {
        // Fungsi deteksi browser
        function detectBrowser() {
            var userAgent = navigator.userAgent;
            var browserName = "Unknown Browser";
            
            // Deteksi browser
            if (userAgent.indexOf("Chrome") > -1 && userAgent.indexOf("Edg") === -1) {
                browserName = "Google Chrome";
            } else if (userAgent.indexOf("Firefox") > -1) {
                browserName = "Mozilla Firefox";
            } else if (userAgent.indexOf("Edg") > -1) {
                browserName = "Microsoft Edge";
            } else if (userAgent.indexOf("Safari") > -1 && userAgent.indexOf("Chrome") === -1) {
                browserName = "Safari";
            } else if (userAgent.indexOf("Opera") > -1 || userAgent.indexOf("OPR") > -1) {
                browserName = "Opera";
            } else if (userAgent.indexOf("Trident") > -1 || userAgent.indexOf("MSIE") > -1) {
                browserName = "Internet Explorer";
            }
            
            return browserName;
        }
        
        // Tampilkan info browser saat ini
        var currentBrowser = detectBrowser();
        $('#browser-name').text(currentBrowser);
        
        // Custom message berdasarkan browser
        var message = "";
        if (currentBrowser === "Internet Explorer") {
            message = "Browser Internet Explorer tidak didukung. Silakan gunakan browser modern seperti Google Chrome, Mozilla Firefox, atau Microsoft Edge.";
        } else {
            message = "Browser " + currentBrowser + " seharusnya didukung. Jika Anda melihat halaman ini, mungkin ada masalah lain. Pastikan browser Anda sudah updated ke versi terbaru.";
        }
        
        $('#browser-message').text(message);
        $('#current-browser-info').show();
        
        // Fungsi tombol coba lagi
        $('#retry-button').click(function() {
            // Redirect ke halaman utama
            window.location.href = '<?php echo site_url("welcome"); ?>';
        });
        
        // Auto-redirect jika browser sudah didukung (opsional)
        if (currentBrowser !== "Internet Explorer" && currentBrowser !== "Unknown Browser") {
            // setTimeout(function() {
            //     window.location.href = '<?php echo site_url("welcome"); ?>';
            // }, 5000); // Redirect otomatis setelah 5 detik
        }
    });
</script>
</body>
</html>