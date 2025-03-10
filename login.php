<!DOCTYPE html>
<html lang="en" xmlns:th="http://www.thymeleaf.org">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Patitas</title>
    <meta name="description"
        content="">
    <meta name="keywords"
        content="">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css"
        rel="stylesheet">
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
    </style>
</head>

<body>
    <header>
    <?php include 'header.php'; ?>
    </header>
    <section class="container mx-auto mt-5">
        <main class="form-signin">
            <form class="needs-validation" novalidate>
                <h1 class="h3 mb-3 fw-normal text-center">Iniciar Sesión</h1>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">@</span>
                    <input type="email" class="form-control" id="username" name="username"
                        placeholder="nombre@ejemplo.com" required>
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
            </form>
        </main>
    </section>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>