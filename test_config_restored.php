<?php
// Teste da configuração restaurada
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Teste da Configuração Restaurada</h1>";

// Incluir configuração
require_once 'config_database.php';

echo "<h2>1. Configurações Detectadas</h2>";
echo "Host: " . DB_HOST . "<br>";
echo "Database: " . DB_NAME . "<br>";
echo "User: " . DB_USER . "<br>";
echo "Charset: " . DB_CHARSET . "<br>";
echo "Port: " . DB_PORT . "<br>";

echo "<h2>2. Ambiente Detectado</h2>";
if (isset($_SERVER['HTTP_HOST'])) {
    echo "HTTP_HOST: " . $_SERVER['HTTP_HOST'] . "<br>";
    $is_localhost = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']) || 
                   strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ||
                   strpos($_SERVER['HTTP_HOST'], '.local') !== false;
    echo "É localhost: " . ($is_localhost ? 'Sim' : 'Não') . "<br>";
    echo "Force remote: " . (isset($force_remote) && $force_remote ? 'Sim' : 'Não') . "<br>";
}

echo "<h2>3. Teste de Conexão</h2>";
try {
    $pdo = getDBConnection();
    echo "✅ Conexão estabelecida com sucesso!<br>";
    
    // Testar query simples
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM produtos");
    $result = $stmt->fetch();
    echo "✅ Total de produtos: " . $result['total'] . "<br>";
    
    // Testar versão do MySQL
    $stmt = $pdo->query("SELECT VERSION() as version");
    $version = $stmt->fetch();
    echo "✅ Versão do MySQL: " . $version['version'] . "<br>";
    
} catch (Exception $e) {
    echo "❌ Erro de conexão: " . $e->getMessage() . "<br>";
    echo "Código: " . $e->getCode() . "<br>";
}

echo "<hr>";
echo "<h2>Próximos Passos</h2>";
echo "<p>Se a conexão funcionou:</p>";
echo "<ul>";
echo "<li><a href='admin/'>Acessar o Admin</a></li>";
echo "<li><a href='debug_admin.php'>Executar Debug Completo</a></li>";
echo "<li><a href='test_admin_load.php'>Testar Carregamento do Admin</a></li>";
echo "</ul>";
?> 