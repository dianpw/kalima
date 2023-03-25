<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengaturan_system extends Member_Controller {
	private $kode_menu = 'user-system';
	private $kelompok = 'pengaturan';
	private $url = 'manager/pengaturan_system';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('konfigurasi_model');

		parent::cek_akses($this->kode_menu);
	}
	
    public function index($page=null, $id=null){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;
        
        $this->template->display_admin($this->kelompok.'/pengaturan_system_view', 'Pengaturan UJIAN ONLINE', $data);
    }

    function simpan(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('ujianonline-nama', 'Nama UJIAN ONLINE','required|strip_tags');
        $this->form_validation->set_rules('ujianonline-keterangan', 'Keterangan UJIAN ONLINE','required|strip_tags');
		$this->form_validation->set_rules('ujianonline-link-login', 'Link Login Operator','required|strip_tags');
		$this->form_validation->set_rules('ujianonline-mobile-lock-xambro', 'Lock Mobile Exam Browser','required|strip_tags');
		$this->form_validation->set_rules('ujianonline-informasi', 'Informasi Peserta Tes','required');
        
        if($this->form_validation->run() == TRUE){
            $data['konfigurasi_isi'] = $this->input->post('ujianonline-nama', true);
			$this->konfigurasi_model->update('konfigurasi_kode', 'ujianonline_nama', $data);
			
			$data['konfigurasi_isi'] = $this->input->post('ujianonline-keterangan', true);
			$this->konfigurasi_model->update('konfigurasi_kode', 'ujianonline_keterangan', $data);
			
			$data['konfigurasi_isi'] = $this->input->post('ujianonline-link-login', true);
			$this->konfigurasi_model->update('konfigurasi_kode', 'link_login_operator', $data);
			
			$data['konfigurasi_isi'] = $this->input->post('ujianonline-mobile-lock-xambro', true);
			$this->konfigurasi_model->update('konfigurasi_kode', 'ujianonline_mobile_lock_xambro', $data);
			
			$data['konfigurasi_isi'] = $this->input->post('ujianonline-informasi', true);
			$this->konfigurasi_model->update('konfigurasi_kode', 'ujianonline_informasi', $data);

            $status['status'] = 1;
			$status['pesan'] = 'Pengaturan berhasil disimpan ';
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    function get_pengaturan_system(){
    	$data['data'] = 1;
		$query = $this->konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'link_login_operator', 1);
		$data['link_login_operator'] = 'ya';
		if($query->num_rows()>0){
			$data['link_login_operator'] = $query->row()->konfigurasi_isi;
		}
		
		$query = $this->konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'ujianonline_nama', 1);
		$data['ujianonline_nama'] = 'Ujian Online';
		if($query->num_rows()>0){
			$data['ujianonline_nama'] = $query->row()->konfigurasi_isi;
		}
		
		$query = $this->konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'ujianonline_keterangan', 1);
		$data['ujianonline_keterangan'] = 'Ujian Online Berbasis Komputer';
		if($query->num_rows()>0){
			$data['ujianonline_keterangan'] = $query->row()->konfigurasi_isi;
		}
		
		$query = $this->konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'ujianonline_informasi', 1);
		$data['ujianonline_informasi'] = 'Silahkan pilih Tes yang diikuti dari daftar tes yang tersedia dibawah ini. Apabila tes tidak muncul, silahkan menghubungi Operator yang bertugas.';
		if($query->num_rows()>0){
			$data['ujianonline_informasi'] = $query->row()->konfigurasi_isi;
		}
		
		$query = $this->konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'ujianonline_mobile_lock_xambro', 1);
		$data['mobile_lock_xambro'] = 'ya';
		if($query->num_rows()>0){
			$data['mobile_lock_xambro'] = $query->row()->konfigurasi_isi;
		}
		
		echo json_encode($data);
    }
}