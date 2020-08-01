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
    <!-- my styles -->
    <link rel="stylesheet" href="../styles.css">
  </head>
  <header>
    <?php include_once 'navbar.php';?>
  </header>
  <body>

        <div id="appCategory">

<!-- //////////////////////////////////////////////////////////////////////////////////////////// -->

          <div class="container my-5">
            <div class="row mt-3">
              <div class="col-lg-6">
                <img class="mytitles" src="../resources/gestionDeCategorias.png" alt="">
              </div>
              <div class="col-lg-6">
                <button class="btn btn-info float-right" v-on:click="showAddModal=true">
                  <span class="material-icons align-middle  ">add_circle</span>&nbsp;&nbsp;Añadir Nueva Categoría
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
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </thead>
                  <tbody>
                    <tr class="text-center" v-for="category of categories">
                      <td>{{category.id}}</td>
                      <td>{{category.name}}</td>
                      <td><a href="#" class="text-success"
                        @click="showEditModal=true;selectCategory(category);"><i class="fa fa-edit"></i></a></td>
                      <td ><a href="#" class="text-danger"
                        v-on:click="showDeleteModal=true;selectCategory(category);"><i class="
                        fa fa-trash"></i> </a> </td>

                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>



          <!-- add model -->
          <div id="overlay" v-if="showAddModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="text-center font-weight-bold">Añadir Categoría</h4>
                  <button type="button=true" class="close" @click="showAddModal=false">
                    <span aria-hidden="true" >&times;</span>
                  </button>
                </div>
                <div class="modal-body p-4">
                  <form action="#" method="post">

                    <div class="form-group">
                      <input type="text" name="name" value="" class="
                      form-control form-control-lg" placeholder="Ingrese el nómbre" v-model="newCategory.name">
                    </div>

                    <div class="form-group">
                      <button type="button" name="button" class="btn btn-info btn-block btn-lg"
                      @click="showAddModal=false;addCategory();clearMsg();"
                      > Añadir Categoría</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>


          <!-- edit model -->
          <div id="overlay" v-if="showEditModal">
            <div class="modal-dialog ">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="text-center font-weight-bold">Editar Categoría</h4>
                  <button type="button=true" class="close" @click="showEditModal=false">
                    <span aria-hidden="true" >&times;</span>
                  </button>
                </div>
                <div class="modal-body p-4">
                  <form action="#" method="post">
                    <div class="form-group">
                      <input type="text" name="name" value="" class="form-control form-control-lg"
                      v-model="currentCategory.id" disabled>
                    </div>
                    <div class="form-group">
                      <input type="text" name="name" value="" class="
                      form-control form-control-lg" placeholder="Ingrese el nómbre" v-model="currentCategory.name"
                      @keyup.enter="showEditModal=false;updateCategory();clearMsg();"
                       >
                    </div>

                    <div class="form-group">
                      <button type="button" name="button" class="btn btn-info btn-block btn-lg"
                      @click="showEditModal=false;updateCategory();clearMsg();"
                      >Editar Categoría</button>
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
                  <h4 class="text-danger text-center font-weight-bold">¿Está seguro de querer eliminar esta categoría?</h4>
                  <div>
                    <h5 ><label class="font-weight-bold">Código:</label> {{currentCategory.id}} </h5>
                    <h5 ><span class="font-weight-bold">Nómbre:</span> {{currentCategory.name}}</h5>
                  </div>
                  <hr>
                  <div class="float-right">
                    <button type="button" name="button" class="btn btn-danger btn-lg " @click="showDeleteModal=false;deleteCategory();clearMsg();">Si</button>
                    &nbsp;
                    <button type="button" name="button" class="btn btn-success btn-lg" @click="showDeleteModal=false">No</button>
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>
      <!-- axios lib -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <!-- development version, includes helpful console warnings -->
    <script src="../resources/libs/vue.js"></script>
    <script src="../front/categoriesFrontend.js"></script>
  </body>
</html>