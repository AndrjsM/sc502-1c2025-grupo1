<?php
session_start();
require 'db.php';

$error = '';
$success = '';

// Mostrar mensajes de éxito/error si existen
if (isset($_SESSION['message'])) {
    if (strpos($_SESSION['message'], 'Error') === 0) {
        $error = $_SESSION['message'];
    } else {
        $success = $_SESSION['message'];
    }
    unset($_SESSION['message']);
}

// Procesar el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Validaciones básicas
    if (empty($username) || empty($password)) {
        $error = "Por favor ingrese ambos campos: usuario y contraseña";
    } else {
        try {
            // Consulta para verificar las credenciales
            $stmt = $conn->prepare("SELECT ID_CLIENTE, NOMBRE, PRIMER_APELLIDO, PASSWORD FROM CLIENTE WHERE CORREO = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Verificar la contraseña 
                if (password_verify($password, $user['PASSWORD'])) {
                    // Regenerar el ID de sesión para prevenir fijación de sesión
                    session_regenerate_id(true);
                    
                    // Iniciar sesión
                    $_SESSION['user_id'] = $user['ID_CLIENTE'];
                    $_SESSION['user_name'] = $user['NOMBRE'] . ' ' . $user['PRIMER_APELLIDO'];
                    $_SESSION['logged_in'] = true;
                    $_SESSION['last_activity'] = time();
                    
                    // Redirigir al dashboard o página principal
                    header("Location: index.php");
                    exit();
                } else {
                    // Mensaje genérico para no revelar información
                    $error = "Credenciales incorrectas. Por favor intente nuevamente.";
                }
            } else {
                // Mismo mensaje aunque el usuario no exista (seguridad)
                $error = "Credenciales incorrectas. Por favor intente nuevamente.";
            }
        } catch (PDOException $e) {
            error_log("Error al iniciar sesión: " . $e->getMessage());
            $error = "Error al iniciar sesión. Por favor intente más tarde.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Patitas</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .form-signin {
            max-width: 380px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin .btn {
            font-size: 1rem;
            font-weight: 700;
        }

        .form-signin .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .form-signin .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .form-signin h1 {
            font-size: 1.5rem;
            font-weight: 400;
            margin-bottom: 1rem;
        }
        
        .alert {
            max-width: 380px;
            margin: 20px auto;
        }
    </style>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <section class="container mx-auto mt-5">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <main class="form-signin">
            <form method="POST" action="login.php" class="needs-validation" novalidate>
                <h1 class="h3 mb-3 fw-normal text-center">Iniciar Sesión</h1>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">@</span>
                    <input type="email" class="form-control" id="username" name="username"
                        placeholder="nombre@ejemplo.com" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    <div class="invalid-feedback">
                        Por favor, ingrese un correo electrónico válido.
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon2"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Contraseña (mínimo 8 caracteres)" required minlength="8">
                    <div class="invalid-feedback">
                        Por favor, ingrese una contraseña de al menos 8 caracteres.
                    </div>
                </div>

                <div class="form-check text-start my-3">
                    <input class="form-check-input" type="checkbox" value="remember-me" id="remember-me"
                        name="remember-me">
                    <label class="form-check-label" for="remember-me">
                        Recuérdame
                    </label>
                </div>
                <button class="btn btn-primary w-100 py-2" type="submit">Iniciar Sesión</button>
                <a class="btn btn-secondary w-100 py-2 mt-2" href="registro.php">Registrarse</a>
                <div class="text-center mt-3">
                    <a href="recuperar_contrasena.php">¿Olvidó su contraseña?</a>
                </div>
            </form>
        </main>
    </section>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        // Validación del formulario del lado del cliente
        (function() {
            'use strict';
            
            var forms = document.querySelectorAll('.needs-validation');
            
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        
                        form.classList.add('was-validated');
                    }, false);
                });
        })();
    </script>
</body>

</html>