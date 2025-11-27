<?php
// network_check.php
session_start();

if ($_POST['network_check']) {
    // Simpan status jaringan terbaru
    $_SESSION['network_status'] = $_POST['status'];
    echo 'OK';
    exit;
}
?>