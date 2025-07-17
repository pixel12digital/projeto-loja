<?php
// Teste para descobrir o host correto da Hostinger
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Teste de Host da Hostinger</h1>";

// Lista de possíveis hosts da Hostinger
$possible_hosts = [
    'localhost',
    '127.0.0.1',
    'sql.radioweb.app.br',
    'mysql.radioweb.app.br',
    'db.radioweb.app.br',
    'localhost.radioweb.app.br'
];

$db_name = 'u819562010_lojaplussize';
$db_user = 'u819562010_lojaplussize';
$db_pass = 'Los@ngo081081';

echo "<h2>Testando diferentes hosts:</h2>";

foreach ($possible_hosts as $host) {
    echo "<h3>Testando host: $host</h3>";
    
    try {
        $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4;port=3306";
        echo "DSN: $dsn<br>";
        
        $pdo = new PDO($dsn, $db_user, $db_pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 5, // Timeout de 5 segundos
        ]);
        
        echo "✅ <strong>CONEXÃO BEM-SUCEDIDA com host: $host</strong><br>";
        
        // Testar query
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM produtos");
        $result = $stmt->fetch();
        echo "✅ Total de produtos: " . $result['total'] . "<br>";
        
        // Se chegou aqui, este é o host correto
        echo "<div style='background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb;'>";
        echo "<strong>🎉 HOST CORRETO ENCONTRADO: $host</strong><br>";
        echo "Use este host na configuração.";
        echo "</div>";
        
        break; // Parar no primeiro que funcionar
        
    } catch (PDOException $e) {
        echo "❌ Erro: " . $e->getMessage() . "<br>";
        echo "Código: " . $e->getCode() . "<br><br>";
    }
}

echo "<hr>";
echo "<h2>Próximos Passos</h2>";
echo "<p>1. Anote o host que funcionou</p>";
echo "<p>2. Atualize o config_database.php com o host correto</p>";
echo "<p>3. Teste novamente a conexão</p>";
?> 