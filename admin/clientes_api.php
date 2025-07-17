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
            listarClientes($pdo);
            break;
        case 'buscar':
            buscarClientes($pdo);
            break;
        case 'visualizar':
            visualizarCliente($pdo);
            break;
        case 'editar':
            editarCliente($pdo);
            break;
        case 'excluir':
            excluirCliente($pdo);
            break;
        case 'criar':
            criarCliente($pdo);
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
                            'nome' => 'Maria Silva',
                            'email' => 'maria@email.com',
                            'telefone' => '(11) 99999-9999',
                            'cpf' => '123.456.789-00',
                            'ativo' => 1,
                            'created_at' => date('Y-m-d H:i:s')
                        ],
                        [
                            'id' => 2,
                            'nome' => 'João Santos',
                            'email' => 'joao@email.com',
                            'telefone' => '(11) 88888-8888',
                            'cpf' => '987.654.321-00',
                            'ativo' => 1,
                            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
                        ],
                        [
                            'id' => 3,
                            'nome' => 'Ana Costa',
                            'email' => 'ana@email.com',
                            'telefone' => '(11) 77777-7777',
                            'cpf' => '456.789.123-00',
                            'ativo' => 1,
                            'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
                        ]
                    ],
                    'total' => 3,
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

function listarClientes($pdo) {
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
    $countSql = "SELECT COUNT(*) FROM clientes c $where";
    $stmt = $pdo->prepare($countSql);
    $stmt->execute($params);
    $total = $stmt->fetchColumn();
    
    // Buscar clientes
    $sql = "SELECT 
                c.*,
                (SELECT COUNT(*) FROM pedidos WHERE cliente_id = c.id) as total_pedidos,
                (SELECT SUM(total) FROM pedidos WHERE cliente_id = c.id AND status != 'cancelado') as total_gasto
            FROM clientes c
            $where
            ORDER BY c.created_at DESC
            LIMIT ? OFFSET ?";
    
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $clientes = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $clientes,
        'total' => $total,
        'page' => $page,
        'limit' => $limit,
        'pages' => ceil($total / $limit)
    ]);
}

function buscarClientes($pdo) {
    $termo = $_GET['termo'] ?? '';
    
    if (empty($termo)) {
        echo json_encode(['error' => 'Termo de busca não especificado']);
        return;
    }
    
    $sql = "SELECT 
                c.*,
                (SELECT COUNT(*) FROM pedidos WHERE cliente_id = c.id) as total_pedidos
            FROM clientes c
            WHERE c.nome LIKE ? 
               OR c.email LIKE ? 
               OR c.cpf LIKE ?
            ORDER BY c.nome
            LIMIT 20";
    
    $termo = "%$termo%";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$termo, $termo, $termo]);
    $clientes = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $clientes
    ]);
}

function visualizarCliente($pdo) {
    $id = $_GET['id'] ?? $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['error' => 'ID do cliente não especificado']);
        return;
    }
    
    // Buscar cliente
    $sql = "SELECT * FROM clientes WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $cliente = $stmt->fetch();
    
    if (!$cliente) {
        echo json_encode(['error' => 'Cliente não encontrado']);
        return;
    }
    
    // Buscar endereços
    $sqlEnderecos = "SELECT * FROM cliente_enderecos WHERE cliente_id = ? ORDER BY principal DESC";
    $stmtEnderecos = $pdo->prepare($sqlEnderecos);
    $stmtEnderecos->execute([$id]);
    $cliente['enderecos'] = $stmtEnderecos->fetchAll();
    
    // Buscar pedidos
    $sqlPedidos = "SELECT id, numero, status, total, created_at FROM pedidos WHERE cliente_id = ? ORDER BY created_at DESC LIMIT 10";
    $stmtPedidos = $pdo->prepare($sqlPedidos);
    $stmtPedidos->execute([$id]);
    $cliente['pedidos'] = $stmtPedidos->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $cliente
    ]);
}

function editarCliente($pdo) {
    $id = $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['error' => 'ID do cliente não especificado']);
        return;
    }
    
    // Verificar se cliente existe
    $stmt = $pdo->prepare("SELECT id FROM clientes WHERE id = ?");
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        echo json_encode(['error' => 'Cliente não encontrado']);
        return;
    }
    
    // Atualizar cliente
    $sql = "UPDATE clientes SET 
                nome = ?,
                email = ?,
                telefone = ?,
                cpf = ?,
                data_nascimento = ?,
                ativo = ?,
                updated_at = NOW()
            WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $_POST['nome'] ?? '',
        $_POST['email'] ?? '',
        $_POST['telefone'] ?? '',
        $_POST['cpf'] ?? '',
        $_POST['data_nascimento'] ?? null,
        $_POST['ativo'] ?? true,
        $id
    ]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Cliente atualizado com sucesso'
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao atualizar cliente']);
    }
}

function excluirCliente($pdo) {
    $id = $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['error' => 'ID do cliente não especificado']);
        return;
    }
    
    // Verificar se há pedidos do cliente
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pedidos WHERE cliente_id = ?");
    $stmt->execute([$id]);
    $totalPedidos = $stmt->fetchColumn();
    
    if ($totalPedidos > 0) {
        echo json_encode(['error' => 'Não é possível excluir cliente com pedidos']);
        return;
    }
    
    try {
        $pdo->beginTransaction();
        
        // Excluir endereços do cliente
        $stmt = $pdo->prepare("DELETE FROM cliente_enderecos WHERE cliente_id = ?");
        $stmt->execute([$id]);
        
        // Excluir cliente
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        
        $pdo->commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Cliente excluído com sucesso'
        ]);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['error' => 'Erro ao excluir cliente: ' . $e->getMessage()]);
    }
}

function criarCliente($pdo) {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    if (empty($nome) || empty($email) || empty($senha)) {
        echo json_encode(['error' => 'Nome, email e senha são obrigatórios']);
        return;
    }
    
    // Verificar se email já existe
    $stmt = $pdo->prepare("SELECT id FROM clientes WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(['error' => 'Email já cadastrado']);
        return;
    }
    
    // Verificar se CPF já existe (se fornecido)
    if (!empty($_POST['cpf'])) {
        $stmt = $pdo->prepare("SELECT id FROM clientes WHERE cpf = ?");
        $stmt->execute([$_POST['cpf']]);
        if ($stmt->fetch()) {
            echo json_encode(['error' => 'CPF já cadastrado']);
            return;
        }
    }
    
    $sql = "INSERT INTO clientes (nome, email, telefone, cpf, data_nascimento, senha, ativo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $nome,
        $email,
        $_POST['telefone'] ?? '',
        $_POST['cpf'] ?? '',
        $_POST['data_nascimento'] ?? null,
        password_hash($senha, PASSWORD_DEFAULT),
        $_POST['ativo'] ?? true
    ]);
    
    if ($result) {
        $cliente_id = $pdo->lastInsertId();
        echo json_encode([
            'success' => true,
            'message' => 'Cliente criado com sucesso',
            'cliente_id' => $cliente_id
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao criar cliente']);
    }
}
?> 