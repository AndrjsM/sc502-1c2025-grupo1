<?php
//como estamos trabajando con BDD, entonces debemos hacer la conexion aqui
include('db.php');

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

// Perfil de Cliente
$infoCliente = "SELECT * FROM clientes WHERE id_cliente = $id_cliente"; //para guardar consultas como texto/string
$resultadoCliente = $conn->query($infoCliente);
$datosCliente = $resultadoCliente->fetch_assoc(); //para aceder a los datos del cliente

//mascotas 
$infoMascota = "SELECT * FROM mascotas WHERE id_cliente = $id_cliente";
$resultadoMascotas = $conn->query($infoMascota);
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
                    <p>Nombre: <?php echo $cliente['nombre']; ?></p>
                    <p>Email: <?php echo $cliente['correo']; ?></p>
                    <p>Teléfono: <?php echo $cliente['telefono']; ?></p>
                    <a href="editarPerfil.php" class="btn btn-warning">Editar Perfil</a>
                </div>
            </div>
        </section>

        <!-- Apartado Mascotas-->
        <section class="mb-5">
            <h2>Mascotas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Raza</th>
                        <th>Edad</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($infoMascota = $resultadoMascotas->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $infoMascota['nombre']; ?></td>
                            <td><?php echo $infoMascota['raza']; ?></td>
                            <td><?php echo $infoMascota['edad']; ?></td>
                            <td>
                                <a href="editarInfoMascota.php?id=<?php echo $infoMascota['id_mascota']; ?>"
                                    class="btn btn-info">Editar</a>
                                <a href="eliminarInfoMascota.php?id=<?php echo $infoMascota['id_mascota']; ?>"
                                    class="btn btn-danger"
                                    onclick="return confirmarEliminacion('<?php echo $infoMascota['nombre']; ?>')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
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
                    <?php while ($row = $resultadoCitas->fetch_assoc()): ?>
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
                    <?php while ($row = $resultadoFacturas->fetch_assoc()): ?>
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