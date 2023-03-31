<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Peserta_kelas extends Member_Controller {
	private $kode_menu = 'peserta-kelas';
	private $kelompok = 'peserta';
	private $url = 'manager/peserta_kelas';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('user_kelas_model');
		$this->load->model('teskelas_model');

		parent::cek_akses($this->kode_menu);
	}
	
    public function index(){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;
        
        $this->template->display_admin($this->kelompok.'/peserta_group_view', 'Daftar Kelas', $data);
    }

    function tambah(){
        //$this->load->library('form_validation');
        
        $this->form_validation->set_rules('tambah-kelas', 'Nama Kelas','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $data['id_kelas'] = uniqid();
            $data['kelas'] = $this->input->post('tambah-kelas', true);

            if($this->user_kelas_model->count_by_kolom('kelas', $data['kelas'])->row()->hasil>0){
                $status['status'] = 0;
                $status['pesan'] = 'Nama Kelas sudah terpakai !';
            }else{
				$this->user_kelas_model->save($data);
                
                $status['status'] = 1;
                $status['pesan'] = 'Kelas berhasil disimpan ';
            }
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    function get_by_id($id=null){
    	$data['data'] = 0;
		if(!empty($id)){
			$query = $this->user_kelas_model->get_by_kolom('id_kelas', $id);
			if($query->num_rows()>0){
				$query = $query->row();
				$data['data'] = 1;
				$data['id_kelas'] = $query->id_kelas;
				$data['kelas'] = $query->kelas;
			}
		}
		echo json_encode($data);
    }

    function edit(){
        //$this->load->library('form_validation');
        
		$this->form_validation->set_rules('edit-id', 'ID','required|strip_tags');
		$this->form_validation->set_rules('edit-kelas', 'Nama Kelas','required|strip_tags');
        $this->form_validation->set_rules('edit-pilihan', 'Pilihan','required|strip_tags');
        $this->form_validation->set_rules('edit-kelas-asli', 'Nama Kelas','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $pilihan = $this->input->post('edit-pilihan', true);
            $id = $this->input->post('edit-id', true);
            
            if($pilihan=='hapus'){//hapus
            	if($this->teskelas_model->count_by_kolom('tstkls_kelas_id', $id)->row()->hasil>0){
            		$status['status'] = 0;
					$status['pesan'] = 'Kelas tidak dapat dihapus, Kelas masih digunakan Tes !';
            	}else{
            		$this->user_kelas_model->delete('id_kelas', $id);
					$status['status'] = 1;
					$status['pesan'] = 'Kelas berhasil dihapus !';
            	}
            }else if($pilihan=='simpan'){//simpan
				$group_asli = $this->input->post('edit-kelas-asli', true);
                $data['kelas'] = $this->input->post('edit-kelas', true);

                if($group_asli!=$data['kelas']){
                	if($this->user_kelas_model->count_by_kolom('kelas', $data['kelas'])->row()->hasil>0){
		                $status['status'] = 0;
		                $status['pesan'] = 'Nama Kelas sudah terpakai !';
		            }else{
						$this->user_kelas_model->update('id_kelas', $id, $data);
		                
		                $status['status'] = 1;
		                $status['pesan'] = 'Kelas berhasil disimpan ';
		            }
                }else{
                	$status['status'] = 1;
                	$status['pesan'] = 'Kelas Berhasil disimpan';
                }
            }
            
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
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
		$query = $this->user_kelas_model->get_datatable($start, $rows, 'kelas', $search);
		$iFilteredTotal = $query->num_rows();
		
		$iTotal= $this->user_kelas_model->get_datatable_count('kelas', $search)->row()->hasil;
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

	    // get result after running query and put it in array
		$i=$start;
		$query = $query->result();
	    foreach ($query as $temp) {			
			$record = array();
            
			$record[] = ++$i;
            $record[] = $temp->kelas;
            $record[] = '<a onclick="edit(\''.$temp->id_kelas.'\')" style="cursor: pointer;" class="btn btn-default btn-xs">Edit</a>';

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