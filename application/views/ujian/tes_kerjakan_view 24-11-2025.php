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
    </style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tes : <?php if(!empty($tes_name)){ echo $tes_name; } ?>
        </h1>
        <div class="breadcrumb">
            <img src="<?php echo base_url(); ?>public/images/zoom.png" style="cursor: pointer;" height="20" onclick="zoomnormal()" title="Klik ukuran font normal" />&nbsp;&nbsp;
            <img src="<?php echo base_url(); ?>public/images/zoom.png" style="cursor: pointer;" height="26" onclick="zoombesar()" title="Klik ukuran font lebih besar" />
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
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
                    <button class="btn btn-default pull-right" id="btn-hentikan">Selesaikan Tes</button>
                </div>
            </div><!-- /.box -->
        </div>
    </section><!-- /.content -->

    <!-- Modal untuk konfirmasi hentikan tes -->
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

<script type="text/javascript">
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

        /**
         * 6. BLOKIR AKSES DEVELOPER TOOLS MELALUI INSPECT ELEMENT
         * Metode tambahan untuk mendeteksi pembukaan developer tools
         */
        let devToolsOpen = false;
        setInterval(function() {
            const widthThreshold = window.outerWidth - window.innerWidth > 100;
            const heightThreshold = window.outerHeight - window.innerHeight > 100;
            
            if ((widthThreshold || heightThreshold) && !devToolsOpen) {
                devToolsOpen = true;
                alert('Developer Tools terdeteksi. Silahkan tutup untuk melanjutkan tes.');
                // Opsional: Redirect atau tindakan lainnya
                // window.location.reload();
            }
        }, 1000);
    }

    /**
     * FUNGSI ZOOM TEKS
     * Untuk mengatur ukuran font soal
     */
    function zoombesar(){
        $('#isi-tes-soal').css("font-size", "140%");
        $('#isi-tes-soal').css("line-height", "140%");
    }

    function zoomnormal(){
        $('#isi-tes-soal').css("font-size", "15px");
        $('#isi-tes-soal').css("line-height", "110%");
    }

    /**
     * FUNGSI RAGU-RAGU
     * Untuk menandai soal yang diragukan jawabannya
     */
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

    /**
     * FUNGSI NAVIGASI SOAL
     * Untuk berpindah antara soal
     */
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

    // Fungsi-fungsi lainnya tetap sama...
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
         * TERAPKAN PENGAMANAN COPY SAAT DOKUMEN SIAP
         * Memastikan pengamanan aktif segera setelah halaman dimuat
         */
        terapkanPengamananCopy();

        // Timer sisa waktu tes
        var sisa_detik = <?php if(!empty($detik_sisa)){ echo $detik_sisa; } ?>;
        setInterval(function() {
            var sisa_menit = Math.round(sisa_detik/60);
            sisa_detik = sisa_detik-1;
            $("#sisa-waktu").html("Sisa Waktu : "+sisa_menit+" menit");

            if(sisa_detik<1){
                window.location.reload();
            }
        }, 1000);

        // Event handler untuk navigasi soal
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
    });
</script>