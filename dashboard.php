<?php
include('db.php');
session_start();
$id_cliente = $_SESSION['id_cliente'];



// Gestionar citas y facturas
try {
    $citasCliente = "SELECT * FROM citas WHERE id_cliente = :id_cliente ORDER BY fecha DESC";
    $stmt = $conn->prepare($citasCliente);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->execute();
    $resultadoCitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $facturasCliente = "SELECT * FROM facturas WHERE id_cita IN (SELECT id_cita FROM citas WHERE id_cliente = :id_cliente)";
    $stmt = $conn->prepare($facturasCliente);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->execute();
    $resultadoFacturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Perfil de Cliente
    $infoCliente = "SELECT * FROM clientes WHERE id_cliente = :id_cliente";
    $stmt = $conn->prepare($infoCliente);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->execute();
    $resultadoCliente = $stmt->fetch(PDO::FETCH_ASSOC);
    $datosCliente = $resultadoCliente;

    // Mascotas
    $infoMascota = "SELECT * FROM mascotas WHERE id_cliente = :id_cliente";
    $stmt = $conn->prepare($infoMascota);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->execute();
    $resultadoMascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patitas al Rescate - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="container my-5">
        <h1 class="text-center">Bienvenido al Dashboard</h1>

        <!-- Apartado Clientes-->
        <section class="mb-5">
            <h2>Perfil del Cliente</h2>
            <div class="card">
                <div class="card-body">
                    <p>Nombre: <?php echo $datosCliente['nombre']; ?></p>
                    <p>Email: <?php echo $datosCliente['correo']; ?></p>
                    <p>Teléfono: <?php echo $datosCliente['telefono']; ?></p>
                    <a href="editarPerfil.php" class="btn btn-warning">Editar Perfil</a>
                </div>
            </div>
        </section>

        <!-- Apartado Mascotas-->
        <section class="mb-5">
            <h2>Mascotas</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Raza</th>
                        <th>Edad</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultadoMascotas as $infoMascota): ?>
                        <tr>
                            <td><?php echo $infoMascota['nombre']; ?></td>
                            <td><?php echo $infoMascota['raza']; ?></td>
                            <td><?php echo $infoMascota['edad']; ?></td>
                            <td>
                                <a href="editarInfoMascota.php?id=<?php echo $infoMascota['id_mascota']; ?>" class="btn btn-info">Editar</a>
                                <a href="eliminarInfoMascota.php?id=<?php echo $infoMascota['id_mascota']; ?>" class="btn btn-danger" onclick="return confirmarEliminacion('<?php echo $infoMascota['nombre']; ?>')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <script>
                function confirmarEliminacion(nombre) {
                    return confirm("¿Estás seguro de que quieres eliminar a " + nombre + "?");
                }
            </script>
            <a href="agregarMascota.php" class="btn btn-primary">Agregar Mascota</a>
        </section>

        <!-- Apartado de Citas-->
        <section class="mb-5">
            <h2>Registro Citas Agendadas</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Cita</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultadoCitas as $row): ?>
                        <tr>
                            <td><?php echo $row['id_cita']; ?></td>
                            <td><?php echo $row['fecha']; ?></td>
                            <td><?php echo $row['hora']; ?></td>
                            <td><?php echo $row['estado']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="agendarCita.php" class="btn btn-primary">Agendar Nueva Cita</a>
        </section>

        <!-- Gestionar Facturas-->
        <section class="mb-5">
            <h2>Historial de Facturas</h2>
            <table class="table">
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
                            <td><?php echo $row['id_factura']; ?></td>
                            <td><?php echo $row['monto']; ?></td>
                            <td><?php echo $row['fecha']; ?></td>
                            <td><?php echo $row['estado']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>

    <?php include 'footer.php'; ?>

</body>

</html>

<?php $conn = null; ?>
