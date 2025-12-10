<?php
/*
|--------------------------------------------------------------------------
| CONFIGURACIÓN DE BASE DE DATOS PARA VERCEL Y TiDB CLOUD
|--------------------------------------------------------------------------
| Este archivo lee las credenciales de las Variables de Entorno de Vercel.
*/

// 1. Leer las variables de entorno.
// Asegúrate de que estos nombres coincidan con los que configuraste en el panel de Vercel.
define('HOST', getenv('HOST'));
define('PORT', getenv('PORT') ?: 4000); // 4000 es el puerto estándar de TiDB
define('USERNAME', getenv('USER'));
define('PASSWORD', getenv('PASS'));
define('NAME', getenv('NAME') ?: 'Webs'); // 'test' es el nombre de DB por defecto en TiDB
 
/* 2. Intento de conexión a la base de datos usando PDO */
try {
    // Data Source Name (DSN) para TiDB (usa el driver 'mysql')
    $dsn = "mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . NAME . ";charset=utf8mb4";
    
    // Opciones de PDO: crucial para manejo de errores y compatibilidad
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanzar excepciones en caso de error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devolver resultados como array asociativo
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, USERNAME, PASSWORD, $options);
    
} catch (PDOException $e) {
    // Mensaje de error detallado para ayudar a la depuración en Vercel
    $error_msg = "ERROR DE CONEXIÓN A TI DB: ";
    if (HOST === false || USERNAME === false || PASSWORD === false) {
        $error_msg .= "Faltan Variables de Entorno. Asegúrate de que DB_HOST, DB_USER y DB_PASS estén configuradas en Vercel. ";
    }
    
    die($error_msg . $e->getMessage());
}
?>