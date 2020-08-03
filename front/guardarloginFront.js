//global
let myres;
//my dom elements
let messUI=(mess)=>{
  document.querySelector('#message').innerHTML=`<span class="alert alert-secondary col-sm-15 text-center font-weight-bold">${mess}</span>`;
}


let userSession=()=>{
  let email="jmperea76@misena.edu.co";
  let pass="123";
  let salida="";

  let exRegEmail=/^([a-zA-Z0-9-_.])+@[a-zA-z]+\.[a-z]{2,4}(\.[a-z]{2})?$/;
  let expRegPass=/^[a-zA-Z0-9_@]{3,16}$/;

  if (email.match(exRegEmail)) {
    if (pass.match(expRegPass)) {

      let user=verifyUserAxios(email,pass);

      if (false) {
        console.log(user)
      }else{
        messUI("credenciales incorrectas!")

        return false

      }

    }else {
      messUI="Formato de contraseña erronea"
    }
  }else{
    messUI="Formato de correo erroneo"
  }

}

let verifyUserAxios=(e,p)=>{
  let u={
    email:e,
    pass:p
  }
  var user = [];
  let formData=toFormData(u);
   axios.post('http://localhost/store2/back/loginBackend.php?action=login',formData).then(function(response){
    if (!response.data.error) {
      if (response.data.user[0]) {
        user.push(response.data.user[0])
        myres=true
      }else{
        myres=false;

      }
    }else{
      console.log(response.data);

    }
  });
  return user
}


let saveUser=(bool)=>{
  sessionStorage.setItem('find',bool);
}


let toFormData=(obj)=>{
  let fd=new FormData();
  for (var i in obj) {
    fd.append(i,obj[i])
  }
  return fd
}

////////
