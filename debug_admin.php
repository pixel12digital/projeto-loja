<?php
// Debug específico para o admin
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "<h1>Debug do Admin - Loja Plus Size</h1>";

// Teste 1: Verificar ambiente
echo "<h2>1. Ambiente</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'N/A') . "<br>";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A') . "<br>";
echo "Script Name: " . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . "<br>";
echo "HTTP Host: " . ($_SERVER['HTTP_HOST'] ?? 'N/A') . "<br>";

// Teste 2: Verificar configuração
echo "<h2>2. Configuração</h2>";
try {
    require_once 'config_database.php';
    echo "✅ config_database.php carregado<br>";
    
    // Verificar se as constantes estão definidas
    $constants = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
    foreach ($constants as $const) {
        if (defined($const)) {
            echo "✅ $const: " . constant($const) . "<br>";
        } else {
            echo "❌ $const não definida<br>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Erro ao carregar configuração: " . $e->getMessage() . "<br>";
}

// Teste 3: Testar conexão com banco
echo "<h2>3. Conexão com Banco</h2>";
try {
    $pdo = getDBConnection();
    echo "✅ Conexão estabelecida<br>";
    
    // Testar query simples
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM produtos");
    $result = $stmt->fetch();
    echo "✅ Total de produtos: " . $result['total'] . "<br>";
    
} catch (Exception $e) {
    echo "❌ Erro de conexão: " . $e->getMessage() . "<br>";
    echo "Código: " . $e->getCode() . "<br>";
}

// Teste 4: Verificar se o admin/index.php pode ser incluído
echo "<h2>4. Teste de Inclusão do Admin</h2>";
$admin_content = file_get_contents('admin/index.php');
if ($admin_content !== false) {
    echo "✅ admin/index.php pode ser lido<br>";
    echo "Tamanho: " . strlen($admin_content) . " bytes<br>";
    
    // Verificar se há caracteres especiais
    if (preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', $admin_content)) {
        echo "⚠️ Arquivo contém caracteres de controle<br>";
    } else {
        echo "✅ Arquivo sem caracteres de controle<br>";
    }
    
} else {
    echo "❌ Não foi possível ler admin/index.php<br>";
}

// Teste 5: Simular carregamento do admin
echo "<h2>5. Simulação de Carregamento</h2>";
echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
echo "<h3>Início do conteúdo do admin:</h3>";
echo "<pre>" . htmlspecialchars(substr($admin_content, 0, 500)) . "</pre>";
echo "</div>";

// Teste 6: Verificar se há problemas de codificação
echo "<h2>6. Verificação de Codificação</h2>";
$encoding = mb_detect_encoding($admin_content, ['UTF-8', 'ISO-8859-1', 'ASCII']);
echo "Codificação detectada: " . $encoding . "<br>";

if ($encoding !== 'UTF-8') {
    echo "⚠️ Arquivo não está em UTF-8<br>";
} else {
    echo "✅ Arquivo em UTF-8<br>";
}

// Teste 7: Verificar se há problemas de BOM
echo "<h2>7. Verificação de BOM</h2>";
if (substr($admin_content, 0, 3) === "\xEF\xBB\xBF") {
    echo "⚠️ Arquivo tem BOM UTF-8<br>";
} else {
    echo "✅ Arquivo sem BOM<br>";
}

echo "<hr>";
echo "<h2>Próximos Passos</h2>";
echo "<p>1. <a href='test_remote_db.php'>Testar conexão com banco remoto</a></p>";
echo "<p>2. <a href='admin/'>Tentar acessar admin diretamente</a></p>";
echo "<p>3. <a href='test_admin_error.php'>Teste completo de erros</a></p>";
?> 