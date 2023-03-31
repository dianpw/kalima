<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modul_mapel extends Member_Controller {
	private $kode_menu = 'modul-mapel';
	private $kelompok = 'modul';
	private $url = 'manager/modul_mapel';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('modul_model');
		$this->load->model('mapel_model');
		$this->load->model('soal_model');
		$this->load->model('tes_mapel_set_model');

		parent::cek_akses($this->kode_menu);
	}
	
    public function index($page=null, $id=null){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

        // Jika modul kosong, ditambah default
		if($this->modul_model->count_all()->row()->hasil==0){
			$data_modul['nama'] = 'Default';
	        $data_modul['modul_aktif'] = 1;
	        $this->modul_model->save($data_modul);
		}

		$query_modul = $this->modul_model->get_modul();
        if($query_modul->num_rows()>0){
        	$select = '';
        	$query_modul = $query_modul->result();
        	foreach ($query_modul as $temp) {
        		$select = $select.'<option value="'.$temp->id_modul.'">'.$temp->nama.'</option>';
        	}

        }else{
        	$select = '<option value="10000000">KOSONG</option>';
        }
        $data['select_modul'] = $select;
        
        $this->template->display_admin($this->kelompok.'/mapel_view', 'Daftar  Mata Pelajaran', $data);
    }

    function tambah(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('tambah-mapel', 'Nama  Mata Pelajaran','required|strip_tags');
        $this->form_validation->set_rules('tambah-modul-id', 'ID Modul','required|strip_tags');
        $this->form_validation->set_rules('tambah-deskripsi', 'Deskripsi','required|strip_tags');
       	$this->form_validation->set_rules('tambah-status', 'Status','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
        	$data['id_mapel'] = uniqid();
        	$data['id_modul'] = $this->input->post('tambah-modul-id', true);
            $data['nama'] = $this->input->post('tambah-mapel', true);
            $data['detail'] = $this->input->post('tambah-deskripsi', true);
            $data['status'] = '1';
			//var_dump($data);
            //if($this->mapel_model->count_by_kolom('nama', $data['nama'])->row()->hasil>0){
            if($this->mapel_model->count_by_mapel_modul($data['nama'], $data['id_modul'])->row()->hasil>0){
                $status['status'] = 0;
                $status['pesan'] = 'Nama Mata Pelajaran sudah terpakai !';
            }else{
				$this->mapel_model->save($data);
                
                $status['status'] = 1;
                $status['pesan'] = ' Mata Pelajaran berhasil disimpan ';
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
			$query = $this->mapel_model->get_by_kolom('id_mapel', $id);
			if($query->num_rows()>0){
				$query = $query->row();
				$data['data'] = 1;
				$data['id_mapel'] = $query->id_mapel;
				$data['mapel'] = $query->nama;
				$data['deskripsi'] = $query->detail;
				$data['status'] = $query->status;
			}
		}
		echo json_encode($data);
    }

    /**
     * Menghapus mata pelajaran yang dipilih
     * @return [type] [description]
     */
    function hapus_daftar_mapel(){
    	//$this->load->library('form_validation');
        
		$this->form_validation->set_rules('edit-mapel-id[]', 'Mata Pelajaran','required|strip_tags');
		if($this->form_validation->run() == TRUE){
			$id_mapel = $this->input->post('edit-mapel-id', TRUE);
			$error_hapus = 0;
			foreach( $id_mapel as $kunci => $isi ) {
				if($isi=="on"){
					if($this->tes_mapel_set_model->count_by_kolom('id_mapel', $kunci)->row()->hasil>0){
	            		$error_hapus++;
	            	}else{
	            		// Memulai transaction mysql
						$this->db->trans_start();

	            		// hapus mata pelajaran di database
	            		$this->mapel_model->delete('id_mapel', $kunci);

	            		// Menutup transaction mysql
						$this->db->trans_complete();

	            		// hapus file mata pelajaran
	            		$this->load->helper('directory');
						$this->load->helper('file');
	            		
	            		$folder = $this->config->item('upload_path').'/mapel_'.$kunci;
	            		if(is_dir($folder)){
	            			delete_files($folder, TRUE);
	            			rmdir($folder);
	            		}
	            	}
            	}
            }
            $status['status'] = 1;
            if($error_hapus>0){
            	$status['pesan'] = 'Daftar mata pelajaran sebagian tidak dapat dihapus karena masih digunakan Tes !';
            }else{
            	$status['pesan'] = 'Daftar Mata Pelajaran berhasil dihapus';
            }
		}else{
			$status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }

    function edit(){
        //$this->load->library('form_validation');
        
		$this->form_validation->set_rules('edit-id', 'ID','required|strip_tags');
		//$this->form_validation->set_rules('edit-modul-id', 'ID Modul','required|strip_tags');
		$this->form_validation->set_rules('edit-mapel', 'Nama  Mata Pelajaran','required|strip_tags');
		$this->form_validation->set_rules('edit-deskripsi', 'Deskripsi','required|strip_tags');
        $this->form_validation->set_rules('edit-pilihan', 'Pilihan','required|strip_tags');
        $this->form_validation->set_rules('edit-mapel-asli', 'Nama  Mata Pelajaran','required|strip_tags');
		//var_dump();
        if($this->form_validation->run() == TRUE){
            $pilihan = $this->input->post('edit-pilihan', true);
            $id_mapel = $this->input->post('edit-id', true);
			$id_modul = $this->input->post('edit-modul-id', true);
            
            if($pilihan=='hapus'){//hapus
            	if($this->tes_mapel_set_model->count_by_kolom('id_mapel', $id_mapel)->row()->hasil>0){
            		$status['status'] = 0;
                	$status['pesan'] = ' Mata Pelajaran masih dipakai pada Tes, tidak bisa dihapus.';
            	}else{
            		// hapus mata pelajaran di database
            		$this->mapel_model->delete('id_mapel', $id_mapel);

            		// hapus file mata pelajaran
            		$this->load->helper('directory');
					$this->load->helper('file');
            		
            		$folder = $this->config->item('upload_path').'/mapel_'.$id_mapel;
            		if(is_dir($folder)){
            			delete_files($folder, TRUE);
            			rmdir($folder);
            		}

					$status['status'] = 1;
					$status['pesan'] = ' Mata Pelajaran berhasil dihapus !';
            	}
            }else if($pilihan=='simpan'){//simpan
				$mapel_asli = $this->input->post('edit-mapel-asli', true);
                $data['nama'] = $this->input->post('edit-mapel', true);
                $data['detail'] = $this->input->post('edit-deskripsi', true);

                if($mapel_asli!=$data['nama']){
                	//if($this->mapel_model->count_by_kolom('nama', $data['nama'])->row()->hasil>0){
					if($this->mapel_model->count_by_mapel_modul($data['nama'], $id_modul)->row()->hasil>0){
		                $status['status'] = 0;
		                $status['pesan'] = 'Nama  Mata Pelajaran sudah terpakai !';
		            }else{
						$this->mapel_model->update('id_mapel', $id_mapel, $data);
		                
		                $status['status'] = 1;
		                $status['pesan'] = ' Mata Pelajaran berhasil disimpan ';
		            }
                }else{
                	$this->mapel_model->update('id_mapel', $id_mapel, $data);
                	$status['status'] = 1;
                	$status['pesan'] = ' Mata Pelajaran Berhasil disimpan';
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
		$modul = $this->input->get('modul');

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
		$query = $this->mapel_model->get_datatable($start, $rows, 'nama', $search, $modul);
		$iFilteredTotal = $query->num_rows();
		
		$iTotal= $this->mapel_model->get_datatable_count('nama', $search, $modul)->row()->hasil;
	    
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

			$jml_soal = $this->soal_model->count_by_kolom('id_mapel', $temp->id_mapel)->row()->hasil;

            $record[] = $temp->nama;
            $record[] = $temp->detail;
            $record[] = $jml_soal;
            if($temp->status==1){
            	$record[] = 'Aktif';
            }else{
            	$record[] = 'Tidak Aktif';
            }
            $record[] = '<a onclick="edit(\''.$temp->id_mapel.'\')" style="cursor: pointer;" class="btn btn-default btn-xs">Edit</a>';
            $record[] = '<input type="checkbox" name="edit-mapel-id['.$temp->id_mapel.']" >';

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