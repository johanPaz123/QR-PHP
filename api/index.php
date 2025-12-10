<?php
require_once "config.php";

$qr_source = "";

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_select = $_GET['id'];
    $qr_source = "create_qr.php?id=" . urlencode($id_select);
}

if (empty($qr_source)) {
    
    try {
        $stmt_default = $pdo->query("SELECT ID FROM urls LIMIT 1");
        $default_id = $stmt_default->fetchColumn();
        if ($default_id) {
             $qr_source = "create_qr.php?id=" . urlencode($default_id);
        } else {
            $qr_source = "create_qr.php?id=0"; 
        }
    } catch (Exception $e) {
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
           
            $query = "SELECT ID, Nombre_Sitio FROM urls ORDER BY Nombre_Sitio";

            if ($result = $pdo->query($query)) {
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch()) {
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