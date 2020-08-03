
<nav id="myNav" class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#"><img class="mt-2" src="http://localhost/store2/resources/titulo.png" alt=""> </a>

</nav>


<script type="text/javascript">
  let user=JSON.parse(localStorage.getItem('user'))
  if (user!=null) {
    console.log(user[0].name);

    let myNavUI=document.querySelector('#myNav');
    // ///////////////////////////////////////////////
    myNavUI.innerHTML=`
      <a class="navbar-brand" href="#"><img class="mt-2" src="http://localhost/store2/resources/titulo.png" alt=""> </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="http://localhost/store2"><span class="font-weight-bold" >Vender</span> <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="http://localhost/store2/views/salesView.php"><span class="font-weight-bold" >Facturas</span></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="http://localhost/store2/views/users.php"><span class="font-weight-bold" >Usuarios</span></a>

          </li>
          <li class="nav-item active">
            <a class="nav-link" href="http://localhost/store2/views/productsView.php"><span class="font-weight-bold" >Productos</span></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="http://localhost/store2/views/categoriesView.php"><span class="font-weight-bold" >Categorías</span></a>
          </li>

        </ul>
      </div>
      <div class="collapse navbar-collapse " id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto mr-5">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle font-weight-bold active" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

              <div id="userGuess"></div>

            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="">Mi Perfil</a>
              <a class="dropdown-item" onclick="logout()" href="http://localhost/store2/back/logoutBackend.php" >Cerrar sesión</a>
            </div>
          </li>

        </ul>
      </div>`

      let userUI=document.querySelector('#userGuess');
      userUI.innerHTML=user[0].name;
  }


</script>
<script type="text/javascript" src="http://localhost/store2/front/logoutFront.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
