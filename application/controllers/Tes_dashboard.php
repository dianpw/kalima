<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * KALIMA TEST
 * Dian Purwanto
 * dianpw6901@gmail.com
 * 2023.1.31
 * 
 * Controller untuk dashboard tes CBT dengan validasi IP
 */
class Tes_dashboard extends Tes_Controller
{
    private $kelompok = 'ujian';
    private $url = 'tes_dashboard';

    function __construct()
    {
        parent::__construct();
        $this->load->model('cbt_user_model');
        $this->load->model('cbt_user_grup_model');
        $this->load->model('cbt_tes_model');
        $this->load->model('cbt_tes_token_model');
        $this->load->model('cbt_tes_topik_set_model');
        $this->load->model('cbt_tes_user_model');
        $this->load->model('cbt_tesgrup_model');
        $this->load->model('cbt_soal_model');
        $this->load->model('cbt_jawaban_model');
        $this->load->model('cbt_tes_soal_model');
        $this->load->model('cbt_tes_soal_jawaban_model');
        $this->load->model('cbt_konfigurasi_model');
    }

    /**
     * Halaman utama dashboard tes
     * Menampilkan informasi tes dan validasi IP
     */
    public function index()
    {
        $this->load->helper('form');
        $data['nama'] = $this->access_tes->get_nama();
        $data['group'] = $this->access_tes->get_group();
        $data['url'] = $this->url;
        $data['timestamp'] = strtotime(date('Y-m-d H:i:s'));

        // Data IP untuk keperluan display dan validasi
        $data['user_ip'] = $this->dapatkan_ip_asal();
        $data['cloudflare_detected'] = (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && !empty($_SERVER['HTTP_CF_CONNECTING_IP']));
        
        // Format IP Cloudflare untuk display
        $cloudflare_ip = $data['cloudflare_detected'] ? $_SERVER['HTTP_CF_CONNECTING_IP'] : '';
        $parts = explode('.', $cloudflare_ip);
        if (count($parts) === 4) {
            $data['cloudflare_ip'] = $parts[0] . '.' . $parts[1] . '.xxx.xxx';
        } else {
            $data['cloudflare_ip'] = $cloudflare_ip;
        }

        // Validasi IP Range
        $ip_validation_result = $this->validasiRangeIP();
        $data['ip_allowed'] = $ip_validation_result['allowed'];
        $data['ip_validation_message'] = $ip_validation_result['message'];
        $data['allowed_ranges'] = $ip_validation_result['allowed_ranges'];

        // Update status tes yang sudah melebihi waktu
        $this->update_status_tes_kadaluarsa();

        // Ambil informasi sistem
        $data['informasi'] = $this->get_informasi_sistem();

        $this->template->display_tes($this->kelompok . '/tes_dashboardIPValid_view', 'Dashboard', $data);
    }

    /**
     * Update status tes yang sudah melebihi waktu pengerjaan
     */
    private function update_status_tes_kadaluarsa()
    {
        try {
            $username = $this->access_tes->get_username();
            $query_user = $this->cbt_user_model->get_by_kolom_limit('user_name', $username, 1);
            
            if ($query_user->num_rows() > 0) {
                $user_id = $query_user->row()->user_id;
                $query_tes = $this->cbt_tes_user_model->get_by_user_status($user_id);
                
                if ($query_tes->num_rows() > 0) {
                    $tanggal_sekarang = new DateTime();
                    
                    foreach ($query_tes->result() as $tes) {
                        $tanggal_tes = new DateTime($tes->tesuser_creation_time);
                        $tanggal_tes->modify('+' . $tes->tes_duration_time . ' minutes');
                        
                        if ($tanggal_sekarang > $tanggal_tes) {
                            $data_tes['tesuser_status'] = 4;
                            $this->cbt_tes_user_model->update('tesuser_id', $tes->tesuser_id, $data_tes);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            log_message('error', 'Error update status tes: ' . $e->getMessage());
        }
    }

    /**
     * Mendapatkan informasi sistem
     */
    private function get_informasi_sistem()
    {
        $informasi = '';
        $query_info = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_informasi', 1);
        
        if ($query_info->num_rows() > 0) {
            $informasi = $query_info->row()->konfigurasi_isi;
        }
        
        return $informasi;
    }

    /**
     * Mendapatkan deskripsi untuk range CIDR
     * @param string $range Range CIDR
     * @return string Deskripsi range
     */
    private function dapatkanDeskripsiRange($range)
    {
        $deskripsi = [
            '10.1.28.0/22' => 'Jaringan Kelas - VH5-Class',
            '10.1.40.0/23' => 'Jaringan Kelas - VH5-Class',
            '10.1.20.0/23' => 'Jaringan Kelas - VH5-Class',
            '10.100.14.0/23' => 'Jaringan Laboratorium - Wifi Jurusan',
            '103.186.167.0/24' => 'Jaringan Utama - ICT'
        ];

        return isset($deskripsi[$range]) ? $deskripsi[$range] : 'Jaringan Internal';
    }

    /**
     * Validasi IP berdasarkan range CIDR dengan dukungan Cloudflare
     * @return array Hasil validasi IP
     */
    private function validasiRangeIP()
    {
        // Daftar range CIDR yang diizinkan (access point)
        $daftar_range_diizinkan = [
            '10.1.28.0/22',
            '10.1.40.0/23',
            '10.1.20.0/23',
            '10.100.14.0/23',
            '103.186.167.0/24'
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
            log_message('info', "Akses IP dari range tidak dikenal - IP: $ip_pengguna");

            return [
                'allowed' => false,
                'message' => "IP Anda ($ip_pengguna) tidak berada dalam range yang diizinkan. <br/>Silahkan menggunakan Jaringan Wifi Sekolah yang disediakan.",
                'matched_range' => null,
                'allowed_ranges' => $ranges_dengan_deskripsi
            ];
        }
    }

    /**
     * Mendapatkan IP asli dengan dukungan Cloudflare
     * @return string Alamat IP asli pengguna
     */
    private function dapatkan_ip_asal()
    {
        $ip_asal = '0.0.0.0';

        // Daftar header dengan prioritas Cloudflare
        $daftar_header = [
            'HTTP_CF_CONNECTING_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'HTTP_CLIENT_IP',
            'REMOTE_ADDR'
        ];

        foreach ($daftar_header as $header) {
            if (isset($_SERVER[$header]) && !empty($_SERVER[$header])) {
                $ip_kandidat = $_SERVER[$header];

                // Handle multiple IPs dalam header
                if (strpos($ip_kandidat, ',') !== false) {
                    $ip_array = explode(',', $ip_kandidat);
                    $ip_kandidat = trim($ip_array[0]);
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
     * Cek apakah IP berada dalam range CIDR
     * @param string $ip Alamat IP yang akan dicek
     * @param string $cidr Range CIDR
     * @return bool True jika IP berada dalam range
     */
    private function cekIPDalamCIDR($ip, $cidr)
    {
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
     * Cek range CIDR untuk IPv6 - PERBAIKAN: Fixed Uninitialized string offset
     * @param string $ip Alamat IPv6
     * @param string $cidr Range CIDR IPv6
     * @return bool True jika IPv6 berada dalam range
     */
    private function cekIPv6DalamCIDR($ip, $cidr)
    {
        list($subnet, $bits) = explode('/', $cidr);

        $ip_bin = @inet_pton($ip);
        $subnet_bin = @inet_pton($subnet);

        if ($ip_bin === false || $subnet_bin === false) {
            return false;
        }

        // PERBAIKAN: Pastikan panjang binary string 16 byte untuk IPv6
        $ip_bin = str_pad($ip_bin, 16, "\0", STR_PAD_RIGHT);
        $subnet_bin = str_pad($subnet_bin, 16, "\0", STR_PAD_RIGHT);

        // Konversi ke binary string dengan pengecekan bounds
        $ip_bin_str = '';
        $subnet_bin_str = '';

        for ($i = 0; $i < 16; $i++) {
            // PERBAIKAN: Gunakan isset() untuk menghindari uninitialized offset
            $byte_ip = isset($ip_bin[$i]) ? ord($ip_bin[$i]) : 0;
            $byte_subnet = isset($subnet_bin[$i]) ? ord($subnet_bin[$i]) : 0;
            
            $ip_bin_str .= sprintf('%08b', $byte_ip);
            $subnet_bin_str .= sprintf('%08b', $byte_subnet);
        }

        // Bandingkan hanya bagian network
        $bagian_network = substr($ip_bin_str, 0, $bits);
        $bagian_subnet = substr($subnet_bin_str, 0, $bits);

        return $bagian_network === $bagian_subnet;
    }

    /**
     * Konfirmasi tes yang akan dilakukan
     * @param int $tes_id ID tes
     */
    function konfirmasi_test($tes_id = null)
    {
        if (empty($tes_id)) {
            redirect('tes_dashboard');
            return;
        }

        try {
            $query_tes = $this->cbt_tes_model->get_by_kolom_limit('tes_id', $tes_id, 1);
            
            if ($query_tes->num_rows() == 0) {
                redirect('tes_dashboard');
                return;
            }

            $query_tes = $query_tes->row();
            $tanggal_sekarang = new DateTime();
            $tanggal_tes = new DateTime($query_tes->tes_end_time);

            // Cek apakah tes masih dalam waktu
            if ($tanggal_sekarang >= $tanggal_tes) {
                redirect('tes_dashboard');
                return;
            }

            // Cek apakah sudah pernah memulai tes
            $username = $this->access_tes->get_username();
            $user_id = $this->cbt_user_model->get_by_kolom_limit('user_name', $username, 1)->row()->user_id;

            if ($this->cbt_tes_user_model->count_by_user_tes($user_id, $query_tes->tes_id)->row()->hasil > 0) {
                redirect('tes_dashboard');
                return;
            }

            // Tampilkan konfirmasi Tes
            $data['tes_id'] = $query_tes->tes_id;
            $data['nama'] = $this->access_tes->get_nama();
            $data['group'] = $this->access_tes->get_group();
            $data['timestamp'] = strtotime(date('Y-m-d H:i:s'));
            $data['url'] = $this->url;
            $data['tes_nama'] = $query_tes->tes_nama;
            $data['tes_waktu'] = $query_tes->tes_duration_time . ' menit';
            $data['tes_poin'] = $query_tes->tes_score_right;
            $data['tes_max_score'] = $query_tes->tes_max_score;

            // Handle token berdasarkan setting tes
            if ($query_tes->tes_token == 1) {
                $data['tes_token'] = '
                    <tr style="height: 45px;">
                        <td></td>
                        <td style="vertical-align: middle;text-align: right;">Token : </td>
                        <td style="vertical-align: middle;"><input type="text" name="token" id="token" autocomplete="off"></td>
                        <td></td>
                    </tr>
                ';
            } else {
                $data['tes_token'] = '<input type="hidden" name="token" id="token">';
            }

            if ($data['tes_max_score'] > 0) {
                $this->template->display_tes($this->kelompok . '/tes_start_view', 'Mulai Tes', $data);
            } else {
                redirect('tes_dashboard');
            }
        } catch (Exception $e) {
            log_message('error', 'Error konfirmasi test: ' . $e->getMessage());
            redirect('tes_dashboard');
        }
    }

    /**
     * Memulai tes
     * Status: 
     * 0 = gagal
     * 1 = sukses  
     * 2 = gagal, halaman dikembalikan ke dashboard
     */
    function mulai_tes()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tes-id', 'Tes', 'required|strip_tags');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 0,
                'pesan' => validation_errors()
            ]);
            return;
        }

        try {
            $tes_id = $this->input->post('tes-id', TRUE);
            $token = $this->input->post('token', TRUE);

            $username = $this->access_tes->get_username();
            $user_id = $this->cbt_user_model->get_by_kolom_limit('user_name', $username, 1)->row()->user_id;

            $query_tes = $this->cbt_tes_model->get_by_kolom_limit('tes_id', $tes_id, 1);
            
            if ($query_tes->num_rows() == 0) {
                echo json_encode([
                    'status' => 2,
                    'pesan' => ''
                ]);
                return;
            }

            $query_tes = $query_tes->row();

            // Cek apakah tes sudah pernah dilakukan
            if ($this->cbt_tes_user_model->count_by_user_tes($user_id, $tes_id)->row()->hasil > 0) {
                echo json_encode([
                    'status' => 2,
                    'pesan' => ''
                ]);
                return;
            }

            // Validasi token
            $is_ok = $this->validasi_token($query_tes, $token, $tes_id);
            
            if (!$is_ok['status']) {
                echo json_encode([
                    'status' => 0,
                    'pesan' => 'Silahkan cek Token yang dimasukkan !'
                ]);
                return;
            }

            // Cek apakah tes mempunyai data soal
            if ($this->cbt_tes_topik_set_model->count_by_kolom('tset_tes_id', $query_tes->tes_id)->row()->hasil == 0) {
                echo json_encode([
                    'status' => 2,
                    'pesan' => ''
                ]);
                return;
            }

            // Mulai proses pembuatan tes
            $result = $this->proses_mulai_tes($query_tes, $user_id, $is_ok['data_token']);

            echo json_encode($result);
        } catch (Exception $e) {
            log_message('error', 'Error mulai tes: ' . $e->getMessage());
            echo json_encode([
                'status' => 0,
                'pesan' => 'Terjadi kesalahan sistem'
            ]);
        }
    }

    /**
     * Validasi token tes
     */
    private function validasi_token($query_tes, $token, $tes_id)
    {
        $data_token = '';
        
        if ($query_tes->tes_token != 1) {
            return ['status' => true, 'data_token' => $data_token];
        }

        if (empty($token)) {
            return ['status' => false, 'data_token' => $data_token];
        }

        $query_token = $this->cbt_tes_token_model->get_by_token_now_limit($token, 1);
        
        if ($query_token->num_rows() == 0) {
            return ['status' => false, 'data_token' => $data_token];
        }

        $query_token = $query_token->row();

        // Token untuk semua TES
        if ($query_token->token_tes_id == 0) {
            if ($query_token->token_aktif == 1) {
                $data_token = $token;
                return ['status' => true, 'data_token' => $data_token];
            } else {
                if ($this->cbt_tes_token_model->count_by_token_lifetime($token, $query_token->token_aktif)->row()->hasil > 0) {
                    $data_token = $token;
                    return ['status' => true, 'data_token' => $data_token];
                }
            }
        } else {
            // Token spesifik untuk Tes
            if ($query_token->token_tes_id == $tes_id) {
                if ($query_token->token_aktif == 1) {
                    $data_token = $token;
                    return ['status' => true, 'data_token' => $data_token];
                } else {
                    if ($this->cbt_tes_token_model->count_by_token_lifetime($token, $query_token->token_aktif)->row()->hasil > 0) {
                        $data_token = $token;
                        return ['status' => true, 'data_token' => $data_token];
                    }
                }
            }
        }

        return ['status' => false, 'data_token' => $data_token];
    }

    /**
     * Proses memulai tes
     */
    private function proses_mulai_tes($query_tes, $user_id, $token)
    {
        $this->db->trans_start();

        try {
            // 1. Memasukkan data ke test_user
            $data_tes = [
                'tesuser_tes_id' => $query_tes->tes_id,
                'tesuser_user_id' => $user_id,
                'tesuser_status' => 1,
                'tesuser_creation_time' => date('Y-m-d H:i:s'),
                'tesuser_token' => $token
            ];

            $tests_users_id = $this->cbt_tes_user_model->save($data_tes);

            // 2. Setup soal untuk tes
            $this->setup_soal_tes($query_tes->tes_id, $tests_users_id, $query_tes);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return [
                    'status' => 0,
                    'pesan' => 'Gagal memulai tes'
                ];
            }

            return [
                'status' => 1,
                'tes_id' => $query_tes->tes_id,
                'pesan' => 'Pembuatan tes untuk user berhasil'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw $e;
        }
    }

    /**
     * Setup soal untuk tes
     */
    private function setup_soal_tes($tes_id, $tests_users_id, $query_tes)
    {
        $query_subject_set = $this->cbt_tes_topik_set_model->get_by_kolom('tset_tes_id', $tes_id)->result();
        $i_soal = 0;

        foreach ($query_subject_set as $subject_set) {
            // Ambil soal berdasarkan setting
            if ($subject_set->tset_acak_soal == 1) {
                $query_soal = $this->cbt_soal_model->get_by_topik_tipe_kesulitan_select_limit(
                    $subject_set->tset_topik_id, 
                    $subject_set->tset_tipe, 
                    $subject_set->tset_difficulty, 
                    'soal_id,soal_topik_id,soal_tipe,soal_audio', 
                    $subject_set->tset_jumlah
                );
            } else {
                $query_soal = $this->cbt_soal_model->get_by_topik_tipe_kesulitan_select_limit_tanpa_acak(
                    $subject_set->tset_topik_id, 
                    $subject_set->tset_tipe, 
                    $subject_set->tset_difficulty, 
                    'soal_id,soal_topik_id,soal_tipe,soal_audio', 
                    $subject_set->tset_jumlah
                );
            }

            if ($query_soal->num_rows() > 0) {
                $insert_soal = [];
                
                foreach ($query_soal->result() as $soal) {
                    $data_soal = [
                        'tessoal_tesuser_id' => $tests_users_id,
                        'tessoal_soal_id' => $soal->soal_id,
                        'tessoal_nilai' => $query_tes->tes_score_unanswered,
                        'tessoal_creation_time' => date('Y-m-d H:i:s'),
                        'tessoal_order' => ++$i_soal
                    ];
                    $insert_soal[] = $data_soal;
                }

                $this->cbt_tes_soal_model->save_batch($insert_soal);

                // Setup jawaban untuk setiap soal
                $this->setup_jawaban_soal($tests_users_id, $subject_set);
            }
        }
    }

    /**
     * Setup jawaban untuk soal
     */
    private function setup_jawaban_soal($tests_users_id, $subject_set)
    {
        $query_test_log = $this->cbt_tes_soal_model->get_by_testuser_select(
            $tests_users_id, 
            $subject_set->tset_topik_id, 
            'tessoal_id, soal_id, soal_tipe'
        )->result();

        foreach ($query_test_log as $test_log) {
            if ($test_log->soal_tipe == 1) { // Tipe soal pilihan ganda
                if ($subject_set->tset_acak_jawaban == 1) {
                    $query_jawaban = $this->cbt_jawaban_model->get_by_soal_limit(
                        $test_log->soal_id, 
                        $subject_set->tset_jawaban
                    );
                } else {
                    $query_jawaban = $this->cbt_jawaban_model->get_by_soal_tanpa_acak($test_log->soal_id);
                }

                if ($query_jawaban->num_rows() > 0) {
                    $insert_jawaban = [];
                    $i_jawaban = 0;
                    
                    foreach ($query_jawaban->result() as $jawaban) {
                        $data_jawaban = [
                            'soaljawaban_jawaban_id' => $jawaban->jawaban_id,
                            'soaljawaban_order' => ++$i_jawaban,
                            'soaljawaban_selected' => 0,
                            'soaljawaban_tessoal_id' => $test_log->tessoal_id
                        ];
                        $insert_jawaban[] = $data_jawaban;
                    }
                    
                    $this->cbt_tes_soal_jawaban_model->save_batch($insert_jawaban);
                }
            }
        }
    }

    /**
     * Merubah password user tes
     */
    function password()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password-old', 'Password Lama', 'required|strip_tags');
        $this->form_validation->set_rules('password-new', 'Password Baru', 'required|strip_tags');
        $this->form_validation->set_rules('password-confirm', 'Confirm Password', 'required|strip_tags');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 0,
                'error' => validation_errors()
            ]);
            return;
        }

        try {
            $old = $this->input->post('password-old', TRUE);
            $new = $this->input->post('password-new', TRUE);
            $confirm = $this->input->post('password-confirm', TRUE);
            $username = $this->access_tes->get_username();

            if ($this->cbt_user_model->count_by_username_password($username, $old) == 0) {
                echo json_encode([
                    'status' => 0,
                    'error' => 'Password Lama tidak Sesuai'
                ]);
                return;
            }

            if ($new != $confirm) {
                echo json_encode([
                    'status' => 0,
                    'error' => 'Kedua password baru tidak sama'
                ]);
                return;
            }

            $data['user_password'] = $new;
            $this->cbt_user_model->update('user_name', $username, $data);

            echo json_encode([
                'status' => 1,
                'error' => ''
            ]);
        } catch (Exception $e) {
            log_message('error', 'Error ganti password: ' . $e->getMessage());
            echo json_encode([
                'status' => 0,
                'error' => 'Terjadi kesalahan sistem'
            ]);
        }
    }

    /**
     * Mendapatkan daftar tes yang dapat diikuti (Datatable)
     */
    function get_datatable()
    {
        // Initialize variables
        $search = isset($_GET['sSearch']) ? $_GET['sSearch'] : "";
        $start = $this->get_start();
        $rows = $this->get_rows();

        $group = $this->access_tes->get_group();
        $query_grup = $this->cbt_user_grup_model->get_by_kolom_limit('grup_nama', $group, 1);
        $grup_id = $query_grup->num_rows() > 0 ? $query_grup->row()->grup_id : 0;

        $username = $this->access_tes->get_username();
        $query_user = $this->cbt_user_model->get_by_kolom_limit('user_name', $username, 1);
        $user_id = $query_user->num_rows() > 0 ? $query_user->row()->user_id : 0;

        // Run query to get tes listing
        $query = $this->cbt_tesgrup_model->get_datatable($start, $rows, $grup_id, $search);
        $iFilteredTotal = $query->num_rows();
        $iTotal = $this->cbt_tesgrup_model->get_datatable_count($grup_id, $search)->row()->hasil;

        $output = [
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => []
        ];

        // Process results
        $i = $start;
        foreach ($query->result() as $temp) {
            // Cek apakah tes memiliki soal
            if ($this->cbt_tes_topik_set_model->count_by_kolom('tset_tes_id', $temp->tes_id)->row()->hasil > 0) {
                $record = [];
                $record[] = ++$i;
                $record[] = $temp->tes_nama;
                $record[] = $temp->tes_begin_time;
                $record[] = $temp->tes_end_time;

                // Cek status tes user
                $record = array_merge($record, $this->get_status_tes_user($temp, $user_id));
                $output['aaData'][] = $record;
            }
        }

        echo json_encode($output);
    }

    /**
     * Mendapatkan status tes user
     */
    private function get_status_tes_user($tes, $user_id)
    {
        $count_tes_user = $this->cbt_tes_user_model->count_by_user_tes($user_id, $tes->tes_id)->row()->hasil;
        
        if ($count_tes_user > 0) {
            $query_test_user = $this->cbt_tes_user_model->get_by_user_tes($user_id, $tes->tes_id)->row();
            $tanggal_sekarang = new DateTime();
            $tanggal_tes = new DateTime($query_test_user->tesuser_creation_time);
            $tanggal_tes->modify('+' . $tes->tes_duration_time . ' minutes');

            if ($tanggal_sekarang < $tanggal_tes && $query_test_user->tesuser_status != 4) {
                // Tes masih berjalan
                return [
                    '',
                    '<a href="' . site_url() . '/tes_kerjakan/index/' . $tes->tes_id . '" style="cursor: pointer;" class="btn btn-default btn-xs">Lanjutkan</a>'
                ];
            } else {
                // Tes sudah selesai
                $nilai = '';
                $detail = '';

                if ($tes->tes_results_to_users == 1) {
                    $query_nilai = $this->cbt_tes_soal_model->get_nilai($query_test_user->tesuser_id)->row();
                    $nilai = isset($query_nilai->hasil) ? $query_nilai->hasil : '';
                }

                if ($tes->tes_detail_to_users == 1) {
                    $detail = '<a href="' . site_url() . '/tes_hasil_detail/index/' . $query_test_user->tesuser_id . '" style="cursor: pointer;" class="btn btn-default btn-xs">Lihat Detail</a>';
                }

                return [$nilai, $detail];
            }
        } else {
            // Belum mengikuti tes
            return [
                '',
                '<a href="' . site_url() . '/' . $this->url . '/konfirmasi_test/' . $tes->tes_id . '" style="cursor: pointer;" class="btn btn-success btn-xs">Kerjakan</a>'
            ];
        }
    }

    /**
     * Fungsi tambahan untuk datatable
     */
    function get_start()
    {
        $start = 0;
        if (isset($_GET['iDisplayStart'])) {
            $start = intval($_GET['iDisplayStart']);
            if ($start < 0) {
                $start = 0;
            }
        }
        return $start;
    }

    function get_rows()
    {
        $rows = 10;
        if (isset($_GET['iDisplayLength'])) {
            $rows = intval($_GET['iDisplayLength']);
            if ($rows < 5 || $rows > 500) {
                $rows = 10;
            }
        }
        return $rows;
    }
}