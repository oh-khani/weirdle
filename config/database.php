<?php
define('DB_HOST', 'db');
define('DB_NAME', 'weirdle');
define('DB_USER', 'weirdle');
define('DB_PASSWORD', 'weirdle');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
