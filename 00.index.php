<?php
require_once "db_conexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="https://th.bing.com/th/id/OIP.ZwgZsScqAUCrVB5IElNAiAHaEK?w=322&h=181&c=7&r=0&o=5&dpr=1.1&pid=1.7" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    BELBANK
                </a>
            </div>
        </nav>
    </header>
      <div class="container-fluid main-container">
        <div class="buttons-div">
              <h1 class="tit1">¡Bienvenido a BELBANK!</h1>
              <h3 class="tit1">Tu banco de confianza</h3>
              <a class="btn btn-primary" href="01.login.php">Iniciar Sesión</a>
              <a class="btn btn-primary" href="02.registro.php">Registrarse</a>
              <style>
                  .buttons-div .btn{
                      width: 130px;
                  }
              </style>
          </div>
          <div class="image-div">
              <img src="https://img.caminofinancial.com/wp-content/uploads/2018/12/19001416/iStock-9638143721-1024x683.jpg" alt="Imagen">
          </div>
      </div>

    <div class="container mt-5 d-none d-md-block">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 ">
                    <img src="images/card-1.jpg" class="card-img-top rounded-circle" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">Tarjetas de crédito BELBANK</h5>
                      <p class="card-text">Solicita la tarjeta que te da meses sin intereses y pagos fijos.</p>
                      <a href="#" class="btn btn-primary">CONOCE MÁS</a>
                    </div>
                  </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 ">
                    <img src="images/card-2.jpg" class="card-img-top rounded-circle" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">Tarjetas adicionales</h5>
                      <p class="card-text">Extiende los beneficios de ser parte de la familia BELBANK.</p>
                      <a href="#" class="btn btn-primary">ME INTERESA</a>
                    </div>
                  </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 ">
                    <img src="images/card-3.jpg" class="card-img-top rounded-circle" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">Trae tu nómina y disftruta beneficios</h5>
                      <p class="card-text">Te bonificamos la comisión por administración de tu tarjeta de crédito cada año.</p>
                      <a href="#" class="btn btn-primary">CONOCE MÁS</a>
                    </div>
                  </div>
            </div>
        </div>
      </div>

      <div class="container mt-5">
        <div class="card mb-3 border-0">
            <div class="row g-0">
              <div class="col-md-5">
                <img src="images/slider-3.jpg" class="img-fluid rounded-start" alt="...">
              </div>
              <div class="col-md-7">
                <div class="card-body">
                  <h2 class="card-title">Crea tu bolsa de ahorro fácil</h2>
                  <p class="card-text">Empieza a ahorrar de manera sencilla y descubre cómo tu dinero puede crecer rápidamente. 
                    Solo regístrate, participa y comprueba que ahorrar siempre tiene recompensa. ¡Haz que tu dinero trabaje para ti!</p>
                  <div class="text-center"><a href="#" class="btn btn-danger btn-lg">ADELANTE</a></div>
                </div>
              </div>
            </div>
          </div>
      </div>

      <div id="ie" class="container mt-5">
        <div class="card mb-3 border-0">
            <div class="row g-0">
              
              <div class="col-md-7 order-2">
                <div class="card-body">
                  <h2 class="card-title">¡Gana un auto con tu tarjeta de nómina!</h2>
                  <p class="card-text">Regístrate de forma sencilla y comienza a hacer tus compras con tu tarjeta de nómina. 
                    Cada compra te convierte automáticamente en participante para ganar un auto. Sin costos adicionales ni trámites complicados: 
                    solo usa tu tarjeta como siempre y aumenta tus posibilidades de llevarte el gran premio.</p>
                  <div class="text-center"><a href="#" class="btn btn-danger btn-lg">ME INTERESA</a></div>
                </div>
              </div>
              <div class="col-md-5 order-1">
                <img src="images/slider-2.jpg" class="img-fluid rounded-start" alt="...">
                <style>
                    .img-fluid{
                        height: 300px;
                    }
                </style>
              </div>
            </div>
          </div>
      </div>
      <br><br>
      <footer class="footer bg-danger">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 mt-4 col-lg-3 text-center text-sm-start">
                <div class="information">
                    <h6 class="footer-heading text-uppercase text-white fw-bold">Clientes Belbank</h6>
                    <ul class="list-unstyled footer-link mt-4">
                        <li class="mb-1"><a href="#" class="text-white text-decoration-none fw-semibold">Priority</a></li>
                        <li class="mb-1"><a href="#" class="text-white text-decoration-none fw-semibold">Jóvenes</a></li>
                        <li class="mb-1"><a href="#" class="text-white text-decoration-none fw-semibold">Patrimonial</a></li>
                        <li class="mb-1"><a href="#" class="text-white text-decoration-none fw-semibold">Empresas y Gobierno</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mt-4 col-lg-3 text-center text-sm-start">
                <div class="resources">
                    <h6 class="footer-heading text-uppercase text-white fw-bold">Economía</h6>
                    <ul class="list-unstyled footer-link mt-4">
                        <li class="mb-1"><a href="#" class="text-white text-decoration-none fw-semibold">Tipo de cambio</a></li>
                        <li class="mb-1"><a href="#" class="text-white text-decoration-none fw-semibold">Análisis Financiera</a></li>
                        <li class="mb-1"><a href="#" class="text-white text-decoration-none fw-semibold">Información financiera</a></li>
                        <li class="mb-1"><a href="#" class="text-white text-decoration-none fw-semibold">Fondos de inversión</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mt-4 col-lg-2 text-center text-sm-start">
              <div class="social">
                  <h6 class="footer-heading text-uppercase text-white fw-bold">Social</h6>
                  <ul class="list-inline my-4">
                    <li class="list-inline-item"><a href="#" class="text-white btn-sm btn btn-primary mb-2"><i class="bi bi-facebook"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="text-danger btn-sm btn btn-light mb-2"><i class="bi bi-instagram"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="text-white btn-sm btn btn-primary mb-2"><i class="bi bi-twitter"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="text-white btn-sm btn btn-success mb-2"><i class="bi bi-whatsapp"></i></a></li>
                </ul>
              </div>
          </div>
            <div class="col-sm-6 col-md-6 mt-4 col-lg-4 text-center text-sm-start">
              <div class="contact">
                  <h6 class="footer-heading text-uppercase text-white fw-bold">Contáctanos</h6>
                  <address class="mt-4 m-0 text-white mb-1"><i class="bi bi-pin-map fw-semibold"></i> Av. Industria Metalúrgica, Blvd. del Parque Industrial Francisco R. Alanis 2001, 25900 Ramos Arizpe, Coah.</address>
                  <a href="tel:+" class="text-white mb-1 text-decoration-none d-block fw-semibold"><i class="bi bi-telephone"></i>  844 503 9865</a>
                  <a href="mailto:" class="text-white mb-1 text-decoration-none d-block fw-semibold"><i class="bi bi-envelope"></i> 23040068@alumno.utc.edu.mx</a>
              </div>
            </div>
        </div>
    </div>
    </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
</html>