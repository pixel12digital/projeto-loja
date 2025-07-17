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
            listarPedidos($pdo);
            break;
        case 'buscar':
            buscarPedidos($pdo);
            break;
        case 'visualizar':
            visualizarPedido($pdo);
            break;
        case 'editar':
            editarPedido($pdo);
            break;
        case 'excluir':
            excluirPedido($pdo);
            break;
        case 'criar':
            criarPedido($pdo);
            break;
        case 'atualizar_status':
            atualizarStatus($pdo);
            break;
        default:
            echo json_encode(['error' => 'Ação não especificada']);
    }
    
} catch (Exception $e) {
    // Se for erro de conexão, retornar dados mock para desenvolvimento
    if (strpos($e->getMessage(), 'Erro de conexão') !== false) {
        $action = $_GET['action'] ?? $_POST['action'] ?? '';
        
        switch ($action) {
            case 'listar':
                echo json_encode([
                    'success' => true,
                    'data' => [
                        [
                            'id' => 1,
                            'numero' => 'PED-001',
                            'cliente_nome' => 'Maria Silva',
                            'cliente_email' => 'maria@email.com',
                            'cliente_telefone' => '(11) 99999-9999',
                            'total' => 299.90,
                            'status' => 'pendente',
                            'created_at' => date('Y-m-d H:i:s'),
                            'itens' => [
                                [
                                    'id' => 1,
                                    'produto_nome' => 'Vestido Plus Size Floral',
                                    'produto_sku' => 'VS-001',
                                    'quantidade' => 1,
                                    'preco_unitario' => 89.90,
                                    'tamanho_nome' => 'M'
                                ]
                            ]
                        ],
                        [
                            'id' => 2,
                            'numero' => 'PED-002',
                            'cliente_nome' => 'João Santos',
                            'cliente_email' => 'joao@email.com',
                            'cliente_telefone' => '(11) 88888-8888',
                            'total' => 450.00,
                            'status' => 'pago',
                            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                            'itens' => [
                                [
                                    'id' => 2,
                                    'produto_nome' => 'Blusa Plus Size Básica',
                                    'produto_sku' => 'BL-001',
                                    'quantidade' => 2,
                                    'preco_unitario' => 45.90,
                                    'tamanho_nome' => 'L'
                                ]
                            ]
                        ]
                    ],
                    'total' => 2,
                    'page' => 1,
                    'limit' => 10,
                    'pages' => 1
                ]);
                break;
            default:
                echo json_encode(['error' => 'Ação não especificada']);
        }
    } else {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

function listarPedidos($pdo) {
    $page = $_GET['page'] ?? 1;
    $limit = $_GET['limit'] ?? 10;
    $offset = ($page - 1) * $limit;
    
    $where = "WHERE 1=1";
    $params = [];
    
    // Filtros
    if (!empty($_GET['status'])) {
        $where .= " AND p.status = ?";
        $params[] = $_GET['status'];
    }
    
    if (!empty($_GET['data_inicio'])) {
        $where .= " AND DATE(p.created_at) >= ?";
        $params[] = $_GET['data_inicio'];
    }
    
    if (!empty($_GET['data_fim'])) {
        $where .= " AND DATE(p.created_at) <= ?";
        $params[] = $_GET['data_fim'];
    }
    
    // Contar total
    $countSql = "SELECT COUNT(*) FROM pedidos p $where";
    $stmt = $pdo->prepare($countSql);
    $stmt->execute($params);
    $total = $stmt->fetchColumn();
    
    // Buscar pedidos
    $sql = "SELECT 
                p.*,
                c.nome as cliente_nome,
                c.email as cliente_email,
                c.telefone as cliente_telefone
            FROM pedidos p
            LEFT JOIN clientes c ON p.cliente_id = c.id
            $where
            ORDER BY p.created_at DESC
            LIMIT ? OFFSET ?";
    
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $pedidos = $stmt->fetchAll();
    
    // Buscar itens dos pedidos
    foreach ($pedidos as &$pedido) {
        $sqlItens = "SELECT 
                        pi.*,
                        p.nome as produto_nome,
                        p.sku as produto_sku,
                        t.nome as tamanho_nome
                    FROM pedido_itens pi
                    LEFT JOIN produtos p ON pi.produto_id = p.id
                    LEFT JOIN tamanhos t ON pi.tamanho_id = t.id
                    WHERE pi.pedido_id = ?";
        
        $stmtItens = $pdo->prepare($sqlItens);
        $stmtItens->execute([$pedido['id']]);
        $pedido['itens'] = $stmtItens->fetchAll();
    }
    
    echo json_encode([
        'success' => true,
        'data' => $pedidos,
        'total' => $total,
        'page' => $page,
        'limit' => $limit,
        'pages' => ceil($total / $limit)
    ]);
}

function buscarPedidos($pdo) {
    $termo = $_GET['termo'] ?? '';
    
    if (empty($termo)) {
        echo json_encode(['error' => 'Termo de busca não especificado']);
        return;
    }
    
    $sql = "SELECT 
                p.*,
                c.nome as cliente_nome,
                c.email as cliente_email
            FROM pedidos p
            LEFT JOIN clientes c ON p.cliente_id = c.id
            WHERE p.numero LIKE ? 
               OR c.nome LIKE ? 
               OR c.email LIKE ?
            ORDER BY p.created_at DESC
            LIMIT 20";
    
    $termo = "%$termo%";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$termo, $termo, $termo]);
    $pedidos = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $pedidos
    ]);
}

function visualizarPedido($pdo) {
    $id = $_GET['id'] ?? $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['error' => 'ID do pedido não especificado']);
        return;
    }
    
    // Buscar pedido
    $sql = "SELECT 
                p.*,
                c.nome as cliente_nome,
                c.email as cliente_email,
                c.telefone as cliente_telefone,
                c.cpf as cliente_cpf
            FROM pedidos p
            LEFT JOIN clientes c ON p.cliente_id = c.id
            WHERE p.id = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $pedido = $stmt->fetch();
    
    if (!$pedido) {
        echo json_encode(['error' => 'Pedido não encontrado']);
        return;
    }
    
    // Buscar itens
    $sqlItens = "SELECT 
                    pi.*,
                    p.nome as produto_nome,
                    p.sku as produto_sku,
                    p.preco as produto_preco,
                    t.nome as tamanho_nome
                FROM pedido_itens pi
                LEFT JOIN produtos p ON pi.produto_id = p.id
                LEFT JOIN tamanhos t ON pi.tamanho_id = t.id
                WHERE pi.pedido_id = ?";
    
    $stmtItens = $pdo->prepare($sqlItens);
    $stmtItens->execute([$id]);
    $pedido['itens'] = $stmtItens->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $pedido
    ]);
}

function editarPedido($pdo) {
    $id = $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['error' => 'ID do pedido não especificado']);
        return;
    }
    
    // Verificar se pedido existe
    $stmt = $pdo->prepare("SELECT id FROM pedidos WHERE id = ?");
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        echo json_encode(['error' => 'Pedido não encontrado']);
        return;
    }
    
    // Atualizar pedido
    $sql = "UPDATE pedidos SET 
                status = ?,
                observacoes = ?,
                updated_at = NOW()
            WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $_POST['status'] ?? 'pendente',
        $_POST['observacoes'] ?? '',
        $id
    ]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Pedido atualizado com sucesso'
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao atualizar pedido']);
    }
}

function excluirPedido($pdo) {
    $id = $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['error' => 'ID do pedido não especificado']);
        return;
    }
    
    try {
        $pdo->beginTransaction();
        
        // Excluir itens do pedido
        $stmt = $pdo->prepare("DELETE FROM pedido_itens WHERE pedido_id = ?");
        $stmt->execute([$id]);
        
        // Excluir pedido
        $stmt = $pdo->prepare("DELETE FROM pedidos WHERE id = ?");
        $stmt->execute([$id]);
        
        $pdo->commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Pedido excluído com sucesso'
        ]);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['error' => 'Erro ao excluir pedido: ' . $e->getMessage()]);
    }
}

function criarPedido($pdo) {
    $cliente_id = $_POST['cliente_id'] ?? null;
    $itens = $_POST['itens'] ?? [];
    
    if (!$cliente_id || empty($itens)) {
        echo json_encode(['error' => 'Dados incompletos']);
        return;
    }
    
    try {
        $pdo->beginTransaction();
        
        // Calcular totais
        $subtotal = 0;
        foreach ($itens as $item) {
            $subtotal += $item['preco_unitario'] * $item['quantidade'];
        }
        
        $frete = $_POST['frete'] ?? 0;
        $desconto = $_POST['desconto'] ?? 0;
        $total = $subtotal + $frete - $desconto;
        
        // Inserir pedido
        $sql = "INSERT INTO pedidos (
                    cliente_id, status, total, subtotal, frete, desconto,
                    forma_pagamento, endereco_entrega, observacoes
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $cliente_id,
            $_POST['status'] ?? 'pendente',
            $total,
            $subtotal,
            $frete,
            $desconto,
            $_POST['forma_pagamento'] ?? '',
            $_POST['endereco_entrega'] ?? '',
            $_POST['observacoes'] ?? ''
        ]);
        
        $pedido_id = $pdo->lastInsertId();
        
        // Inserir itens
        foreach ($itens as $item) {
            $sql = "INSERT INTO pedido_itens (
                        pedido_id, produto_id, tamanho_id, quantidade,
                        preco_unitario, subtotal
                    ) VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $pedido_id,
                $item['produto_id'],
                $item['tamanho_id'] ?? null,
                $item['quantidade'],
                $item['preco_unitario'],
                $item['preco_unitario'] * $item['quantidade']
            ]);
        }
        
        $pdo->commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Pedido criado com sucesso',
            'pedido_id' => $pedido_id
        ]);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['error' => 'Erro ao criar pedido: ' . $e->getMessage()]);
    }
}

function atualizarStatus($pdo) {
    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? null;
    
    if (!$id || !$status) {
        echo json_encode(['error' => 'ID e status são obrigatórios']);
        return;
    }
    
    $sql = "UPDATE pedidos SET status = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$status, $id]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Status atualizado com sucesso'
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao atualizar status']);
    }
}
?> 