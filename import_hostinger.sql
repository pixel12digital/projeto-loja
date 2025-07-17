-- Script para importar no banco da Hostinger
-- Execute este script no phpMyAdmin da Hostinger

-- Tabela de Categorias
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    slug VARCHAR(100) UNIQUE,
    imagem VARCHAR(255),
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de Produtos
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    sku VARCHAR(50) UNIQUE NOT NULL,
    categoria_id INT,
    preco DECIMAL(10,2) NOT NULL,
    preco_promocional DECIMAL(10,2),
    estoque INT DEFAULT 0,
    peso DECIMAL(8,3),
    dimensoes VARCHAR(50),
    status ENUM('ativo', 'inativo', 'promocao') DEFAULT 'ativo',
    destaque BOOLEAN DEFAULT FALSE,
    meta_title VARCHAR(255),
    meta_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Tabela de Imagens dos Produtos
CREATE TABLE IF NOT EXISTS produto_imagens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    imagem VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    ordem INT DEFAULT 0,
    principal BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

-- Tabela de Tamanhos
CREATE TABLE IF NOT EXISTS tamanhos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(10) NOT NULL UNIQUE,
    ordem INT DEFAULT 0
);

-- Tabela de Produtos x Tamanhos
CREATE TABLE IF NOT EXISTS produto_tamanhos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tamanho_id INT NOT NULL,
    estoque INT DEFAULT 0,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE,
    FOREIGN KEY (tamanho_id) REFERENCES tamanhos(id)
);

-- Tabela de Clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    telefone VARCHAR(20),
    cpf VARCHAR(14) UNIQUE,
    data_nascimento DATE,
    senha VARCHAR(255) NOT NULL,
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de Endereços dos Clientes
CREATE TABLE IF NOT EXISTS cliente_enderecos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    nome VARCHAR(100),
    cep VARCHAR(9) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    complemento VARCHAR(100),
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado VARCHAR(2) NOT NULL,
    principal BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
);

-- Tabela de Pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(20) UNIQUE NOT NULL,
    cliente_id INT NOT NULL,
    status ENUM('pendente', 'processando', 'enviado', 'entregue', 'cancelado') DEFAULT 'pendente',
    total DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    frete DECIMAL(10,2) DEFAULT 0,
    desconto DECIMAL(10,2) DEFAULT 0,
    forma_pagamento VARCHAR(50),
    endereco_entrega TEXT,
    observacoes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- Tabela de Itens do Pedido
CREATE TABLE IF NOT EXISTS pedido_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    tamanho_id INT,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id),
    FOREIGN KEY (tamanho_id) REFERENCES tamanhos(id)
);

-- Tabela de Newsletter
CREATE TABLE IF NOT EXISTS newsletter (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    nome VARCHAR(255),
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Cupons de Desconto
CREATE TABLE IF NOT EXISTS cupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) UNIQUE NOT NULL,
    tipo ENUM('percentual', 'valor') NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    valor_minimo DECIMAL(10,2),
    limite_uso INT,
    usado INT DEFAULT 0,
    data_inicio DATE,
    data_fim DATE,
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Configurações da Loja
CREATE TABLE IF NOT EXISTS configuracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT,
    tipo VARCHAR(50) DEFAULT 'text',
    descricao TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de Usuários do Admin
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'estoquista', 'atendimento') DEFAULT 'admin',
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Inserir dados de exemplo

-- Categorias
INSERT INTO categorias (nome, descricao, slug) VALUES
('Vestidos', 'Vestidos elegantes para todas as ocasiões', 'vestidos'),
('Blusas', 'Blusas confortáveis e estilosas', 'blusas'),
('Calças', 'Calças com modelagem perfeita', 'calcas'),
('Íntimas', 'Lingerie confortável e sensual', 'intimas'),
('Saias', 'Saias elegantes e modernas', 'saias'),
('Casacos', 'Casacos e jaquetas da moda', 'casacos'),
('Acessórios', 'Acessórios para completar o look', 'acessorios');

-- Tamanhos
INSERT INTO tamanhos (nome, ordem) VALUES
('P', 1),
('M', 2),
('G', 3),
('GG', 4),
('XGG', 5),
('38', 6),
('40', 7),
('42', 8),
('44', 9),
('46', 10),
('48', 11),
('50', 12);

-- Produtos de exemplo
INSERT INTO produtos (nome, descricao, sku, categoria_id, preco, preco_promocional, estoque, status, destaque) VALUES
('Vestido Floral Manga Longa', 'Lindo vestido floral com manga longa, perfeito para o outono. Tecido fluido e modelagem que valoriza as curvas.', 'VF001', 1, 129.90, 159.90, 15, 'promocao', TRUE),
('Blusa Social Elegante', 'Blusa social em crepe, ideal para o ambiente de trabalho. Corte moderno e confortável.', 'BS002', 2, 89.90, NULL, 8, 'ativo', TRUE),
('Calça Jeans Skinny', 'Calça jeans com elastano, modelagem skinny que alonga a silhueta. Lavagem escura moderna.', 'CJ003', 3, 149.90, 189.90, 3, 'ativo', TRUE),
('Conjunto Íntimo Renda', 'Conjunto de sutiã e calcinha em renda delicada. Conforto e sensualidade em perfeita harmonia.', 'CI004', 4, 79.90, NULL, 22, 'ativo', TRUE),
('Vestido Midi Listrado', 'Vestido midi com listras verticais que afinam a silhueta. Manga 3/4 e decote V.', 'VM005', 1, 119.90, NULL, 12, 'ativo', FALSE),
('Blusa Básica Algodão', 'Blusa básica em algodão premium, disponível em várias cores. Essencial no guarda-roupa.', 'BB006', 2, 49.90, 39.90, 25, 'promocao', FALSE);

-- Usuário admin padrão (senha: admin123)
INSERT INTO usuarios (nome, email, senha, tipo) VALUES
('Administrador', 'admin@bellacurves.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Configurações padrão
INSERT INTO configuracoes (chave, valor, tipo, descricao) VALUES
('nome_loja', 'Bella Curves', 'text', 'Nome da loja'),
('email_contato', 'contato@bellacurves.com', 'email', 'Email de contato'),
('telefone_contato', '(11) 99999-9999', 'text', 'Telefone de contato'),
('endereco_loja', 'Rua das Flores, 123 - São Paulo/SP', 'text', 'Endereço da loja'),
('politica_privacidade', 'Política de privacidade da Bella Curves...', 'textarea', 'Política de privacidade'),
('termos_uso', 'Termos de uso da Bella Curves...', 'textarea', 'Termos de uso');

-- Criar índices para performance
CREATE INDEX idx_produtos_categoria ON produtos(categoria_id);
CREATE INDEX idx_produtos_status ON produtos(status);
CREATE INDEX idx_produtos_destaque ON produtos(destaque);
CREATE INDEX idx_produto_imagens_produto ON produto_imagens(produto_id);
CREATE INDEX idx_produto_tamanhos_produto ON produto_tamanhos(produto_id);
CREATE INDEX idx_pedidos_cliente ON pedidos(cliente_id);
CREATE INDEX idx_pedidos_status ON pedidos(status);
CREATE INDEX idx_pedido_itens_pedido ON pedido_itens(pedido_id);
CREATE INDEX idx_clientes_email ON clientes(email);
CREATE INDEX idx_clientes_cpf ON clientes(cpf); 