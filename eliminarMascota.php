<?php 
session_start();

if(!$_SESSION['id_cliente']){
    header("Location: login.php");
    exit();
}

include('includes/db.php');

$id_mascota = $_GET['id'];

if(!$id_mascota){
    header("Location: dashboard.php");
    exit();
}

//eliminar mascota del ddb: db.php
$eliminarMascota = "DELETE FROM mascotas WHERE id_mascota = $id_mascota";

if($conn->query($eliminarMascota) === TRUE){
    header("Location: dashboard.php");
    exit();
}else{
    $alerta = "Error. No se pudo eliminar la mascota: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Mascota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container my-5">
        <h2>Eliminar Mascota</h2>

        <?php if ($alerta) : ?>
            <div class="alert alert-danger">
                <?php echo $alerta; ?>
            </div>
        <?php endif; ?>

        <p>¿Realmente quieres eliminar esta mascota? Es una acción irreversible.</p>

        <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>
