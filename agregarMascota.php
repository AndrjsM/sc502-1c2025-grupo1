<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Mascota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container my-5">
        <h2>Registrar Mascota</h2>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nombre de la Mascota:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Raza de la Mascota:</label>
                <input type="text" name="raza" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Edad de la Mascota:</label>
                <input type="number" name="edad" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Mascota</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>