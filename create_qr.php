<?php
require_once "config.php";
include "phpqrcode/qrlib.php"; 

ob_start();

if (isset($_GET['id'])) {
    $id_select = (int)$_GET['id']; 

    try {
        $qr = "SELECT URL FROM urls WHERE id = :id";
        $stmt = $pdo->prepare($qr);
        $stmt->bindParam(":id", $id_select);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $url_a_codificar = $row ? $row['URL'] : "Error: ID $id_select no encontrado.";
            
        } else {
            $url_a_codificar = "Error: Fallo al ejecutar la consulta.";
        }
    } catch (PDOException $e) {
        $url_a_codificar = "Error de DB: " . $e->getMessage();
    }
} else {
    $url_a_codificar = "Selecciona un sitio web.";
}

ob_end_clean();
QRcode::png($url_a_codificar);
exit;
