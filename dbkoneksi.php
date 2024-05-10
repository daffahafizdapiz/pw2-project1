<?php
// Konfigurasi database
$host = 'localhost'; // Ganti sesuai dengan host Anda
$dbname = 'dbpuskesmas'; // Ganti dengan nama database Anda
$user = 'root'; // Ganti dengan nama pengguna database Anda
$pass = ''; // Ganti dengan kata sandi database Anda

// Buat koneksi Database
$dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
?>
