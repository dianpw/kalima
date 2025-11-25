<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* SISTEM UJIAN ONLINE KALIMA TEST
* @author Dian Purwanto
* @email dianpw6901@gmail.com
* @version 2023.1.31
* @description Controller untuk dashboard peserta tes dengan validasi IP dan manajemen tes
*/

// ===== KONFIGURASI ERROR REPORTING =====
/* error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1); */
// ======================================

class Tes_dashboard extends Tes_Controller {
	private $kelompok = 'ujian';
	private $url = 'tes_dashboard';
	
    function __construct(){
		parent::__construct();
		$this->load->model([
			'cbt_user_model',
			'cbt_user_grup_model', 
			'cbt_tes_model',
			'cbt_tes_token_model',
			'cbt_tes_topik_set_model',
			'cbt_tes_user_model',
			'cbt_tesgrup_model',
			'cbt_soal_model',
			'cbt_jawaban_model',
			'cbt_tes_soal_model',
			'cbt_tes_soal_jawaban_model',
			'cbt_konfigurasi_model'
		]);
    }
    
    /**
     * HALAMAN UTAMA DASHBOARD PESERTA TES
     * Menampilkan dashboard dengan informasi tes, validasi IP, dan daftar tes tersedia
     */
    public function index(){
        $this->load->helper('form');

        // Data dasar user
        $data['nama'] = $this->access_tes->get_nama();
        $data['group'] = $this->access_tes->get_group();
        $data['url'] = $this->url;
        $data['timestamp'] = strtotime(date('Y-m-d H:i:s'));

        // Data IP untuk keperluan display dan validasi
        $data['user_ip'] = $this->dapatkan_ip_asal();
        $data['cloudflare_detected'] = (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && !empty($_SERVER['HTTP_CF_CONNECTING_IP']));
        $data['cloudflare_ip'] = $data['cloudflare_detected'] ? $_SERVER['HTTP_CF_CONNECTING_IP'] : '';

        // Validasi IP Range - Hasilnya untuk warning bukan block
        $ip_validation_result = $this->validasiRangeIP();
        $data['ip_allowed'] = $ip_validation_result['allowed'];
        $data['ip_validation_message'] = $ip_validation_result['message'];
        $data['allowed_ranges'] = $ip_validation_result['allowed_ranges'];

        // Update status tes yang sudah melewati batas waktu
        $this->updateStatusTesYangKedaluwarsa();

        // Informasi sistem dari database
        $data['informasi'] = $this->dapatkanInformasiSistem();

        $this->template->display_tes($this->kelompok.'/tes_dashboardIPValid_view', 'Dashboard', $data);
    }

    /**
     * MENDAPATKAN INFORMASI SISTEM DARI DATABASE
     * @return string Informasi sistem yang akan ditampilkan
     */
    private function dapatkanInformasiSistem() {
        $query_info = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_informasi', 1);
        return ($query_info->num_rows() > 0) ? $query_info->row()->konfigurasi_isi : '';
    }

    /**
     * UPDATE STATUS TES YANG SUDAH MELEWATI BATAS WAKTU
     * Mengubah status tes menjadi 4 (selesai) jika waktu tes sudah habis
     */
    private function updateStatusTesYangKedaluwarsa() {
        $username = $this->access_tes->get_username();
        $query_user = $this->cbt_user_model->get_by_kolom_limit('user_name', $username, 1);
        
        if($query_user->num_rows() > 0){
            $user_id = $query_user->row()->user_id;
            $query_tes = $this->cbt_tes_user_model->get_by_user_status($user_id);
            
            if($query_tes->num_rows() > 0){
                $tanggal_sekarang = new DateTime();
                
                foreach ($query_tes->result() as $tes) {
                    $tanggal_tes = new DateTime($tes->tesuser_creation_time);
                    $tanggal_tes->modify('+'.$tes->tes_duration_time.' minutes');
                    
                    // Jika waktu sekarang melebihi waktu tes, update status menjadi 4
                    if($tanggal_sekarang > $tanggal_tes){
                        $data_tes['tesuser_status'] = 4;
                        $this->cbt_tes_user_model->update('tesuser_id', $tes->tesuser_id, $data_tes);
                    }
                }
            }
        }
    }

    /**
     * MENDAPATKAN IP ASLI DENGAN DUKUNGAN CLOUDFLARE
     * @return string Alamat IP asli pengguna
     * @description Mendeteksi IP asli dengan prioritas header Cloudflare untuk akurasi yang lebih baik
     */
    private function dapatkan_ip_asal() {
        $ip_asal = '0.0.0.0';

        // Daftar header dengan prioritas Cloudflare
        $daftar_header = [
            'HTTP_CF_CONNECTING_IP',    // Header khusus Cloudflare
            'HTTP_X_FORWARDED_FOR',     // Standard forward header
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'HTTP_CLIENT_IP',
            'REMOTE_ADDR'               // IP langsung dari server
        ];

        foreach ($daftar_header as $header) {
            if (isset($_SERVER[$header]) && !empty($_SERVER[$header])) {
                $ip_kandidat = $_SERVER[$header];
                
                // Handle multiple IPs dalam header (biasanya di X-Forwarded-For)
                if (strpos($ip_kandidat, ',') !== false) {
                    $ip_array = explode(',', $ip_kandidat);
                    $ip_kandidat = trim($ip_array[0]); // Ambil IP pertama
                }
                
                // Validasi format IP
                if (filter_var($ip_kandidat, FILTER_VALIDATE_IP)) {
                    $ip_asal = $ip_kandidat;
                    break;
                }
            }
        }
        
        return $ip_asal;
    }

    /**
     * VALIDASI IP BERDASARKAN RANGE CIDR DENGAN DUKUNGAN CLOUDFLARE
     * @return array Hasil validasi IP
     * @description Memeriksa apakah IP pengguna berada dalam range access point yang diizinkan
     */
    private function validasiRangeIP() {
        // Daftar range CIDR yang diizinkan (access point)
        $daftar_range_diizinkan = [
            '10.1.28.0/22',      // Range: 10.1.28.1 - 10.1.31.254
            '10.1.40.0/23',      // Range: 10.1.40.1 - 10.1.41.254  
            '10.1.20.0/23',      // Range: 10.1.20.1 - 10.1.21.254 
            '10.100.14.0/23',    // Range: 10.100.14.1 - 10.100.15.254 
            '103.186.167.0/24',  // Range: 103.187.167.1 - 103.187.167.254
            '127.0.0.1',         // IPv4 localhost untuk development
            '::1'                // IPv6 localhost untuk development
        ];

        $ip_pengguna = $this->dapatkan_ip_asal();
        $ip_diizinkan = false;
        $range_cocok = '';
        
        foreach ($daftar_range_diizinkan as $cidr) {
            if ($this->cekIPDalamCIDR($ip_pengguna, $cidr)) {
                $ip_diizinkan = true;
                $range_cocok = $cidr;
                break;
            }
        }

        // Siapkan deskripsi untuk setiap range
        $ranges_dengan_deskripsi = [];
        foreach ($daftar_range_diizinkan as $range) {
            $ranges_dengan_deskripsi[] = [
                'range' => $range,
                'description' => $this->dapatkanDeskripsiRange($range)
            ];
        }

        if ($ip_diizinkan) {
            return [
                'allowed' => true,
                'message' => "IP Anda ($ip_pengguna) valid dan diizinkan mengakses sistem.",
                'matched_range' => $range_cocok,
                'allowed_ranges' => $ranges_dengan_deskripsi
            ];
        } else {
            // Log percobaan akses tetap dilakukan
            //log_message('warning', "Akses IP dari range tidak dikenal - IP: $ip_pengguna, Range Diizinkan: " . implode(', ', $daftar_range_diizinkan));
			log_message('info', "Akses IP dari range tidak dikenal - IP: $ip_pengguna, Range Diizinkan: " . implode(', ', $daftar_range_diizinkan));
            
            return [
                'allowed' => false,
                'message' => "IP Anda ($ip_pengguna) tidak berada dalam range yang diizinkan. Silakan hubungi administrator jika ini adalah kesalahan.",
                'matched_range' => null,
                'allowed_ranges' => $ranges_dengan_deskripsi
            ];
        }
    }

    /**
     * CEK APAKAH IP BERADA DALAM RANGE CIDR
     * @param string $ip Alamat IP yang akan dicek
     * @param string $cidr Range CIDR
     * @return bool True jika IP berada dalam range
     * @description Support untuk IPv4 dan IPv6
     */
    private function cekIPDalamCIDR($ip, $cidr) {
        // Handle IPv6 localhost
        if ($cidr === '::1' && $ip === '::1') {
            return true;
        }

        // Handle IPv4 localhost
        if ($cidr === '127.0.0.1' && $ip === '127.0.0.1') {
            return true;
        }

        // Handle single IP (tanpa CIDR)
        if (strpos($cidr, '/') === false) {
            return $ip === $cidr;
        }

        list($subnet, $bits) = explode('/', $cidr);
        
        // Untuk IPv4
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $ip_long = ip2long($ip);
            $subnet_long = ip2long($subnet);
            
            if ($ip_long === false || $subnet_long === false) {
                return false;
            }
            
            $mask = -1 << (32 - $bits);
            $subnet_long &= $mask;
            
            return ($ip_long & $mask) == $subnet_long;
        }
        
        // Untuk IPv6
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return $this->cekIPv6DalamCIDR($ip, $cidr);
        }
        
        return false;
    }

    /**
     * CEK RANGE CIDR UNTUK IPv6
     * @param string $ip Alamat IPv6
     * @param string $cidr Range CIDR IPv6
     * @return bool True jika IPv6 berada dalam range
     */
    private function cekIPv6DalamCIDR($ip, $cidr) {
        list($subnet, $bits) = explode('/', $cidr);
        
        $ip_bin = inet_pton($ip);
        $subnet_bin = inet_pton($subnet);
        
        if ($ip_bin === false || $subnet_bin === false) {
            return false;
        }
        
        // Konversi ke binary string
        $ip_bin_str = '';
        $subnet_bin_str = '';
        
        for ($i = 0; $i < 16; $i++) {
            $ip_bin_str .= sprintf('%08b', ord($ip_bin[$i]));
            $subnet_bin_str .= sprintf('%08b', ord($subnet_bin[$i]));
        }
        
        // Bandingkan hanya bagian network
        $bagian_network = substr($ip_bin_str, 0, $bits);
        $bagian_subnet = substr($subnet_bin_str, 0, $bits);
        
        return $bagian_network === $bagian_subnet;
    }

    /**
     * MENDAPATKAN DESKRIPSI UNTUK RANGE CIDR
     * @param string $range Range CIDR
     * @return string Deskripsi range
     */
    private function dapatkanDeskripsiRange($range) {
        $deskripsi = [
            '10.1.28.0/22' => 'Jaringan Utama - Local',
            '10.1.40.0/23' => 'Jaringan Utama - Local', 
            '10.1.20.0/23' => 'Jaringan Utama - Local',
            '10.100.14.0/23' => 'Jaringan Laboratorium',
            '103.187.167.0/24' => 'Cloudflare Network',
            '162.158.108.0/24' => 'Cloudflare Network',
            '127.0.0.1' => 'Localhost Development',
            '::1' => 'IPv6 Localhost'
        ];
        
        return isset($deskripsi[$range]) ? $deskripsi[$range] : 'Jaringan Internal';
    }

    /**
     * KONFIRMASI TES YANG AKAN DILAKUKAN
     * @param int|null $tes_id ID tes
     * @description Menampilkan halaman konfirmasi sebelum memulai tes
     */
    function konfirmasi_test($tes_id = null){
    	if(empty($tes_id)){
    		redirect('tes_dashboard');
    	}

    	$query_tes = $this->cbt_tes_model->get_by_kolom_limit('tes_id', $tes_id, 1);
    	if($query_tes->num_rows() == 0){
    		redirect('tes_dashboard');
    	}

    	$tes = $query_tes->row();
    	$tanggal_sekarang = new DateTime();
    	$tanggal_selesai_tes = new DateTime($tes->tes_end_time);

    	// Cek apakah tes masih dalam periode waktu
    	if($tanggal_sekarang >= $tanggal_selesai_tes){
    		redirect('tes_dashboard');
    	}

    	// Cek apakah user sudah pernah memulai tes ini
    	$username = $this->access_tes->get_username();
    	$user_id = $this->cbt_user_model->get_by_kolom_limit('user_name', $username, 1)->row()->user_id;

    	if($this->cbt_tes_user_model->count_by_user_tes($user_id, $tes->tes_id)->row()->hasil > 0){
    		redirect('tes_dashboard');
    	}

    	// Data untuk halaman konfirmasi
    	$data['tes_id'] = $tes->tes_id;
    	$data['nama'] = $this->access_tes->get_nama();
    	$data['group'] = $this->access_tes->get_group();
    	$data['timestamp'] = strtotime(date('Y-m-d H:i:s'));
    	$data['url'] = $this->url;
    	$data['tes_nama'] = $tes->tes_nama;
    	$data['tes_waktu'] = $tes->tes_duration_time . ' menit';
    	$data['tes_poin'] = $tes->tes_score_right;
    	$data['tes_max_score'] = $tes->tes_max_score;

    	// Handle token berdasarkan setting tes
    	if($tes->tes_token == 1){
    		$data['tes_token'] = '
    			<tr style="height: 45px;">
                    <td></td>
                    <td style="vertical-align: middle;text-align: right;">Token : </td>
                    <td style="vertical-align: middle;"><input type="text" name="token" id="token" autocomplete="off"></td>
                    <td></td>
                </tr>
    		';
    	}else{
    		$data['tes_token'] = '<input type="hidden" name="token" id="token">';
    	}

    	// Pastikan tes memiliki soal sebelum ditampilkan
    	if($data['tes_max_score'] > 0){
    		$this->template->display_tes($this->kelompok.'/tes_start_view', 'Mulai Tes', $data);	
    	}else{
    		redirect('tes_dashboard');
    	}
    }

    /**
     * MEMULAI TES
     * @return JSON Response status dan pesan
     * @description Memproses pembuatan sesi tes baru untuk user
     */
    function mulai_tes(){
    	$this->load->library('form_validation');
    	$this->form_validation->set_rules('tes-id', 'Tes', 'required|strip_tags');
        
        if(!$this->form_validation->run()){
            echo json_encode([
                'status' => 0,
                'pesan' => validation_errors()
            ]);
            return;
        }

		$tes_id = $this->input->post('tes-id', TRUE);
		$token = $this->input->post('token', TRUE);
		
		$username = $this->access_tes->get_username();
		$user_id = $this->cbt_user_model->get_by_kolom_limit('user_name', $username, 1)->row()->user_id;

		$query_tes = $this->cbt_tes_model->get_by_kolom_limit('tes_id', $tes_id, 1);
		if($query_tes->num_rows() == 0){
			echo json_encode(['status' => 2, 'pesan' => '']);
			return;
		}

		$tes = $query_tes->row();

		// Cek apakah user sudah pernah mengikuti tes ini
		if($this->cbt_tes_user_model->count_by_user_tes($user_id, $tes_id)->row()->hasil > 0){
			echo json_encode(['status' => 2, 'pesan' => '']);
			return;
		}

		// Validasi token jika diperlukan
		if(!$this->validasiToken($tes, $token)){
			echo json_encode([
				'status' => 0,
				'pesan' => 'Silahkan cek Token yang dimasukkan !'
			]);
			return;
		}

		// Cek apakah tes memiliki soal
		if($this->cbt_tes_topik_set_model->count_by_kolom('tset_tes_id', $tes->tes_id)->row()->hasil == 0){
			echo json_encode(['status' => 2, 'pesan' => '']);
			return;
		}

		// Mulai proses pembuatan tes
		if($this->buatTesUntukUser($tes, $user_id, $token)){
			echo json_encode([
				'status' => 1,
				'tes_id' => $tes_id,
				'pesan' => 'Pembuatan tes untuk user berhasil'
			]);
		}else{
			echo json_encode(['status' => 2, 'pesan' => '']);
		}
    }

    /**
     * VALIDASI TOKEN TES
     * @param object $tes Data tes
     * @param string $token Token yang dimasukkan
     * @return bool True jika token valid
     */
    private function validasiToken($tes, $token) {
        if($tes->tes_token != 1){
            return true; // Tes tidak memerlukan token
        }

        if(empty($token)){
            return false;
        }

        $query_token = $this->cbt_tes_token_model->get_by_token_now_limit($token, 1);
        if($query_token->num_rows() == 0){
            return false;
        }

        $data_token = $query_token->row();
        
        // Token untuk semua tes
        if($data_token->token_tes_id == 0){
            return $this->cekMasaAktifToken($data_token, $token);
        }
        
        // Token spesifik untuk tes tertentu
        if($data_token->token_tes_id == $tes->tes_id){
            return $this->cekMasaAktifToken($data_token, $token);
        }
        
        return false;
    }

    /**
     * CEK MASA AKTIF TOKEN
     * @param object $data_token Data token
     * @param string $token Token
     * @return bool True jika token masih aktif
     */
    private function cekMasaAktifToken($data_token, $token) {
        if($data_token->token_aktif == 1){
            return true; // Token aktif 1 hari
        }else{
            return $this->cbt_tes_token_model->count_by_token_lifetime($token, $data_token->token_aktif)->row()->hasil > 0;
        }
    }

    /**
     * MEMBUAT TES UNTUK USER
     * @param object $tes Data tes
     * @param int $user_id ID user
     * @param string $token Token
     * @return bool True jika berhasil
     */
    private function buatTesUntukUser($tes, $user_id, $token) {
        $this->db->trans_start();

        // 1. Simpan data tes user
        $data_tes = [
            'tesuser_tes_id' => $tes->tes_id,
            'tesuser_user_id' => $user_id,
            'tesuser_status' => 1,
            'tesuser_creation_time' => date('Y-m-d H:i:s')
        ];
        
        if(!empty($token)){
            $data_tes['tesuser_token'] = $token;
        }

        $tes_user_id = $this->cbt_tes_user_model->save($data_tes);

        // 2. Ambil dan proses soal untuk tes
        $this->prosesSoalTes($tes, $tes_user_id);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * PROSES SOAL UNTUK TES
     * @param object $tes Data tes
     * @param int $tes_user_id ID tes user
     */
    private function prosesSoalTes($tes, $tes_user_id) {
        $query_set_topik = $this->cbt_tes_topik_set_model->get_by_kolom('tset_tes_id', $tes->tes_id)->result();
        $counter_soal = 0;
        $semua_soal = [];

        foreach ($query_set_topik as $set_topik) {
            // Ambil soal berdasarkan setting
            if($set_topik->tset_acak_soal == 1){
                $query_soal = $this->cbt_soal_model->get_by_topik_tipe_kesulitan_select_limit(
                    $set_topik->tset_topik_id, 
                    $set_topik->tset_tipe, 
                    $set_topik->tset_difficulty, 
                    'soal_id,soal_topik_id,soal_tipe,soal_audio', 
                    $set_topik->tset_jumlah
                );
            }else{
                $query_soal = $this->cbt_soal_model->get_by_topik_tipe_kesulitan_select_limit_tanpa_acak(
                    $set_topik->tset_topik_id, 
                    $set_topik->tset_tipe, 
                    $set_topik->tset_difficulty, 
                    'soal_id,soal_topik_id,soal_tipe,soal_audio', 
                    $set_topik->tset_jumlah
                );
            }

            if($query_soal->num_rows() > 0){
                foreach ($query_soal->result() as $soal) {
                    $semua_soal[] = [
                        'tessoal_tesuser_id' => $tes_user_id,
                        'tessoal_soal_id' => $soal->soal_id,
                        'tessoal_nilai' => $tes->tes_score_unanswered,
                        'tessoal_creation_time' => date('Y-m-d H:i:s'),
                        'tessoal_order' => ++$counter_soal
                    ];
                }

                // Proses jawaban untuk soal pilihan ganda
                $this->prosesJawabanSoal($tes_user_id, $set_topik);
            }
        }

        // Simpan semua soal sekaligus
        if(!empty($semua_soal)){
            $this->cbt_tes_soal_model->save_batch($semua_soal);
        }
    }

    /**
     * PROSES JAWABAN UNTUK SOAL
     * @param int $tes_user_id ID tes user
     * @param object $set_topik Setting topik
     */
    private function prosesJawabanSoal($tes_user_id, $set_topik) {
        $query_log_tes = $this->cbt_tes_soal_model->get_by_testuser_select(
            $tes_user_id, 
            $set_topik->tset_topik_id, 
            'tessoal_id, soal_id, soal_tipe'
        )->result();

        foreach ($query_log_tes as $log_tes) {
            if($log_tes->soal_tipe != 1) continue; // Hanya proses soal pilihan ganda

            if($set_topik->tset_acak_jawaban == 1){
                $query_jawaban = $this->cbt_jawaban_model->get_by_soal_limit($log_tes->soal_id, $set_topik->tset_jawaban);
            }else{
                $query_jawaban = $this->cbt_jawaban_model->get_by_soal_tanpa_acak($log_tes->soal_id);
            }

            if($query_jawaban->num_rows() > 0){
                $jawaban_data = [];
                $counter_jawaban = 0;

                foreach ($query_jawaban->result() as $jawaban) {
                    $jawaban_data[] = [
                        'soaljawaban_jawaban_id' => $jawaban->jawaban_id,
                        'soaljawaban_order' => ++$counter_jawaban,
                        'soaljawaban_selected' => 0,
                        'soaljawaban_tessoal_id' => $log_tes->tessoal_id
                    ];
                }

                $this->cbt_tes_soal_jawaban_model->save_batch($jawaban_data);
            }
        }
    }

    /**
     * UBAH PASSWORD USER
     * @return JSON Response status dan error
     */
    function password(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password-old', 'Password Lama', 'required|strip_tags');
        $this->form_validation->set_rules('password-new', 'Password Baru', 'required|strip_tags');
        $this->form_validation->set_rules('password-confirm', 'Confirm Password', 'required|strip_tags');
        
        if(!$this->form_validation->run()){
            echo json_encode([
                'status' => 0,
                'error' => validation_errors()
            ]);
            return;
        }

        $password_lama = $this->input->post('password-old', TRUE);
        $password_baru = $this->input->post('password-new', TRUE);
        $konfirmasi_password = $this->input->post('password-confirm', TRUE);
        $username = $this->access_tes->get_username();

        // Validasi password lama
        if($this->cbt_user_model->count_by_username_password($username, $password_lama) == 0){
            echo json_encode([
                'status' => 0,
                'error' => 'Password Lama tidak Sesuai'
            ]);
            return;
        }

        // Validasi konfirmasi password baru
        if($password_baru != $konfirmasi_password){
            echo json_encode([
                'status' => 0,
                'error' => 'Kedua password baru tidak sama'
            ]);
            return;
        }

        // Update password
        $this->cbt_user_model->update('user_name', $username, ['user_password' => $password_baru]);
        
        echo json_encode([
            'status' => 1,
            'error' => ''
        ]);
    }

    /**
     * MENDAPATKAN DATA TABEL TES UNTUK DATATABLES
     * @description Mengembalikan data JSON untuk DataTables
     */
    function get_datatable(){
        // Inisialisasi variabel
        $search = $this->input->get('sSearch', TRUE);
        $start = $this->get_start();
        $rows = $this->get_rows();

        // Data user dan grup
        $group = $this->access_tes->get_group();
        $username = $this->access_tes->get_username();
        
        $grup_id = 0;
        $query_grup = $this->cbt_user_grup_model->get_by_kolom_limit('grup_nama', $group, 1);
        if($query_grup->num_rows() > 0){
            $grup_id = $query_grup->row()->grup_id;
        }

        $user_id = 0;
        $query_user = $this->cbt_user_model->get_by_kolom_limit('user_name', $username, 1);
        if($query_user->num_rows() > 0){
            $user_id = $query_user->row()->user_id;
        }

        // Query data tes
        $query = $this->cbt_tesgrup_model->get_datatable($start, $rows, $grup_id);
        $total_filtered = $query->num_rows();
        $total_data = $this->cbt_tesgrup_model->get_datatable_count($grup_id)->row()->hasil;

        // Persiapan output
        $output = [
            "sEcho" => intval($this->input->get('sEcho', TRUE)),
            "iTotalRecords" => $total_data,
            "iTotalDisplayRecords" => $total_data,
            "aaData" => []
        ];

        // Proses data
        $counter = $start;
        foreach ($query->result() as $tes) {
            // Cek apakah tes memiliki soal
            if($this->cbt_tes_topik_set_model->count_by_kolom('tset_tes_id', $tes->tes_id)->row()->hasil == 0){
                continue;
            }

            $record = [
                ++$counter,
                $tes->tes_nama,
                $tes->tes_begin_time,
                $tes->tes_end_time,
                '',
                ''
            ];

            // Cek status tes user
            $record = $this->tentukanStatusDanAksiTes($tes, $user_id, $record);
            $output['aaData'][] = $record;
        }

        header('Content-Type: application/json');
        echo json_encode($output);
    }

    /**
     * MENENTUKAN STATUS DAN AKSI TES UNTUK USER
     * @param object $tes Data tes
     * @param int $user_id ID user
     * @param array $record Data record
     * @return array Record yang sudah diupdate
     */
    private function tentukanStatusDanAksiTes($tes, $user_id, $record) {
        $query_tes_user = $this->cbt_tes_user_model->count_by_user_tes($user_id, $tes->tes_id);
        
        if($query_tes_user->row()->hasil > 0){
            $data_tes_user = $this->cbt_tes_user_model->get_by_user_tes($user_id, $tes->tes_id)->row();
            $tanggal_sekarang = new DateTime();
            $tanggal_tes = new DateTime($data_tes_user->tesuser_creation_time);
            $tanggal_tes->modify('+'.$tes->tes_duration_time.' minutes');

            // Tes masih berjalan
            if($tanggal_sekarang < $tanggal_tes && $data_tes_user->tesuser_status != 4){
                $record[4] = '<span class="label label-warning">Dalam Pengerjaan</span>';
                $record[5] = '<a href="'.site_url('tes_kerjakan/index/'.$tes->tes_id).'" class="btn btn-primary btn-xs">Lanjutkan</a>';
            }else{
                // Tes sudah selesai
                $record[4] = $this->getNilaiTes($tes, $data_tes_user->tesuser_id);
                $record[5] = $this->getTombolDetail($tes, $data_tes_user->tesuser_id);
            }
        }else{
            // Belum mulai tes
            $record[4] = '<span class="label label-default">Belum Dimulai</span>';
            $record[5] = '<a href="'.site_url($this->url.'/konfirmasi_test/'.$tes->tes_id).'" class="btn btn-success btn-xs">Kerjakan</a>';
        }

        return $record;
    }

    /**
     * MENDAPATKAN NILAI TES JIKA DITAMPILKAN
     * @param object $tes Data tes
     * @param int $tes_user_id ID tes user
     * @return string HTML nilai atau status
     */
    private function getNilaiTes($tes, $tes_user_id) {
        if($tes->tes_results_to_users == 1){
            $nilai = $this->cbt_tes_soal_model->get_nilai($tes_user_id)->row()->hasil;
            return '<span class="label label-success">Nilai: '.$nilai.'</span>';
        }
        return '<span class="label label-info">Selesai</span>';
    }

    /**
     * MENDAPATKAN TOMBOL DETAIL TES JIKA DITAMPILKAN
     * @param object $tes Data tes
     * @param int $tes_user_id ID tes user
     * @return string HTML tombol atau string kosong
     */
    private function getTombolDetail($tes, $tes_user_id) {
        if($tes->tes_detail_to_users == 1){
            return '<a href="'.site_url('tes_hasil_detail/index/'.$tes_user_id).'" class="btn btn-info btn-xs">Lihat Detail</a>';
        }
        return '';
    }

    /**
     * FUNGSI BANTUAN UNTUK DATATABLES - START
     */
    function get_start() {
        $start = $this->input->get('iDisplayStart', TRUE);
        return ($start !== null && $start != '') ? max(0, intval($start)) : 0;
    }

    function get_rows() {
        $rows = $this->input->get('iDisplayLength', TRUE);
        $rows = ($rows !== null && $rows != '') ? intval($rows) : 10;
        return ($rows < 5 || $rows > 500) ? 10 : $rows;
    }

    function get_sort_dir() {
        $sort_dir = $this->input->get('sSortDir_0', TRUE);
        return ($sort_dir && $sort_dir != "asc") ? "DESC" : "ASC";
    }
}