<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $raza = $_POST['raza'];
    $edad = $_POST['edad'];

    if (isset($_SESSION['id_cliente'])) {
        $id_cliente = $_SESSION['id_cliente'];

    try {
        $query = "INSERT INTO mascotas (nombre, raza, edad, id_cliente) VALUES (:nombre, :raza, :edad, :id_cliente)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':raza', $raza);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':id_cliente', $id_cliente);

        if ($stmt->execute()) {
            echo "Tu mascota registrada con éxito.";
        } else {
            echo "Lo sentimos. Ha ocurrido un error al registrar la mascota.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Mascota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container my-5">
        <h2>Registrar Mascota</h2>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nombre de la Mascota:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Raza de la Mascota:</label>
                <input type="text" name="raza" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Edad de la Mascota en Meses:</label>
                <input type="number" name="edad" class="form-control" min="0" required>

            </div>
            <button type="submit" class="btn btn-warning text-dark">Registrar Mascota</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php $conn = null; ?>
