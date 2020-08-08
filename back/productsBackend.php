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
    $sql=$conn->query("SELECT p.id,p.name,p.stock,p.price,c.id as c_id,c.name as c_name FROM products p,categories c where p.category_id=c.id");
    $products=array();
    while($row=$sql->fetch_assoc()){
      $row['quantity']=0;
      array_push($products,$row);
    }
    $result['products']=$products;
  }

  //create
  if ($action=='create') {
    $name=$_POST['name'];
    $stock=$_POST['stock'];
    $price=$_POST['price'];
    $category_id=$_POST['category_id'];
    $sql=$conn->query("INSERT INTO products (name,stock,price,category_id)
    VALUES('$name','$stock','$price','$category_id')");
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
    $stock=$_POST['stock'];
    $price=$_POST['price'];
    $category_id=$_POST['c_id'];
    $sql=$conn->query("UPDATE products SET name='$name',stock='$stock',price='$price',category_id='$category_id' WHERE id='$id'");

    if ($sql) {
      $result['message']="Actualización Exitosa!";
    }else{
      $result['error']=true;
      $result['message']="Fallo en la actualización! "+$sql->getMessage();
    }
  }
  //delete
  if ($action=='delete') {
    $id=$_POST['id'];

    $sql=$conn->query("DELETE FROM products WHERE id='$id'");

    if ($sql) {
      $result['message']="Eliminación Exitosa!";
    }else{
      $result['error']=true;
      $result['message']="Fallo en la eliminación!";
    }
  }

  //filter
  if ($action=="filter") {
    $keyup=$_POST['value'];
    $sql=$conn->query("SELECT p.id, p.name,p.stock,p.price,c.id as c_id,c.name as c_name
      FROM products p,categories c
      WHERE p.category_id=c.id and (p.name like '%$keyup%' or c.name like '%$keyup%') ");

    $products=array();
    while ($row=$sql->fetch_assoc()) {
      $row['quantity']=0;
      array_push($products,$row);
    }
    $result['products']=$products;
  }

  $conn->close();
  echo json_encode($result);
 ?>
