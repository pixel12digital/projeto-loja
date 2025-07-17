-- Banco de Dados: Loja Plus Size - Bella Curves
-- Estrutura básica para demonstração

CREATE DATABASE IF NOT EXISTS loja_plus_size;
USE loja_plus_size;

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

-- Imagens dos produtos (simulação)
INSERT INTO produto_imagens (produto_id, imagem, alt_text, ordem, principal) VALUES
(1, 'vestido_floral_01.jpg', 'Vestido Floral Manga Longa - Frente', 0, TRUE),
(1, 'vestido_floral_02.jpg', 'Vestido Floral Manga Longa - Costas', 1, FALSE),
(2, 'blusa_social_01.jpg', 'Blusa Social Elegante - Frente', 0, TRUE),
(2, 'blusa_social_02.jpg', 'Blusa Social Elegante - Detalhe', 1, FALSE),
(3, 'calca_jeans_01.jpg', 'Calça Jeans Skinny - Frente', 0, TRUE),
(3, 'calca_jeans_02.jpg', 'Calça Jeans Skinny - Costas', 1, FALSE),
(4, 'conjunto_intimo_01.jpg', 'Conjunto Íntimo Renda - Completo', 0, TRUE),
(5, 'vestido_midi_01.jpg', 'Vestido Midi Listrado - Frente', 0, TRUE),
(6, 'blusa_basica_01.jpg', 'Blusa Básica Algodão - Frente', 0, TRUE);

-- Tamanhos dos produtos
INSERT INTO produto_tamanhos (produto_id, tamanho_id, estoque) VALUES
-- Vestido Floral (P, M, G, GG, XGG)
(1, 1, 3), (1, 2, 4), (1, 3, 5), (1, 4, 2), (1, 5, 1),
-- Blusa Social (P, M, G, GG, XGG)
(2, 1, 1), (2, 2, 2), (2, 3, 3), (2, 4, 1), (2, 5, 1),
-- Calça Jeans (38-48)
(3, 6, 0), (3, 7, 1), (3, 8, 1), (3, 9, 1), (3, 10, 0), (3, 11, 0),
-- Conjunto Íntimo (P, M, G, GG, XGG)
(4, 1, 5), (4, 2, 6), (4, 3, 7), (4, 4, 3), (4, 5, 1),
-- Vestido Midi (P, M, G, GG, XGG)
(5, 1, 2), (5, 2, 3), (5, 3, 4), (5, 4, 2), (5, 5, 1),
-- Blusa Básica (P, M, G, GG, XGG)
(6, 1, 5), (6, 2, 6), (6, 3, 8), (6, 4, 4), (6, 5, 2);

-- Configurações da loja
INSERT INTO configuracoes (chave, valor, tipo, descricao) VALUES
('loja_nome', 'Bella Curves', 'text', 'Nome da loja'),
('loja_email', 'contato@bellacurves.com.br', 'email', 'E-mail principal da loja'),
('loja_telefone', '(11) 9999-9999', 'text', 'Telefone da loja'),
('loja_endereco', 'Rua das Flores, 123 - São Paulo/SP', 'text', 'Endereço da loja'),
('frete_gratis_valor', '199.00', 'decimal', 'Valor mínimo para frete grátis'),
('moeda_simbolo', 'R$', 'text', 'Símbolo da moeda'),
('timezone', 'America/Sao_Paulo', 'text', 'Fuso horário'),
('email_smtp_host', '', 'text', 'Servidor SMTP'),
('email_smtp_user', '', 'text', 'Usuário SMTP'),
('email_smtp_pass', '', 'password', 'Senha SMTP'),
('pagamento_pix', '1', 'boolean', 'Aceitar PIX'),
('pagamento_cartao', '1', 'boolean', 'Aceitar cartão'),
('pagamento_boleto', '1', 'boolean', 'Aceitar boleto');

-- Cupons de exemplo
INSERT INTO cupons (codigo, tipo, valor, valor_minimo, limite_uso, data_inicio, data_fim) VALUES
('BEMVINDA10', 'percentual', 10.00, 100.00, 100, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY)),
('FRETEGRATIS', 'valor', 15.00, 150.00, 50, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 15 DAY)),
('PLUSSIZE20', 'percentual', 20.00, 200.00, 25, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY));

-- Criar índices para performance
CREATE INDEX idx_produtos_categoria ON produtos(categoria_id);
CREATE INDEX idx_produtos_status ON produtos(status);
CREATE INDEX idx_produtos_destaque ON produtos(destaque);
CREATE INDEX idx_produto_imagens_produto ON produto_imagens(produto_id);
CREATE INDEX idx_produto_tamanhos_produto ON produto_tamanhos(produto_id);
CREATE INDEX idx_pedidos_cliente ON pedidos(cliente_id);
CREATE INDEX idx_pedidos_status ON pedidos(status);
CREATE INDEX idx_pedido_itens_pedido ON pedido_itens(pedido_id);

-- Views úteis

-- View de produtos com informações completas
CREATE OR REPLACE VIEW vw_produtos_completos AS
SELECT 
    p.*,
    c.nome as categoria_nome,
    c.slug as categoria_slug,
    (SELECT imagem FROM produto_imagens WHERE produto_id = p.id AND principal = TRUE LIMIT 1) as imagem_principal,
    (SELECT COUNT(*) FROM produto_imagens WHERE produto_id = p.id) as total_imagens,
    (SELECT SUM(estoque) FROM produto_tamanhos WHERE produto_id = p.id) as estoque_total
FROM produtos p
LEFT JOIN categorias c ON p.categoria_id = c.id;

-- View de estatísticas de vendas
CREATE OR REPLACE VIEW vw_estatisticas_vendas AS
SELECT 
    DATE(created_at) as data,
    COUNT(*) as total_pedidos,
    SUM(total) as faturamento,
    AVG(total) as ticket_medio
FROM pedidos 
WHERE status NOT IN ('cancelado')
GROUP BY DATE(created_at)
ORDER BY data DESC;

-- Procedures úteis

DELIMITER //

-- Procedure para atualizar estoque após venda
CREATE PROCEDURE sp_atualizar_estoque(
    IN p_produto_id INT,
    IN p_tamanho_id INT,
    IN p_quantidade INT
)
BEGIN
    DECLARE estoque_atual INT DEFAULT 0;
    
    -- Verificar estoque atual
    SELECT estoque INTO estoque_atual 
    FROM produto_tamanhos 
    WHERE produto_id = p_produto_id AND tamanho_id = p_tamanho_id;
    
    -- Atualizar estoque se suficiente
    IF estoque_atual >= p_quantidade THEN
        UPDATE produto_tamanhos 
        SET estoque = estoque - p_quantidade
        WHERE produto_id = p_produto_id AND tamanho_id = p_tamanho_id;
        
        -- Atualizar estoque total do produto
        UPDATE produtos 
        SET estoque = (
            SELECT SUM(estoque) 
            FROM produto_tamanhos 
            WHERE produto_id = p_produto_id
        )
        WHERE id = p_produto_id;
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Estoque insuficiente';
    END IF;
END //

-- Procedure para calcular frete (simulação)
CREATE PROCEDURE sp_calcular_frete(
    IN p_cep_origem VARCHAR(9),
    IN p_cep_destino VARCHAR(9),
    IN p_peso DECIMAL(8,3),
    OUT p_valor DECIMAL(10,2),
    OUT p_prazo INT
)
BEGIN
    -- Simulação simples de cálculo de frete
    DECLARE distancia INT DEFAULT 0;
    
    -- Calcular "distância" baseada nos CEPs (simulação)
    SET distancia = ABS(CAST(SUBSTRING(p_cep_destino, 1, 5) AS UNSIGNED) - 
                       CAST(SUBSTRING(p_cep_origem, 1, 5) AS UNSIGNED));
    
    -- Calcular valor baseado no peso e distância
    SET p_valor = (p_peso * 2.5) + (distancia * 0.01) + 10.00;
    
    -- Calcular prazo (3-15 dias úteis)
    SET p_prazo = LEAST(15, GREATEST(3, FLOOR(distancia / 1000) + 3));
END //

DELIMITER ;

-- Triggers

-- Trigger para gerar número do pedido automaticamente
DELIMITER //
CREATE TRIGGER tr_gerar_numero_pedido 
BEFORE INSERT ON pedidos
FOR EACH ROW
BEGIN
    IF NEW.numero IS NULL OR NEW.numero = '' THEN
        SET NEW.numero = CONCAT('BC', YEAR(NOW()), LPAD(MONTH(NOW()), 2, '0'), LPAD((SELECT COALESCE(MAX(id), 0) + 1 FROM pedidos), 6, '0'));
    END IF;
END //
DELIMITER ;

-- Trigger para atualizar estoque após inserir item do pedido
DELIMITER //
CREATE TRIGGER tr_atualizar_estoque_pedido
AFTER INSERT ON pedido_itens
FOR EACH ROW
BEGIN
    CALL sp_atualizar_estoque(NEW.produto_id, NEW.tamanho_id, NEW.quantidade);
END //
DELIMITER ;

-- Comentários finais
-- Esta estrutura fornece uma base sólida para uma loja Plus Size
-- Inclui todas as funcionalidades essenciais para e-commerce
-- Otimizada para performance com índices apropriados
-- Inclui procedures e triggers para automação
-- Preparada para escalabilidade e futuras expansões 