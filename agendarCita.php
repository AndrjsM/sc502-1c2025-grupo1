<?php
//include('db.php');
session_start();

// cliente está autenticado
if (!isset($_SESSION['id_cliente'])) {
    header("Location: login.php"); // volver al login si no está autenticado
    exit();
}

$id_cliente = $_SESSION['id_cliente'];

$alerta = "";

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['id_mascota'], $_POST['fecha'], $_POST['hora'])) {
        $id_mascota = $_POST['id_mascota'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];

        
        if (empty($id_mascota) || empty($fecha) || empty($hora)) {
            $alerta = "Por favor, completa todos los campos.";
        } else {
            

            $stmt = $conn->prepare("INSERT INTO citas (id_cliente, id_mascota, fecha, hora) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $id_cliente, $id_mascota, $fecha, $hora);

            if ($stmt->execute()) {
                $alerta = "Cita agendada con éxito.";
            } else {
                $alerta = "Error al agendar la cita: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        $alerta = "Datos del formulario incompletos.";
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

        <!-- Alerta -->
        <?php if (!empty($alerta)) : ?>
            <div class="alert <?php echo strpos($alerta, 'éxito') !== false ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $alerta; ?>
            </div>
        <?php endif; ?>

        <!-- Agendar cita -->
        <form action="agendarCitas.php" method="POST">
            <div class="mb-3">
                <label for="id_mascota" class="form-label">Selecciona la Mascota:</label>
                <select name="id_mascota" id="id_mascota" class="form-select" required>
                    <option value="" disabled selected>Selecciona una mascota</option>
                    <?php

                    // Mascotas del cliente
                    $query = "SELECT id_mascota, nombre FROM mascotas WHERE id_cliente = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $id_cliente);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_mascota'] . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                    }

                    $stmt->close();
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="hora" class="form-label">Hora:</label>
                <input type="time" name="hora" id="hora" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Agendar Cita</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
