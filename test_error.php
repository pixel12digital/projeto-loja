<?php
// Teste de erros e configuração
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Teste de Erros - Loja Plus Size</h1>";

// Teste 1: Verificar se o arquivo de configuração existe
echo "<h2>1. Verificação de Arquivos</h2>";
$config_file = 'config_database.php';
if (file_exists($config_file)) {
    echo "✅ config_database.php encontrado<br>";
} else {
    echo "❌ config_database.php NÃO encontrado<br>";
}

// Teste 2: Incluir configuração
echo "<h2>2. Inclusão da Configuração</h2>";
try {
    require_once $config_file;
    echo "✅ Configuração carregada com sucesso<br>";
} catch (Exception $e) {
    echo "❌ Erro ao carregar configuração: " . $e->getMessage() . "<br>";
}

// Teste 3: Verificar constantes
echo "<h2>3. Verificação de Constantes</h2>";
$constants = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
foreach ($constants as $const) {
    if (defined($const)) {
        echo "✅ $const definida: " . constant($const) . "<br>";
    } else {
        echo "❌ $const NÃO definida<br>";
    }
}

// Teste 4: Testar conexão com banco
echo "<h2>4. Teste de Conexão com Banco</h2>";
if (function_exists('testConnection')) {
    $result = testConnection();
    if ($result['success']) {
        echo "✅ " . $result['message'] . "<br>";
    } else {
        echo "❌ " . $result['message'] . "<br>";
    }
} else {
    echo "❌ Função testConnection não encontrada<br>";
}

// Teste 5: Verificar ambiente
echo "<h2>5. Detecção de Ambiente</h2>";
if (isset($_SERVER['HTTP_HOST'])) {
    echo "Host: " . $_SERVER['HTTP_HOST'] . "<br>";
    $is_localhost = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']) || 
                   strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;
    echo "É localhost: " . ($is_localhost ? 'Sim' : 'Não') . "<br>";
} else {
    echo "❌ HTTP_HOST não disponível<br>";
}

// Teste 6: Verificar URL base
echo "<h2>6. URL Base</h2>";
if (function_exists('getBaseURL')) {
    $base_url = getBaseURL();
    if ($base_url) {
        echo "✅ URL Base: " . $base_url . "<br>";
    } else {
        echo "❌ URL Base não disponível<br>";
    }
} else {
    echo "❌ Função getBaseURL não encontrada<br>";
}

// Teste 7: Verificar erros do PHP
echo "<h2>7. Últimos Erros do PHP</h2>";
$errors = error_get_last();
if ($errors) {
    echo "❌ Último erro: " . $errors['message'] . " em " . $errors['file'] . " linha " . $errors['line'] . "<br>";
} else {
    echo "✅ Nenhum erro PHP detectado<br>";
}

echo "<hr>";
echo "<p><strong>Teste concluído!</strong></p>";
?> 