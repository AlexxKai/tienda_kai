-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `tienda_kai` ;

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `tienda_kai` DEFAULT CHARACTER SET utf8 ;
USE `tienda_kai` ;

-- -----------------------------------------------------
-- Table `mydb`.`Productos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tienda_kai`.`usuarios` ;

-- Crear la tabla de usuarios
CREATE TABLE usuarios (
    ID_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre_apellidos VARCHAR(100) NOT NULL,
    telefono VARCHAR(15),
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

-- Crear la tabla de productos
CREATE TABLE productos (
    ID_producto INT PRIMARY KEY AUTO_INCREMENT,
    cantidad INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    fabricante VARCHAR(100)
);

-- Crear la tabla de pedidos
CREATE TABLE pedidos (
    ID_pedido INT PRIMARY KEY AUTO_INCREMENT,
    ID_usuario INT,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_usuario) REFERENCES usuarios(ID_usuario)
);

-- Crear la tabla de detalles de pedido
CREATE TABLE detalles_pedido (
    ID_detalle INT PRIMARY KEY AUTO_INCREMENT,
    ID_pedido INT,
    ID_producto INT,
    cantidad INT NOT NULL,
    FOREIGN KEY (ID_pedido) REFERENCES pedidos(ID_pedido),
    FOREIGN KEY (ID_producto) REFERENCES productos(ID_producto)
);

-- Crear la tabla de carrito de compras
CREATE TABLE carrito_compras (
    ID_usuario INT,
    ID_producto INT,
    cantidad INT NOT NULL,
    PRIMARY KEY (ID_usuario, ID_producto),
    FOREIGN KEY (ID_usuario) REFERENCES usuarios(ID_usuario),
    FOREIGN KEY (ID_producto) REFERENCES productos(ID_producto)
);

-- Crear la tabla de favoritos
CREATE TABLE favoritos (
    ID_usuario INT,
    ID_producto INT,
    PRIMARY KEY (ID_usuario, ID_producto),
    FOREIGN KEY (ID_usuario) REFERENCES usuarios(ID_usuario),
    FOREIGN KEY (ID_producto) REFERENCES productos(ID_producto)
);
