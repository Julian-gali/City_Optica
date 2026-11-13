-- ====================================================================
-- SCRIPT SQL PARA CREAR LA BASE DE DATOS DE CITY ÓPTICA
-- ====================================================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS cityoptica;
USE cityoptica;

-- ====================================================================
-- TABLA DE USUARIOS (ADMINISTRADORES)
-- ====================================================================
CREATE TABLE usuario (
    idUsuario INT PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(50) UNIQUE NOT NULL,
    clave VARCHAR(100) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    activo INT DEFAULT 1
);

-- Insertar usuarios de prueba
INSERT INTO usuario (login, clave, nombre) VALUES 
('admin', 'admin123', 'Administrador Sistema'),
('vendedor', 'vendedor123', 'Vendedor City Óptica'),
('gerente', 'gerente123', 'Gerente');

-- ====================================================================
-- TABLA DE CATEGORÍAS
-- ====================================================================
CREATE TABLE categoria (
    idCategoria INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    activo INT DEFAULT 1
);

-- Insertar categorías de prueba
INSERT INTO categoria (nombre, descripcion) VALUES 
('Monturas', 'Monturas y armazones para lentes'),
('Lentes de Contacto', 'Lentes de contacto de diferentes tipos'),
('Gafas de Sol', 'Gafas de sol con protección UV'),
('Accesorios', 'Accesorios para cuidado de gafas'),
('Lentes Oftálmicos', 'Lentes graduados de calidad');

-- ====================================================================
-- TABLA DE PRODUCTOS
-- ====================================================================
CREATE TABLE producto (
    idProducto INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    idCategoria INT NOT NULL,
    imagen VARCHAR(255),
    activo INT DEFAULT 1,
    fechaCreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idCategoria) REFERENCES categoria(idCategoria)
);

-- Insertar productos de prueba
INSERT INTO producto (nombre, descripcion, precio, idCategoria, imagen) VALUES 
('Monturas Ray-Ban Classic', 'Monturas clásicas Ray-Ban en color negro. Diseño clásico y atemporal que combina con cualquier estilo.', 150.00, 1, 'rayban_classic.jpg'),
('Monturas Tommy Hilfiger', 'Monturas modernas Tommy Hilfiger en color plateado. Perfecto para uso diario y profesional.', 120.00, 1, 'tommy_hilfiger.jpg'),
('Lentes Progresivos Premium', 'Lentes progresivos de última generación para corrección completa de visión a cualquier distancia.', 250.00, 5, 'lentes_progresivo.jpg'),
('Lentes Antirreflejo', 'Lentes con tratamiento antirreflejo para mejor visión y menos fatiga ocular.', 180.00, 5, 'lentes_antirreflejo.jpg'),
('Gafas de Sol Polarizadas', 'Gafas de sol con lentes polarizados para máxima protección solar.', 95.00, 3, 'gafas_sol.jpg'),
('Lentes de Contacto Diarias', 'Lentes de contacto cómodas para uso diario. Caja con 30 lentes.', 45.00, 2, 'lentes_contacto_diarias.jpg'),
('Monturas Infantiles', 'Monturas coloridas y resistentes diseñadas especialmente para niños.', 85.00, 1, 'monturas_infantiles.jpg'),
('Estuche Premium', 'Estuche de calidad para guardar y proteger tus gafas.', 25.00, 4, 'estuche.jpg'),
('Paño de Limpieza', 'Paño especial para limpiar lentes sin rayarlos.', 5.00, 4, 'pano_limpieza.jpg'),
('Gotitas Lubricantes', 'Gotitas lubricantes para mantener los ojos hidratados.', 12.00, 4, 'gotitas_oculares.jpg');

-- ====================================================================
-- TABLA DE CLIENTES
-- ====================================================================
CREATE TABLE cliente (
    idCliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    documento VARCHAR(20) UNIQUE NOT NULL,
    telefono VARCHAR(15),
    email VARCHAR(100) UNIQUE NOT NULL,
    tipoLente VARCHAR(50),
    fechaRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar clientes de prueba
INSERT INTO cliente (nombre, documento, telefono, email, tipoLente) VALUES 
('Juan Pérez García', '1234567890', '3001234567', 'juan.perez@email.com', 'Monofocal'),
('María García López', '0987654321', '3009876543', 'maria.garcia@email.com', 'Progresivo'),
('Carlos López Martínez', '1122334455', '3011223344', 'carlos.lopez@email.com', 'Bifocal');

-- ====================================================================
-- TABLA DE CARRITO
-- ====================================================================
CREATE TABLE carrito (
    idCarrito INT PRIMARY KEY AUTO_INCREMENT,
    idCliente INT,
    idProducto INT NOT NULL,
    cantidad INT DEFAULT 1,
    fechaAgregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idCliente) REFERENCES cliente(idCliente),
    FOREIGN KEY (idProducto) REFERENCES producto(idProducto)
);

-- ====================================================================
-- TABLA DE PEDIDOS
-- ====================================================================
CREATE TABLE pedido (
    idPedido INT PRIMARY KEY AUTO_INCREMENT,
    idCliente INT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado VARCHAR(50) DEFAULT 'pendiente',
    monto DECIMAL(10, 2),
    FOREIGN KEY (idCliente) REFERENCES cliente(idCliente)
);

-- ====================================================================
-- TABLA DE DETALLE DE PEDIDOS
-- ====================================================================
CREATE TABLE detallePedido (
    idDetalle INT PRIMARY KEY AUTO_INCREMENT,
    idPedido INT NOT NULL,
    idProducto INT NOT NULL,
    cantidad INT,
    precio DECIMAL(10, 2),
    FOREIGN KEY (idPedido) REFERENCES pedido(idPedido),
    FOREIGN KEY (idProducto) REFERENCES producto(idProducto)
);

-- ====================================================================
-- TABLA DE COMENTARIOS (para la API REST)
-- ====================================================================
CREATE TABLE comentario (
    idComentario INT PRIMARY KEY AUTO_INCREMENT,
    idProducto INT NOT NULL,
    autor VARCHAR(100) NOT NULL,
    texto TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idProducto) REFERENCES producto(idProducto)
);

-- ====================================================================
-- TABLA DE CALIFICACIONES (para la API REST)
-- ====================================================================
CREATE TABLE calificacion (
    idCalificacion INT PRIMARY KEY AUTO_INCREMENT,
    idProducto INT NOT NULL,
    autor VARCHAR(100) NOT NULL,
    puntaje TINYINT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idProducto) REFERENCES producto(idProducto)
);

-- ====================================================================
-- ÍNDICES PARA MEJORAR RENDIMIENTO
-- ====================================================================
CREATE INDEX idx_usuario_login ON usuario(login);
CREATE INDEX idx_producto_categoria ON producto(idCategoria);
CREATE INDEX idx_cliente_email ON cliente(email);
CREATE INDEX idx_cliente_documento ON cliente(documento);
CREATE INDEX idx_carrito_cliente ON carrito(idCliente);
CREATE INDEX idx_pedido_cliente ON pedido(idCliente);
CREATE INDEX idx_comentario_producto ON comentario(idProducto);
CREATE INDEX idx_calificacion_producto ON calificacion(idProducto);

-- ====================================================================
-- FIN DEL SCRIPT
-- ====================================================================
-- La base de datos está lista para usar.
-- Usuario admin para acceder: login='admin' clave='admin123'
--
-- NOTA: Si la BD ya existe y tiene pedido/detallePedido con columnas antiguas,
-- ejecutar en phpMyAdmin antes de usar:
--   ALTER TABLE pedido CHANGE fechaPedido fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
--   ALTER TABLE pedido CHANGE total monto DECIMAL(10,2);
--   ALTER TABLE detallePedido CHANGE precioUnitario precio DECIMAL(10,2);
--   CREATE TABLE IF NOT EXISTS comentario (...) [ver arriba]
--   CREATE TABLE IF NOT EXISTS calificacion (...) [ver arriba]
