<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| File ini memungkinkan Anda untuk memetakan ulang request URI ke 
| fungsi controller tertentu.
|
| Biasanya ada hubungan one-to-one antara string URL dan class/method
| controller yang sesuai. Segment dalam URL biasanya mengikuti pola:
|
|	example.com/class/method/id/
|
| Namun dalam beberapa kasus, Anda mungkin ingin memetakan ulang hubungan
| ini sehingga class/fungsi yang berbeda dipanggil dari yang sesuai
| dengan URL.
*/

/*
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
| Ada tiga route yang dicadangkan:
*/

// Controller default yang di-load ketika tidak ada data di URI
$route['default_controller'] = 'welcome';
// REKOMENDASI: Ganti dengan controller yang lebih deskriptif
// Contoh: 'home', 'dashboard', 'landing'

// Route untuk halaman manager - memetakan /manager ke controller manager/welcome
$route['manager'] = "manager/welcome";
// REKOMENDASI: Pastikan struktur folder controller 'manager' ada
// dan controller 'Welcome' berada di subfolder manager

// Controller untuk menangani halaman 404 (Page Not Found)
$route['404_override'] = '';
// REKOMENDASI: Buat custom 404 page untuk user experience yang better
// Contoh: $route['404_override'] = 'errors/error_404';

// Mengatur translasi dashes dalam URI
$route['translate_uri_dashes'] = FALSE;
// REKOMENDASI: Set TRUE jika ingin menggunakan hyphen dalam URL
// Contoh: my-controller/index akan diterjemahkan ke my_controller/index