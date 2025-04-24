<?php
include('db.php');
session_start();

// Verificar si el cliente está en la sesión
if (!isset($_SESSION['cliente']['id_cliente'])) {
    header("Location: login.php");
    exit();
}

$id_cliente = $_SESSION['cliente']['id_cliente'];
error_log("ID Cliente: " . $id_cliente); // Para depuración
// Gestionar citas y facturas
try {
    // Comentando la consulta de citas
    /*
    $citasCliente = "SELECT c.*, m.nombre as nombre_mascota 
                    FROM citas c 
                    JOIN mascotas m ON c.id_mascota = m.id_mascota 
                    WHERE c.id_cliente = :id_cliente 
                    ORDER BY c.fecha DESC";
    $stmt = $conn->prepare($citasCliente);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->execute();
    $resultadoCitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    */
    $resultadoCitas = []; // Mensaje de vacío

    // Comentando la consulta de facturas
    /*
    $facturasCliente = "SELECT * FROM facturas 
                       WHERE id_cita IN (SELECT id_cita FROM citas WHERE id_cliente = :id_cliente)";
    $stmt = $conn->prepare($facturasCliente);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->execute();
    $resultadoFacturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    */
    $resultadoFacturas = []; // Mensaje de vacío

    // Perfil de Cliente
    /*
    $infoCliente = "SELECT * FROM clientes WHERE id_cliente = :id_cliente";
    $stmt = $conn->prepare($infoCliente);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->execute();
    $resultadoCliente = $stmt->fetch(PDO::FETCH_ASSOC);
    $datosCliente = $resultadoCliente;
    */
    $datosCliente = $_SESSION; // Datos del cliente desde la sesión
    error_log("Datos del cliente: " . print_r($datosCliente, true)); // Para depuración

    // Mascotas
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

    // Agregar un error_log para verificar el contenido de $resultadoMascotas
    error_log('Contenido de resultadoMascotas: ' . print_r($resultadoMascotas, true));

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patitas al Rescate - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .alert {
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1 class="text-center mb-4">Bienvenido al Dashboard</h1>

        <!-- Perfil del Cliente -->
        <section class="mb-5">
            <h2 class="section-title">Perfil del Cliente</h2>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            $cliente = $datosCliente['cliente'];
                            ?>
                            <p><strong>ID Cliente:</strong> <?php echo htmlspecialchars($cliente['id_cliente']); ?></p>
                            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($cliente['nombre']); ?></p>
                            <p><strong>Apellido:</strong> <?php echo htmlspecialchars($cliente['apellido']); ?></p>
                            <p><strong>Correo:</strong> <?php echo htmlspecialchars($cliente['correo']); ?></p>
                            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($cliente['telefono']); ?></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="editarPerfil.php" class="btn btn-primary">Editar Perfil</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mascotas -->
        <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center my-2">
                <h2 class="section-title">Mascotas</h2>
                <a href="agregarMascota.php" class="btn btn-primary">Agregar Mascota</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Raza</th>
                            <th>Edad (meses)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($resultadoMascotas)): ?>
                            <tr>
                                <td colspan="4" class="text-center">
                                    <div class="alert alert-info">No hay mascotas asociadas. Por favor registre sus mascotas.</div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($resultadoMascotas as $mascota): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($mascota['NOMBRE_MASCOTA'] ?? 'No disponible'); ?></td>
                                    <td><?php echo htmlspecialchars($mascota['RAZA'] ?? 'No disponible'); ?></td>
                                    <td><?php echo htmlspecialchars($mascota['MESES'] ?? 'No disponible'); ?></td>
                                    <td>
                                        <a href="editarMascota.php?id=<?php echo $mascota['ID_MASCOTA'] ?? ''; ?>" class="btn btn-info btn-sm">Editar</a>
                                        <a href="eliminarMascota.php?id=<?php echo $mascota['ID_MASCOTA'] ?? ''; ?>" class="btn btn-danger btn-sm" onclick="return confirmarEliminacion('<?php echo addslashes($mascota['NOMBRE_MASCOTA'] ?? ''); ?>')">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Citas -->
        <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center my-2">
                <h2 class="section-title">Citas Agendadas</h2>
                <a href="agendarCita.php" class="btn btn-primary">Agendar Nueva Cita</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mascota</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($resultadoCitas)): ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="alert alert-info">No hay citas agendadas. Por favor agende una cita.</div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($resultadoCitas as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id_cita']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre_mascota']); ?></td>
                                    <td><?php echo htmlspecialchars($row['fecha']); ?></td>
                                    <td><?php echo htmlspecialchars($row['hora']); ?></td>
                                    <td>
                                        <span class="badge <?php echo $row['estado'] == 'Pendiente' ? 'bg-warning' : ($row['estado'] == 'Completada' ? 'bg-success' : 'bg-secondary'); ?>">
                                            <?php echo htmlspecialchars($row['estado']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($row['estado'] == 'Pendiente'): ?>
                                            <a href="editarCita.php?id=<?php echo $row['id_cita']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                            <a href="cancelarCita.php?id=<?php echo $row['id_cita']; ?>" class="btn btn-danger btn-sm">Cancelar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Facturas -->
        <section class="mb-5">
            <h2 class="section-title">Historial de Facturas</h2>
            <?php if (empty($resultadoFacturas)): ?>
                <div class="alert alert-info">
                    No hay facturas registradas.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Factura</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultadoFacturas as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id_factura']); ?></td>
                                    <td>₡<?php echo number_format(htmlspecialchars($row['monto']), 2); ?></td>
                                    <td><?php echo htmlspecialchars($row['fecha']); ?></td>
                                    <td>
                                        <span class="badge <?php echo $row['estado'] == 'Pagada' ? 'bg-success' : 'bg-warning'; ?>">
                                            <?php echo htmlspecialchars($row['estado']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarEliminacion(nombre) {
            return confirm("¿Estás seguro de que quieres eliminar a " + nombre + "? Esta acción no se puede deshacer.");
        }
    </script>
</body>

</html>

<?php $conn = null; ?>