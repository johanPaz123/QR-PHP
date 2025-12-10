<?php


define('DB_HOST', getenv('DB_HOST'));
define('DB_PORT', getenv('DB_PORT') ?: 4000); 
define('DB_USERNAME', getenv('DB_USERNAME'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_NAME', getenv('DB_NAME') ?: 'Webs'); 
 
try {
    
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
    
} catch (PDOException $e) {
    $error_msg = "ERROR DE CONEXIÓN A TI DB: ";
    if (DB_HOST === false || DB_USERNAME === false || DB_PASSWORD === false) {
        $error_msg .= "Faltan Variables de Entorno. Asegúrate de que DB_HOST, DB_USER y DB_PASS estén configuradas en Vercel. ";
    }
    
    die($error_msg . $e->getMessage());
}
?>