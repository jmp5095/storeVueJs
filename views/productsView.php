<?php
  session_start();
  if (!isset($_SESSION['user'])) {
    ?><script type="text/javascript">
      alert('Inicie sesión');
      window.location.href='http://localhost/store2/views/loginView.php'
    </script><?php
  }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- material icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Development version -->
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
    <!-- my styles -->
    <link rel="stylesheet" href="../styles.css">
  </head>
  <header>
    <?php include_once 'navbar.php';?>
  </header>
  <body>

        <div id="app">

<!-- //////////////////////////////////////////////////////////////////////////////////////////// -->

          <div class="container my-5">

            <hr>
            <div class="row mt-3">
              <div class="col-lg-6">
                <img class="mytitles" src="../resources/gestionDeProductos.png" alt="">
              </div>
              <div class="col-lg-6">
                <button class="btn btn-info float-right" v-on:click="showAddModal=true;getAllCategories();">

                    <span class="material-icons align-middle ">add_circle</span>&nbsp;&nbsp;Añadir Nuevo Producto
                </button>
              </div>
              <div class="col-lg-3 mt-3">
                <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" v-model="key.value" v-on:keyup="filterProduct">

              </div>

            </div>
            <hr >
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
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </thead>
                  <tbody>
                    <tr class="text-center" v-for="product in products">
                      <td>{{product.id}}</td>
                      <td>{{product.name}}</td>
                      <td>{{product.stock}}</td>
                      <td>{{product.price}}</td>
                      <td>{{product.c_name}}</td>
                      <td><a href="#" class="text-success"
                        @click="showEditModal=true;selectProduct(product);getAllCategories();"><i class="fa fa-edit"></i></a></td>
                      <td ><a href="#" class="text-danger"
                        v-on:click="showDeleteModal=true;selectProduct(product);"><i class="
                        fa fa-trash"></i> </a> </td>
                    </tr>
                  </tbody>
                </table>
                <hr>
              </div>
            </div>
          </div>



          <!-- add model -->
          <div id="overlay" v-if="showAddModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="text-center font-weight-bold">Añadir Producto</h4>
                  <button type="button=true" class="close" @click="showAddModal=false">
                    <span aria-hidden="true" >&times;</span>
                  </button>
                </div>
                <div class="modal-body p-4">
                  <form action="#" method="post">

                    <div class="form-group">
                      <input type="text" class="
                      form-control form-control-lg" placeholder="Ingrese el nómbre" v-model="newProduct.name">
                    </div>
                    <div class="form-group">
                      <input type="number" class="
                      form-control form-control-lg" placeholder="Ingrese la cantidad" v-model="newProduct.stock">
                    </div>
                    <div class="form-group">
                      <input type="number" class="
                      form-control form-control-lg" placeholder="Ingrese el precio" v-model="newProduct.price">
                    </div>
                    <div class="form-group">
                      <select class="form-control " v-model="newProduct.category_id">
                        <option class="form-control" v-for="category in categories" v-bind:value="category.id"> {{category.name}} </option>
                      </select>
                    </div>


                    <div class="form-group">
                      <button type="button" name="button" class="btn btn-info btn-block btn-lg"
                      @click="showAddModal=false;addProduct();clearMsg();"
                      > Añadir Producto</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Update model -->
          <div id="overlay" v-if="showEditModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="text-center font-weight-bold">Editar Producto</h4>
                  <button type="button=true" class="close" @click="showEditModal=false">
                    <span aria-hidden="true" >&times;</span>
                  </button>
                </div>
                <div class="modal-body p-4">
                  <form action="#" method="post">

                    <div class="form-group">
                      <input type="text" class="
                      form-control form-control-lg" placeholder="Ingrese el nómbre" v-model="currentProduct.name">
                    </div>
                    <div class="form-group">
                      <input type="number" class="
                      form-control form-control-lg" placeholder="Ingrese la cantidad" v-model="currentProduct.stock">
                    </div>
                    <div class="form-group">
                      <input type="number" class="
                      form-control form-control-lg" placeholder="Ingrese el precio" v-model="currentProduct.price">
                    </div>
                    <div class="form-group">
                      <select class="form-control " v-model="currentProduct.c_id">
                        <option class="form-control" v-for="category in categories" v-bind:value="category.id"> {{category.name}} </option>
                      </select>
                    </div>

                    <div class="form-group">
                      <button type="button" name="button" class="btn btn-info btn-block btn-lg"
                      @click="showEditModal=false;updateProduct();clearMsg();"
                      > Editar Producto</button>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- delete model -->
          <div id="overlay" v-if="showDeleteModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button=true" class="close" @click="showDeleteModal=false">
                    <span aria-hidden="true" >&times;</span>
                  </button>
                </div>
                <div class="modal-body p-4">
                  <h4 class="text-danger text-center font-weight-bold">¿Está seguro de querer eliminar este producto?</h4>
                  <div>
                    <h5 ><label class="font-weight-bold">Código:</label> {{currentProduct.id}} </h5>
                    <h5 ><span class="font-weight-bold">Nómbre:</span> {{currentProduct.name}}</h5>
                  </div>
                  <hr>
                  <div class="float-right">
                    <button type="button" name="button" class="btn btn-danger btn-lg " @click="showDeleteModal=false;deleteProduct();clearMsg();">Si</button>
                    &nbsp;
                    <button type="button" name="button" class="btn btn-success btn-lg" @click="showDeleteModal=false">No</button>
                  </div>
                </div>
              </div>
            </div>
          </div>




        </div>
      <!-- axios lib -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>
    <!-- development version, includes helpful console warnings -->
    <script src="../resources/libs/vue.js"></script>
    <script src="../front/productsFrontend.js"></script>
  </body>
</html>
