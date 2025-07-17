<?php
// Loja Plus Size - Bella Curves
// Página do Carrinho de Compras

session_start();

// Incluir configurações
require_once '../config.php';

// Verificar conexão com banco
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    $error = "Erro de conexão: " . $e->getMessage();
}

// Inicializar carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Remover produto do carrinho
if (isset($_POST['remover_produto'])) {
    $produto_id = $_POST['produto_id'];
    unset($_SESSION['carrinho'][$produto_id]);
    header('Location: carrinho.php');
    exit;
}

// Atualizar quantidade
if (isset($_POST['atualizar_quantidade'])) {
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    
    if ($quantidade > 0) {
        $_SESSION['carrinho'][$produto_id] = $quantidade;
    } else {
        unset($_SESSION['carrinho'][$produto_id]);
    }
    
    header('Location: carrinho.php');
    exit;
}

// Limpar carrinho
if (isset($_POST['limpar_carrinho'])) {
    $_SESSION['carrinho'] = [];
    header('Location: carrinho.php');
    exit;
}

// Buscar produtos do carrinho
$produtos_carrinho = [];
$total_geral = 0;

if (!empty($_SESSION['carrinho'])) {
    $ids = array_keys($_SESSION['carrinho']);
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($produtos as $produto) {
        $quantidade = $_SESSION['carrinho'][$produto['id']];
        $subtotal = $produto['preco'] * $quantidade;
        $total_geral += $subtotal;
        
        $produtos_carrinho[] = [
            'produto' => $produto,
            'quantidade' => $quantidade,
            'subtotal' => $subtotal
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - Bella Curves</title>
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
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Carrinho */
        .carrinho-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .carrinho-vazio {
            text-align: center;
            padding: 60px 20px;
        }
        
        .carrinho-vazio i {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        
        .carrinho-vazio h2 {
            color: var(--secondary-color);
            margin-bottom: 15px;
        }
        
        .carrinho-item {
            display: grid;
            grid-template-columns: 100px 1fr auto auto auto;
            gap: 20px;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }
        
        .carrinho-item:last-child {
            border-bottom: none;
        }
        
        .produto-imagem {
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--secondary-color);
        }
        
        .produto-info h3 {
            color: var(--text-color);
            margin-bottom: 5px;
        }
        
        .produto-info p {
            color: #666;
            font-size: 0.9rem;
        }
        
        .quantidade-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .quantidade-input {
            width: 60px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-size: 0.9rem;
        }
        
        .btn-primary {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--secondary-color);
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-secondary {
            background: var(--light-gray);
            color: var(--text-color);
        }
        
        .btn-secondary:hover {
            background: #e9ecef;
        }
        
        .preco {
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .carrinho-resumo {
            background: var(--light-gray);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .resumo-item {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        
        .resumo-total {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--secondary-color);
            border-top: 2px solid var(--primary-color);
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .acoes-carrinho {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            justify-content: center;
        }
        
        /* Responsivo */
        @media (max-width: 768px) {
            .carrinho-item {
                grid-template-columns: 1fr;
                gap: 15px;
                text-align: center;
            }
            
            .produto-imagem {
                margin: 0 auto;
            }
            
            .quantidade-controls {
                justify-content: center;
            }
            
            .acoes-carrinho {
                flex-direction: column;
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
                    <li><a href="index.php#produtos">Produtos</a></li>
                    <li><a href="carrinho.php">Carrinho</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Carrinho -->
    <div class="container">
        <h1 style="text-align: center; margin: 30px 0; color: var(--secondary-color);">
            <i class="fas fa-shopping-cart"></i> Seu Carrinho
        </h1>
        
        <?php if (empty($produtos_carrinho)): ?>
            <div class="carrinho-container">
                <div class="carrinho-vazio">
                    <i class="fas fa-shopping-bag"></i>
                    <h2>Seu carrinho está vazio</h2>
                    <p>Adicione alguns produtos para começar suas compras!</p>
                    <a href="index.php" class="btn btn-primary" style="margin-top: 20px;">
                        <i class="fas fa-arrow-left"></i> Continuar Comprando
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="carrinho-container">
                <?php foreach ($produtos_carrinho as $item): ?>
                    <div class="carrinho-item">
                        <div class="produto-imagem">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        
                        <div class="produto-info">
                            <h3><?php echo htmlspecialchars($item['produto']['nome']); ?></h3>
                            <p><?php echo htmlspecialchars($item['produto']['descricao']); ?></p>
                        </div>
                        
                        <div class="quantidade-controls">
                            <form method="POST" style="display: flex; align-items: center; gap: 10px;">
                                <input type="hidden" name="produto_id" value="<?php echo $item['produto']['id']; ?>">
                                <input type="number" name="quantidade" value="<?php echo $item['quantidade']; ?>" 
                                       min="1" class="quantidade-input">
                                <button type="submit" name="atualizar_quantidade" class="btn btn-primary">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>
                        </div>
                        
                        <div class="preco">
                            R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?>
                        </div>
                        
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="produto_id" value="<?php echo $item['produto']['id']; ?>">
                            <button type="submit" name="remover_produto" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
                
                <!-- Resumo do Carrinho -->
                <div class="carrinho-resumo">
                    <div class="resumo-item">
                        <span>Subtotal:</span>
                        <span>R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></span>
                    </div>
                    <div class="resumo-item">
                        <span>Frete:</span>
                        <span>Grátis</span>
                    </div>
                    <div class="resumo-item resumo-total">
                        <span>Total:</span>
                        <span>R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></span>
                    </div>
                </div>
                
                <!-- Ações do Carrinho -->
                <div class="acoes-carrinho">
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Continuar Comprando
                    </a>
                    
                    <form method="POST" style="display: inline;">
                        <button type="submit" name="limpar_carrinho" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Limpar Carrinho
                        </button>
                    </form>
                    
                    <a href="checkout.php" class="btn btn-primary">
                        <i class="fas fa-credit-card"></i> Finalizar Compra
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Carrinho carregado!');
        });
    </script>
</body>
</html> 