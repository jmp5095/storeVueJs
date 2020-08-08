
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
    sale_id:0,
    totalCar:0,
    search:'',
    picked:'byName'
  },
  mounted: function(){
    this.getAllProducts();
  },
  methods:{
    getAllProducts:function(){
      let lsp=JSON.parse(localStorage.getItem('LSProducts'))
      if (lsp==null) {
        axios.get('http://localhost/store2/back/productsBackend.php?action=read').then(function(response){

          if (!response.data.error) {
            app.products=response.data.products;
            localStorage.setItem('LSProducts', JSON.stringify(response.data.products))
            console.log(app.products);
          }else{
            app.errorMsg=response.data.message;

          }
        });
      }else{
        console.log('ya estaba en localstorage')
        let lsp=JSON.parse(localStorage.getItem('LSProducts'))
        this.products=lsp;
        let lst=JSON.parse(localStorage.getItem('total'))
        this.totalCar=lst

      }

    },
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


    pay:function(){

      let lsc=JSON.parse(localStorage.getItem('LSCar'));
      let tp=0;
      if (lsc) {

        let formData=app.toFormData(app.venta);

        axios.post('http://localhost/store2/back/saleBackend.php?action=create',formData).then(function(response){

          if (!response.data.error) {
            // app.successMsg="registro exitoso!!";
            app.sale_id= response.data.sale_id;
            console.log(app.sale_id)
            app.createFill(app.sale_id);
          }else{
            // app.errorMsg="Error de registro";

          }

        });

      }else{
        app.errorMsg="La canasta esta vacia!"
      }
    },
    createFill:function(sale_id){
      //my car of shopping
      let lsc=JSON.parse(localStorage.getItem('LSCar'));
      //id of the facture
      app.sale_id=sale_id;
      console.log(app.sale_id)

      //register of products saled
      for (var c of lsc) {

        app.currentProduct={
          stock:c.stock,
          quantity:c.quantity,
          sale_id:app.sale_id,
          product_id:c.id,
        }

        app.createProductSale();
        app.updateProduct();
      }
      //clean the local storage
      localStorage.removeItem('LSCar');
      localStorage.removeItem('total');
      this.getAllProducts();
      app.car=[];
      app.totalCar=0;
    },

    createProductSale:function(){
      let formData=app.toFormData(app.currentProduct);
      axios.post('http://localhost/store2/back/saleBackend.php?action=productsSales',formData).then(function(response){
        if (!response.data.error) {

          app.successMsg=response.data.message;
          console.log(response.data.sql);

        }else{

          app.errorMsg=response.data.message;
          console.log(response.data.sql);

        }
      });


    },

    updateProduct:function(){
      let formData=app.toFormData(app.currentProduct);
      axios.post('http://localhost/store2/back/saleBackend.php?action=update',formData).then(function(response){
        app.currentProduct={};
        if (response.data.error) {
          app.errorMsg=response.data.message
        }
      });
    },

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

        app.updateLSProducts();
        app.updateShoppingCart();
        app.clearMsg();
      }else{
        app.errorMsg='Por favor ingrese una cantidad válida.';
      }

    },
    updateLSProducts:function(){
      let id=app.currentProduct.id
      let lsp=JSON.parse(localStorage.getItem('LSProducts'))

      lsp.forEach((item, i) => {
        if (item.id==id) {
          item.quantity=0
        }
      });
      localStorage.setItem('LSProducts',JSON.stringify(lsp))

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
      app.sale_id_numeric=0;
    }

  },
  computed:{
    filter:function(){
      return this.products.filter((item)=>
        item.name.toLowerCase().includes(this.search)
        || item.c_name.toLowerCase().includes(this.search)
        || item.id.includes(this.search)
      )
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
