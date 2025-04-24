<?php
// Verificar si la sesión ya está activa antes de iniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el cliente está logueado
$clienteLogueado = isset($_SESSION['cliente']['id_cliente']);
error_log("Cliente logueado: " . ($clienteLogueado ? 'Sí' : 'No'));
$nombre = isset($_SESSION['cliente']['nombre']) ? $_SESSION['cliente']['nombre'] : 'Usuario';
error_log("Nombre del cliente: " . $nombre);
?>

<header>
    <nav class="navbar navbar-expand-lg" aria-label="Eighth navbar example">
        <div class="container d-flex align-items-center">
            <div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand ms-2" href="home.php">
                    <!-- <img src="logo.png" alt="Logo" style="width: 30px; height: 30px;"> -->
                    Patitas al rescate
                </a>
            </div>

            <div class="col-md-3 text-end d-lg-none">
                <?php if ($clienteLogueado): ?>
                    <div class="dropdown text-end">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars($nombre); ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="dashboard.php">Ir al Dashboard</a></li>
                            <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" type="button" class="btn btn-outline-primary">Iniciar sesión</a>
                    <a href="registro.php" type="button" class="btn btn-secondary ms-2">Registrarse</a>
                <?php endif; ?>
            </div>

            <div class="collapse navbar-collapse" id="navbarsExample07">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="servicios.php">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ubicacion.php">Ubicacion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contactenos.php">Contactenos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="agregarMascota.php">Agregar Mascota</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="agendarCita.php">Agendar Cita</a>
                    </li>
                </ul>

                <div class="col-md-3 text-end d-none d-lg-block">
                    <?php if ($clienteLogueado): ?>
                        <div class="dropdown text-end">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo htmlspecialchars($nombre); ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="dashboard.php">Ir al Dashboard</a></li>
                                <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="login.php" type="button" class="btn btn-outline-primary">Iniciar sesión</a>
                        <a href="registro.php" type="button" class="btn btn-secondary ms-2">Registrarse</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>
