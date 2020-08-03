<?php
$conn=new mysqli("localhost","root","juanmanuel","store2_db");

if (!$conn->connect_error) {
  // echo "conexion exitosa";
}else{
  // echo "no fue posible conectarse";
}

$action="";
$resp= Array('error'=>false);

if (isset($_GET['action'])) {
  $action=$_GET['action'];
}

if ($action=="login") {
  $email=$_POST['email'];
  $pass=$_POST['pass'];

  $sql=$conn->query("SELECT id,identification,name,email,phone FROM users WHERE email='$email' and password='$pass' ");
  $user=Array();
  if ($row=$sql->fetch_assoc()) {
    array_push($user,$row);
  }

  if ($user) {
    session_start();
    $_SESSION['user']=$user[0];
    $resp['user']=$user;
    $resp['lasesion']=$_SESSION['user'];

  }else{
    // echo "No existe";

  }

}

echo json_encode($resp);
 ?>
