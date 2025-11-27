<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| File ini menentukan sistem mana yang harus dimuat secara otomatis
|
| Untuk menjaga framework ringan, hanya resource minimal yang dimuat
| secara default. Contohnya, database tidak terhubung otomatis karena
| tidak ada asumsi apakah Anda akan menggunakannya. File ini memungkinkan
| Anda mendefinisikan sistem mana yang ingin dimuat di setiap request.
*/

/*
| -------------------------------------------------------------------
|  Auto-load Packages
| -------------------------------------------------------------------
| Package adalah library third-party yang dapat dimuat otomatis
|
| Prototype:
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
*/
$autoload['packages'] = array();
// REKOMENDASI: Jika menggunakan Composer, tambahkan path vendor
// $autoload['packages'] = array(APPPATH.'third_party', VENDORPATH);

/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| Library classes yang berada di system/libraries/ atau 
| application/libraries/
|
| REKOMENDASI: Hanya load library yang digunakan di semua controller
| Loading berlebihan akan mempengaruhi performa
*/
$autoload['libraries'] = array('session','database','access','template');

// ANALISIS KONFIGURASI SAAT INI:
// - 'session'    : Diperlukan untuk session management - OK
// - 'database'   : Koneksi database global - OK jika digunakan di semua halaman
// - 'access'     : Custom library (mungkin untuk authentication) - OK
// - 'template'   : Custom library (mungkin untuk templating) - OK

// REKOMENDASI: 
// 1. Jika tidak semua halaman butuh database, pindahkan ke controller tertentu
// 2. Pastikan library 'access' dan 'template' sudah ada di application/libraries/

/*
| -------------------------------------------------------------------
|  Auto-load Drivers
| -------------------------------------------------------------------
| Drivers classes yang extend CI_Driver_Library
| Contoh: cache, session, database drivers
*/
$autoload['drivers'] = array();
// REKOMENDASI: Jika menggunakan cache, tambahkan:
// $autoload['drivers'] = array('cache');

/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| File helper yang memberikan fungsi bantu
|
| REKOMENDASI: Load helper yang benar-benar digunakan di banyak tempat
*/
$autoload['helper'] = array('form','url','security');

// ANALISIS KONFIGURASI SAAT INI:
// - 'form'    : Helper untuk form - OK jika banyak form
// - 'url'     : Helper untuk URL - Sangat diperlukan - OK
// - 'security': Helper untuk security - Baik untuk keamanan - OK

// REKOMENDASI TAMBAHAN:
// 1. Untuk aplikasi dengan banyak string manipulation, tambahkan 'text'
// 2. Untuk file operations, tambahkan 'file'
// 3. Untuk number formatting, tambahkan 'number'

/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| File konfigurasi custom yang ingin dimuat otomatis
|
| NOTE: Hanya untuk config file custom
*/
$autoload['config'] = array();
// REKOMENDASI: Jika memiliki config custom, contoh:
// $autoload['config'] = array('app_config', 'email_config');

/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| File bahasa untuk internationalization
*/
$autoload['language'] = array();
// REKOMENDASI: Jika aplikasi multi-bahasa, tambahkan:
// $autoload['language'] = array('general', 'validation');

/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Models yang dimuat otomatis di semua controller
|
| REKOMENDASI: HINDARI loading model di sini kecuali benar-benar 
| digunakan di semua controller. Lebih baik load di controller tertentu.
*/
$autoload['model'] = array();
// KONFIGURASI SUDAH BAIK - tidak loading model secara global

/*
| -------------------------------------------------------------------
| REKOMENDASI UMUM
| -------------------------------------------------------------------
*/
// 1. PERFORMANCE: Jangan overload autoload dengan library/helper 
//    yang tidak digunakan di semua halaman

// 2. SECURITY: Helper 'security' sudah baik untuk XSS cleaning dll

// 3. MAINTENANCE: Struktur saat ini sudah cukup baik dan modular

// 4. CUSTOM LIBRARY: Pastikan library custom ('access', 'template') 
//    sudah didefinisikan dengan benar di application/libraries/

// 5. ERROR HANDLING: Jika ada error "Unable to load the requested class",
//    periksa penulisan nama library/helper (case sensitive)