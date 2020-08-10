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
  <!-- my styles -->
  <link rel="stylesheet" href="../styles.css">
</head>
<header>
  <?php
  include_once 'navbar.php';

  ?>
</header>
<body>

  <div id="app">

    <!-- //////////////////////////////////////////////////////////////////////////////////////////// -->
    <div class="container my-5">
      <hr>
      <!-- title -->
      <div class="row mt-3">
        <div class="col-lg-6">
          <img class="" src="../resources/facturas.png">
        </div>
        <div class="col-lg-6">
          <a class="btn btn-info float-right" href="../index.php">
            <i class="fa fa-shopping-cart mr-2"></i>&nbsp;&nbsp;Registrar Venta
          </a>
        </div>
        <div class=" col-sm-5 ">
          <div class="row ml-2 mt-3">
            <div >
              <label for="seller">Vendedor</label>
              <input class="mr-2" type="radio" id="seller" value="seller" v-model="picked">
            </div>
            <div >
              <label for="date">Fecha</label>
              <input class="" type="radio" id="date" value="date" v-model="picked">
            </div>
          </div>

          <div class="row">

            <div class="col-sm-7"  v-if="picked=='seller'">
              <input class="form-control " type="search" placeholder="Buscar" aria-label="Search" v-model="search">
            </div>

            <div class="col-sm-7" v-if="picked=='date'">
              <input class="form-control " type="date" aria-label="Search" v-model="searchDate.value" >
            </div>

            <div class="ml-2">
              <button class="btn btn-danger" v-on:click="filterClean()">Todo</button>
            </div>
          </div>
        </div>


      </div>
      <hr>
      <!-- Controls pagination -->
      <nav>
        <ul class="pagination">
          <li><a href="#" ><span class="page-link text-secondary" v-on:click.prevent="" v-show="pag==1" > << </span> </a></li>
          <li><a href="#" ><span class="page-link" v-on:click.prevent="pag--" v-show="pag!=1"> << </span> </a></li>
          <li> <a href="#"><span class="page-link" v-on:click.prevent="">{{pag}}</span> </a> </li>
          <li><a href="#"><span class="page-link" v-on:click.prevent="pag++" v-if="picked=='seller'" v-show="filter.length-(pag*NUM_RESULTS) > 0"> >> </span> </a></li>
          <li><a href="#"><span class="page-link" v-on:click.prevent="pag++" v-if="picked=='date'" v-show="filterDate.length-(pag*NUM_RESULTS) > 0"> >> </span> </a></li>
        </ul>
      </nav>
      <!-- Displaying Records -->
      <div class="row">
        <div class="col-lg-12">
          <table class="table table-bordered table-striped table-dark">
            <thead class="text-center bg-info text-light">
              <th>No° Factura</th>
              <th>Vendedor</th>
              <th>Fecha de venta</th>
              <th>Detalles</th>
            </thead>
            <tbody>
              <tr class="text-center" v-for="(sale,index) of filter" v-if="picked=='seller'" v-show="(pag-1)*NUM_RESULTS <= index && pag*NUM_RESULTS > index">

                <td>{{sale.id}}</td>
                <td>{{sale.name}}</td>
                <td>{{sale.created_up}}</td>
                <td><a class="text-info" v-on:click="showBillModal=true;selectSale(sale);getBill()"><i class="fa fa-eye"></i></a></td>

              </tr>
              <tr class="text-center" v-for="(sale,index) of filterDate" v-if="picked=='date'" v-show="(pag-1)*NUM_RESULTS <= index && pag*NUM_RESULTS > index">

                <td>{{sale.id}}</td>
                <td>{{sale.name}}</td>
                <td>{{sale.created_up}}</td>
                <td><a class="text-info" v-on:click="showBillModal=true;selectSale(sale);getBill()"><i class="fa fa-eye"></i></a></td>

              </tr>
            </tbody>
          </table>
          <hr>
        </div>
      </div>
    </div>


    <!-- ver factura  -->
    <div id="overlay" v-if="showBillModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <div class="flex-column">
              <h2 class="text-center font-weight-bold mt-3">Factura N° {{currentSale.id}}</h2>
              <div class="d-inline-flex">
                <h3 class="font-weight-bold mr-3">Total:</h3> <h4 class="align-middle"> ${{bill['total']}}</h4>
              </div>

            </div>
            <button type="button=true" class="close" @click="showBillModal=false">
              <span aria-hidden="true" >&times;</span>
            </button>
          </div>
          <div class="modal-body p-4">
            <div class="alert alert-success" v-for="p of bill">
              <span class="font-weight-bold text-primary mr-1">Producto:</span>{{p.name}}
              <span class="font-weight-bold text-primary ml-2 mr-1">Precio:</span>{{p.price}}
              <span class="font-weight-bold text-primary ml-2 mr-1">Cantidad:</span>{{p.quantity}}
            </div>
            <button @click="showBillModal=false" class="btn btn-danger form-control tex-center" name="button"><span class="font-weight-bold">Regresar</span></button>
          </div>
        </div>
      </div>
    </div>




  </div>
  <!-- axios lib -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
  <!-- development version, includes helpful console warnings -->
  <script src="../resources/libs/vue.js"></script>
  <script src="../front/salesFront.js"></script>
</body>
</html>
