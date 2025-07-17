<?php
// Configuração do Banco de Dados - Loja Plus Size
// Funciona automaticamente em local e produção (Hostinger)

// Ativar exibição de erros para debug (remover em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Detectar ambiente automaticamente
$is_localhost = false;
if (isset($_SERVER['HTTP_HOST'])) {
    $is_localhost = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']) || 
                   strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ||
                   strpos($_SERVER['HTTP_HOST'], '.local') !== false;
}

if ($is_localhost) {
    // Configuração Local (XAMPP) - valores padrão
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'loja_plus_size');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_CHARSET', 'utf8mb4');
} else {
    // Configuração Produção (Hostinger)
    // Primeiro tenta variáveis de ambiente, depois valores padrão
    $db_host = getenv('DB_HOST');
    $db_name = getenv('DB_NAME');
    $db_user = getenv('DB_USER');
    $db_pass = getenv('DB_PASS');
    
    // Se não encontrar variáveis de ambiente, usar valores padrão da Hostinger
    if (!$db_host) $db_host = 'localhost';
    if (!$db_name) $db_name = 'u819562010_lojaplussize'; // Seu banco real
    if (!$db_user) $db_user = 'u819562010_lojaplussize'; // Seu usuário real
    if (!$db_pass) $db_pass = 'Los@ngo081081'; // Sua senha real
    
    define('DB_HOST', $db_host);
    define('DB_NAME', $db_name);
    define('DB_USER', $db_user);
    define('DB_PASS', $db_pass);
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
        // Log do erro para debug
        error_log("Erro de conexão com banco: " . $e->getMessage());
        
        // Retornar erro JSON se for uma requisição AJAX
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Erro de conexão: ' . $e->getMessage()]);
            exit;
        }
        
        // Para requisições normais, mostrar erro amigável
        echo "<h2>Erro de Conexão com Banco de Dados</h2>";
        echo "<p>Não foi possível conectar ao banco de dados. Verifique as configurações.</p>";
        echo "<p><strong>Detalhes:</strong> " . $e->getMessage() . "</p>";
        exit;
    }
}

// Função para obter URL base
function getBaseURL() {
    // Verificar se está sendo executado via CLI
    if (!isset($_SERVER['HTTP_HOST'])) {
        return false; // Não disponível via CLI
    }
    
    $is_localhost = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']) || 
                   strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;
    
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

// Função para testar conexão (debug)
function testConnection() {
    try {
        $pdo = getDBConnection();
        return ['success' => true, 'message' => 'Conexão OK'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}
?> 