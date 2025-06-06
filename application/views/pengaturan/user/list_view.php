<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Data User
		<small>Pengaturan User</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/manager"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">User</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
    						<div class="box-title">Data User</div>
    						<div class="box-tools pull-right">
    							<div class="dropdown pull-right">
    								<a class="btn btn-primary" href="<?php echo current_url(); ?>/index/add">Tambah User</a>
    							</div>
    						</div>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <table id="table-user" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="all">Username</th>
                                    <th class="all">Nama</th>
									<th class="all">Kode Mapel, Modul & Mapel</th>
									<th class="all">Keterangan</th>
                                    <th class="all">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> </td>
                                    <td> </td>
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
    </div>
</section><!-- /.content -->

<script lang="javascript">
    $(function(){
        $('#table-user').DataTable({
                  "sAjaxSource": "<?= current_url();?>/get_all_user/",
                  "bProcessing": true,
                  "bServerSide": true, 
                  "paging": true,
                  "searching": true,
                  "iDisplayLength":10,
                  "aoColumns": [
    					{"bSearchable": true, "bSortable": true, "sWidth":"20px"},
    					{"bSearchable": true, "bSortable": true},
						{"bSearchable": true, "bSortable": false, "sWidth":"30px"},
						{"bSearchable": true, "bSortable": false},
						{"bSearchable": true, "bSortable": false},
                        {"bSearchable": true, "bSortable": false, "sWidth":"30px"}],
                  "autoWidth": true,
				  "responsive": true
         });          
    });
</script>