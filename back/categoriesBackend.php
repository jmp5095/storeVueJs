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

  //my categories
  if ($action=='read') {
    $sql=$conn->query("SELECT * FROM categories");
    $categories=array();
    while($row=$sql->fetch_assoc()){
      array_push($categories,$row);
    }
    $result['categories']=$categories;
  }

  //create
  if ($action=='create') {
    $name=$_POST['name'];
    $sql=$conn->query("INSERT INTO categories (name)
    VALUES('$name')");
    $result['resp']=$sql;
    if ($sql) {
      $result['message']="Registro Exitoso!";
    }else{
      $result['error']=true;
      $result['message']="No fue posible realizar el registro!";
    }
  }
  //update
  if ($action=='update') {
    $id=$_POST['id'];
    $name=$_POST['name'];
    $sql=$conn->query("UPDATE categories SET name='$name' WHERE id='$id'");

    if ($sql) {
      $result['message']="Actualización Exitosa!";
    }else{
      $result['error']=true;
      $result['message']="Fallo en la actualización!";
    }
  }
  //delete
  if ($action=='delete') {
    $id=$_POST['id'];

    $sql=$conn->query("DELETE FROM categories WHERE id='$id'");

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
