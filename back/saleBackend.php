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
//read sales
if ($action=='read') {
  $sql=$conn->query("SELECT s.id,u.name,s.created_up FROM sales s, users u WHERE s.seller_id=u.id");
  $sales=Array();
  while($row=$sql->fetch_assoc()){
    array_push($sales,$row);
  }
  $result['sales']=$sales;
}

//read bill
if ($action=='readBill') {
  $sale_id=$_POST['id'];

  $sql=$conn->query("SELECT p.name,ps.quantity, p.price
    FROM products_sales ps, products p
    WHERE ps.sale_id=$sale_id
    AND ps.product_id=p.id ");

  $bill=Array();
  while ($row=$sql->fetch_assoc()) {
    array_push($bill,$row);
  }

  $result['bill']=$bill;
}
//register or create sale
if ($action=='create') {
  session_start();
  $seller_id=$_SESSION['user']['id'];

  $sql=$conn->query("INSERT INTO sales (seller_id,created_up)
  VALUES($seller_id,NOW())");

  $rs = $conn->query("SELECT MAX(id) AS id FROM sales");
    if ($row =$rs->fetch_assoc()) {
      $id = $row;
    }else{
      $result['error']=true;
    }
    $result['sale_id']= $id['id'];

}

//create bill
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
  $quantity=$_POST['quantity'];
  $prod=$conn->query("SELECT stock FROM products where id=$id");
  $myProd=array();
  if ($row=$prod->fetch_assoc()) {
    array_push($myProd,$row);
  }
  $stock=$myProd[0]['stock'];
  $newStock=$stock - $quantity;
  $sql=$conn->query("UPDATE products SET stock='$newStock' WHERE id='$id'");
  $result['resp']="UPDATE products SET stock='$stock' WHERE id='$id'";
  if ($sql) {
  }else{
    $result['error']=true;
  }
}

// filter products

if ($action=="filter") {
  $keyup=$_POST['value'];
  $sql=$conn->query("SELECT s.id,u.name,s.created_up
    FROM sales s,users u
    WHERE s.seller_id=u.id
    and u.name like '%$keyup%'");

  $sales=array();
  while ($row=$sql->fetch_assoc()) {
    array_push($sales,$row);
  }
  $result['sales']=$sales;

}

if ($action=="filterDate") {
  $date=$_POST['value'];
  $sql=$conn->query("SELECT s.id,u.name,s.created_up
    FROM sales s, users u
    WHERE s.seller_id=u.id
    AND s.created_up LIKE'%$date%'");

  $sales=array();
  while($row=$sql->fetch_assoc()){
    array_push($sales,$row);
  }
  $result['sales']=$sales;
}

$conn->close();
echo json_encode($result);
 ?>
