
const app2=new Vue({
  el:'#appCategory',
  data:{
    errorMsg:'',
    successMsg:'',
    showAddModal:false,
    showEditModal:false,
    showDeleteModal:false,
    categories:[],
    newCategory:{name:""},
    currentCategory:{},
    search:'',
    pag:1,
    NUM_RESULTS: 5
  },
  mounted: function(){
    this.getAllCategories();
  },
  methods:{
    getAllCategories:function(){
     axios.get("http://localhost/store2/back/categoriesBackend.php?action=read").then(function(response){
         if (response.data.error) {
           app2.errorMsg=response.data.message;
         }else{
           app2.categories=response.data.categories;
         }
       });
     },
    addCategory:function(){
      let formData=app2.toFormData(app2.newCategory);
      console.log(app2.newCategory);
      axios.post("http://localhost/store2/back/categoriesBackend.php?action=create",formData).then(function(response){
          app2.newCategory={name:""};
          console.log(response);
          if (response.data.error) {
            app2.errorMsg=response.data.message;
          }else{
            app2.successMsg=response.data.message;
            console.log(app2.successMsg);
            app2.getAllCategories();
          }
        });
    },
    updateCategory:function(){
      let formData=app2.toFormData(app2.currentCategory);
      axios.post("http://localhost/store2/back/categoriesBackend.php?action=update",formData).then(function(response){
          app2.currentUser={};
          if (response.data.error) {
            app2.errorMsg=response.data.message;
          }else{
            app2.successMsg=response.data.message;
            console.log(response);
            app2.getAllCategories();
          }
        });
    },
    deleteCategory:function(){

        let formData=app2.toFormData(app2.currentCategory);
        axios.post("http://localhost/store2/back/categoriesBackend.php?action=delete",formData).then(function(response){
          app2.currentCategory={};
          if (response.data.error) {
            app2.errorMsg=response.data.message;
          }else{
            app2.successMsg=response.data.message;
            app2.getAllCategories();
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
    selectCategory:function(category){
      app2.currentCategory=category;
    },
    clearMsg:function(){
      app2.errorMsg='';
      app2.successMsg='';
    }

  },
  computed:{
    filter:function(){
      return this.categories.filter((item)=> item.name.toLowerCase().includes(this.search.toLowerCase())
                                          || item.id.includes(this.search))
    }
  }
});
