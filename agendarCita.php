<?php
include('db.php');
session_start();
$id_cliente = $_SESSION['id_cliente'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id_mascota = $_POST['id_mascota'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    try {
        $agendar = "INSERT INTO citas (id_cliente, id_mascota, fecha, hora) VALUES (:id_cliente, :id_mascota, :fecha, :hora)";
        $stmt = $conn->prepare($agendar);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_mascota', $id_mascota);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);

        if ($stmt->execute()) {
            $aviso = "Cita agendada con éxito.";
        } else {
            $aviso = "Error. No se agendó la cita.";
        }
    } catch (PDOException $e) {
        $aviso = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container my-5">
        <h1 class="text-center">Agendar Cita</h1>

        <form action="agendarCitas.php" method="POST">
            <div class="mb-3">
                <label for="id_mascota" class="form-label">Selecciona la Mascota: </label>
                <select name="id_mascota" id="id_mascota" class="form-select">
                    <?php
                    try {
                        $mascotasCliente = "SELECT * FROM mascotas WHERE id_cliente = :id_cliente";
                        $stmt = $conn->prepare($mascotasCliente);
                        $stmt->bindParam(':id_cliente', $id_cliente);
                        $stmt->execute();
                        $resultadoMascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($resultadoMascotas as $row) {
                            echo "<option value='".$row['id_mascota']."'>".$row['nombre']."</option>";
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="hora" class="form-label">Hora:</label>
                <input type="time" name="hora" id="hora" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Agendar Cita</button>
        </form>
        <a href="dashboard.php" class="btn btn-link mt-3">Volver al Dashboard</a>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>

<?php $conn = null; ?>
