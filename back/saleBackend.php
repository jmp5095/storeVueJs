<?php
$conn=new mysqli("localhost","root","juanmanuel","store2_db");
if ($conn->connect_error) {
  die("Conection failded!! "+$conn->connect_error);
}else{
  // echo "conectio successfull";
}

$result=array('error'=>false);
$action='';

if (isset($_GET['action'])) {
  $action=$_GET['action'];

}

if ($action=='create') {
  $seller_id=$_POST['seller_id'];
  $sql=$conn->query("INSERT INTO sales (seller_id,created_up)
  VALUES($seller_id,NOW())");

  $rs = $conn->query("SELECT MAX(id) AS id FROM sales");
    if ($row =$rs->fetch_assoc()) {
      $id = $row;
    }
    $result['sale_id']= $id['id'];

}

//create
if ($action=='productsSales') {
  $quantity=$_POST['quantity'];
  $sale_id=$_POST['sale_id'];
  $product_id=$_POST['product_id'];

  $sql=$conn->query("INSERT INTO products_sales (quantity,sale_id,product_id)
  VALUES('$quantity',$sale_id,'$product_id')");
  $result['sql']="INSERT INTO products_sales (quantity,sale_id,product_id)
  VALUES('$quantity',$sale_id,'$product_id')";
  if ($sql) {
    $result['message']="Venta exitosa!";
  }else{
    $result['error']=true;
    $result['message']="No fue posible realizar el registro de la venta!";
  }
}

//update product
if ($action=='update') {
  $id=$_POST['product_id'];
  $stock=$_POST['stock'];
  $sql=$conn->query("UPDATE products SET stock='$stock' WHERE id='$id'");
  $result['resp']="UPDATE products SET stock='$stock' WHERE id='$id'";
  if ($sql) {
  }else{
    $result['error']=true;
  }
}

$conn->close();
echo json_encode($result);
 ?>
