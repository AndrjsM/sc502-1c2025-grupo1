<?php
//como estamos trabajando con BDD, entonces debemos hacer la conexion aqui
include('includes/db.php');

session_start(); //se usa cuando ya se esta registrado
$id_cliente = $_SESSION['id_cliente'];

//Gestionar citas y facturas

$citasCliente = "SELECT * FROM citas 
              WHERE id_cliente = $id_cliente 
              ORDER BY fecha DESC";
$resultadoCitas = $conn->query($citasCliente);

$facturasCliente = "SELECT * FROM facturas 
              WHERE id_cita IN (SELECT id_cita 
              From citas WHERE id_cliente = $id_cliente)";
$resultadoFacturas = $conn->query($facturasCliente);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patitas al Rescate - Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <?php include 'header.php'; ?>

    <div class="container my-5">
        <h1 class="text-center">Bienvenido al Dashboard</h1>

        <!-- Apartado de Citas-->
        <section class="mb-5">
            <h2>Registro Citas Agendadas</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Cita</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th> <!--el estado de la cita-->
                    </tr>
                </thead>
                <tbody>
                <?php while($row = $resultadoCitas->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_cita']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo $row['hora']; ?></td>
                        <td><?php echo $row['estado']; ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <a href="agendarCita.php" class="btn btn-primary">Agendar Nueva Cita</a>
        </section>

        <!-- Gestionar Facturas-->
        <section class="mb-5">
            <h2>Historial de Facturas</h2>
            <table>
                    <thead>
                        <tr>
                            <th>ID Factura</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $resultadoFacturas->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id_factura']; ?></td>
                                <td><?php echo $row['monto']; ?></td>
                                <td><?php echo $row['fecha']; ?></td>
                                <td><?php echo $row['estado']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
            </table>
        </section>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>

<?php $conn->close(); ?>
