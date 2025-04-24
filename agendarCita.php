<?php
include('db.php');
session_start();
$id_cliente = $_SESSION['cliente']['id_cliente'];
error_log("ID Cliente: " . $id_cliente);

// Preload data for the form
$mascotas = [];
$veterinarios = [];
$servicios = [];

try {
    // Fetch mascotas
    $infoMascota = "SELECT id_mascota, nombre FROM usuarios_tablas.mascotas WHERE id_cliente = :id_cliente";
    $stmt = $conn->prepare($infoMascota);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->execute();
    $mascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Mascotas: " . print_r($mascotas, true));
} catch (PDOException $e) {
    error_log("Error al cargar mascotas: " . $e->getMessage());
}

try {
    // Fetch veterinarios
    $queryVeterinarios = "SELECT ID_VETERINARIO, NOMBRE FROM usuarios_tablas.veterinarios";
    $stmt = $conn->prepare($queryVeterinarios);
    $stmt->execute();
    $veterinarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Veterinarios: " . print_r($veterinarios, true));
} catch (PDOException $e) {
    error_log("Error al cargar veterinarios: " . $e->getMessage());
}

// Fetch services before rendering the form
try {
    $queryServicios = "SELECT ID_SERVICIO, NOMBRE_SERVICIO, DURACION_MINUTOS FROM servicios_tablas.servicios";
    $stmt = $conn->prepare($queryServicios);
    $stmt->execute();
    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Log the fetched services for debugging
    error_log("Servicios disponibles: " . print_r($servicios, true));
} catch (PDOException $e) {
    error_log("Error al cargar servicios: " . $e->getMessage());
    $servicios = [];
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
                if (empty($mascotas)) {
                    echo "<option value=''>No tienes mascotas registradas</option>";
                } else {
                    foreach ($mascotas as $mascota) {
                        echo "<option value='" . $mascota['ID_MASCOTA'] . "'>" . htmlspecialchars($mascota['NOMBRE']) . "</option>";
                    }
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
            <label for="servicios" class="form-label">Selecciona los Servicios:</label>
            <select name="servicios[]" id="servicios" class="form-select" multiple required>
                <?php
                if (!empty($servicios)) {
                    foreach ($servicios as $servicio) {
                        echo "<option value='" . htmlspecialchars($servicio['ID_SERVICIO']) . "'>" . htmlspecialchars($servicio['NOMBRE_SERVICIO']) . " (" . htmlspecialchars($servicio['DURACION_MINUTOS']) . " horas)</option>";
                    }
                } else {
                    echo "<option value=''>No hay servicios disponibles</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="veterinario" class="form-label">Selecciona el Veterinario:</label>
            <select name="veterinario" id="veterinario" class="form-select" required>
                <?php
                foreach ($veterinarios as $veterinario) {
                    echo "<option value='" . $veterinario['ID_VETERINARIO'] . "'>" . htmlspecialchars($veterinario['NOMBRE']) . "</option>";
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
