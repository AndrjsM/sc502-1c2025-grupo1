<?php
include('db.php');
session_start();

if (!isset($_SESSION['id_cliente'])) {
    header("Location: login.php");
    exit();
}

$id_cliente = $_SESSION['id_cliente'];
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
    $infoMascota = "SELECT * FROM mascotas WHERE id_cliente = :id_cliente";
    $stmt = $conn->prepare($infoMascota);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->execute();
    $resultadoMascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .table-responsive {
            overflow-x: auto;
        }
        .section-title {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .btn-action {
            margin-right: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container my-5">
        <!-- Mensajes de éxito -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                Cita actualizada correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['cancelada'])): ?>
            <div class="alert alert-info alert-dismissible fade show">
                Cita cancelada correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h1 class="text-center mb-4">Bienvenido al Dashboard</h1>

        <!-- Apartado Clientes-->
        <section class="mb-5">
            <h2 class="section-title">Perfil del Cliente</h2>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($datosCliente['nombre']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($datosCliente['correo']); ?></p>
                            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($datosCliente['telefono']); ?></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="editarPerfil.php" class="btn btn-warning">Editar Perfil</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Apartado Mascotas-->
        <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="section-title">Mascotas</h2>
                <a href="agregarMascota.php" class="btn btn-primary">Agregar Mascota</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Raza</th>
                            <th>Edad (meses)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultadoMascotas as $infoMascota): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($infoMascota['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($infoMascota['raza']); ?></td>
                                <td><?php echo htmlspecialchars($infoMascota['edad']); ?></td>
                                <td>
                                    <a href="editarInfoMascota.php?id=<?php echo $infoMascota['id_mascota']; ?>" 
                                       class="btn btn-info btn-sm btn-action">Editar</a>
                                    <a href="eliminarInfoMascota.php?id=<?php echo $infoMascota['id_mascota']; ?>" 
                                       class="btn btn-danger btn-sm btn-action" 
                                       onclick="return confirmarEliminacion('<?php echo addslashes($infoMascota['nombre']); ?>')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Apartado de Citas-->
        <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="section-title">Citas Agendadas</h2>
                <a href="agendarCita.php" class="btn btn-primary">Agendar Nueva Cita</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
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
                        <?php foreach ($resultadoCitas as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_cita']); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre_mascota']); ?></td>
                                <td><?php echo htmlspecialchars($row['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($row['hora']); ?></td>
                                <td>
                                    <span class="badge 
                                        <?php echo $row['estado'] == 'Pendiente' ? 'bg-warning' : 
                                              ($row['estado'] == 'Completada' ? 'bg-success' : 'bg-secondary'); ?>">
                                        <?php echo htmlspecialchars($row['estado']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($row['estado'] == 'Pendiente'): ?>
                                        <a href="editarCita.php?id=<?php echo $row['id_cita']; ?>" 
                                           class="btn btn-warning btn-sm btn-action">Editar</a>
                                        <a href="cancelarCita.php?id=<?php echo $row['id_cita']; ?>" 
                                           class="btn btn-danger btn-sm btn-action">Cancelar</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Gestionar Facturas-->
        <section class="mb-5">
            <h2 class="section-title">Historial de Facturas</h2>
            
            <?php if (empty($resultadoFacturas)): ?>
                <div class="alert alert-info">
                    No hay facturas registradas.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
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
                                        <span class="badge 
                                            <?php echo $row['estado'] == 'Pagada' ? 'bg-success' : 'bg-warning'; ?>">
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