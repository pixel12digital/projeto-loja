<?php
require_once '../config_database.php';

// Verifica se o parâmetro id foi passado
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo '<h2>Produto não encontrado.</h2>';
    exit;
}

try {
    $pdo = getDBConnection();
    // Busca o produto
    $stmt = $pdo->prepare('SELECT p.*, c.nome as categoria_nome FROM produtos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE p.id = ? LIMIT 1');
    $stmt->execute([$id]);
    $produto = $stmt->fetch();
    if (!$produto) {
        echo '<h2>Produto não encontrado.</h2>';
        exit;
    }
    // Busca imagens do produto
    $stmtImg = $pdo->prepare('SELECT * FROM produto_imagens WHERE produto_id = ? ORDER BY ordem, principal DESC');
    $stmtImg->execute([$id]);
    $imagens = $stmtImg->fetchAll();
} catch (Exception $e) {
    echo '<h2>Erro ao carregar produto: ' . htmlspecialchars($e->getMessage()) . '</h2>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($produto['nome']); ?> - Bella Curves</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .produto-container { max-width: 900px; margin: 40px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 32px; display: flex; gap: 32px; }
        .produto-imagens { flex: 1; }
        .produto-imagens img { max-width: 100%; border-radius: 8px; margin-bottom: 12px; }
        .produto-info { flex: 2; }
        .produto-info h1 { margin-top: 0; }
        .produto-preco { font-size: 2rem; color: #6366f1; margin: 16px 0; }
        .produto-categoria { color: #888; font-size: 1rem; margin-bottom: 8px; }
        .produto-estoque { color: #090; font-size: 1rem; margin-bottom: 16px; }
        .produto-descricao { margin-top: 24px; font-size: 1.1rem; }
        .btn-comprar { background: #6366f1; color: #fff; border: none; padding: 12px 32px; border-radius: 4px; font-size: 1.1rem; cursor: pointer; margin-top: 24px; }
        .btn-comprar:disabled { background: #ccc; cursor: not-allowed; }
    </style>
</head>
<body>
    <div class="produto-container">
        <div class="produto-imagens">
            <?php if ($imagens && count($imagens) > 0): ?>
                <?php foreach ($imagens as $img): ?>
                    <img src="../uploads/products/<?php echo htmlspecialchars($img['imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                <?php endforeach; ?>
            <?php else: ?>
                <img src="../assets/img/no-image.png" alt="Sem imagem">
            <?php endif; ?>
        </div>
        <div class="produto-info">
            <h1><?php echo htmlspecialchars($produto['nome']); ?></h1>
            <div class="produto-categoria">Categoria: <?php echo htmlspecialchars($produto['categoria_nome'] ?? '-'); ?></div>
            <div class="produto-preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
            <div class="produto-estoque">Estoque: <?php echo (int)$produto['estoque']; ?> un.</div>
            <div class="produto-descricao"><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></div>
            <form action="carrinho.php" method="post">
                <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                <input type="number" name="quantidade" value="1" min="1" max="<?php echo (int)$produto['estoque']; ?>" style="width:60px;">
                <button class="btn-comprar" type="submit" <?php if ($produto['estoque'] <= 0) echo 'disabled'; ?>>Comprar</button>
            </form>
        </div>
    </div>
</body>
</html> 