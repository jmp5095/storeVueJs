CREATE TABLE users(
  id int(11) primary key auto_increment,
  name varchar(50) not null,
  email varchar(100) not null unique,
  phone varchar(30)
);

CREATE TABLE categories(
  id int(4) primary key auto_increment,
  name varchar(50) not null,
  );

CREATE TABLE products(
  id int(11) primary key auto_increment,
  name varchar(50) not null,
  stock int(100) not null,
  price decimal(30) not null,
  category_id int(3) not null,
  FOREIGN KEY (category_id) references categories(id)
);

CREATE TABLE sales(
  id int(11) primary key auto_increment,
  seller_id int(11) not null,
  created_up datetime,
  FOREIGN KEY (seller_id) references users(id)
);

CREATE TABLE products_sales(
  id int(11) primary key auto_increment,
  quantity int(11) not null,
  sale_id int(11) not null,
  product_id int(11) not null,
  FOREIGN KEY (sale_id) references sales(id),
  FOREIGN KEY (product_id) references products(id)
);

CREATE TABLE permiso_rol(
  per_rol_id int(11) primary key auto_increment,
  per_id int(11) not null,
  rol_id int(11) not null,
  FOREIGN KEY (per_id) references permiso(per_id),
  FOREIGN KEY (rol_id) references rol(rol_id)
);
