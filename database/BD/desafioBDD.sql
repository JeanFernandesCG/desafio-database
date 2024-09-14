CREATE DATABASE desafio_banco_dados;

USE desafio_banco_dados;

CREATE TABLE
    cadastros (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        documento VARCHAR(20) NOT NULL,
        cep VARCHAR(10) NOT NULL,
        estado VARCHAR(2) NOT NULL,
        cidade VARCHAR(50) NOT NULL,
        endereco VARCHAR(100) NOT NULL
    );

CREATE TABLE
    tags (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(50) NOT NULL
    );

CREATE TABLE
    cadastros_tags (
        cadastro_id INT NOT NULL,
        tag_id INT NOT NULL,
        FOREIGN KEY (cadastro_id) REFERENCES cadastros (id) ON DELETE CASCADE,
        FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE,
        PRIMARY KEY (cadastro_id, tag_id)
    );

CREATE TABLE
    categorias (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(50) NOT NULL
    );

CREATE TABLE
    lancamentos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tipo ENUM ('pagar', 'receber') NOT NULL,
        status ENUM ('aberto', 'liquidado') NOT NULL,
        descricao VARCHAR(255) NOT NULL,
        valor DECIMAL(10, 2) NOT NULL,
        valor_liquidado DECIMAL(10, 2),
        vencimento DATE NOT NULL,
        liquidacao DATE,
        cadastro_id INT,
        categoria_id INT,
        FOREIGN KEY (cadastro_id) REFERENCES cadastros (id) ON DELETE SET NULL,
        FOREIGN KEY (categoria_id) REFERENCES categorias (id) ON DELETE SET NULL
    );