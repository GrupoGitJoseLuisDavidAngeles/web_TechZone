CREATE DATABASE IF NOT EXISTS tienda_online
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE tienda_online;

SET NAMES utf8mb4;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'cliente') DEFAULT 'cliente'
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    categoria_id INT NOT NULL,
    imagen VARCHAR(255),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE carritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE carrito_productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    carrito_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    FOREIGN KEY (carrito_id) REFERENCES carritos(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id),
    UNIQUE (carrito_id, producto_id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO categorias (nombre, descripcion) VALUES
('Portátiles', 'Ordenadores portátiles'),
('Sobremesa', 'PCs de sobremesa'),
('Componentes', 'Componentes hardware'),
('Periféricos', 'Teclados, ratones, monitores, etc.');

INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) VALUES
('ASUS VivoBook 15', 'Portátil 15.6" Intel i5, 16GB RAM, 512GB SSD', 699.99, 15, 1, 'laptop.png'),
('HP Pavilion Gaming', 'Portátil gaming AMD Ryzen 5, GTX 1650, 16GB RAM', 849.99, 8, 1, 'laptop.png'),
('Lenovo ThinkPad E14', 'Portátil profesional Intel i7, 16GB RAM, 1TB SSD', 1099.00, 5, 1, 'laptop.png');

INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) VALUES
('PC Gaming Ryzen 7', 'Ryzen 7 5800X, RTX 3070, 32GB RAM, 1TB SSD', 1799.99, 4, 2, 'desktop.png'),
('PC Oficina Básico', 'Intel i3, 8GB RAM, 256GB SSD', 499.99, 10, 2, 'desktop.png'),
('PC Creator Pro', 'Intel i9, RTX 4080, 64GB RAM, 2TB SSD', 2999.00, 2, 2, 'desktop.png');

INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) VALUES
('AMD Ryzen 5 5600X', 'Procesador 6 núcleos 12 hilos', 189.99, 20, 3, 'cpu.png'),
('NVIDIA RTX 4060', 'Tarjeta gráfica 8GB GDDR6', 329.99, 12, 3, 'gpu.png'),
('Corsair Vengeance 16GB', 'Memoria RAM DDR4 3200MHz (2x8GB)', 79.99, 30, 3, 'ram.png'),
('Samsung 970 EVO Plus 1TB', 'SSD NVMe 1TB alta velocidad', 109.99, 18, 3, 'ssd.png');

INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) VALUES
('Logitech G Pro X', 'Teclado mecánico gaming RGB', 129.99, 25, 4, 'keyboard.png'),
('Razer DeathAdder V2', 'Ratón gaming óptico 20.000 DPI', 59.99, 40, 4, 'mouse.png'),
('LG UltraGear 27"', 'Monitor gaming 144Hz 1ms', 299.99, 7, 4, 'monitor.png'),
('HyperX Cloud II', 'Auriculares gaming con sonido 7.1', 99.99, 14, 4, 'headphones.png');
