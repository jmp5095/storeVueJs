
const app=new Vue({
  el:'#app',
  data:{
    errorMsg:'',
    successMsg:'',
    showAddModal:false,
    showEditModal:false,
    showDeleteModal:false,
    users:[],
    newUser:{identification:"",name:"",email:"",phone:""},
    currentUser:{}
  },
  mounted: function(){
    this.getAllUsers();
  },
  methods:{
    getAllUsers(){
     axios.get("http://localhost/store2/back/users.php?action=read").then(function(response){
         if (response.data.error) {
           app.errorMsg=response.data.message;
         }else{
           app.users=response.data.users;
         }
       });
     },
    addUser(){
      let formData=app.toFormData(app.newUser);
      console.log(formData);
      axios.post("http://localhost/store2/back/users.php?action=create",formData).then(function(response){
          app.newUser={identification:"",name:"",email:"",phone:""};
          if (response.data.error) {
            app.errorMsg=response.data.message;
          }else{
            app.successMsg=response.data.message;
            app.getAllUsers();
          }
        });
    },
    updateUser(){
      let formData=app.toFormData(app.currentUser);
      axios.post("http://localhost/store2/back/users.php?action=update",formData).then(function(response){
          app.currentUser={};
          if (response.data.error) {
            app.errorMsg=response.data.message;
          }else{
            app.successMsg=response.data.message;
            app.getAllUsers();
          }
        });
    },
    deleteUser(){

        let formData=app.toFormData(app.currentUser);
        axios.post("http://localhost/store2/back/users.php?action=delete",formData).then(function(response){
          app.currentUser={};
          if (response.data.error) {
            app.errorMsg=response.data.message;
          }else{
            app.successMsg=response.data.message;
            app.getAllUsers();
          }
        });
    },
    toFormData(obj){
      let fd=new FormData();
      for (let i in obj) {
        fd.append(i,obj[i])
      }
      return fd;
    },
    selectUser(user){
      app.currentUser=user;
    },
    clearMsg(){
      app.errorMsg='';
      app.successMsg='';
    }

  }
});
