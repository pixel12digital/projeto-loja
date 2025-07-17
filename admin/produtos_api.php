<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config_database.php';

try {
    $pdo = getDBConnection();
    
    $action = $_GET['action'] ?? $_POST['action'] ?? '';
    
    switch ($action) {
        case 'listar':
            listarProdutos($pdo);
            break;
        case 'buscar':
            buscarProdutos($pdo);
            break;
        case 'visualizar':
            visualizarProduto($pdo);
            break;
        case 'editar':
            editarProduto($pdo);
            break;
        case 'excluir':
            excluirProduto($pdo);
            break;
        case 'criar':
            criarProduto($pdo);
            break;
        default:
            echo json_encode(['error' => 'Ação não especificada']);
    }
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

function listarProdutos($pdo) {
    $page = $_GET['page'] ?? 1;
    $limit = $_GET['limit'] ?? 10;
    $offset = ($page - 1) * $limit;
    
    $where = "WHERE 1=1";
    $params = [];
    
    // Filtros
    if (!empty($_GET['categoria_id'])) {
        $where .= " AND p.categoria_id = ?";
        $params[] = $_GET['categoria_id'];
    }
    
    if (!empty($_GET['status'])) {
        $where .= " AND p.status = ?";
        $params[] = $_GET['status'];
    }
    
    if (!empty($_GET['destaque'])) {
        $where .= " AND p.destaque = ?";
        $params[] = $_GET['destaque'];
    }
    
    // Contar total
    $countSql = "SELECT COUNT(*) FROM produtos p $where";
    $stmt = $pdo->prepare($countSql);
    $stmt->execute($params);
    $total = $stmt->fetchColumn();
    
    // Buscar produtos
    $sql = "SELECT 
                p.*,
                c.nome as categoria_nome
            FROM produtos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            $where
            ORDER BY p.created_at DESC
            LIMIT ? OFFSET ?";
    
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $produtos = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $produtos,
        'total' => $total,
        'page' => $page,
        'limit' => $limit,
        'pages' => ceil($total / $limit)
    ]);
}

function buscarProdutos($pdo) {
    $termo = $_GET['termo'] ?? '';
    
    if (empty($termo)) {
        echo json_encode(['error' => 'Termo de busca não especificado']);
        return;
    }
    
    $sql = "SELECT 
                p.*,
                c.nome as categoria_nome
            FROM produtos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            WHERE p.nome LIKE ? 
               OR p.sku LIKE ? 
               OR p.descricao LIKE ?
            ORDER BY p.nome
            LIMIT 20";
    
    $termo = "%$termo%";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$termo, $termo, $termo]);
    $produtos = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $produtos
    ]);
}

function visualizarProduto($pdo) {
    $id = $_GET['id'] ?? $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['error' => 'ID do produto não especificado']);
        return;
    }
    
    // Buscar produto
    $sql = "SELECT 
                p.*,
                c.nome as categoria_nome
            FROM produtos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            WHERE p.id = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $produto = $stmt->fetch();
    
    if (!$produto) {
        echo json_encode(['error' => 'Produto não encontrado']);
        return;
    }
    
    // Buscar imagens
    $sqlImagens = "SELECT * FROM produto_imagens WHERE produto_id = ? ORDER BY ordem, principal DESC";
    $stmtImagens = $pdo->prepare($sqlImagens);
    $stmtImagens->execute([$id]);
    $produto['imagens'] = $stmtImagens->fetchAll();
    
    // Buscar tamanhos
    $sqlTamanhos = "SELECT 
                        pt.*,
                        t.nome as tamanho_nome
                    FROM produto_tamanhos pt
                    LEFT JOIN tamanhos t ON pt.tamanho_id = t.id
                    WHERE pt.produto_id = ?
                    ORDER BY t.ordem";
    $stmtTamanhos = $pdo->prepare($sqlTamanhos);
    $stmtTamanhos->execute([$id]);
    $produto['tamanhos'] = $stmtTamanhos->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $produto
    ]);
}

function editarProduto($pdo) {
    $id = $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['error' => 'ID do produto não especificado']);
        return;
    }
    
    // Verificar se produto existe
    $stmt = $pdo->prepare("SELECT id FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        echo json_encode(['error' => 'Produto não encontrado']);
        return;
    }
    
    // Atualizar produto
    $sql = "UPDATE produtos SET 
                nome = ?,
                descricao = ?,
                sku = ?,
                categoria_id = ?,
                preco = ?,
                preco_promocional = ?,
                estoque = ?,
                peso = ?,
                dimensoes = ?,
                status = ?,
                destaque = ?,
                meta_title = ?,
                meta_description = ?,
                updated_at = NOW()
            WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $_POST['nome'] ?? '',
        $_POST['descricao'] ?? '',
        $_POST['sku'] ?? '',
        $_POST['categoria_id'] ?? null,
        $_POST['preco'] ?? 0,
        $_POST['preco_promocional'] ?? null,
        $_POST['estoque'] ?? 0,
        $_POST['peso'] ?? null,
        $_POST['dimensoes'] ?? '',
        $_POST['status'] ?? 'ativo',
        $_POST['destaque'] ?? false,
        $_POST['meta_title'] ?? '',
        $_POST['meta_description'] ?? '',
        $id
    ]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Produto atualizado com sucesso'
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao atualizar produto']);
    }
}

function excluirProduto($pdo) {
    $id = $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['error' => 'ID do produto não especificado']);
        return;
    }
    
    try {
        $pdo->beginTransaction();
        
        // Excluir imagens do produto
        $stmt = $pdo->prepare("DELETE FROM produto_imagens WHERE produto_id = ?");
        $stmt->execute([$id]);
        
        // Excluir tamanhos do produto
        $stmt = $pdo->prepare("DELETE FROM produto_tamanhos WHERE produto_id = ?");
        $stmt->execute([$id]);
        
        // Excluir produto
        $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        
        $pdo->commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Produto excluído com sucesso'
        ]);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['error' => 'Erro ao excluir produto: ' . $e->getMessage()]);
    }
}

function criarProduto($pdo) {
    $nome = $_POST['nome'] ?? '';
    $sku = $_POST['sku'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    
    if (empty($nome) || empty($sku) || $preco <= 0) {
        echo json_encode(['error' => 'Dados obrigatórios não preenchidos']);
        return;
    }
    
    // Verificar se SKU já existe
    $stmt = $pdo->prepare("SELECT id FROM produtos WHERE sku = ?");
    $stmt->execute([$sku]);
    if ($stmt->fetch()) {
        echo json_encode(['error' => 'SKU já existe']);
        return;
    }
    
    $sql = "INSERT INTO produtos (
                nome, descricao, sku, categoria_id, preco, preco_promocional,
                estoque, peso, dimensoes, status, destaque, meta_title, meta_description
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $nome,
        $_POST['descricao'] ?? '',
        $sku,
        $_POST['categoria_id'] ?? null,
        $preco,
        $_POST['preco_promocional'] ?? null,
        $_POST['estoque'] ?? 0,
        $_POST['peso'] ?? null,
        $_POST['dimensoes'] ?? '',
        $_POST['status'] ?? 'ativo',
        $_POST['destaque'] ?? false,
        $_POST['meta_title'] ?? '',
        $_POST['meta_description'] ?? ''
    ]);
    
    if ($result) {
        $produto_id = $pdo->lastInsertId();
        echo json_encode([
            'success' => true,
            'message' => 'Produto criado com sucesso',
            'produto_id' => $produto_id
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao criar produto']);
    }
}
?> 