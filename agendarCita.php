<?php
include('db.php');
session_start();
$id_cliente = $_SESSION['cliente']['id_cliente'];
error_log("ID Cliente: " . $id_cliente);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id_mascota = $_POST['id_mascota'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $servicio = $_POST['servicio'];
    $veterinario = $_POST['veterinario'];

    try {
        $agendar = "INSERT INTO citas (id_cliente, id_mascota, fecha, hora, servicio, veterinario) VALUES (:id_cliente, :id_mascota, :fecha, :hora, :servicio, :veterinario)";
        $stmt = $conn->prepare($agendar);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->bindParam(':id_mascota', $id_mascota, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':servicio', $servicio);
        $stmt->bindParam(':veterinario', $veterinario);

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

    <?php if (isset($aviso)) : ?>
        <div class="alert alert-info text-center">
            <?= htmlspecialchars($aviso) ?>
        </div>
    <?php endif; ?>

    <form action="agendarCita.php" method="POST">
        <div class="mb-3">
            <label for="id_mascota" class="form-label">Selecciona la Mascota:</label>
            <select name="id_mascota" id="id_mascota" class="form-select" required>
                <?php
                try {
                    $infoMascota = "SELECT
                        m.id_mascota AS ID_Mascota,
                        m.nombre AS Nombre_Mascota,
                        m.especie AS Especie,
                        m.raza AS Raza,
                        m.meses AS Meses,
                        c.nombre AS Nombre_Cliente,
                        c.apellido AS Apellido_Cliente
                    FROM
                        usuarios_tablas.mascotas m
                    JOIN
                        usuarios_tablas.clientes c
                    ON
                        m.id_cliente = c.id_cliente
                    WHERE
                        m.id_cliente = :id_cliente";
                    $stmt = $conn->prepare($infoMascota);
                    $stmt->bindParam(':id_cliente', $id_cliente);
                    $stmt->execute();
                    $resultadoMascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($resultadoMascotas)) {
                        echo "<option value=''>No tienes mascotas registradas</option>";
                    } else {
                        foreach ($resultadoMascotas as $mascota) {
                            echo "<option value='" . $mascota['ID_Mascota'] . "'>" . htmlspecialchars($mascota['Nombre_Mascota']) . "</option>";
                        }
                    }
                } catch (PDOException $e) {
                    echo "<option value=''>Error al cargar mascotas</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha:</label>
            <input type="date" name="fecha" id="fecha" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="hora" class="form-label">Hora:</label>
            <input type="time" name="hora" id="hora" class="form-control" required min="08:00" max="17:00">
        </div>

        <div class="mb-3">
            <label for="servicio" class="form-label">Selecciona el Servicio:</label>
            <select name="servicio" id="servicio" class="form-select" required>
                <?php
                $servicios = ["Consulta General", "Vacunación", "Desparasitación", "Cirugía", "Baño y Corte"];
                foreach ($servicios as $serv) {
                    echo "<option value='" . htmlspecialchars($serv) . "'>" . htmlspecialchars($serv) . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="veterinario" class="form-label">Selecciona el Veterinario:</label>
            <select name="veterinario" id="veterinario" class="form-select" required>
                <?php
                try {
                    $queryVeterinarios = "SELECT id_veterinario, nombre FROM usuarios_tablas.veterinarios";
                    $stmt = $conn->prepare($queryVeterinarios);
                    $stmt->execute();
                    $veterinarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($veterinarios as $veterinario) {
                        echo "<option value='" . $veterinario['id_veterinario'] . "'>" . htmlspecialchars($veterinario['nombre']) . "</option>";
                    }
                } catch (PDOException $e) {
                    echo "<option value=''>Error al cargar veterinarios</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Agendar Cita</button>
    </form>

    <a href="dashboard.php" class="btn btn-link mt-3">Volver al Dashboard</a>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
    const dateInput = document.getElementById('fecha');
    const today = new Date();
    dateInput.min = today.toISOString().split('T')[0];

    dateInput.addEventListener('input', function () {
        const selectedDate = new Date(this.value);
        const selectedDay = selectedDate.getDay();
        if (selectedDay === 0 || selectedDay === 6) {
            alert('Por favor selecciona un día entre lunes y viernes.');
            this.value = '';
        }
    });
</script>
</body>
</html>

<?php $conn = null; ?>
