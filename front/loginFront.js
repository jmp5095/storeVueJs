//global
let myres;
//my dom elements
let messUI=(mess)=>{
  document.querySelector('#message').innerHTML=`<span class="alert alert-secondary col-sm-15 text-center font-weight-bold">${mess}</span>`;
}
let emailUI=()=>{
  return document.querySelector('#email').value;
}

let passUI=()=>{
  return document.querySelector('#pass').value;
}

let userSession=()=>{
  let email=emailUI();
  let pass=passUI();
  let salida="";

  let exRegEmail=/^([a-zA-Z0-9-_.])+@[a-zA-z]+\.[a-z]{2,4}(\.[a-z]{2})?$/;
  let expRegPass=/^[a-zA-Z0-9_@]{3,16}$/;

  if (email.match(exRegEmail)) {
    if (pass.match(expRegPass)) {

      let user=verifyUserAxios(email,pass);

    }else {
      messUI("Formato de contraseña erronea")
      resUI=false
    }
  }else{
    resUI=false
    messUI("Formato de correo erroneo")
  }
  return false;
}

let verifyUserAxios=(e,p)=>{
  let u={
    email:e,
    pass:p
  }
  var user = [];
  let formData=toFormData(u);
  let prom= axios.post('http://localhost/store2/back/loginBackend.php?action=login',formData).then(function(response){

    if (! response.data.error) {
        if (response.data.user[0]) {

          window.location.href='http://localhost/store2/'

          localStorage.setItem('user',JSON.stringify(response.data.user))
        }else{
          console.log('no logueado')
          messUI("credenciales incorrectas!")

        }

    }else{
      console.log(response.data);

    }
  });
  return prom;
}


let mymess=(m)=>{
  console.log(m)
}


let toFormData=(obj)=>{
  let fd=new FormData();
  for (var i in obj) {
    fd.append(i,obj[i])
  }
  return fd
}

////////
