<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Edit User
		<small> Form edit user</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/manager"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Edit User</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
<?php echo form_open('manager/useratur/edit','id="form-edit-user" class="form-horizontal"')?>
	<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit User</h3>
            </div><!-- /.box-header -->
            
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="form-pesan"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="form-pesan"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Username</label>
                                    <div class="col-sm-5">
                                        <input type="hidden" id="aksi" name="aksi" />
                                        <input type="text" class="form-control input-sm" value="<?php if(!empty($username)){ echo $username; } ?>" id="username" name="username" placeholder="Username" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Password</label>
                                    <div class="col-sm-5">
                                        <input type="password" class="form-control input-sm" value="kosongkosong" id="password" name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Level</label>
                                    <div class="col-sm-5">
                                        <?php 
                                            if(!empty($level_opsi)){
                                                echo $level_opsi;
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Nama</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control input-sm" value="<?php if(!empty($nama_lengkap)){ echo $nama_lengkap; } ?>" id="nama" name="nama" placeholder="Nama Pengguna">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Kode Mapel</label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control input-sm" value="<?php if(!empty($opsi1)){ echo $opsi1; } ?>" id="opsi1" name="opsi1" placeholder="Daftar Mata Pelajaran yang dikelola user" readonly>
                                            <span class="input-group-btn">
                                                <button class="btn btn-info btn-flat" type="button" id="btn-topik">Daftar Mata Pelajaran</button>
                                                <button class="btn btn-default btn-flat" type="button" id="btn-topik-hapus">Hapus</button>
                                            </span>
                                        </div>
                                        <p class="help-block">Jika kosong, maka user dapat mengelola soal semua mata pelajaran.</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Daftar Mata Pelajaran</label>
                                    <div class="col-sm-5">
                                        <span>
                                            <?php
                                                if(!empty($topik_nama)){
                                                    echo $topik_nama;
                                                }else{
                                                    echo 'semua mapel';
                                                }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control input-sm" value="<?php if(!empty($keterangan)){ echo $keterangan; } ?>" id="keterangan" name="keterangan" placeholder="Keterangan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="box-footer">
                <div class="pull-left">
                    <button type="button" id="back" class="btn btn-warning" onclick="window.history.back()">Kembali</button>
                </div>
                <div class="pull-right">
                    <button type="button" id="hapus" class="btn btn-danger">Hapus</button>
                    <button type="button" id="simpan" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>

<div class="modal" id="modal-topik" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Pilih Mata Pelajaran</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body form-horizontal">
                            <div id="form-pesan-topik"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Pilih Modul</label>
                                <div class="col-sm-5">
                                    <select class="form-control input-sm" name="topik-modul" id="topik-modul">
                                        <?php
                                            if(!empty($select_modul)){
                                                echo $select_modul;
                                            }
                                        ?>
                                    </select>  
                                </div>
                            </div>

                            <table id="table-topik" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="all">Mata Pelajaran</th>
                                    <th>Deskripsi</th>
                                    <th class="all"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
</div>

</section><!-- /.content -->

<script lang="javascript">
    function refresh_table(){
        $('#table-topik').dataTable().fnReloadAjax();
    }
    function tambah_topik(topik_id, topik_nama){
        var daftar_topik = $('#opsi1').val();
        if(daftar_topik.length>0){
            var array_topik = daftar_topik.split(','), i;
            var counter=0;
            for(i=0;i<array_topik.length;i++){
                if(topik_id==array_topik[i]){
                    counter++;   
                }
            }
            if(counter>0){
                notify_error('Mata Pelajaran '+topik_nama+' sudah berada di Opsi1');
            }else{
                daftar_topik = daftar_topik+","+topik_id;
                $('#opsi1').val(daftar_topik);
                notify_success('Mata Pelajaran '+topik_nama+' berhasil ditambahkan');
            }
        }else{
            daftar_topik = topik_id;
            $('#opsi1').val(daftar_topik);
            notify_success('Mata Pelajaran '+topik_nama+' berhasil ditambahkan');
        }
    }
    $(function(){
        $('#btn-topik-hapus').click(function(){
            $('#opsi1').val('');
        });
        $('#btn-topik').click(function(){
            $("#modal-topik").modal('show');
        });
        // memilih mata pelajaran berdasarkan modul
        $("#topik-modul").change(function(){
            refresh_table();
        });
        
        $('#simpan').click(function(){
            $("#modal-proses").modal('show');
            $('#aksi').val('1');
            $('#form-edit-user').submit();
        }); 
        $('#hapus').click(function(){
            $("#modal-proses").modal('show');
            $('#aksi').val('0');
            $('#form-edit-user').submit();
        });
             
        $('#form-edit-user').submit(function(){
                $.ajax({
                    url:"<?php echo site_url(); ?>/manager/useratur/edit",
     			    type:"POST",
     			    data:$('#form-edit-user').serialize(),
     			    cache: false,
      		        success:function(respon){
         		    	var obj = $.parseJSON(respon);
      		            if(obj.status==1){
      		                $("#modal-proses").modal('hide');
      		                $('#form-pesan').html(pesan_succ(obj.pesan));
                            setTimeout(function(){ window.open("<?php echo site_url(); ?>/manager/useratur","_self"); }, 1000);
          		        }else{
          		            $("#modal-proses").modal('hide');
                            $('#form-pesan').html(pesan_err(obj.pesan));
          		        }
         			}
      		});
            
      		return false;
        });

        $('#table-topik').DataTable({
                  "paging": true,
                  "iDisplayLength":10,
                  "bProcessing": false,
                  "bServerSide": true, 
                  "searching": true,
                  "aoColumns": [
                        {"bSearchable": false, "bSortable": false, "sWidth":"20px"},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false, "sWidth":"30px"}],
                  "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable_topik/",
                  "autoWidth": false,
                  "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "modul", "value": $('#topik-modul').val()} );
                  }
         }); 
    });
</script>