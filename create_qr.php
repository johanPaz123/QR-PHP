<?php
require_once "config.php";
// Asegúrate de que la ruta a tu librería esté correcta:
include "phpqrcode/qrlib.php"; 

// Evita que el output se envíe al navegador antes de que el PNG se genere
ob_start();

$url_a_codificar = "Error: ID no válido.";

if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
    $id_select = (int)$_GET['id']; 

    try {
        // Consulta preparada para obtener la URL
        $qr_sql = "SELECT URL FROM urls WHERE id = :id";
        $stmt = $pdo->prepare($qr_sql);
        $stmt->bindParam(":id", $id_select, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si se encuentra la fila, usa la URL; si no, marca error.
            if ($row) {
                $url_a_codificar = $row['URL'];
            } else {
                $url_a_codificar = "Error: ID $id_select no encontrado en la base de datos.";
            }
            
        } else {
            $url_a_codificar = "Error: Fallo al ejecutar la consulta SQL.";
        }
    } catch (PDOException $e) {
        // Captura errores de conexión o SQL
        $url_a_codificar = "Error de DB: " . $e->getMessage();
    }
} else {
    // Mensaje por defecto si no se pasó un ID o si el ID es 0 (usado en index.php)
    $url_a_codificar = "Selecciona un sitio web o la base de datos está vacía.";
}

// Limpia el búfer y genera la imagen PNG
ob_end_clean();
QRcode::png($url_a_codificar);
exit;