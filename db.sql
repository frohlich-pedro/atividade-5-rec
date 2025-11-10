CREATE DATABASE IF NOT EXISTS padaria;
USE padaria;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    data_contratacao DATE NOT NULL
);

CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
);

CREATE TABLE produtos (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    quantidade_estoque INT NOT NULL,
    id_categoria INT,
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefone VARCHAR(20),
    endereco VARCHAR(255),
    data_cadastro DATE NOT NULL
);

CREATE TABLE pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    data_pedido DATETIME NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'pendente',
    id_cliente INT NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

CREATE TABLE itens_pedido (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    id_pedido INT NOT NULL,
    id_produto INT NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido),
    FOREIGN KEY (id_produto) REFERENCES produtos(id_produto)
);

INSERT INTO usuarios (nome, email, senha_hash, telefone, data_contratacao) VALUES 
('Admin', 'admin@padaria.com', '$2y$10$Hixe4e5v5B3eB7F6k2S9e.F6f6c6dE7f6g7H8i9j0k1l2m3n4o5p6q', '(11) 9999-9999', '2024-01-01');

INSERT INTO categorias (nome, descricao) VALUES 
('Pães', 'Pães diversos'),
('Bolos', 'Bolos caseiros'),
('Salgados', 'Salgados assados'),
('Doces', 'Doces e sobremesas');

INSERT INTO produtos (nome, descricao, preco, quantidade_estoque, id_categoria, id_usuario) VALUES 
('Pão Francês', 'Pão francês tradicional', 0.50, 100, 1, 1),
('Bolo de Chocolate', 'Bolo de chocolate caseiro', 25.00, 10, 2, 1),
('Coxinha', 'Coxinha de frango', 4.50, 30, 3, 1);
