<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Pengaturan UJIAN ONLINE
		<small>Melakukan pengaturan Identitas UJIAN ONLINE</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Pengaturan UJIAN ONLINE</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <div class="col-xs-12">
			<?php echo form_open($url.'/simpan','id="form-pengaturan"'); ?>
                <div class="box">
                    <div class="box-header with-border">
    					<div class="box-title">Daftar Pengaturan UJIAN ONLINE</div>
                    </div><!-- /.box-header -->

                    <div class="box-body form-horizontal">
						<div id="form-pesan"></div>
                        <div class="form-group">
							<label class="col-sm-4 control-label">Nama</label>
                            <div class="col-sm-8">
								<input type="text" class="form-control input-sm" id="ujianonline-nama" name="ujianonline-nama" >
                                <p class="help-block">
									Nama Pelaksana UJIAN ONLINE.<br />
                                    Digunakan sebagai identitas pelaksanaan Tes.
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Keterangan</label>
                            <div class="col-sm-8">
								<input type="text" class="form-control input-sm" id="ujianonline-keterangan" name="ujianonline-keterangan" >
                                <p class="help-block">
									Keterangan Pelaksana bisa diisi dengan Slogan ataupun Alamat dari Organisasi.
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Link Login Operator</label>
                            <div class="col-sm-8">
								<select class="form-control input-sm" id="ujianonline-link-login" name="ujianonline-link-login">
									<option value="tidak">Tidak</option>
                                    <option value="ya">Ya</option>
								</select>
                                <p class="help-block">
									Menampilkan Link <b>Log In Operator</b> pada Halaman login user.
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Lock Mobile Exam Browser</label>
                            <div class="col-sm-8">
								<select class="form-control input-sm" id="ujianonline-mobile-lock-xambro" name="ujianonline-mobile-lock-xambro">
									<option value="tidak">Tidak</option>
                                    <option value="ya">Ya</option>
								</select>
                                <p class="help-block">
									Lock Browser Mobile / Browser Android agar hanya dapat digunakan melalui Exam Browser
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Informasi ke Peserta Tes</label>
                            <div class="col-sm-8">
								<input type="hidden" name="ujianonline-informasi" id="ujianonline-informasi" >
								<textarea class="textarea" id="ujianonline_informasi" name="ujianonline_informasi" style="width: 100%; height: 150px; font-size: 13px; line-height: 25px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                <p class="help-block">
									Informasi yang diberikan ke peserta tes di Dashboard Peserta Tes
								</p>
							</div>
						</div>
                    </div>
					<div class="box-footer">
						<button type="submit" id="btn-simpan" class="btn btn-primary pull-right">Simpan Pengaturan</button>
					</div>
                </div>
			</form>
        </div>
    </div>
</section><!-- /.content -->



<script lang="javascript">
	function load_data(){
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_pengaturan_system', function(data){
            if(data.data==1){
                $('#ujianonline-nama').val(data.ujianonline_nama);
                $('#ujianonline-keterangan').val(data.ujianonline_keterangan);
                $('#ujianonline-link-login').val(data.link_login_operator);
				$('#ujianonline-mobile-lock-xambro').val(data.mobile_lock_xambro);
				$('#ujianonline_informasi').val(data.ujianonline_informasi);
				$('#ujianonline-informasi').val('');
            }
            $("#modal-proses").modal('hide');
        });
    }

    $(function(){
		CKEDITOR.replace('ujianonline_informasi');
		
		load_data();
        $('#form-pengaturan').submit(function(){
            $("#modal-proses").modal('show');
			$('#ujianonline-informasi').val(CKEDITOR.instances.ujianonline_informasi.getData());
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/simpan",
                    type:"POST",
                    data:$('#form-pengaturan').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            $("#modal-proses").modal('hide');
                            notify_success(obj.pesan);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan').html(pesan_err(obj.pesan));
                        }
                    }
            });
            return false;
        });
    });
</script>