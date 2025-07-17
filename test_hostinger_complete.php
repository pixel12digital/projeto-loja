<?php
// Teste completo para Hostinger
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Teste Completo - Configuração Hostinger</h1>";

echo "<h2>1. Informações do Ambiente</h2>";
echo "HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'N/A') . "<br>";
echo "SERVER_NAME: " . ($_SERVER['SERVER_NAME'] ?? 'N/A') . "<br>";
echo "REMOTE_ADDR: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A') . "<br>";
echo "PHP Version: " . phpversion() . "<br>";

echo "<h2>2. Possíveis Configurações da Hostinger</h2>";

// Configurações comuns da Hostinger
$configs = [
    [
        'name' => 'Configuração 1 - Localhost (mais comum)',
        'host' => 'localhost',
        'port' => 3306
    ],
    [
        'name' => 'Configuração 2 - IP Local',
        'host' => '127.0.0.1',
        'port' => 3306
    ],
    [
        'name' => 'Configuração 3 - Hostinger SQL',
        'host' => 'sql.hostinger.com',
        'port' => 3306
    ],
    [
        'name' => 'Configuração 4 - Hostinger MySQL',
        'host' => 'mysql.hostinger.com',
        'port' => 3306
    ],
    [
        'name' => 'Configuração 5 - Porta Diferente',
        'host' => 'localhost',
        'port' => 3307
    ],
    [
        'name' => 'Configuração 6 - Porta Diferente IP',
        'host' => '127.0.0.1',
        'port' => 3307
    ]
];

$db_name = 'u819562010_lojaplussize';
$db_user = 'u819562010_lojaplussize';
$db_pass = 'Los@ngo081081';

foreach ($configs as $config) {
    echo "<h3>Testando: " . $config['name'] . "</h3>";
    echo "Host: " . $config['host'] . ":" . $config['port'] . "<br>";
    
    try {
        $dsn = "mysql:host=" . $config['host'] . ";port=" . $config['port'] . ";dbname=$db_name;charset=utf8mb4";
        echo "DSN: $dsn<br>";
        
        $pdo = new PDO($dsn, $db_user, $db_pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 5,
        ]);
        
        echo "✅ <strong>CONEXÃO BEM-SUCEDIDA!</strong><br>";
        
        // Testar query
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM produtos");
        $result = $stmt->fetch();
        echo "✅ Total de produtos: " . $result['total'] . "<br>";
        
        echo "<div style='background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb;'>";
        echo "<strong>🎉 CONFIGURAÇÃO CORRETA ENCONTRADA!</strong><br>";
        echo "Host: " . $config['host'] . "<br>";
        echo "Porta: " . $config['port'] . "<br>";
        echo "Use estas configurações no config_database.php";
        echo "</div>";
        
        break;
        
    } catch (PDOException $e) {
        echo "❌ Erro: " . $e->getMessage() . "<br>";
        echo "Código: " . $e->getCode() . "<br><br>";
    }
}

echo "<h2>3. Verificação de Informações da Hostinger</h2>";
echo "<p><strong>Importante:</strong> Verifique no painel da Hostinger:</p>";
echo "<ul>";
echo "<li>Nome do servidor MySQL</li>";
echo "<li>Porta do MySQL</li>";
echo "<li>Nome do banco de dados</li>";
echo "<li>Usuário do banco</li>";
echo "<li>Senha do banco</li>";
echo "<li>Se conexões remotas estão habilitadas</li>";
echo "</ul>";

echo "<h2>4. Possíveis Soluções</h2>";
echo "<p>Se nenhuma configuração funcionou:</p>";
echo "<ol>";
echo "<li><strong>Verifique o painel da Hostinger</strong> - As informações podem estar diferentes</li>";
echo "<li><strong>Conexões remotas</strong> - A Hostinger pode ter desabilitado conexões remotas</li>";
echo "<li><strong>Firewall</strong> - Seu provedor de internet pode estar bloqueando</li>";
echo "<li><strong>VPN/Proxy</strong> - Pode estar interferindo na conexão</li>";
echo "<li><strong>Use o banco local</strong> - Configure para usar MySQL local durante desenvolvimento</li>";
echo "</ol>";

echo "<h2>5. Próximos Passos</h2>";
echo "<p>1. Verifique as informações no painel da Hostinger</p>";
echo "<p>2. Se não conseguir conectar remotamente, use banco local para desenvolvimento</p>";
echo "<p>3. Teste a conexão no servidor da Hostinger (produção)</p>";

echo "<hr>";
echo "<p><a href='config_database.php'>Ver configuração atual</a></p>";
?> 