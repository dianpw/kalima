<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| File ini berisi pengaturan yang diperlukan untuk mengakses database.
*/

// GROUP DATABASE YANG AKTIF
$active_group = 'default'; // Group database yang digunakan - OK untuk single database
$query_builder = TRUE; // Mengaktifkan Query Builder - OK

$db['default'] = array(
	'dsn'	=> '',
	// REKOMENDASI KEAMANAN: Gunakan environment variables untuk hostname
	'hostname' => '10.100.14.240', // IP database server
	// REKOMENDASI: Simpan credentials di environment file (.env)
	'username' => 'ujian', // Username database
	'password' => '1q2w3e4r', // Password database - PERINGATAN: Hardcoded password!
	'database' => 'kalima', // Nama database
	'dbdriver' => 'mysqli', // Driver database - OK (mysqli lebih aman dari mysql)
	'dbprefix' => '', // Prefix table - kosong OK
	'pconnect' => FALSE, // Persistent connection - FALSE baik untuk stabilitas
	
	// REKOMENDASI: Setting debug berdasarkan environment
	'db_debug' => (ENVIRONMENT !== 'production'),
	// Penjelasan: 
	// - Di development: TRUE (tampilkan error database)
	// - Di production: FALSE (sembunyikan error database)
	
	'cache_on' => FALSE, // Query caching - FALSE OK
	'cachedir' => '', // Directory cache - kosong OK
	'char_set' => 'utf8', // Character set
	// REKOMENDASI: Gunakan utf8mb4 untuk support emoji dan karakter lengkap
	// 'char_set' => 'utf8mb4',
	
	'dbcollat' => 'utf8_general_ci', // Collation
	// REKOMENDASI: Untuk utf8mb4, gunakan:
	// 'dbcollat' => 'utf8mb4_unicode_ci',
	
	'swap_pre' => '', // Swap prefix - kosong OK
	'encrypt' => FALSE, // Enkripsi koneksi - FALSE OK untuk LAN
	// REKOMENDASI: Untuk production external database, set TRUE dengan SSL
	
	'compress' => FALSE, // Kompresi client - FALSE OK
	'stricton' => FALSE, // Strict mode - FALSE OK
	// REKOMENDASI: Untuk development, set TRUE untuk strict SQL checking
	
	'failover' => array(), // Failover connections - kosong OK
	// REKOMENDASI: Untuk high availability, setup failover server
	
	'save_queries' => TRUE // Save queries untuk debugging - TRUE baik untuk development
	// REKOMENDASI: Di production set FALSE untuk menghemat memory
);