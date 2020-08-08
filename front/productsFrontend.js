
const app=new Vue({
  el:'#app',
  data:{
    errorMsg:'',
    successMsg:'',
    showAddModal:false,
    showEditModal:false,
    showDeleteModal:false,
    products:[],
    categories:[],
    newProduct:{name:'',stock:'',price:'',category_id:1},
    currentProduct:{},
    key:{value:''},
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
    getAllProducts:function(){
     axios.get('http://localhost/store2/back/productsBackend.php?action=read').then(function(response){
         if (response.data.error) {
           app.errorMsg=response.data.message;
         }else{
             app.products=response.data.products;
             console.log("no esta nulo");
         }
       });
     },
    addProduct:function(){
      let formData=app.toFormData(app.newProduct);
      console.log(app.newProduct);
      axios.post('http://localhost/store2/back/productsBackend.php?action=create',formData).then(function(response){
          app.newProduct={name:"",stock:"",price:"",category_id:1};
          if (response.data.error) {
            app.errorMsg=response.data.message;
          }else{
            app.successMsg=response.data.message;
            app.getAllProducts();
          }
        });
    },
    updateProduct:function(){
      let formData=app.toFormData(app.currentProduct);
      axios.post('http://localhost/store2/back/productsBackend.php?action=update',formData).then(function(response){
        app.currentProduct={};
        if (response.data.error) {
          app.errorMsg=response.data.message;
        }else{
          app.successMsg=response.data.message;
          app.getAllProducts();
        }
      });
    },
    deleteProduct:function(){
      let formData=app.toFormData(app.currentProduct);
      axios.post('http://localhost/store2/back/productsBackend.php?action=delete',formData).then(function(response){
        if (response.data.error) {
          app.errorMsg=response.data.message;
        }else{
          app.successMsg=response.data.message;
          app.getAllProducts();
        }
      });
    },
    filterProduct:function(){
      let formData=app.toFormData(app.key);
      axios.post('http://localhost/store2/back/productsBackend.php?action=filter',formData).then(function (response){
        if (response.data.error) {
          app.errorMsg="Error en la filtración";
        }else{
          app.products=response.data.products;
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


  }
});
