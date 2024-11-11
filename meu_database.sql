-- Criação do banco de dados
CREATE DATABASE devs_do_rn;

-- Tabela de associados
CREATE TABLE associados (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    data_filiacao DATE NOT NULL
);

-- Tabela de anuidades
CREATE TABLE anuidades (
    id SERIAL PRIMARY KEY,
    ano INT NOT NULL,
    valor DECIMAL(10, 2) NOT NULL
);

-- Tabela de pagamentos
CREATE TABLE pagamentos (
    id SERIAL PRIMARY KEY,
    associado_id INT NOT NULL,
    anuidade_id INT NOT NULL,
    pago BOOLEAN NOT NULL DEFAULT FALSE,
    data_pagamento DATE,
    FOREIGN KEY (associado_id) REFERENCES associados(id),
    FOREIGN KEY (anuidade_id) REFERENCES anuidades(id)
);
