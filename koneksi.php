<?php
// Matikan pelaporan error mentah mysqli agar kredensial tidak bocor
mysqli_report(MYSQLI_REPORT_OFF);

// Otomatis baca berkas .env jika tersedia di server hosting
$env_file = __DIR__ . '/.env';
if (file_exists($env_file)) {
    $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || str_starts_with($line, '#')) {
            continue;
        }
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            if (!isset($_SERVER[$name]) && !isset($_ENV[$name])) {
                putenv("{$name}={$value}");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
$db_name = getenv('DB_NAME') ?: 'db_arsip';

$koneksi = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$koneksi) {
    error_log("Database Connection Error: " . mysqli_connect_error());
    die("Terjadi gangguan koneksi ke basis data. Silakan hubungi administrator sistem.");
}

// Pastikan charset UTF-8 mb4
mysqli_set_charset($koneksi, "utf8mb4");
?>