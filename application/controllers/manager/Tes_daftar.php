<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* KALIMA TEST
* Dian Purwanto
* dianpw6901@gmail.com
* 2023.1.31
*/
class Tes_daftar extends Member_Controller {
	private $kode_menu = 'tes-daftar';
	private $kelompok = 'tes';
	private $url = 'manager/tes_daftar';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_tes_model');
		$this->load->model('cbt_topik_model');
		$this->load->model('cbt_modul_model');
		$this->load->model('cbt_tesgrup_model');
		$this->load->model('cbt_tes_topik_set_model');

		parent::cek_akses($this->kode_menu);
	}
	
    public function index($status=null, $pesan=null){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

        if(!empty($pesan)){
        	if($status=='0'){
        		$data['pesan_hapus'] = '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-info"></i> Perhatian</h4>'.$pesan.'</div>';
        	}else{
        		$data['pesan_hapus'] = '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-info"></i> Informasi</h4>'.$pesan.'</div>';
        	}
        }
        
        $this->template->display_admin($this->kelompok.'/tes_daftar_view', 'Daftar Tes', $data);
    }

    function hapus_tes(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('hapus-id', 'ID Tes','required|strip_tags');
        $this->form_validation->set_rules('hapus-nama', 'Nama Tes','required|strip_tags');
        $this->form_validation->set_rules('hapus-deskripsi', 'Deskripsi Tes','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $tes_id = $this->input->post('hapus-id', true);

            $this->cbt_tes_model->delete('tes_id', $tes_id);

            $status['status'] = 1;
            $status['pesan'] = 'Tes berhasil dihapus';
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }

    function hapus_daftar_tes(){
    	$this->load->library('form_validation');
        
        $this->form_validation->set_rules('edit-tes-id[]', 'ID Tes','required|strip_tags');
        
        $status=0;
        $pesan='';
        if($this->form_validation->run() == TRUE){
        	$tes_id = $this->input->post('edit-tes-id', TRUE);
            $centang = $this->input->post('centang', TRUE);
            if($centang=='1'){
            	foreach( $tes_id as $kunci => $isi ) {
					if($isi=="on"){
						// Memulai transaction mysql
						$this->db->trans_start();

		            	$this->cbt_tes_model->delete('tes_id', $kunci);

		            	// Menutup transaction mysql
						$this->db->trans_complete();
	            	}
	            }
            	$status=1;
        		$pesan='Tes yang dipilih berhasil dihapus';
            }else{
            	$pesan='Centang pernyataan bahwa anda yakin untuk menghapus Tes=';
            }
        }else{
            $pesan='Pilih terlebih dahulu Tes yang akan dihapus';
        }
        
    	$this->index($status, $pesan);
    }
    
    function get_by_id($id=null){
    	$data['data'] = 0;
		if(!empty($id)){
			$query = $this->cbt_tes_model->get_by_kolom('tes_id', $id);
			if($query->num_rows()>0){
				$query = $query->row();
				$data['data'] = 1;
				$data['id'] = $query->tes_id;
				$data['nama'] = $query->tes_nama;
				$data['deskripsi'] = $query->tes_detail;
				$data['waktu'] = $query->tes_duration_time;
	            $data['poin'] = $query->tes_score_right;
	            $data['poin_salah'] = $query->tes_score_wrong;
	            $data['poin_kosong'] = $query->tes_score_unanswered;
	            $data['tunjukkan_hasil'] = $query->tes_results_to_users;
	            $data['token'] = $query->tes_token;
	            $data['rentang_waktu'] = $query->tes_begin_time.' - '.$query->tes_end_time;
			}
		}
		echo json_encode($data);
    }
    
    function get_datatable(){
		// variable initialization
		$search = "";
		$start = 0;
		$rows = 10;

		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->get_start();
		$rows = $this->get_rows();

		// run query to get user listing
		$query = $this->cbt_tes_model->get_datatable($start, $rows, 'tes_nama', $search);
		$iFilteredTotal = $query->num_rows();
		
		$iTotal= $this->cbt_tes_model->get_datatable_count('tes_nama', $search)->row()->hasil;
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

	    // get result after running query and put it in array
		$i=$start;
		$query = $query->result();
		//var_dump($query);
	    foreach ($query as $temp) {			
			$record = array();
            //nomor
			$record[] = ++$i;
			$query_topik = $this->cbt_tes_topik_set_model->get_by_kolom('tset_tes_id', $temp->tes_id);
			if($query_topik->num_rows()>0){
				$query_topik = $query_topik->result();
				$data_soal = '';
				foreach($query_topik as $topik){
					$query_topik = $this->cbt_topik_model->get_by_kolom_limit('topik_id', $topik->tset_topik_id, 1)->row();
					$query_modul = $this->cbt_modul_model->get_by_kolom_limit('modul_id', $query_topik->topik_modul_id, 1)->row();
					
					$ket_acak = '';
					if($topik->tset_acak_soal==1){
						$ket_acak = $ket_acak.'<br>Acak Soal: <b>Ya</b>';
					}else{
						$ket_acak = $ket_acak.'<br>Acak Soal: <b>Tidak</b>';
					}
					if($topik->tset_acak_jawaban==1){
						$ket_acak = $ket_acak.'<br>Acak Jwb: <b>Ya</b>';
					}else{
						$ket_acak = $ket_acak.'<br>Acak Jwb: <b>Tidak</b>';
					}
					
					if(empty($data_soal)){
						$data_soal = '<b>'.$query_modul->modul_nama.' - '.$temp->tes_nama.'</b> <br> Mapel: <b>'.$query_topik->topik_nama.'</b><br> Soal: <b>'.$topik->tset_jumlah.' Soal</b> <br> Jawaban: <b>'.$topik->tset_jawaban.' Opsi</b>';
					}else{//$query_topik->topik_nama
						$data_soal = $data_soal.'<br />'.'Modul: <b>'.$query_modul->modul_nama.'</b><br />Mapel: <b>'.$query_topik->topik_nama.'</b><br /> Soal: <b>'.$topik->tset_jumlah.' Soal</b><br /> Opsi Jawaban: <b>'.$topik->tset_jawaban.' Opsi</b><br />';
					}
				}
				//data soal
				$record[] = $data_soal;
			}else{
				$record[] = 'Belum ada soal';
			}
			//Waktu
            $record[] = 'Durasi: <br><b>'.$temp->tes_duration_time.' Menit</b><br>Mulai Tes: <br><b>'.$temp->tes_begin_time.'</b>';
			//Nilai
            $record[] = 'Poin Maks:<br><b>'.$temp->tes_max_score.'</b><br> Poin Dasar: <br><b>'.$temp->tes_score_right.'</b>';

            if($temp->tes_results_to_users==1){
            	$tampil_hasil = 'Ya';
            }else{
            	$tampil_hasil = 'Tidak';
            }

            if($temp->tes_token==1){
            	$token = 'Ya';
            }else{
            	$token = 'Tidak';
            }
			//Pengaturan
			$record[] = 'Tampil Nilai: <b>'.$tampil_hasil.'</b><br>Token: <b>'.$token.'</b>'.$ket_acak;

            
			$query_grup = $this->cbt_tesgrup_model->get_by_tes_id($temp->tes_id);
			if($query_grup->num_rows()>0){
				$query_grup = $query_grup->result();
				$data_grup = '';
				foreach($query_grup as $grup){
					if(empty($data_grup)){
						$data_grup = $grup->grup_nama;
					}else{
						$data_grup = $data_grup.', '.$grup->grup_nama;
					}
				}
				$record[] = $data_grup;
			}else{
				$record[] = 'Belum ada grup';
			}
			
            $record[] = '
            	<a onclick="edit(\''.$temp->tes_id.'\')" style="cursor: pointer;" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
            	<a onclick="hapus(\''.$temp->tes_id.'\')" style="cursor: pointer;" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></a>
            ';

            $record[] = '<input type="checkbox" name="edit-tes-id['.$temp->tes_id.']" >';

			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
        
		echo json_encode($output);
	}
	
	/**
	* funsi tambahan 
	* 
	* 
*/
	
	function get_start() {
		$start = 0;
		if (isset($_GET['iDisplayStart'])) {
			$start = intval($_GET['iDisplayStart']);

			if ($start < 0)
				$start = 0;
		}

		return $start;
	}

	function get_rows() {
		$rows = 10;
		if (isset($_GET['iDisplayLength'])) {
			$rows = intval($_GET['iDisplayLength']);
			if ($rows < 5 || $rows > 500) {
				$rows = 10;
			}
		}

		return $rows;
	}

	function get_sort_dir() {
		$sort_dir = "ASC";
		$sdir = strip_tags($_GET['sSortDir_0']);
		if (isset($sdir)) {
			if ($sdir != "asc" ) {
				$sort_dir = "DESC";
			}
		}

		return $sort_dir;
	}
}