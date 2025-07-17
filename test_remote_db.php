<?php
// Teste de conexão com banco remoto
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Teste de Conexão com Banco Remoto</h1>";

// Incluir configuração
require_once 'config_database.php';

echo "<h2>1. Configurações Detectadas</h2>";
echo "Host: " . DB_HOST . "<br>";
echo "Database: " . DB_NAME . "<br>";
echo "User: " . DB_USER . "<br>";
echo "Charset: " . DB_CHARSET . "<br>";
echo "Port: " . DB_PORT . "<br>";

echo "<h2>2. Teste de Conexão</h2>";
try {
    $pdo = getDBConnection();
    echo "✅ Conexão com banco remoto estabelecida com sucesso!<br>";
    
    // Testar uma query simples
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM produtos");
    $result = $stmt->fetch();
    echo "✅ Query de teste executada. Total de produtos: " . $result['total'] . "<br>";
    
} catch (Exception $e) {
    echo "❌ Erro na conexão: " . $e->getMessage() . "<br>";
    echo "<strong>Detalhes do erro:</strong><br>";
    echo "Código: " . $e->getCode() . "<br>";
    echo "Arquivo: " . $e->getFile() . "<br>";
    echo "Linha: " . $e->getLine() . "<br>";
}

echo "<h2>3. Verificação de Tabelas</h2>";
try {
    $pdo = getDBConnection();
    $tables = ['produtos', 'categorias', 'pedidos', 'clientes', 'configuracoes'];
    
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM $table");
            $result = $stmt->fetch();
            echo "✅ Tabela '$table': " . $result['total'] . " registros<br>";
        } catch (Exception $e) {
            echo "❌ Tabela '$table': " . $e->getMessage() . "<br>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Erro ao verificar tabelas: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<p><strong>Teste concluído!</strong></p>";
?> 