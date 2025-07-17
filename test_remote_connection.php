<?php
// Teste específico para conexão remota
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Teste de Conexão Remota - Loja Plus Size</h1>";

// Incluir configuração
require_once 'config_database.php';

echo "<h2>1. Configurações Atuais</h2>";
echo "Host: " . DB_HOST . "<br>";
echo "Database: " . DB_NAME . "<br>";
echo "User: " . DB_USER . "<br>";
echo "Charset: " . DB_CHARSET . "<br>";
echo "Port: " . DB_PORT . "<br>";

echo "<h2>2. Teste de Conexão Direta</h2>";
try {
    // Tentar conexão direta com PDO
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET . ";port=" . DB_PORT;
    echo "DSN: " . $dsn . "<br>";
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_TIMEOUT => 10, // Timeout de 10 segundos
    ]);
    
    echo "✅ Conexão estabelecida com sucesso!<br>";
    
    // Testar query simples
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM produtos");
    $result = $stmt->fetch();
    echo "✅ Query executada. Total de produtos: " . $result['total'] . "<br>";
    
    // Testar versão do MySQL
    $stmt = $pdo->query("SELECT VERSION() as version");
    $version = $stmt->fetch();
    echo "✅ Versão do MySQL: " . $version['version'] . "<br>";
    
} catch (PDOException $e) {
    echo "❌ Erro de conexão: " . $e->getMessage() . "<br>";
    echo "Código: " . $e->getCode() . "<br>";
    
    // Sugestões baseadas no erro
    if ($e->getCode() == 2002) {
        echo "<h3>Sugestões para erro 2002:</h3>";
        echo "<ul>";
        echo "<li>Verificar se o host está correto</li>";
        echo "<li>Verificar se a porta está correta</li>";
        echo "<li>Verificar se há firewall bloqueando</li>";
        echo "<li>Verificar se o servidor MySQL está rodando</li>";
        echo "</ul>";
    } elseif ($e->getCode() == 1045) {
        echo "<h3>Sugestões para erro 1045:</h3>";
        echo "<ul>";
        echo "<li>Verificar usuário e senha</li>";
        echo "<li>Verificar se o usuário tem permissão de acesso</li>";
        echo "</ul>";
    } elseif ($e->getCode() == 1049) {
        echo "<h3>Sugestões para erro 1049:</h3>";
        echo "<ul>";
        echo "<li>Verificar se o banco de dados existe</li>";
        echo "<li>Verificar se o nome do banco está correto</li>";
        echo "</ul>";
    }
}

echo "<h2>3. Teste de Função getDBConnection()</h2>";
try {
    $pdo = getDBConnection();
    echo "✅ Função getDBConnection() funcionando<br>";
    
    // Testar tabelas
    $tables = ['produtos', 'categorias', 'pedidos', 'clientes'];
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
    echo "❌ Erro na função getDBConnection(): " . $e->getMessage() . "<br>";
}

echo "<h2>4. Informações do Ambiente</h2>";
echo "HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'N/A') . "<br>";
echo "SERVER_NAME: " . ($_SERVER['SERVER_NAME'] ?? 'N/A') . "<br>";
echo "REMOTE_ADDR: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A') . "<br>";
echo "PHP Version: " . phpversion() . "<br>";

echo "<hr>";
echo "<h2>Próximos Passos</h2>";
echo "<p>Se a conexão funcionou, você pode:</p>";
echo "<ul>";
echo "<li><a href='admin/'>Acessar o Admin</a></li>";
echo "<li><a href='debug_admin.php'>Executar Debug Completo</a></li>";
echo "<li><a href='test_admin_load.php'>Testar Carregamento do Admin</a></li>";
echo "</ul>";
?> 