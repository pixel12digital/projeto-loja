<?php
// Loja Plus Size - Catálogo de Produtos
// Página principal da loja

session_start();

// Incluir configurações
require_once '../config_database.php';

// Verificar conexão com banco
try {
    $pdo = new PDO("mysql:host=" . DB_HOSTNAME . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Buscar produtos do banco
    $stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC LIMIT 12");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    $produtos = [];
    $error = "Erro de conexão: " . $e->getMessage();
}

// Inicializar carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adicionar produto ao carrinho
if (isset($_POST['adicionar_carrinho'])) {
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'] ?? 1;
    
    if (isset($_SESSION['carrinho'][$produto_id])) {
        $_SESSION['carrinho'][$produto_id] += $quantidade;
    } else {
        $_SESSION['carrinho'][$produto_id] = $quantidade;
    }
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Calcular total do carrinho
$total_carrinho = 0;
foreach ($_SESSION['carrinho'] as $qtd) {
    $total_carrinho += $qtd;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bella Curves - Loja Plus Size</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #d4a574;
            --secondary-color: #8b4f6b;
            --accent-color: #f4e8dc;
            --text-color: #333;
            --light-gray: #f8f9fa;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--accent-color);
            color: var(--text-color);
        }
        
        /* Header */
        .header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 30px;
        }
        
        .nav-menu a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-menu a:hover {
            color: var(--primary-color);
        }
        
        .cart-icon {
            position: relative;
            font-size: 1.2rem;
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            text-align: center;
            padding: 60px 20px;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        .hero p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Produtos Grid */
        .produtos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }
        
        .produto-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .produto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .produto-imagem {
            width: 100%;
            height: 250px;
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--secondary-color);
        }
        
        .produto-info {
            padding: 20px;
        }
        
        .produto-titulo {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-color);
        }
        
        .produto-descricao {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .produto-preco {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .produto-acoes {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-primary {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: var(--light-gray);
            color: var(--text-color);
        }
        
        .btn-secondary:hover {
            background: #e9ecef;
        }
        
        .quantidade-input {
            width: 60px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        
        /* Footer */
        .footer {
            background: var(--secondary-color);
            color: white;
            text-align: center;
            padding: 40px 20px;
            margin-top: 60px;
        }
        
        /* Responsivo */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            
            .nav-menu {
                gap: 15px;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .produtos-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="index.php" class="logo">🛍️ Bella Curves</a>
            
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Início</a></li>
                    <li><a href="#produtos">Produtos</a></li>
                    <li><a href="#sobre">Sobre</a></li>
                    <li><a href="#contato">Contato</a></li>
                </ul>
            </nav>
            
            <a href="carrinho.php" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <?php if ($total_carrinho > 0): ?>
                    <span class="cart-count"><?php echo $total_carrinho; ?></span>
                <?php endif; ?>
            </a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Bella Curves</h1>
            <p>Moda Plus Size com Estilo e Conforto</p>
        </div>
    </section>

    <!-- Produtos -->
    <section id="produtos" class="container">
        <h2 style="text-align: center; margin: 40px 0; color: var(--secondary-color);">
            <i class="fas fa-tshirt"></i> Nossos Produtos
        </h2>
        
        <?php if (empty($produtos)): ?>
            <div style="text-align: center; padding: 40px;">
                <i class="fas fa-box-open" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 20px;"></i>
                <h3>Nenhum produto cadastrado</h3>
                <p>Acesse o painel administrativo para adicionar produtos.</p>
                <a href="../admin/" class="btn btn-primary">Painel Admin</a>
            </div>
        <?php else: ?>
            <div class="produtos-grid">
                <?php foreach ($produtos as $produto): ?>
                    <div class="produto-card">
                        <div class="produto-imagem">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <div class="produto-info">
                            <h3 class="produto-titulo"><?php echo htmlspecialchars($produto['nome'] ?? 'Produto'); ?></h3>
                            <p class="produto-descricao">
                                <?php echo htmlspecialchars($produto['descricao'] ?? 'Descrição do produto'); ?>
                            </p>
                            <div class="produto-preco">
                                R$ <?php echo number_format($produto['preco'] ?? 99.90, 2, ',', '.'); ?>
                            </div>
                            <form method="POST" class="produto-acoes">
                                <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                                <input type="number" name="quantidade" value="1" min="1" class="quantidade-input">
                                <button type="submit" name="adicionar_carrinho" class="btn btn-primary">
                                    <i class="fas fa-cart-plus"></i> Adicionar
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <h3>Bella Curves</h3>
            <p>Moda Plus Size com qualidade e estilo</p>
            <div style="margin-top: 20px;">
                <a href="../admin/" class="btn btn-secondary" style="margin: 5px;">
                    <i class="fas fa-cog"></i> Admin
                </a>
                <a href="../" class="btn btn-secondary" style="margin: 5px;">
                    <i class="fas fa-home"></i> Voltar
                </a>
            </div>
        </div>
    </footer>

    <script>
        // Adicionar interatividade
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Bella Curves - Loja carregada!');
            
            // Smooth scroll para links internos
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html> 