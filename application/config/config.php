<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// KONFIGURASI CUSTOM
$config['upload_path'] = 'uploads';  // Path untuk upload file
$config['site_name'] = 'KALIMA TEST'; // Nama website
$config['site_version'] = '2023.1.31'; // Versi aplikasi

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
*/
// REKOMENDASI: Untuk production, sebaiknya gunakan URL statis
// $config['base_url'] = 'https://domain-anda.com/';

// Konfigurasi dinamis - sudah baik untuk development
$root = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$config['base_url'] = $root;

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
*/
$config['index_page'] = ''; // Sudah baik untuk clean URL

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
*/
$config['uri_protocol'] = 'REQUEST_URI'; // Sudah tepat

/*
|--------------------------------------------------------------------------
| Default Language & Character Set
|--------------------------------------------------------------------------
*/
$config['language'] = 'indonesia'; // Bahasa Indonesia - sudah baik
$config['charset'] = 'UTF-8'; // Character set - sudah tepat

/*
|--------------------------------------------------------------------------
| Session Configuration
|--------------------------------------------------------------------------
*/
// REKOMENDASI: Untuk keamanan lebih baik, beberapa setting bisa diperbaiki
$config['sess_driver'] = 'database'; // Menggunakan database untuk session - baik
$config['sess_cookie_name'] = 'ci_session_kalima'; // Nama custom - baik
$config['sess_expiration'] = 7200; // Session browser only - perhatikan untuk aplikasi banking

// REKOMENDASI: Untuk aplikasi yang membutuhkan keamanan tinggi, set expiration time
// $config['sess_expiration'] = 7200; // 2 jam

$config['sess_save_path'] = 'cbt_sessions'; // Table session - pastikan table sudah dibuat
$config['sess_match_ip'] = FALSE; 
// REKOMENDASI: Set TRUE untuk keamanan lebih (match IP address)

$config['sess_time_to_update'] = 300; // Regenerate session ID setiap 5 menit - baik
$config['sess_regenerate_destroy'] = FALSE; // Biarkan FALSE untuk usability

/*
|--------------------------------------------------------------------------
| Security Configuration
|--------------------------------------------------------------------------
*/
$config['encryption_key'] = 'sdjs djhas dhkajshdfsdfsKJKAhsa ahdsa d*&^876ad a7dud kahdkjas dias76dkashd sd dkfsdfsdfsdfsdjashdja shdkjhKJHSKjd s8d9789sd sd';
// REKOMENDASI: Key sangat panjang, pertimbangkan untuk menggunakan key yang lebih mudah dikelola

$config['csrf_protection'] = FALSE;
// REKOMENDASI: Set TRUE untuk form protection di production

/*
|--------------------------------------------------------------------------
| Error Handling
|--------------------------------------------------------------------------
*/
$config['log_threshold'] = 0;
// REKOMENDASI: Untuk development set 2, untuk production set 1
// 0 = Tidak log error (tidak disarankan)
// 1 = Error Messages saja
// 2 = Debug Messages
// 3 = Informational Messages
// 4 = All Messages

/*
|--------------------------------------------------------------------------
| Database Session Setup (Tambahkan di file database.php)
|--------------------------------------------------------------------------
*/
// REKOMENDASI: Pastikan table 'cbt_sessions' sudah dibuat dengan structure:
/*
CREATE TABLE cbt_sessions (
    id varchar(128) NOT NULL,
    ip_address varchar(45) NOT NULL,
    timestamp int(10) unsigned DEFAULT 0 NOT NULL,
    data blob NOT NULL,
    PRIMARY KEY (id),
    KEY ci_sessions_timestamp (timestamp)
);
*/

/*
|--------------------------------------------------------------------------
| Additional Recommendations
|--------------------------------------------------------------------------
*/
// 1. Untuk production, set $config['compress_output'] = TRUE;
// 2. Pastikan folder 'uploads' memiliki permission yang tepat
// 3. Enable error logging di production dengan threshold 1
// 4. Consider enabling CSRF protection
// 5. Untuk session security, pertimbangkan sess_match_ip = TRUE

/*
|--------------------------------------------------------------------------
| Cookie Settings
|--------------------------------------------------------------------------
*/
$config['cookie_prefix']    = '';
$config['cookie_domain']    = '';
$config['cookie_path']      = '/';
$config['cookie_secure']    = FALSE;
// REKOMENDASI: Jika menggunakan HTTPS, set TRUE
$config['cookie_httponly']  = FALSE;
// REKOMENDASI: Set TRUE untuk mencegah akses cookie via JavaScript

/*
|--------------------------------------------------------------------------
| Other Configurations  
|--------------------------------------------------------------------------
*/
$config['composer_autoload'] = FALSE; // Biarkan FALSE jika tidak menggunakan Composer
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-'; // Karakter yang diizinkan di URL - sudah baik
$config['enable_query_strings'] = FALSE; // Biarkan FALSE untuk SEO friendly URL