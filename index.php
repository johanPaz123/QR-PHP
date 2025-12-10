<?php
require_once "config.php";

$qr_source = "";

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_select = $_GET['id'];

    // La URL de la imagen QR generada
    $qr_source = "create_qr.php?id=" . urlencode($id_select);
}

// Opcional: Define una URL por defecto si no se ha seleccionado nada aún
if (empty($qr_source)) {
    // Puedes seleccionar el primer ID de la base de datos para mostrar un QR inicial
    try {
        $stmt_default = $pdo->query("SELECT ID FROM urls LIMIT 1");
        $default_id = $stmt_default->fetchColumn();
        if ($default_id) {
             $qr_source = "create_qr.php?id=" . urlencode($default_id);
        } else {
             // Si no hay datos, muestra un QR de error o texto por defecto
             $qr_source = "create_qr.php?id=0"; // Usaremos ID 0 para un error controlado
        }
    } catch (Exception $e) {
        // En caso de error de DB, muestra una imagen genérica
        $qr_source = "create_qr.php?id=0"; 
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Códigos QR</title>
</head>

<body>
    <h2>Código QR de la selección actual</h2>
    <img src="<?php echo htmlspecialchars($qr_source) ?>" alt="Codigo QR">
    <hr>
    
    <h2>Seleccionar Página Web</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
        <select name="id">
            <?php
            // La consulta SQL sigue siendo la misma
            $query = "SELECT ID, Nombre_Sitio FROM urls ORDER BY Nombre_Sitio";

            if ($result = $pdo->query($query)) {
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch()) {
                        // Compara si el ID seleccionado coincide para marcar la opción como 'selected'
                        $selected = (isset($id_select) && $id_select == $row['ID']) ? 'selected' : '';
                        echo '<option value="' . $row['ID'] . '" ' . $selected . '>' . htmlspecialchars($row['Nombre_Sitio']) . '</option>';
                    }
                } else {
                    echo '<option value="0">Sin resultados</option>';
                }
                unset($result);
            } else {
                echo '<option value="0">Error al consultar DB</option>';
            }
            ?>
        </select>
        <input type="submit" value="GenerarQR">
    </form>
</body>

</html>