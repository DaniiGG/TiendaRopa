CREATE DATABASE IF NOT EXISTS tienda;
SET NAMES UTF8;
CREATE DATABASE IF NOT EXISTS tienda;
USE tienda;

DROP TABLE IF EXISTS usuarios;
CREATE TABLE IF NOT EXISTS usuarios(
    id int(255) auto_increment not null,
    nombre varchar(100) not null,
    apellidos varchar(255),
    email varchar(255) not null,
    pass varchar(255) not null,
    rol varchar(20),
    CONSTRAINT pk_usuarios PRIMARY KEY(id),
    CONSTRAINT uq_email UNIQUE(email)
) ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS categorias;
CREATE TABLE IF NOT EXISTS categorias(
    id int(255) auto_increment not null,
    nombre varchar(100) not null,
    CONSTRAINT pk_categorias PRIMARY KEY(id)
) ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS productos;
CREATE TABLE IF NOT EXISTS productos(
    id int(255) auto_increment not null,
    categoria_id int(255) not null,
    nombre varchar(100) not null,
    descripcion text,
    precio float(100,2) not null,
    stock int(255) not null,
    oferta varchar(2),
    fecha date not null,
    imagen varchar(255),
    CONSTRAINT pk_productos PRIMARY KEY(id),
    CONSTRAINT fk_producto_categoria FOREIGN KEY(categoria_id) REFERENCES categorias(id)
) ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS pedidos;
CREATE TABLE IF NOT EXISTS pedidos(
    id int(255) auto_increment not null,
    usuario_id int(255) not null,
    provincia varchar(100) not null,
    localidad varchar(100) not null,
    direccion varchar(255) not null,
    coste float(200,2) not null,
    estado varchar(20) not null,
    fecha date,
    hora time,
    CONSTRAINT pk_pedidos PRIMARY KEY(id),
    CONSTRAINT fk_pedido_usuario FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS lineas_pedidos;
CREATE TABLE IF NOT EXISTS lineas_pedidos(
    id int(255) auto_increment not null,
    pedido_id int(255) not null,
    producto_id int(255) not null,
    unidades int(255) not null,
    CONSTRAINT pk_lineas_pedidos PRIMARY KEY(id),
    CONSTRAINT fk_linea_pedido FOREIGN KEY(pedido_id) REFERENCES pedidos(id),
    CONSTRAINT fk_linea_producto FOREIGN KEY(producto_id) REFERENCES productos(id)
) ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Usuarios Table
INSERT INTO usuarios (nombre, apellidos, email, pass, rol)
VALUES 
    ('Admin', 'Perez', 'admin@gmail.com', '$2y$04$GRztoMIyveHDlDcOI78UL.wd8YoV/kzDf.Yl1v6kVD.FBRirFXqpi', 'admin'), -- contraseña: admin123
    ('Maria', 'Gomez', 'user@gmail.com', '$2y$04$oIsVKwzT2df0b.caOiXyV.so/.eBqpcOmH.FwGzxfxDDI2Qiwc4qa', 'user'); -- contraseña: user123

-- Categorias Table
INSERT INTO categorias (nombre) VALUES ('Camisas'), ('Pantalones'), ('Zapatillas');

-- Productos Table
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen)
VALUES 
    (1, 'Camisa', 'Camisa muy bonita', 30, 30, 'no', '2024-01-21', 'img/61L7JvSMYlL.AC_UY1000.jpg'),
    (2, 'Pantalón', 'Pantalón de algodón con diseño moderno', 29, 25, 'NO', '2024-01-21', 'img/spa_pl_Pantalon-grueso-de-chandal-cargo-para-hombre-negro-Bolf-JX9395A-89767_7.jpg'),
    (3, 'Zapatillas deporte', 'Zapatillas de alto rendimiento para running', 129, 30, 'No', '2024-01-21', 'img/319088057_830885034831807_3100388459411120041_n-1.jpg');

-- Pedidos Table
INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora)
VALUES (1, 'Provincia Ejemplo', 'Localidad Ejemplo', 'Dirección Ejemplo', 50.99, 'Pendiente', '2024-01-21', '12:30:00');

-- Lineas_pedidos Table
INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades)
VALUES (1, 1, 2);
