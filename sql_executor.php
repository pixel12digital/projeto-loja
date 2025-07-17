<?php
// Script para executar comandos SQL remotamente
// Acesse via: https://peru-turkey-621361.hostingersite.com/sql_executor.php

// Configurações de segurança
$allowed_ips = ['127.0.0.1', '::1']; // Adicione seus IPs aqui para segurança
$secret_key = 'loja_plus_size_2024'; // Chave secreta para acesso

// Configuração do banco
$host = 'auth-db1067.hstgr.io';
$dbname = 'u819562010_lojaplussize';
$username = 'u819562010_lojaplussize';
$password = 'Los@ngo081081';

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Executor - Loja Plus Size</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #c49d61;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        textarea {
            height: 200px;
            font-family: monospace;
        }
        button {
            background-color: #c49d61;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #a88751;
        }
        .result {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #c49d61;
        }
        .error {
            background-color: #f8d7da;
            border-left-color: #dc3545;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            border-left-color: #28a745;
            color: #155724;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #c49d61;
            color: white;
        }
        .quick-commands {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 10px;
            margin-bottom: 20px;
        }
        .quick-cmd {
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            font-family: monospace;
        }
        .quick-cmd:hover {
            background-color: #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛠️ SQL Executor - Loja Plus Size</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="secret">Chave de Acesso:</label>
                <input type="password" id="secret" name="secret" required>
            </div>
            
            <div class="form-group">
                <label>Comandos Rápidos:</label>
                <div class="quick-commands">
                    <div class="quick-cmd" onclick="setSQL('SHOW TABLES;')">Listar Tabelas</div>
                    <div class="quick-cmd" onclick="setSQL('SELECT COUNT(*) as total_produtos FROM products;')">Contar Produtos</div>
                    <div class="quick-cmd" onclick="setSQL('SELECT * FROM products LIMIT 10;')">Produtos (10 primeiros)</div>
                    <div class="quick-cmd" onclick="setSQL('SELECT * FROM categories;')">Categorias</div>
                    <div class="quick-cmd" onclick="setSQL('DESCRIBE products;')">Estrutura Produtos</div>
                    <div class="quick-cmd" onclick="setSQL('SELECT COUNT(*) as total_pedidos FROM orders;')">Total Pedidos</div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="sql">Comando SQL:</label>
                <textarea id="sql" name="sql" placeholder="Digite seu comando SQL aqui..."><?php echo htmlspecialchars($_POST['sql'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="action">Tipo de Operação:</label>
                <select id="action" name="action">
                    <option value="query">SELECT (Consulta)</option>
                    <option value="execute">INSERT/UPDATE/DELETE</option>
                    <option value="multiquery">Múltiplos Comandos</option>
                </select>
            </div>
            
            <button type="submit">Executar SQL</button>
        </form>

        <?php
        if ($_POST && isset($_POST['secret']) && isset($_POST['sql'])) {
            // Verificar chave secreta
            if ($_POST['secret'] !== $secret_key) {
                echo '<div class="result error">❌ Chave de acesso inválida!</div>';
            } else {
                try {
                    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $sql = trim($_POST['sql']);
                    $action = $_POST['action'] ?? 'query';
                    
                    echo '<div class="result success">';
                    echo '<h3>✅ Conexão estabelecida com sucesso!</h3>';
                    
                    if ($action === 'multiquery') {
                        // Múltiplos comandos
                        $statements = explode(';', $sql);
                        foreach ($statements as $statement) {
                            $statement = trim($statement);
                            if (empty($statement)) continue;
                            
                            echo "<h4>Executando: " . htmlspecialchars($statement) . "</h4>";
                            
                            if (stripos($statement, 'SELECT') === 0 || stripos($statement, 'SHOW') === 0 || stripos($statement, 'DESCRIBE') === 0) {
                                $stmt = $pdo->prepare($statement);
                                $stmt->execute();
                                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                if ($results) {
                                    echo '<table>';
                                    echo '<tr>';
                                    foreach (array_keys($results[0]) as $column) {
                                        echo '<th>' . htmlspecialchars($column) . '</th>';
                                    }
                                    echo '</tr>';
                                    
                                    foreach ($results as $row) {
                                        echo '<tr>';
                                        foreach ($row as $value) {
                                            echo '<td>' . htmlspecialchars($value ?? 'NULL') . '</td>';
                                        }
                                        echo '</tr>';
                                    }
                                    echo '</table>';
                                    echo '<p><strong>Registros encontrados:</strong> ' . count($results) . '</p>';
                                } else {
                                    echo '<p>Nenhum resultado encontrado.</p>';
                                }
                            } else {
                                $stmt = $pdo->prepare($statement);
                                $stmt->execute();
                                echo '<p><strong>Comando executado com sucesso!</strong></p>';
                                echo '<p><strong>Linhas afetadas:</strong> ' . $stmt->rowCount() . '</p>';
                            }
                        }
                    } else if ($action === 'query') {
                        // Consulta SELECT
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        if ($results) {
                            echo '<table>';
                            echo '<tr>';
                            foreach (array_keys($results[0]) as $column) {
                                echo '<th>' . htmlspecialchars($column) . '</th>';
                            }
                            echo '</tr>';
                            
                            foreach ($results as $row) {
                                echo '<tr>';
                                foreach ($row as $value) {
                                    echo '<td>' . htmlspecialchars($value ?? 'NULL') . '</td>';
                                }
                                echo '</tr>';
                            }
                            echo '</table>';
                            echo '<p><strong>Registros encontrados:</strong> ' . count($results) . '</p>';
                        } else {
                            echo '<p>Nenhum resultado encontrado.</p>';
                        }
                    } else {
                        // INSERT/UPDATE/DELETE
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        echo '<p><strong>Comando executado com sucesso!</strong></p>';
                        echo '<p><strong>Linhas afetadas:</strong> ' . $stmt->rowCount() . '</p>';
                    }
                    
                    echo '</div>';
                    
                } catch (PDOException $e) {
                    echo '<div class="result error">';
                    echo '<h3>❌ Erro na execução:</h3>';
                    echo '<p><strong>Erro:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
                    echo '</div>';
                }
            }
        }
        ?>
    </div>

    <script>
        function setSQL(sql) {
            document.getElementById('sql').value = sql;
        }
    </script>
</body>
</html> 