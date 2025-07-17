# 🔌 Guia de Acesso ao Banco de Dados

## 📋 Informações de Conexão

```
Host: peru-turkey-621361.hostingersite.com
Banco: u819562010_lojaplussize
Usuário: u819562010_lojaplussize
Senha: Los@ngo081081
```

## 🚫 Limitações da Hostinger

A **Hostinger bloqueia conexões MySQL externas** por segurança em hospedagem compartilhada:
- ❌ MySQL direto via terminal: `mysql -h host -u user -p`
- ❌ SSH: `ssh user@host`
- ❌ Ferramentas externas: HeidiSQL, phpMyAdmin local, etc.

## ✅ Métodos de Acesso Disponíveis

### 1. **phpMyAdmin (Recomendado)**

**Localização:** Painel Hostinger → Bancos de dados → MySQL remoto → phpMyAdmin

**Vantagens:**
- ✅ Interface gráfica completa
- ✅ Import/export de dados
- ✅ Editor SQL avançado
- ✅ Sem configuração adicional

**Como usar:**
1. Acesse o painel da Hostinger
2. Vá em "Bancos de dados"
3. Clique em "phpMyAdmin" ao lado do banco `u819562010_lojaplussize`
4. Use as credenciais acima para entrar

### 2. **SQL Executor Web (Criado)**

**URL:** `https://peru-turkey-621361.hostingersite.com/sql_executor.php`

**Chave de Acesso:** `loja_plus_size_2024`

**Vantagens:**
- ✅ Acesso direto via navegador
- ✅ Comandos rápidos pré-definidos
- ✅ Suporte a múltiplas queries
- ✅ Interface visual dos resultados

**Recursos:**
- 🔍 **Comandos Rápidos:** SHOW TABLES, COUNT produtos, etc.
- 📊 **Visualização:** Tabelas formatadas
- 🔒 **Segurança:** Chave de acesso obrigatória
- ⚡ **Tipos:** SELECT, INSERT/UPDATE/DELETE, Múltiplas queries

### 3. **Script PHP Personalizado**

Se precisar de funcionalidades específicas, pode criar scripts PHP no servidor:

```php
<?php
try {
    $pdo = new PDO(
        "mysql:host=peru-turkey-621361.hostingersite.com;dbname=u819562010_lojaplussize", 
        "u819562010_lojaplussize", 
        "Los@ngo081081"
    );
    
    // Suas consultas aqui
    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    echo "Total de produtos: " . $stmt->fetchColumn();
    
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
```

## 🛠️ Comandos SQL Úteis

### Verificação do Banco
```sql
-- Listar todas as tabelas
SHOW TABLES;

-- Verificar estrutura de uma tabela
DESCRIBE products;

-- Contar registros
SELECT COUNT(*) FROM products;
SELECT COUNT(*) FROM categories;
SELECT COUNT(*) FROM orders;
```

### Consultas de Produtos
```sql
-- Todos os produtos
SELECT * FROM products ORDER BY created_at DESC;

-- Produtos por categoria
SELECT p.name, c.name as categoria 
FROM products p 
JOIN categories c ON p.category_id = c.id;

-- Produtos em estoque
SELECT * FROM products WHERE stock > 0;
```

### Gestão de Pedidos
```sql
-- Pedidos recentes
SELECT * FROM orders ORDER BY created_at DESC LIMIT 10;

-- Total de vendas
SELECT SUM(total_amount) as total_vendas FROM orders;

-- Produtos mais vendidos
SELECT p.name, SUM(oi.quantity) as vendidos
FROM order_items oi
JOIN products p ON oi.product_id = p.id
GROUP BY p.id
ORDER BY vendidos DESC;
```

## 🔧 Troubleshooting

### Erro de Conexão
```
ERROR 2002 (HY000): Can't connect to MySQL server
```
**Solução:** Normal em hospedagem compartilhada. Use phpMyAdmin ou SQL Executor.

### Erro de Autenticação
```
ERROR 1045 (28000): Access denied for user
```
**Solução:** Verifique as credenciais no painel da Hostinger.

### Timeout
```
ERROR 2003 (HY000): Can't connect to MySQL server on 'host' (10060)
```
**Solução:** Firewall bloqueando. Use métodos web (phpMyAdmin/SQL Executor).

## 📊 Monitoramento

### Performance
```sql
-- Tabelas com mais registros
SELECT 
    TABLE_NAME, 
    TABLE_ROWS 
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'u819562010_lojaplussize';

-- Tamanho do banco
SELECT 
    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'DB Size (MB)'
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'u819562010_lojaplussize';
```

### Logs de Atividade
```sql
-- Últimas atividades (se logadas)
SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT 20;

-- Produtos criados recentemente
SELECT * FROM products WHERE created_at > DATE_SUB(NOW(), INTERVAL 7 DAY);
```

## 🔐 Segurança

### Backup Automático
```sql
-- Via phpMyAdmin: Exportar → SQL → Baixar

-- Via SQL Executor: Use comando BACKUP (se disponível)
```

### Usuários e Permissões
```sql
-- Verificar privilégios
SHOW GRANTS FOR 'u819562010_lojaplussize'@'%';

-- Listar usuários (se tiver permissão)
SELECT User, Host FROM mysql.user;
```

---

## 📞 Suporte

**Problemas de Conexão:** Hostinger Support
**Problemas de Código:** Verifique logs de PHP em `/public_html/error_logs/`
**SQL Executor:** Acesse via navegador com chave `loja_plus_size_2024` 