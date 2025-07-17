<?php
// Arquivo de teste para verificar configuração
// Acesse: https://seudominio.com/test_config.php

echo "<h1>Teste de Configuração - Loja Plus Size</h1>";

// Incluir configuração
require_once 'config_database.php';

echo "<h2>1. Informações do Ambiente</h2>";
echo "<p><strong>HTTP_HOST:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'N/A') . "</p>";
echo "<p><strong>É localhost:</strong> " . ($is_localhost ? 'SIM' : 'NÃO') . "</p>";

echo "<h2>2. Configurações do Banco</h2>";
echo "<p><strong>DB_HOST:</strong> " . DB_HOST . "</p>";
echo "<p><strong>DB_NAME:</strong> " . DB_NAME . "</p>";
echo "<p><strong>DB_USER:</strong> " . DB_USER . "</p>";
echo "<p><strong>DB_PASS:</strong> " . (DB_PASS ? '***DEFINIDA***' : 'VAZIA') . "</p>";

echo "<h2>3. Variáveis de Ambiente</h2>";
echo "<p><strong>DB_HOST (env):</strong> " . (getenv('DB_HOST') ?: 'NÃO DEFINIDA') . "</p>";
echo "<p><strong>DB_NAME (env):</strong> " . (getenv('DB_NAME') ?: 'NÃO DEFINIDA') . "</p>";
echo "<p><strong>DB_USER (env):</strong> " . (getenv('DB_USER') ?: 'NÃO DEFINIDA') . "</p>";
echo "<p><strong>DB_PASS (env):</strong> " . (getenv('DB_PASS') ? 'DEFINIDA' : 'NÃO DEFINIDA') . "</p>";

echo "<h2>4. Teste de Conexão</h2>";
try {
    $pdo = getDBConnection();
    echo "<p style='color: green;'><strong>✅ SUCESSO:</strong> Conexão com banco estabelecida!</p>";
    
    // Testar query simples
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM produtos");
    $result = $stmt->fetch();
    echo "<p><strong>Total de produtos:</strong> " . $result['total'] . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>❌ ERRO:</strong> " . $e->getMessage() . "</p>";
}

echo "<h2>5. Informações do PHP</h2>";
echo "<p><strong>Versão PHP:</strong> " . phpversion() . "</p>";
echo "<p><strong>PDO MySQL:</strong> " . (extension_loaded('pdo_mysql') ? 'INSTALADO' : 'NÃO INSTALADO') . "</p>";

echo "<hr>";
echo "<p><a href='index.php'>← Voltar para o site</a></p>";
?> 