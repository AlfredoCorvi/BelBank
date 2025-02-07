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
<body >
    <header>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand ms-3" href="#">
                    <img src="https://th.bing.com/th/id/OIP.ZwgZsScqAUCrVB5IElNAiAHaEK?w=322&h=181&c=7&r=0&o=5&dpr=1.1&pid=1.7" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    BELBANK
                </a>
            </div>
        </nav>
    </header>
      <div class="container-fluid main-container">
        <div class="buttons-div">
           <div class="container-sm" style="max-width: 520px;">
              <h1>¡Bienvenido a <span class="bel">BEL</span><span class="bank">BANK</span>!</h1>
              <h5 class="tit1">A donde tus sueños financieros comienzan a hacerse realidad!
              Tu confianza, nuestro compromiso.<br><br> Únete a nosotros y abre tu cuenta hoy mismo.</h5>
            </div>
            <a class="btn btn-outline-light" href="01.02.loginyregistro.php" >Abre tu cuenta</a>
        </div>
          <div class="image-div">
              <img src="https://img.caminofinancial.com/wp-content/uploads/2018/12/19001416/iStock-9638143721-1024x683.jpg" alt="Imagen">
          </div>
      </div>

    <!---->
    <div class="container mt-4">
  <div class="row row-cols-1 row-cols-md-5 g-4">
    <div class="col">
      <div class="card-icons text-center border-0 shadow rounded-0 p-4" style="max-width: 22rem;">
        <div class="icon">
          <i class="bi bi-phone"></i>
        </div>
        <div class="card-body">
          <h4 class="card-title fw-bold">BelMóvil</h4>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card-icons text-center border-0 shadow rounded-0 p-4" style="max-width: 22rem;">
        <div class="icon">
          <i class="bi bi-pc-display"></i>
        </div>
        <div class="card-body">
          <h4 class="card-title fw-bold">BelWeb</h4>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card-icons text-center border-0 shadow rounded-0 p-4" style="max-width: 22rem;">
        <div class="icon">
          <i class="bi bi-cash-coin"></i>
        </div>
        <div class="card-body">
          <h4 class="card-title fw-bold">Cajeros</h4>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card-icons text-center border-0 shadow rounded-0 p-4" style="max-width: 22rem;">
        <div class="icon">
          <i class="bi bi-buildings"></i>
        </div>
        <div class="card-body">
          <h4 class="card-title fw-bold">Sucursales</h4>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card-icons text-center border-0 shadow rounded-0 p-4" style="max-width: 22rem;">
        <div class="icon">
          <i class="bi bi-info-circle"></i>
        </div>
        <div class="card-body">
          <h4 class="card-title fw-bold">Ayuda</h4>
        </div>
      </div>
    </div>
  </div>
</div>


    <!---->


    <div class="container mt-5 d-none d-md-block">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 ">
                    <img src="images/card-1.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">Tarjetas de crédito BELBANK</h5>
                      <p class="card-text">Solicita la tarjeta que te da meses sin intereses y pagos fijos.</p>
                      <a href="#" class="btn-icon">
                        <i class="bi bi-arrow-right-square fs-1 arrow-hover"></i>
                      </a>
                    </div>
                  </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 ">
                    <img src="images/card-2.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">Tarjetas adicionales</h5>
                      <p class="card-text">Extiende los beneficios de ser parte de la familia BELBANK.</p>
                      <a href="#" class="btn-icon">
                        <i class="bi bi-arrow-right-square fs-1 arrow-hover"></i>
                      </a>                    
                    </div>
                  </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 ">
                    <img src="images/card-3.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">Trae tu nómina y disftruta beneficios</h5>
                      <p class="card-text">Te bonificamos la comisión por administración de tu tarjeta de crédito cada año.</p>
                      <a href="#" class="btn-icon">
                        <i class="bi bi-arrow-right-square fs-1 arrow-hover"></i>
                      </a>                    
                    </div>
                  </div>
            </div>
        </div>
      </div>
      <!--otros 3-->
      <div class="container mt-5 d-none d-md-block">
          <div class="row">
              <div class="col-md-4">
                  <div class="card border-0 ">
                      <img src="https://image.freepik.com/foto-gratis/mujer-con-telefono-movil-en-las-manos-las-personas-que-usan-el-concepto-de-dispositivo_8353-6421.jpg" class="card-img-top" alt="...">
                      <div class="card-body">
                        <h5 class="card-title">Cambia tu nómina hpy desde la App BelBank Movil</h5>
                        <p class="card-text">Obtén un seguro por muerte accidental, asistencias sin costo, 
                          condiciones preferenciales en préstamos y créditos y mucho más.</p>
                        <a href="#" class="btn-icon">
                        <i class="bi bi-arrow-right-square fs-1 arrow-hover"></i>
                      </a>                      
                    </div>
                    </div>
              </div>
              <div class="col-md-4">
                  <div class="card border-0 ">
                      <img src="https://th.bing.com/th/id/OIP.Yl1nPeo9Hh2lz0MnvaV1wAHaE7?rs=1&pid=ImgDetMain" class="card-img-top" alt="...">
                      <div class="card-body">
                        <h5 class="card-title">Transfiere, retira sin tarjeta, paga tus servicios, compra seguro y más</h5>
                        <p class="card-text">Descubre todas las funcionalidades de tu ScotiaMóvil y échate el banco a la bolsa.</p>
                        <a href="#" class="btn-icon">
                        <i class="bi bi-arrow-right-square fs-1 arrow-hover"></i>
                      </a>                      
                    </div>
                    </div>
              </div>
              <div class="col-md-4">
                  <div class="card border-0 ">
                      <img src="https://image.freepik.com/foto-gratis/manos-mujer-sosteniendo-usando-telefono-celular_38716-128.jpg" class="card-img-top" alt="...">
                      <div class="card-body">
                        <h5 class="card-title">Ábrela en minutos desde la app ScotiaMóvil</h5>
                        <p class="card-text">Realiza transferencias en corto y paga tus servicios </p>
                        <a href="#" class="btn-icon">
                        <i class="bi bi-arrow-right-square fs-1 arrow-hover"></i>
                      </a>                      
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
                    Cada compra te convierte automáticamente en participante para ganar un auto. 
                    Sin costos adicionales ni trámites complicados: 
                    solo usa tu tarjeta como siempre y aumenta tus posibilidades de llevarte el gran premio. <br><br> 
                    Además, mientras más uses tu tarjeta, más oportunidades tendrás de ganar, 
                    ¡así que no dejes pasar ni una compra! No importa si es para tu día a día o algo especial, cada gasto cuenta. 
                    ¿Qué esperas para comenzar a participar y acercarte a tu nuevo auto?</p>
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