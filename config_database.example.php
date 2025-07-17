<?php
// Configuração do Banco de Dados - Loja Plus Size
// COPIE ESTE ARQUIVO PARA config_database.php E CONFIGURE SUAS CREDENCIAIS

// Detectar ambiente automaticamente
$is_localhost = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']) || strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;

if ($is_localhost) {
    // Configuração Local (XAMPP)
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'loja_plus_size');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_CHARSET', 'utf8mb4');
} else {
    // Configuração Produção (Hostinger)
    // ALTERE ESTAS CONFIGURAÇÕES PARA SUAS CREDENCIAIS DE PRODUÇÃO
    define('DB_HOST', 'seu_host_aqui');
    define('DB_NAME', 'seu_banco_aqui');
    define('DB_USER', 'seu_usuario_aqui');
    define('DB_PASS', 'sua_senha_aqui');
    define('DB_CHARSET', 'utf8mb4');
}

// Configurações comuns
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');

// Função para conectar ao banco
function getDBConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET . ";port=" . DB_PORT;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Erro de conexão: ' . $e->getMessage()]);
        exit;
    }
}

// Função para obter URL base
function getBaseURL() {
    // Verificar se está sendo executado via CLI
    if (!isset($_SERVER['HTTP_HOST'])) {
        return false; // Não disponível via CLI
    }
    
    $is_localhost = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']) || strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;
    
    if ($is_localhost) {
        return 'http://localhost/projeto-ecommerce/loja-plus-size/';
    } else {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $path = dirname($_SERVER['SCRIPT_NAME']);
        return $protocol . '://' . $host . $path . '/';
    }
}

// Função para obter caminho base
function getBasePath() {
    return dirname(__FILE__);
}
?> 