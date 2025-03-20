<?php
session_start();

if (!isset($_SESSION['id_cliente'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

$id_mascota = $_GET['id'] ?? null;

if (!$id_mascota) {
    header("Location: dashboard.php");
    exit();
}

// Conexión PDO
try {
    $sql = "SELECT * FROM mascotas WHERE id_mascota = $id_mascota";
    $result = $conn->query($sql);
    $datosMascota = $result->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

// POST para dates enviados desde un HTML
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $raza = $_POST['raza'];
    $edad = $_POST['edad'];

    try {
        $updateMascota = "UPDATE mascotas SET nombre = '$nombre', raza = '$raza', edad = '$edad' WHERE id_mascota = $id_mascota";
        $result = $conn->exec($updateMascota);

        if ($result) {
            header("Location: dashboard.php");
            exit();
        } else {
            $alerta = "Error. No se pudo actualizar.";
        }
    } catch (PDOException $e) {
        $alerta = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Mascota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container my-5">
        <h2>Editar Mascota</h2>

        <?php if (isset($alerta)) : ?>
            <div class="alert alert-danger">
                <?php echo $alerta; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nombre de la Mascota:</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo $datosMascota['nombre']; ?>" required> 
            </div>
            <div class="mb-3">
                <label class="form-label">Raza de la Mascota:</label>
                <input type="text" name="raza" class="form-control" value="<?php echo $datosMascota['raza']; ?>" required> 
            </div>
            <div class="mb-3">
                <label class="form-label">Edad de la Mascota:</label>
                <input type="text" name="edad" class="form-control" value="<?php echo $datosMascota['edad']; ?>" required> 
            </div>
            <button type="submit" class="btn btn-success">Guardar Actualización</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php $conn = null; ?>
