CREATE DATABASE IF NOT EXISTS investai CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE investai;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS ativos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticker VARCHAR(20) NOT NULL UNIQUE,
    nome VARCHAR(150),
    tipo VARCHAR(30),
    setor VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    ticker VARCHAR(20) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY favorito_usuario_ativo (usuario_id, ticker),
    CONSTRAINT fk_favoritos_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON DELETE CASCADE
);

INSERT INTO ativos (ticker, nome, tipo, setor) VALUES
('PETR4', 'Petrobras PN', 'Acao', 'Petroleo, Gas e Biocombustiveis'),
('VALE3', 'Vale ON', 'Acao', 'Mineracao'),
('ITUB4', 'Itau Unibanco PN', 'Acao', 'Financeiro'),
('MXRF11', 'Maxi Renda FII', 'FII', 'Papel')
ON DUPLICATE KEY UPDATE
    nome = VALUES(nome),
    tipo = VALUES(tipo),
    setor = VALUES(setor);
