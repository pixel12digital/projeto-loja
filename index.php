<?php
// Loja Plus Size - Bella Curves
// Página Principal

// Incluir configurações
require_once 'config.php';

// Verificar se o banco está conectado
try {
    $pdo = new PDO("mysql:host=" . DB_HOSTNAME . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_status = "✅ Conectado";
} catch(PDOException $e) {
    $db_status = "❌ Erro: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bella Curves - Loja Plus Size</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f4e8dc 0%, #d4a574 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 40px 0;
        }
        .logo {
            font-size: 3rem;
            font-weight: bold;
            color: #8b4f6b;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 30px;
        }
        .status-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .status-item {
            display: flex;
            align-items: center;
            margin: 15px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .status-icon {
            font-size: 1.5rem;
            margin-right: 15px;
            width: 30px;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(45deg, #d4a574, #8b4f6b);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            margin: 10px;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .btn-admin {
            background: linear-gradient(45deg, #8b4f6b, #d4a574);
        }
        .btn-store {
            background: linear-gradient(45deg, #d4a574, #8b4f6b);
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .feature {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .feature i {
            font-size: 2rem;
            color: #d4a574;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🛍️ Bella Curves</div>
            <div class="subtitle">Loja Plus Size - Sistema de E-commerce</div>
        </div>

        <div class="status-card">
            <h2><i class="fas fa-info-circle"></i> Status do Sistema</h2>
            
            <div class="status-item">
                <i class="fas fa-database status-icon" style="color: <?php echo strpos($db_status, '✅') !== false ? '#28a745' : '#dc3545'; ?>"></i>
                <div>
                    <strong>Banco de Dados:</strong> <?php echo $db_status; ?>
                </div>
            </div>
            
            <div class="status-item">
                <i class="fas fa-server status-icon" style="color: #28a745;"></i>
                <div>
                    <strong>Servidor Web:</strong> ✅ Apache/PHP Funcionando
                </div>
            </div>
            
            <div class="status-item">
                <i class="fas fa-folder status-icon" style="color: #28a745;"></i>
                <div>
                    <strong>Arquivos:</strong> ✅ Estrutura Completa
                </div>
            </div>
        </div>

        <div class="features">
            <div class="feature">
                <i class="fas fa-shopping-cart"></i>
                <h3>Loja Virtual</h3>
                <p>Catálogo completo de produtos plus size</p>
            </div>
            <div class="feature">
                <i class="fas fa-credit-card"></i>
                <h3>Pagamentos</h3>
                <p>Múltiplas formas de pagamento</p>
            </div>
            <div class="feature">
                <i class="fas fa-mobile-alt"></i>
                <h3>Responsivo</h3>
                <p>Otimizado para todos os dispositivos</p>
            </div>
            <div class="feature">
                <i class="fas fa-chart-line"></i>
                <h3>Relatórios</h3>
                <p>Dashboard completo de vendas</p>
            </div>
        </div>

        <div style="text-align: center; margin: 40px 0;">
            <a href="admin/" class="btn btn-admin">
                <i class="fas fa-cog"></i> Painel Administrativo
            </a>
            <a href="loja/" class="btn btn-store">
                <i class="fas fa-store"></i> Acessar Loja
            </a>
        </div>

        <div class="status-card">
            <h3><i class="fas fa-tools"></i> Informações Técnicas</h3>
            <p><strong>Host:</strong> <?php echo DB_HOSTNAME; ?></p>
            <p><strong>Database:</strong> <?php echo DB_DATABASE; ?></p>
            <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
            <p><strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Apache'; ?></p>
        </div>
    </div>

    <script>
        // Adicionar interatividade
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Bella Curves - Loja Plus Size carregada com sucesso!');
        });
    </script>
</body>
</html> 