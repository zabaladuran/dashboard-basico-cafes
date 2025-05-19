
-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS cafeteria_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cafeteria_db;

-- Tabla de cafés
CREATE TABLE cafes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  descripcion TEXT
);

-- Tabla de clientes
CREATE TABLE clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(100)
);

-- Tabla de ventas
CREATE TABLE ventas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cafe_id INT NOT NULL,
  cliente_id INT NOT NULL,
  cantidad INT NOT NULL,
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (cafe_id) REFERENCES cafes(id),
  FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);


-- Insertar cafés de ejemplo
INSERT INTO cafes (nombre, precio, descripcion) VALUES
('Espresso', 3500, 'Café intenso y aromático, servido en taza pequeña.'),
('Cappuccino', 4500, 'Café con leche vaporizada y espuma.'),
('Latte', 4200, 'Café suave con abundante leche.'),
('Americano', 3000, 'Café filtrado, sabor suave y ligero.');

-- Insertar clientes de ejemplo
INSERT INTO clientes (nombre, email) VALUES
('Juan Pérez', 'juanperez@email.com'),
('Ana Gómez', 'anagomez@email.com'),
('Carlos Ruiz', 'carlosruiz@email.com');

-- Insertar ventas de ejemplo
INSERT INTO ventas (cafe_id, cliente_id, cantidad) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 1, 1),
(4, 3, 3);

