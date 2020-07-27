<?php
  $conn=new mysqli("localhost","root","juanmanuel","store2_db");
  if ($conn->connect_error) {
    die("Connection Failed! ".$conn->connect_error);
  }else{
    // echo "success connect!";
  }
  $result=array('error'=>false);
  $action='';

  if (isset($_GET['action'])) {
    $action=$_GET['action'];
  }

  //my users
  if ($action=='read') {
    $sql=$conn->query("SELECT * FROM users");
    $users=array();
    while($row=$sql->fetch_assoc()){
      array_push($users,$row);
    }
    $result['users']=$users;
  }

  //create user
  if ($action=='create') {
    $identification=$_POST['identification'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $sql=$conn->query("INSERT INTO users (identification,name,email,phone)
    VALUES('$identification','$name','$email','$phone')");

    if ($sql) {
      $result['message']="Registro Exitoso!";
    }else{
      $result['error']=true;
      $result['message']="No fue posible realizar el registro!";
    }
  }
  //update user
  if ($action=='update') {
    $id=$_POST['id'];
    $identification=$_POST['identification'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $sql=$conn->query("UPDATE users SET identification='$identification', name='$name', email='$email', phone='$phone' WHERE id='$id'");


    if ($sql) {
      $result['message']="Actualización Exitosa!";
    }else{
      $result['error']=true;
      $result['message']="Fallo en la actualización!";
    }
  }
  //delete user
  if ($action=='delete') {
    $id=$_POST['id'];

    $sql=$conn->query("DELETE FROM users WHERE id='$id'");

    if ($sql) {
      $result['message']="Eliminación Exitosa!";
    }else{
      $result['error']=true;
      $result['message']="Fallo en la eliminación!";
    }
  }

  $conn->close();
  echo json_encode($result);
 ?>
