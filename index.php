<?php
require_once "config.php";

$qr_source = "";

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_select = $_GET['id'];

    $qr_source = "create_qr.php?id=" . urlencode($id_select);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codigos QR</title>
</head>

<body>
    <h2>QR Pagina https://cifpcarballeira.com/moodle</h2>
    <img src="qr1.php" alt="Codigo QR">
    <hr>
    <h2>Paginas Web</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
        <select name="id">
            <?php
            $query = "SELECT * FROM urls";

            if ($result = $pdo->query($query)) {
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch()) {
                        echo '<option value="' . $row['ID'] . '">' . htmlspecialchars($row['Nombre_Sitio']) . '</option>';
                    }
                } else {
                    echo '<option>Sin resultados</option>';
                }
                unset($result);
            }
            ?>
        </select>
        <input type="submit" value="GenerarQR">
    </form>

    <h3>Codigo QR Seleccionado</h3>
    <img src="<?php echo htmlspecialchars($qr_source)?>" alt="Codigo qr">
</body>

</html>