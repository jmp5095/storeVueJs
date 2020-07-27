
const app=new Vue({
  el:'#app',
  data:{
    showCar:false,
    errorMsg:'',
    successMsg:'',
    products:[],
    categories:[],
    car:[],
    currentProduct:{},
    key:{value:''},
    venta:{totalPrice:'',seller_id:1},
    sale_id_numeric:0,
    totalCar:0
  },
  mounted: function(){
    this.getAllProducts();
  },
  methods:{
        getAllCategories:function(){
          axios.get('http://localhost/store2/back/categoriesBackend.php?action=read').then(function(response){
              if (response.data.error) {
                app.errorMsg=response.data.message;
              }else{
                app.categories=response.data.categories;
              }
            });
        },
        total:function(){
          let lst=localStorage.getItem('total');
          if (lst) {
            app.totalCar=parseFloat(lst);
          }

        },
        getAllProducts:function(){
         axios.get('http://localhost/store2/back/productsBackend.php?action=read').then(function(response){
             if (response.data.error) {
               app.errorMsg=response.data.message;
             }else{
               let lsp=JSON.parse(localStorage.getItem('LSProducts'));
               if (lsp==null) {
                 app.products=response.data.products;
                 localStorage.setItem('LSProducts',JSON.stringify(app.products))
                 console.log("bd");
                 app.total();
               }else{
                 app.total();
                 app.products=lsp;
                 console.log(app.products)
                 console.log("no bd");

               }
             }
           });
         },

         pay:function(){

              let lsc=JSON.parse(localStorage.getItem('LSCar'));
              let tp=0;
              if (lsc) {

              for (let i=0;i<lsc.length;i++) {
                tp+=lsc[i].totalPrice;
              }

              app.venta.totalPrice=tp;

              let formData=app.toFormData(app.venta);

              axios.post('http://localhost/store2/back/saleBackend.php?action=create',formData).then(function(response){

                  if (response.data.error) {
                      app.errorMsg="Error de registro";
                  }else{
                      app.successMsg="registro exitoso!!";
                      let sd=response.data.sale_id

                      localStorage.setItem('sale_id',JSON.stringify(sd));
                  }

              });


              //id of the facture
              let saleid=JSON.parse(localStorage.getItem('sale_id'));
              app.sale_id_numeric=saleid;

              if (app.sale_id_numeric==null) {
                app.sale_id_numeric=1
              }else{
                app.sale_id_numeric++;
              }




              //register of products saled
              for (var c of lsc) {

                app.currentProduct={
                  stock:c.stock,
                  quantity:c.quantity,
                  sale_id:app.sale_id_numeric,
                  product_id:c.id,
                }

                app.createProductSale();
                app.updateProduct();
              }
              //clean the local storage
              localStorage.removeItem('LSProducts');
              localStorage.removeItem('LSCar');
              localStorage.removeItem('total');
              this.getAllProducts();
              app.car=[];
              app.totalCar=0;

            }else{
              app.errorMsg="La canasta esta vacia!"
            }
         },

         createProductSale:function(){
            let formData=app.toFormData(app.currentProduct);
            axios.post('http://localhost/store2/back/saleBackend.php?action=productsSales',formData).then(function(response){

              if (response.data.error) {
                app.errorMsg=response.data.message;

              }else{

                app.successMsg=response.data.message;
              }
            });


         },

         updateProduct:function(){
           let formData=app.toFormData(app.currentProduct);
           axios.post('http://localhost/store2/back/saleBackend.php?action=update',formData).then(function(response){
             app.currentProduct={};
             if (response.data.error) {
             }else{
             }
           });
         },
        // filterProduct:function(){
        //   let formData=app.toFormData(app.key);
        //   axios.post('http://localhost/store2/back/productsBackend.php?action=filter',formData).then(function (response){
        //     if (response.data.error) {
        //       app.errorMsg="Error en la filtración";
        //     }else{
        //       app.products=response.data.products;
        //     }
        //   });
        // },

        toFormData:function(obj){
          let fd=new FormData();
          for (let i in obj) {
            fd.append(i,obj[i])
          }
          return fd;
        },
        selectProduct:function(product){
          app.currentProduct=product;
        },
        clearMsg:function(){
          app.errorMsg='';
          app.successMsg='';
        },


        //shopping cart
        addShoppingCart:function(product){
          app.selectProduct(product);
          if (app.currentProduct.quantity>0){

            app.currentProduct.totalPrice=app.currentProduct.price*app.currentProduct.quantity;
            app.totalCar+=app.currentProduct.totalPrice;
            localStorage.setItem('total',JSON.stringify(app.totalCar))

            app.car.push(app.currentProduct);
            localStorage.setItem('LSCar',JSON.stringify(app.car));

            app.updateShoppingCart();
            app.clearMsg();
          }else{
            app.errorMsg='Por favor ingrese una cantidad válida.';
          }

        },

        updateShoppingCart:function(){

          let sc=JSON.parse(localStorage.getItem('LSCar'));
          if (sc!=null) {
            console.log("hay");
            app.car=sc;
          }else{
            console.log("No hay");
            app.car=[];
          }

        },

        sum:function(product){
          if (product.stock>0) {
            product.stock--;
            product.quantity++;
            localStorage.setItem('LSProducts',JSON.stringify(app.products));
          }
        },

        res:function(product){
          if (product.quantity>0) {
            product.stock++;
            product.quantity--;
            localStorage.setItem('LSProducts', JSON.stringify(app.products))
          }
        },

        cleanStorage:function(){
          localStorage.removeItem('LSProducts');
          localStorage.removeItem('LSCar');
          localStorage.removeItem('total');
          this.getAllProducts();
          app.car=[];
          app.totalCar=0;
        }

  },
  created:function(){
    let datosLS=JSON.parse(localStorage.getItem('LSCar'));
    console.log('executada')
    if (datosLS==null) {
      this.car=[];
    }else{
      this.car=datosLS;
    }
  }
});
