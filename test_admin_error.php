<?php
// Teste específico para erros do admin
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Teste de Erros do Admin</h1>";

// Teste 1: Verificar se o arquivo admin/index.php existe
echo "<h2>1. Verificação de Arquivos</h2>";
$admin_file = 'admin/index.php';
if (file_exists($admin_file)) {
    echo "✅ admin/index.php encontrado<br>";
    
    // Verificar tamanho do arquivo
    $size = filesize($admin_file);
    echo "Tamanho: " . number_format($size) . " bytes<br>";
    
    // Verificar se há erros de sintaxe
    $output = shell_exec('C:\xampp\php\php.exe -l ' . $admin_file . ' 2>&1');
    if (strpos($output, 'No syntax errors') !== false) {
        echo "✅ Sintaxe PHP OK<br>";
    } else {
        echo "❌ Erro de sintaxe: " . $output . "<br>";
    }
    
} else {
    echo "❌ admin/index.php NÃO encontrado<br>";
}

// Teste 2: Verificar arquivos CSS e JS
echo "<h2>2. Verificação de Assets</h2>";
$assets = [
    'assets/css/admin.css',
    'assets/js/admin.js'
];

foreach ($assets as $asset) {
    if (file_exists($asset)) {
        echo "✅ $asset encontrado<br>";
    } else {
        echo "❌ $asset NÃO encontrado<br>";
    }
}

// Teste 3: Verificar APIs
echo "<h2>3. Verificação de APIs</h2>";
$apis = [
    'admin/dashboard_api.php',
    'admin/produtos_api.php',
    'admin/pedidos_api.php',
    'admin/categorias_api.php',
    'admin/clientes_api.php',
    'admin/configuracoes_api.php'
];

foreach ($apis as $api) {
    if (file_exists($api)) {
        echo "✅ $api encontrado<br>";
    } else {
        echo "❌ $api NÃO encontrado<br>";
    }
}

// Teste 4: Simular carregamento do admin
echo "<h2>4. Simulação de Carregamento</h2>";
try {
    // Incluir configuração
    require_once 'config_database.php';
    echo "✅ Configuração carregada<br>";
    
    // Testar conexão
    $pdo = getDBConnection();
    echo "✅ Conexão com banco estabelecida<br>";
    
    // Testar uma query simples
    $stmt = $pdo->query("SELECT 1 as test");
    $result = $stmt->fetch();
    echo "✅ Query de teste executada<br>";
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "<br>";
}

// Teste 5: Verificar permissões de arquivo
echo "<h2>5. Verificação de Permissões</h2>";
$files_to_check = [
    'admin/index.php',
    'config_database.php',
    'assets/css/admin.css',
    'assets/js/admin.js'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        $perms = fileperms($file);
        $perms_octal = substr(sprintf('%o', $perms), -4);
        echo "✅ $file - Permissões: $perms_octal<br>";
    }
}

echo "<hr>";
echo "<p><strong>Teste concluído!</strong></p>";
echo "<p><a href='admin/'>Tentar acessar admin</a></p>";
?> 