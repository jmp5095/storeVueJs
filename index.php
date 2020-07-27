<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- my styles -->
    <link rel="stylesheet" href="styles.css">
    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>

        <div id="app">
          <nav class="navbar navbar-expand-lg   bg-dark">
            <a class="navbar-brand text-primary mr-5" href="http://localhost/store2"><img src="resources/titulo.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link text-light " href="http://localhost/store2">Vender<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light" href="http://localhost/store2/views/users.html">Usuarios</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light" href="http://localhost/store2/views/productsView.html">Productos</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light" href="http://localhost/store2/views/categoriesView.html">Categorías</a>
                </li>
              </ul>
            <div>
                <input class="form-control mr-sm-2" type="search" placeholder="Buscar" v-model="key.value" v-on:keyup="">
            </div>
          </nav>
<!-- //////////////////////////////////////////////////////////////////////////////////////////// -->

      <div class="container my-5">
        <div class="row mt-3">
          <div class="col-lg-6">
            <img class="mytitles" src="resources/registroDeVenta.png">
          </div>
          <div class="col-lg-6">
            <button class="btn btn-primary float-right" v-on:click="clearMsg();pay()">
              <i class="fa fa-shopping-cart fa-2x mr-2"></i><span class="font-weight-bold text-center">Registrar Venta</span>
            </button>
          </div>
        </div>
        <hr class="bg-info">
        <div class="alert alert-danger" v-if="errorMsg">
          {{errorMsg}}
        </div>
        <div class="alert alert-info" v-if="successMsg">
          {{successMsg}}
        </div>
        <!-- Displaying Records -->
        <div class="row">
          <div class="col-lg-12">
            <table class="table table-bordered table-striped table-dark">
              <thead class="text-center bg-info text-light">
                <th>ID</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Cantidad a vender</th>
                <th>Añadir al la venta</th>
              </thead>
              <tbody>

                <tr class="text-center" v-for="product in products">
                  <td>{{product.id}}</td>
                  <td>{{product.name}}</td>
                  <td>{{product.stock}}</td>
                  <td>$ {{product.price}}</td>
                  <td>{{product.c_name}}</td>
                  <td class="align-middle">
                  <div class="d-inline-flex align-middle">
                    <input  type="number" class="form-control mr-3" style = "width:70px;" v-model="product.quantity" disabled>
                    <button class="btn btn-success mr-1"  @click="sum(product)"><i class="fa fa-plus"></i></button>
                    <button class="btn btn-danger " @click="res(product)"><i class="fa fa-minus"></i></button>
                  </div>
                </td>

                <td class="align-middle"><button class="btn btn-info" @click="addShoppingCart(product);product.quantity=0;"><i class="fa fa-cart-plus"></i></button></td>
                </tr>
              </tbody>
            </table>
            <hr class="bg-info">

            <div >

              <div class="float-right">
                <h1 class="font-weight-bold">Productos en canasta</h1>
              </div>

                <div class=" d-inline-flex ">
                  <h2 class="font-weight-bold mr-3">Total:</h2> <h3 class="align-middle"> ${{totalCar}}</h3>
                </div>
                <div class="">
                  <button class="btn btn-danger" v-on:click="cleanStorage">
                    <i class="fa fa-shopping-bag fa-2x mr-2" aria-hidden="true"></i><span class="font-weight-bold text-center">Vaciar canasta / Actualizar Stock</span>
                  </button>
                </div>

            </div>


            <hr class="bg-info">

            <div class="">
              <div class="alert alert-primary" role="alert" v-for="p in car">
                <img class="mr-3" src="resources/lemon-solid.svg" width="20" height="30"  alt="">
                <tr>
                  <td style="width:15px;" ><b class="mr-2"> Nombre:</b>{{p.name}}</td>
                  <td style="width:15px;"><b class="ml-4 mr-2">Precio/u:</b>${{p.price}}</td>
                  <td style="width:15px;"><b class="ml-4 mr-2">Cantidad:</b>{{p.quantity}}</td>
                  <td style="width:15px;"><b class="ml-4 mr-2">Precio/t:</b>${{p.totalPrice}}</td>

                </tr>
              </div>

            </div>


          </div>
        </div>


      </div>






        </div>
      <!-- axios lib -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <!-- development version, includes helpful console warnings -->
    <script src="resources/libs/vue.js"></script>
    <!-- my code front  -->
    <script src="front/indexFront.js"></script>

  </body>
</html>
