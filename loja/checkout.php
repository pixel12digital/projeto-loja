<?php
// Loja Plus Size - Checkout
// Finalização da compra

session_start();

// Incluir configurações
require_once '../config_database.php';

// Verificar se há produtos no carrinho
if (empty($_SESSION['carrinho'])) {
    header('Location: carrinho.php');
    exit;
}

// Verificar conexão com banco
try {
    $pdo = getDBConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    $error = "Erro de conexão: " . $e->getMessage();
}

// Buscar produtos do carrinho
$produtos_carrinho = [];
$total_geral = 0;

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

// Processar finalização da compra
if (isset($_POST['finalizar_compra'])) {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $cep = $_POST['cep'] ?? '';
    
    if (!empty($nome) && !empty($email)) {
        // Aqui você pode salvar o pedido no banco de dados
        // Por enquanto, vamos apenas limpar o carrinho e mostrar sucesso
        
        $_SESSION['carrinho'] = [];
        $pedido_sucesso = true;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Bella Curves</title>
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
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .checkout-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin: 20px 0;
        }
        
        .checkout-form {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .resumo-pedido {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            height: fit-content;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: var(--text-color);
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-size: 1rem;
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
        
        .produto-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .produto-item:last-child {
            border-bottom: none;
        }
        
        .produto-info {
            flex: 1;
        }
        
        .produto-nome {
            font-weight: 600;
            color: var(--text-color);
        }
        
        .produto-quantidade {
            color: #666;
            font-size: 0.9rem;
        }
        
        .produto-preco {
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .resumo-total {
            border-top: 2px solid var(--primary-color);
            padding-top: 15px;
            margin-top: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--secondary-color);
        }
        
        .sucesso-mensagem {
            background: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
        }
        
        .sucesso-mensagem i {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        
        /* Responsivo */
        @media (max-width: 768px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="index.php" class="logo">🛍️ Bella Curves</a>
        </div>
    </header>

    <!-- Checkout -->
    <div class="container">
        <h1 style="text-align: center; margin: 30px 0; color: var(--secondary-color);">
            <i class="fas fa-credit-card"></i> Finalizar Compra
        </h1>
        
        <?php if (isset($pedido_sucesso)): ?>
            <div class="sucesso-mensagem">
                <i class="fas fa-check-circle"></i>
                <h2>Pedido Realizado com Sucesso!</h2>
                <p>Obrigada por sua compra. Você receberá um email com os detalhes do pedido.</p>
                <a href="index.php" class="btn btn-primary" style="margin-top: 20px;">
                    <i class="fas fa-home"></i> Voltar à Loja
                </a>
            </div>
        <?php else: ?>
            <div class="checkout-grid">
                <!-- Formulário de Dados -->
                <div class="checkout-form">
                    <h2 style="margin-bottom: 30px; color: var(--secondary-color);">
                        <i class="fas fa-user"></i> Dados Pessoais
                    </h2>
                    
                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nome">Nome Completo *</label>
                                <input type="text" id="nome" name="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="tel" id="telefone" name="telefone">
                        </div>
                        
                        <div class="form-group">
                            <label for="endereco">Endereço Completo</label>
                            <textarea id="endereco" name="endereco" rows="3"></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="cidade">Cidade</label>
                                <input type="text" id="cidade" name="cidade">
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select id="estado" name="estado">
                                    <option value="">Selecione...</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="PR">Paraná</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="BA">Bahia</option>
                                    <option value="GO">Goiás</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="CE">Ceará</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="cep">CEP</label>
                            <input type="text" id="cep" name="cep" placeholder="00000-000">
                        </div>
                        
                        <div style="margin-top: 30px;">
                            <button type="submit" name="finalizar_compra" class="btn btn-primary">
                                <i class="fas fa-check"></i> Finalizar Pedido
                            </button>
                            <a href="carrinho.php" class="btn btn-secondary" style="margin-left: 15px;">
                                <i class="fas fa-arrow-left"></i> Voltar ao Carrinho
                            </a>
                        </div>
                    </form>
                </div>
                
                <!-- Resumo do Pedido -->
                <div class="resumo-pedido">
                    <h3 style="margin-bottom: 20px; color: var(--secondary-color);">
                        <i class="fas fa-shopping-bag"></i> Resumo do Pedido
                    </h3>
                    
                    <?php foreach ($produtos_carrinho as $item): ?>
                        <div class="produto-item">
                            <div class="produto-info">
                                <div class="produto-nome"><?php echo htmlspecialchars($item['produto']['nome']); ?></div>
                                <div class="produto-quantidade">Qtd: <?php echo $item['quantidade']; ?></div>
                            </div>
                            <div class="produto-preco">
                                R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="produto-item resumo-total">
                        <span>Total:</span>
                        <span>R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></span>
                    </div>
                    
                    <div style="margin-top: 20px; padding: 15px; background: var(--light-gray); border-radius: 8px;">
                        <h4 style="color: var(--secondary-color); margin-bottom: 10px;">
                            <i class="fas fa-truck"></i> Frete
                        </h4>
                        <p style="color: #28a745; font-weight: 600;">Grátis para todo o Brasil</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Checkout carregado!');
            
            // Máscara para telefone
            const telefone = document.getElementById('telefone');
            if (telefone) {
                telefone.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                    e.target.value = value;
                });
            }
            
            // Máscara para CEP
            const cep = document.getElementById('cep');
            if (cep) {
                cep.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                    e.target.value = value;
                });
            }
        });
    </script>
</body>
</html> 