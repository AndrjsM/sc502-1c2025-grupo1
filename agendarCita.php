<?php
include('db.php');
session_start();

// Validación básica de sesión
if (!isset($_SESSION['cliente']['id_cliente'])) {
    header("Location: login.php");
    exit();
}

$id_cliente = $_SESSION['cliente']['id_cliente'];
error_log("ID Cliente: " . $id_cliente);

$aviso = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_mascota = $_POST['id_mascota'] ?? null;
    $fecha = $_POST['fecha'] ?? null;
    $hora = $_POST['hora'] ?? null;
    $servicio = $_POST['servicio'] ?? null;
    $veterinario = $_POST['veterinario'] ?? null;

    if ($id_mascota && $fecha && $hora && $servicio && $veterinario) {
        try {
            $sql = "INSERT INTO citas (id_cliente, id_mascota, fecha, hora, servicio, veterinario) 
                    VALUES (:id_cliente, :id_mascota, :fecha, :hora, :servicio, :veterinario)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(':id_mascota', $id_mascota, PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':hora', $hora);
            $stmt->bindParam(':servicio', $servicio);
            $stmt->bindParam(':veterinario', $veterinario);

            if ($stmt->execute()) {
                $aviso = "Cita agendada con éxito.";
            } else {
                $aviso = "Error. No se pudo agendar la cita.";
            }
        } catch (PDOException $e) {
            $aviso = "Error: " . $e->getMessage();
        }
    } else {
        $aviso = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agendar Cita</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container my-5">
<div class="text-center mb-4">
    <img src="https://okvet.co/wp-content/uploads/2020/06/que-es-una-veterinaria.jpg" 
         alt="Veterinaria" 
         class="img-fluid rounded shadow" 
         style="max-height: 250px; object-fit: cover;">
</div>

<h1 class="text-center" style="color: #ffc107;">Agendar Cita</h1>



    <?php if (!empty($aviso)) : ?>
        <div class="alert alert-info text-center">
            <?= htmlspecialchars($aviso) ?>
        </div>
    <?php endif; ?>

    <form action="agendarCita.php" method="POST">
        <!-- Mascotas -->
        <div class="mb-3">
            <label for="id_mascota" class="form-label">Selecciona la Mascota:</label>
            <select name="id_mascota" id="id_mascota" class="form-select" required>
                <option value="">-- Elige una mascota --</option>
                <?php
                try {
                    $query = "SELECT id_mascota, nombre FROM usuarios_tablas.mascotas WHERE id_cliente = :id_cliente";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
                    $stmt->execute();
                    $mascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($mascotas) {
                        foreach ($mascotas as $m) {
                            echo "<option value='" . htmlspecialchars($m['id_mascota']) . "'>" . htmlspecialchars($m['nombre']) . "</option>";
                        }
                    } else {
                        echo "<option disabled>No tienes mascotas registradas</option>";
                    }
                } catch (PDOException $e) {
                    echo "<option disabled>Error al cargar mascotas</option>";
                }
                ?>
            </select>
        </div>

        <!-- Fecha -->
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha:</label>
            <input type="date" name="fecha" id="fecha" class="form-control" required>
        </div>

        <!-- Hora -->
        <div class="mb-3">
            <label for="hora" class="form-label">Hora:</label>
            <select name="hora" id="hora" class="form-select" required>
                <?php
                for ($h = 8; $h <= 17; $h++) {
                    foreach (['00', '30'] as $min) {
                        $time = sprintf("%02d:%s", $h, $min);
                        echo "<option value='$time'>$time</option>";
                    }
                }
                ?>
            </select>
        </div>

        <!-- Servicios -->
        <div class="mb-3">
            <label for="servicios" class="form-label">Selecciona los Servicios:</label>
            <select name="servicios[]" id="servicios" class="form-select" multiple required>
                <?php
                $servicios = [
                    "Atención de Emergencia",
                    "Consulta Veterinaria",
                    "Vacunación",
                    "Cirugías & Procedimientos",
                    "Estética y Spa",
                    "Diagnóstico por Imágenes"
                ];
                foreach ($servicios as $serv) {
                    echo "<option value='" . htmlspecialchars($serv) . "'>" . htmlspecialchars($serv) . "</option>";
                }
                ?>
            </select>
        </div>

        <!-- Veterinarios -->
        <div class="mb-3">
            <label for="veterinario" class="form-label">Selecciona el Veterinario:</label>
            <select name="veterinario" id="veterinario" class="form-select" required>
                <?php
                try {
                    $query = "SELECT id_veterinario, nombre FROM usuarios_tablas.veterinarios";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $veterinarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($veterinarios as $v) {
                        echo "<option value='" . $v['id_veterinario'] . "'>" . htmlspecialchars($v['nombre']) . "</option>";
                    }
                } catch (PDOException $e) {
                    echo "<option disabled>Error al cargar veterinarios</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Agendar Cita</button>
        <a href="dashboard.php" class="btn btn-link mt-3">Volver al Dashboard</a>
    </form>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
    const fechaInput = document.getElementById('fecha');
    const hoy = new Date();
    fechaInput.min = hoy.toISOString().split('T')[0];

    fechaInput.addEventListener('change', () => {
        const dia = new Date(fechaInput.value).getDay();
        if (dia === 0 || dia === 6) {
            alert("Por favor selecciona un día entre lunes y viernes.");
            fechaInput.value = '';
        }
    });
</script>
</body>
</html>

<?php $conn = null; ?>
