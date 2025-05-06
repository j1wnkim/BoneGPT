<?php
try {
    $pdo = new PDO('pgsql:host=soc-sdp-27.soc.uconn.edu;dbname=bgptsample', 'laravel_user', 'temp');
    echo 'Connected to PostgreSQL!';
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
