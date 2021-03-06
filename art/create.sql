<<<<<<< HEAD
USE art_webapp_prototype;

DROP TABLE IF EXISTS purchaseItem;
DROP TABLE IF EXISTS purchase;
DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS product;

CREATE TABLE customer(
  CustEmail varchar(255) NOT NULL,
  CustFName CHAR(50) NOT NULL,
  CustLName CHAR(50) NOT NULL,
  Address varchar(255) NOT NULL,
  State varchar(255) NOT NULL,
  Country varchar(255) NOT NULL,
  PostCode varchar(50) NOT NULL,
  Phone varchar(12) NOT NULL,
  PRIMARY KEY (CustEmail)
)ENGINE=InnoDB, DEFAULT CHARACTER SET utf8;

CREATE TABLE product(
  ProductNo INT(11) NOT NULL AUTO_INCREMENT,
  ProductName varchar(50) NOT NULL,
  Description text NOT NULL,
  price INT(10) NOT NULL,
  Category varchar(255) NOT NULL,
  Size varchar(50) NOT NULL,
  picture varchar(255),
  OnShow INT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (ProductNo)
)ENGINE=InnoDB, DEFAULT CHARACTER SET utf8;

CREATE TABLE purchase(
  PurchaseNo INT(11) NOT NULL AUTO_INCREMENT,
  PurchaseDate DATETIME NOT NULL DEFAULT NOW(),
  CustEmail varchar(255) NOT NULL,
  PRIMARY KEY (PurchaseNo),
  FOREIGN KEY (CustEmail) REFERENCES customer(CustEmail)
)ENGINE=InnoDB, DEFAULT CHARACTER SET utf8;

CREATE TABLE purchaseItem(
  ItemNo INT(11) NOT NULL AUTO_INCREMENT,
  Quantity INT(3) NOT NULL,
  PurchaseNo INT(11) NOT NULL,
  ProductNo INT(11) NOT NULL,
  PRIMARY KEY (ItemNo),
  FOREIGN KEY (PurchaseNo) REFERENCES purchase(PurchaseNo),
  FOREIGN KEY (ProductNo) REFERENCES product(ProductNo)
)ENGINE=InnoDB, DEFAULT CHARACTER SET utf8;
=======
USE art_webapp_prototype;

DROP TABLE IF EXISTS purchaseItem;
DROP TABLE IF EXISTS purchase;
DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS product;

CREATE TABLE customer(
  CustEmail varchar(255) NOT NULL,
  CustFName CHAR(50) NOT NULL,
  CustLName CHAR(50) NOT NULL,
  Address varchar(255) NOT NULL,
  State varchar(255) NOT NULL,
  Country varchar(255) NOT NULL,
  PostCode varchar(50) NOT NULL,
  Phone varchar(12) NOT NULL,
  PRIMARY KEY (CustEmail)
)ENGINE=InnoDB, DEFAULT CHARACTER SET utf8;

CREATE TABLE product(
  ProductNo INT(11) NOT NULL AUTO_INCREMENT,
  ProductName varchar(50) NOT NULL,
  Description text NOT NULL,
  price INT(10) NOT NULL,
  Category varchar(255) NOT NULL,
  Size varchar(50) NOT NULL,
  picture varchar(255),
  OnShow INT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (ProductNo)
)ENGINE=InnoDB, DEFAULT CHARACTER SET utf8;

CREATE TABLE purchase(
  PurchaseNo INT(11) NOT NULL AUTO_INCREMENT,
  PurchaseDate DATETIME NOT NULL DEFAULT NOW(),
  CustEmail varchar(255) NOT NULL,
  PRIMARY KEY (PurchaseNo),
  FOREIGN KEY (CustEmail) REFERENCES customer(CustEmail)
)ENGINE=InnoDB, DEFAULT CHARACTER SET utf8;

CREATE TABLE purchaseItem(
  ItemNo INT(11) NOT NULL AUTO_INCREMENT,
  Quantity INT(3) NOT NULL,
  PurchaseNo INT(11) NOT NULL,
  ProductNo INT(11) NOT NULL,
  PRIMARY KEY (ItemNo),
  FOREIGN KEY (PurchaseNo) REFERENCES purchase(PurchaseNo),
  FOREIGN KEY (ProductNo) REFERENCES product(ProductNo)
)ENGINE=InnoDB, DEFAULT CHARACTER SET utf8;
>>>>>>> 289d02e5d992baf4dee82ca9fe6d884e774e649f
