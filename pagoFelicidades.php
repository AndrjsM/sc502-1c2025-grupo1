<!-- pagoFelicidades.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gracias por tu compra - Patitas al Rescate</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400|Montserrat:700" rel="stylesheet" type="text/css">
    <style>
        @import url(//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css);
        @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
    </style>
    <link rel="stylesheet" href="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/default_thank_you.css">
    <script src="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/jquery-1.9.1.min.js"></script>
    <script src="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/html5shiv.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="main-content text-center">
        <i class="fa fa-check main-content__checkmark" id="checkmark"></i>
        <h1 class="site-header__title" data-lead-id="site-header-title">¡GRACIAS POR TU COMPRA!</h1>
        <p class="main-content__body" data-lead-id="main-content-body">
            Tu pago ha sido procesado con éxito. Apreciamos tu confianza en <b>Patitas al Rescate</b>.  
            Puedes descargar tu factura en el siguiente botón.
        </p>
        <a href="descargar_factura.php" class="btn btn-primary mt-3"> <!-- dicha funcion no esta disponible-->
            <i class="fa fa-download"></i> Descargar Factura
        </a>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>