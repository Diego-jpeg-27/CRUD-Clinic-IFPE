CREATE DATABASE IF NOT EXISTS sistema_ifpe;
USE sistema_ifpe;

-- Tabela de Médicos
CREATE TABLE medico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    especialidade VARCHAR(100) NOT NULL,
    crm VARCHAR(20) NOT NULL UNIQUE
);

-- Tabela de Pacientes (agora com campo de imagem de perfil)
CREATE TABLE paciente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    data_nascimento DATE NOT NULL,
    tipo_sanguineo VARCHAR(5) NOT NULL,
    foto VARCHAR(255)  -- /storage
);

-- Tabela de Consultas (relacionamento com restrição de unicidade)
CREATE TABLE consulta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_medico INT NOT NULL,
    id_paciente INT NOT NULL,
    data_hora DATETIME NOT NULL,
    observacoes TEXT,
    
    UNIQUE (id_medico, id_paciente, data_hora), 

    FOREIGN KEY (id_medico) REFERENCES medico(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (id_paciente) REFERENCES paciente(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Tabela de Usuários
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);