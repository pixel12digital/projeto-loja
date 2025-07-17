-- ===============================================
-- COMANDOS SQL ÚTEIS - LOJA PLUS SIZE
-- ===============================================
-- Execute estes comandos no phpMyAdmin para testes
-- Banco: u819562010_lojaplussize

-- 🔍 VERIFICAÇÕES BÁSICAS
-- ===============================================

-- Ver todas as tabelas criadas
SHOW TABLES;

-- Contar registros em cada tabela
SELECT 'categorias' as tabela, COUNT(*) as total FROM categorias
UNION ALL
SELECT 'produtos' as tabela, COUNT(*) as total FROM produtos
UNION ALL
SELECT 'tamanhos' as tabela, COUNT(*) as total FROM tamanhos
UNION ALL
SELECT 'produto_tamanhos' as tabela, COUNT(*) as total FROM produto_tamanhos;

-- 📦 CONSULTAS DE PRODUTOS
-- ===============================================

-- Ver todos os produtos com suas categorias
SELECT 
    p.nome,
    p.sku,
    c.nome as categoria,
    p.preco,
    p.preco_promocional,
    p.estoque,
    p.status
FROM produtos p
LEFT JOIN categorias c ON p.categoria_id = c.id
ORDER BY p.nome;

-- Produtos em promoção
SELECT nome, preco, preco_promocional, 
       (preco_promocional - preco) as desconto
FROM produtos 
WHERE preco_promocional IS NOT NULL 
  AND preco_promocional > 0;

-- Produtos com estoque baixo (menos de 5)
SELECT nome, sku, estoque, status
FROM produtos 
WHERE estoque < 5
ORDER BY estoque ASC;

-- 👗 CONSULTAS DE CATEGORIAS
-- ===============================================

-- Categorias com quantidade de produtos
SELECT 
    c.nome as categoria,
    COUNT(p.id) as total_produtos,
    SUM(p.estoque) as estoque_total
FROM categorias c
LEFT JOIN produtos p ON c.id = p.categoria_id
GROUP BY c.id, c.nome
ORDER BY total_produtos DESC;

-- 📏 CONSULTAS DE TAMANHOS
-- ===============================================

-- Tamanhos disponíveis com estoque
SELECT 
    t.nome as tamanho,
    COUNT(pt.produto_id) as produtos_disponiveis,
    SUM(pt.estoque) as estoque_total
FROM tamanhos t
LEFT JOIN produto_tamanhos pt ON t.id = pt.tamanho_id
GROUP BY t.id, t.nome
ORDER BY t.ordem;

-- Produtos por tamanho específico (exemplo: G)
SELECT 
    p.nome,
    t.nome as tamanho,
    pt.estoque
FROM produtos p
JOIN produto_tamanhos pt ON p.id = pt.produto_id
JOIN tamanhos t ON pt.tamanho_id = t.id
WHERE t.nome = 'G' AND pt.estoque > 0;

-- 💰 CONSULTAS FINANCEIRAS
-- ===============================================

-- Valor total do estoque
SELECT 
    SUM(preco * estoque) as valor_total_estoque,
    COUNT(*) as total_produtos
FROM produtos 
WHERE status = 'ativo';

-- Produtos mais caros
SELECT nome, preco, sku
FROM produtos 
WHERE status = 'ativo'
ORDER BY preco DESC
LIMIT 5;

-- Produtos mais baratos
SELECT nome, preco, sku
FROM produtos 
WHERE status = 'ativo'
ORDER BY preco ASC
LIMIT 5;

-- 🎯 CONSULTAS PARA RELATÓRIOS
-- ===============================================

-- Resumo geral da loja
SELECT 
    (SELECT COUNT(*) FROM produtos WHERE status = 'ativo') as produtos_ativos,
    (SELECT COUNT(*) FROM produtos WHERE status = 'promocao') as produtos_promocao,
    (SELECT COUNT(*) FROM categorias WHERE ativo = 1) as categorias_ativas,
    (SELECT SUM(estoque) FROM produtos) as estoque_total;

-- Produtos destaque
SELECT nome, preco, sku, status
FROM produtos 
WHERE destaque = TRUE
ORDER BY nome;

-- ⚙️ COMANDOS DE MANUTENÇÃO
-- ===============================================

-- Atualizar status de produto específico
-- UPDATE produtos SET status = 'ativo' WHERE sku = 'VF001';

-- Adicionar desconto em uma categoria
-- UPDATE produtos SET preco_promocional = preco * 0.9 
-- WHERE categoria_id = 1 AND preco_promocional IS NULL;

-- Limpar cupons expirados (exemplo)
-- DELETE FROM cupons WHERE data_fim < CURDATE();

-- 🧪 COMANDOS DE TESTE
-- ===============================================

-- Inserir produto teste (descomente para usar)
/*
INSERT INTO produtos (nome, sku, categoria_id, preco, estoque, status) 
VALUES ('Produto Teste', 'TEST001', 1, 99.90, 10, 'ativo');
*/

-- Inserir cliente teste (descomente para usar)
/*
INSERT INTO clientes (nome, email, telefone, senha) 
VALUES ('Cliente Teste', 'teste@email.com', '11999999999', MD5('123456'));
*/

-- 📊 VIEWS ÚTEIS
-- ===============================================

-- Produtos completos (já criada no database.sql)
SELECT * FROM vw_produtos_completos LIMIT 5;

-- Verificar se views existem
SHOW FULL TABLES WHERE Table_type = 'VIEW';

-- 🔧 COMANDOS DE DIAGNÓSTICO
-- ===============================================

-- Verificar estrutura da tabela produtos
DESCRIBE produtos;

-- Ver índices das tabelas
SHOW INDEX FROM produtos;

-- Verificar espaço usado pelas tabelas
SELECT 
    TABLE_NAME as tabela,
    ROUND(((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024), 2) as tamanho_mb
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'u819562010_lojaplussize'
ORDER BY tamanho_mb DESC;

-- 🚨 COMANDOS DE EMERGÊNCIA
-- ===============================================

-- Reativar todos os produtos (se necessário)
-- UPDATE produtos SET status = 'ativo' WHERE status = 'inativo';

-- Resetar estoque de um produto
-- UPDATE produtos SET estoque = 0 WHERE sku = 'CÓDIGO_PRODUTO';

-- Limpar newsletter (se necessário)
-- DELETE FROM newsletter WHERE ativo = 0;

-- ===============================================
-- FIM DOS COMANDOS ÚTEIS
-- ===============================================

-- 📝 NOTAS:
-- - Comandos com UPDATE/DELETE estão comentados por segurança
-- - Sempre faça backup antes de executar comandos de alteração
-- - Este é um banco de TESTES - não usar em produção
-- - Para inserir novos dados, use o painel admin sempre que possível 