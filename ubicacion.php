<!-- ubicacion.php -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patitas al Rescate - Ubicación</title>
  <meta name="description" content="Conoce la ubicación de nuestra clínica en San José, Costa Rica. Visítanos y descubre cómo llegar.">
  <meta name="keywords" content="ubicación, clínica, San José, Costa Rica, mapa">
  <link rel="icon" href="favicon.ico">
  
  <!-- Preconexión a recursos externos -->
  <link rel="preconnect" href="https://cdn.jsdelivr.net">
  <link rel="preconnect" href="https://cdnjs.cloudflare.com">

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  >
  <!-- Bootstrap Icons -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css"
    rel="stylesheet"
  >
  <style>
    /* Banner de Ubicación */
    .location-banner {
      background: url('https://img.freepik.com/foto-gratis/mapa-vista-superior-sobre-fondo-azul_23-2148786160.jpg') no-repeat center center;
      background-size: cover;
      height: 300px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    }
    .location-banner h1 {
      font-size: 3rem;
    }
    /* Fondo y estilo para el contenido principal */
    main {
      background: linear-gradient(to bottom right, #f0f9ff, #cbebff);
      padding: 40px 0;
    }
    .card {
      border-radius: 15px;
    }
    .card-body {
      background: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    ul li {
      font-size: 1.1rem;
      margin-bottom: 5px;
    }
  </style>
</head>
<body>
  <!-- Incluir cabecera -->
  <?php include 'header.php'; ?>

  <!-- Banner de Ubicación -->
  <section class="location-banner">
    <div class="text-center">
      <h1>Encuéntranos</h1>
    </div>
  </section>

  <!-- Contenido principal -->
  <main>
    <div class="container">
      <div class="row justify-content-center">
        <!-- Card de Ubicación -->
        <div class="col-md-8 col-lg-6 mb-4">
          <div class="card h-100 shadow-sm border-0">
            <div class="card-body text-center">
              <i class="bi bi-geo-alt display-4 text-success mb-3" aria-hidden="true"></i>
              <h2 class="card-title">Visítanos en Nuestra Clínica</h2>
              <p class="card-text">
                Estamos ubicados en el corazón de San José, Costa Rica. ¡Te esperamos!
              </p>
              <ul class="list-unstyled">
                <li><i class="bi bi-house-door me-2"></i>San José, Costa Rica</li>
                <li><i class="bi bi-signpost me-2"></i>100 metros norte del Parque Central</li>
              </ul>
              <div class="ratio ratio-16x9">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.982734693637!2d-84.077288685227!3d9.93536587651835!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa0e3f5c3b5c5b5%3A0x5c5c5c5c5c5c5c5c!2sParque%20Central%2C%20San%20Jos%C3%A9%2C%20Costa%20Rica!5e0!3m2!1ses!2scr!4v1641234567890!5m2!1ses!2scr" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Incluir pie de página -->
  <?php include 'footer.php'; ?>

  <!-- Bootstrap JS (con Popper) -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-NlNdpGZ1EnP9B2DT4lLGXSwET8fQLz+mDmI5FOFAe7I3rx+BTHDpldm9RN2IO6JR"
    crossorigin="anonymous"
  ></script>
</body>
</html>
