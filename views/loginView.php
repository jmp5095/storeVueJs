<?php
  session_start();
  if (isset($_SESSION['user'])) {
    ?><script type="text/javascript">
      window.location.href='http://localhost/store2'
    </script><?php
  }

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  </head>
  <header>
    <?php include_once 'navbar.php'; ?>
  </header>
  <body class="">

    <div class="container mt-2 ">
      <div class="d-flex justify-content-center">



        <div class="form my-5 col-sm-8 bg-dark rounded-pill"  >

          <h1 class="display-4 mt-3 text-light text-center">Iniciar Sesión</h1>
          <div class="d-flex justify-content-center">
            <div class="col-sm-7 mt-4">
              <div class="d-flex justify-content-center " id="message">
              </div>

              <div class="form-group ">
                <label class="h5 font-weight-bold text-light" for="mail">Correo electrónico</label>
                <input id="email" class="form-control" type="mail" name="email" placeholder="Ingrese su correo" value="">
              </div>
              <div class="form-group">
                <label class="h5 font-weight-bold text-light" for="pass">Contraseña</label>
                <input id="pass" class="form-control" type="password" name="pass" placeholder="Ingrese su contraseña" value="">
              </div>

              <div class="my-4 mt-5 d-flex justify-content-center">
                <button class="btn btn-info col-sm-5 font-weight-bold" name="button" onclick="userSession()" >Ingresar</button>
              </div>

            </div>
          </div>

        </div>
      </div>

    </div>



    <!-- my js -->
    <script type="text/javascript" src="../front/loginFront.js"></script>
    <!-- axios lib -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>

  </body>
</html>
