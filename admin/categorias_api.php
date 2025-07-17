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
            listarCategorias($pdo);
            break;
        case 'buscar':
            buscarCategorias($pdo);
            break;
        case 'visualizar':
            visualizarCategoria($pdo);
            break;
        case 'editar':
            editarCategoria($pdo);
            break;
        case 'excluir':
            excluirCategoria($pdo);
            break;
        case 'criar':
            criarCategoria($pdo);
            break;
        default:
            echo json_encode(['error' => 'Ação não especificada']);
    }
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

function listarCategorias($pdo) {
    $page = $_GET['page'] ?? 1;
    $limit = $_GET['limit'] ?? 10;
    $offset = ($page - 1) * $limit;
    
    $where = "WHERE 1=1";
    $params = [];
    
    // Filtros
    if (!empty($_GET['ativo'])) {
        $where .= " AND c.ativo = ?";
        $params[] = $_GET['ativo'];
    }
    
    // Contar total
    $countSql = "SELECT COUNT(*) FROM categorias c $where";
    $stmt = $pdo->prepare($countSql);
    $stmt->execute($params);
    $total = $stmt->fetchColumn();
    
    // Buscar categorias
    $sql = "SELECT 
                c.*,
                (SELECT COUNT(*) FROM produtos WHERE categoria_id = c.id) as total_produtos
            FROM categorias c
            $where
            ORDER BY c.nome
            LIMIT ? OFFSET ?";
    
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $categorias = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $categorias,
        'total' => $total,
        'page' => $page,
        'limit' => $limit,
        'pages' => ceil($total / $limit)
    ]);
}

function buscarCategorias($pdo) {
    $termo = $_GET['termo'] ?? '';
    
    if (empty($termo)) {
        echo json_encode(['error' => 'Termo de busca não especificado']);
        return;
    }
    
    $sql = "SELECT 
                c.*,
                (SELECT COUNT(*) FROM produtos WHERE categoria_id = c.id) as total_produtos
            FROM categorias c
            WHERE c.nome LIKE ? 
               OR c.descricao LIKE ?
            ORDER BY c.nome
            LIMIT 20";
    
    $termo = "%$termo%";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$termo, $termo]);
    $categorias = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $categorias
    ]);
}

function visualizarCategoria($pdo) {
    $id = $_GET['id'] ?? $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['error' => 'ID da categoria não especificado']);
        return;
    }
    
    // Buscar categoria
    $sql = "SELECT * FROM categorias WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $categoria = $stmt->fetch();
    
    if (!$categoria) {
        echo json_encode(['error' => 'Categoria não encontrada']);
        return;
    }
    
    // Buscar produtos da categoria
    $sqlProdutos = "SELECT id, nome, sku, preco, estoque, status FROM produtos WHERE categoria_id = ? ORDER BY nome";
    $stmtProdutos = $pdo->prepare($sqlProdutos);
    $stmtProdutos->execute([$id]);
    $categoria['produtos'] = $stmtProdutos->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $categoria
    ]);
}

function editarCategoria($pdo) {
    $id = $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['error' => 'ID da categoria não especificado']);
        return;
    }
    
    // Verificar se categoria existe
    $stmt = $pdo->prepare("SELECT id FROM categorias WHERE id = ?");
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        echo json_encode(['error' => 'Categoria não encontrada']);
        return;
    }
    
    // Atualizar categoria
    $sql = "UPDATE categorias SET 
                nome = ?,
                descricao = ?,
                slug = ?,
                imagem = ?,
                ativo = ?,
                updated_at = NOW()
            WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $_POST['nome'] ?? '',
        $_POST['descricao'] ?? '',
        $_POST['slug'] ?? '',
        $_POST['imagem'] ?? '',
        $_POST['ativo'] ?? true,
        $id
    ]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Categoria atualizada com sucesso'
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao atualizar categoria']);
    }
}

function excluirCategoria($pdo) {
    $id = $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['error' => 'ID da categoria não especificado']);
        return;
    }
    
    // Verificar se há produtos na categoria
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM produtos WHERE categoria_id = ?");
    $stmt->execute([$id]);
    $totalProdutos = $stmt->fetchColumn();
    
    if ($totalProdutos > 0) {
        echo json_encode(['error' => 'Não é possível excluir categoria com produtos']);
        return;
    }
    
    // Excluir categoria
    $stmt = $pdo->prepare("DELETE FROM categorias WHERE id = ?");
    $result = $stmt->execute([$id]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Categoria excluída com sucesso'
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao excluir categoria']);
    }
}

function criarCategoria($pdo) {
    $nome = $_POST['nome'] ?? '';
    
    if (empty($nome)) {
        echo json_encode(['error' => 'Nome da categoria é obrigatório']);
        return;
    }
    
    // Verificar se nome já existe
    $stmt = $pdo->prepare("SELECT id FROM categorias WHERE nome = ?");
    $stmt->execute([$nome]);
    if ($stmt->fetch()) {
        echo json_encode(['error' => 'Categoria com este nome já existe']);
        return;
    }
    
    // Gerar slug se não fornecido
    $slug = $_POST['slug'] ?? '';
    if (empty($slug)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nome)));
    }
    
    $sql = "INSERT INTO categorias (nome, descricao, slug, imagem, ativo) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $nome,
        $_POST['descricao'] ?? '',
        $slug,
        $_POST['imagem'] ?? '',
        $_POST['ativo'] ?? true
    ]);
    
    if ($result) {
        $categoria_id = $pdo->lastInsertId();
        echo json_encode([
            'success' => true,
            'message' => 'Categoria criada com sucesso',
            'categoria_id' => $categoria_id
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao criar categoria']);
    }
}
?> 