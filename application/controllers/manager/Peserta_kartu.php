<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Peserta_kartu extends Member_Controller {
	private $kode_menu = 'peserta-kartu';
	private $kelompok = 'peserta';
	private $url = 'manager/peserta_kartu';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_user_grup_model');
		$this->load->model('cbt_user_model');
		$this->load->model('cbt_konfigurasi_model');

        parent::cek_akses($this->kode_menu);
	}
	
    public function index(){
		$data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;
		
		$query_group = $this->cbt_user_grup_model->get_group();

        if($query_group->num_rows()>0){
        	$select = '';
        	$query_group = $query_group->result();
        	foreach ($query_group as $temp) {
        		$select = $select.'<option value="'.$temp->grup_id.'">'.$temp->grup_nama.'</option>';
        	}

        }else{
        	$select = '<option value="0">KOSONG</option>';
        }
        $data['select_group'] = $select;
		
        $this->template->display_admin($this->kelompok.'/peserta_kartu_view', 'Cetak Kartu Peserta', $data);
    }

	/**
	* Cetak kartu hanya untuk satu grup saja
	*/
    public function cetak_kartu($grup_id=null){
		$data['kode_menu'] = $this->kode_menu;
		
		$kartu = '<h3>Data Peserta Kosong</h3>';
		if(!empty($grup_id)){
			$query_user = $this->cbt_user_model->get_by_kolom('user_grup_id', $grup_id);
			if($query_user->num_rows()>0){
				$kartu = '';
				$query_user = $query_user->result();
				
				$query_konfig = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_nama', 1);
				$cbt_nama = 'KALIMA TEST';
				if($query_konfig->num_rows()>0){
					$cbt_nama = $query_konfig->row()->konfigurasi_isi;
				}
				$query_konfig_ket = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_keterangan', 1);
				$cbt_ket = '';
				if($query_konfig_ket->num_rows()>0){
					$cbt_ket = $query_konfig_ket->row()->konfigurasi_isi;
				}
				
				$query_group = $this->cbt_user_grup_model->get_by_kolom_limit('grup_id', $grup_id, 1);
				$group = 'NULL';
				if($query_group->num_rows()>0){
					$group = $query_group->row()->grup_nama;
				}
				
				foreach($query_user AS $temp){
					$kartu = $kartu.'
						<div class="kartu">
							<div class="header">'.$cbt_nama.'<br/><small>'.$cbt_ket.'</small></div>
							<hr />
							<table>
								<tr>
									<td width="95px">Nama</td>
									<td width="5px">:</td>
									<td width="210px">'.$this->singkatNama($temp->user_firstname, $maxLength = 24).'</td>
								</tr>
								<tr>
									<td>Username</td>
									<td>:</td>
									<td>'.$temp->user_name.'</td>
								</tr>
								<tr>
									<td>Password</td>
									<td>:</td>
									<td>'.$temp->user_password.'</td>
								</tr>
								<tr>
									<td>Kelas</td>
									<td>:</td>
									<td>'.$group.'</td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td>:</td>
									<td>'.$temp->user_detail.'</td>
								</tr>
							</table>
						</div>
					';
				}
			}
		}
		
		$data['kartu'] = $kartu;
		
		$this->load->view($this->kelompok.'/peserta_cetak_kartu_view', $data);
	}

	function singkatNama($nama, $maxLength = 10) {
		// Hilangkan gelar depan dan belakang
		$nama = preg_replace('/\b(Dr|Prof|Ir|Hj|H|S\.H|M\.\w+)\b\.?/i', '', $nama);
		$nama = trim(preg_replace('/\s+/', ' ', $nama));
		
		// Jika nama sudah <= 20 karakter, kembalikan asli
		if (strlen($nama) <= $maxLength) {
			return $nama;
		}
		
		// Pisahkan nama per kata
		$parts = explode(' ', $nama);
		$count = count($parts);
		
		// Jika hanya 1 kata, potong saja
		if ($count == 1) {
			return substr($nama, 0, $maxLength);
		}
		
		// Mulai dengan kata pertama
		$namaSingkat = $parts[0];
		
		// Jika kata pertama saja sudah >= maxLength
		if (strlen($namaSingkat) >= $maxLength) {
			return substr($namaSingkat, 0, $maxLength);
		}
		
		// Proses kata kedua dan seterusnya
		for ($i = 1; $i < $count; $i++) {
			$tambahan = '';
			
			// Untuk kata kedua, coba pertahankan utuh dulu
			if ($i == 1) {
				$tambahan = ' ' . $parts[$i];
			} 
			// Untuk kata ketiga dst, langsung singkat
			else {
				$tambahan = ' ' . substr($parts[$i], 0, 1) . '.';
			}
			
			// Cek apakah penambahan masih dalam batas
			if (strlen($namaSingkat . $tambahan) <= $maxLength) {
				$namaSingkat .= $tambahan;
			} 
			// Jika tidak, coba singkat kata kedua
			else {
				// Jika kata kedua belum disingkat, coba singkat
				if ($i == 1) {
					$tambahan = ' ' . substr($parts[$i], 0, 1) . '.';
					if (strlen($namaSingkat . $tambahan) <= $maxLength) {
						$namaSingkat .= $tambahan;
					}
				}
				break;
			}
		}
		
		return $namaSingkat;
	}
}