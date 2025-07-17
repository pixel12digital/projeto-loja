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
        case 'estatisticas':
            getEstatisticas($pdo);
            break;
        case 'pedidos_recentes':
            getPedidosRecentes($pdo);
            break;
        case 'produtos_populares':
            getProdutosPopulares($pdo);
            break;
        case 'vendas_por_periodo':
            getVendasPorPeriodo($pdo);
            break;
        default:
            echo json_encode(['error' => 'Ação não especificada']);
    }
    
} catch (Exception $e) {
    // Se for erro de conexão, retornar dados mock para desenvolvimento
    if (strpos($e->getMessage(), 'Erro de conexão') !== false) {
        $action = $_GET['action'] ?? $_POST['action'] ?? '';
        
        switch ($action) {
            case 'estatisticas':
                echo json_encode([
                    'success' => true,
                    'data' => [
                        'vendas' => [
                            'total_pedidos' => 47,
                            'total_vendas' => 15420.00,
                            'ticket_medio' => 328.08
                        ],
                        'produtos' => 1234,
                        'clientes' => 892,
                        'pedidos_pendentes' => 5,
                        'comparacao' => [
                            'crescimento_pedidos' => 12.5,
                            'crescimento_vendas' => 8.2
                        ]
                    ]
                ]);
                break;
            case 'pedidos_recentes':
                echo json_encode([
                    'success' => true,
                    'data' => [
                        [
                            'id' => 1,
                            'numero' => 'PED-001',
                            'cliente_nome' => 'Maria Silva',
                            'cliente_email' => 'maria@email.com',
                            'total' => 299.90,
                            'status' => 'pendente',
                            'created_at' => date('Y-m-d H:i:s')
                        ],
                        [
                            'id' => 2,
                            'numero' => 'PED-002',
                            'cliente_nome' => 'João Santos',
                            'cliente_email' => 'joao@email.com',
                            'total' => 450.00,
                            'status' => 'pago',
                            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
                        ]
                    ]
                ]);
                break;
            case 'produtos_populares':
                echo json_encode([
                    'success' => true,
                    'data' => [
                        [
                            'nome' => 'Vestido Plus Size Floral',
                            'sku' => 'VS-001',
                            'preco' => 89.90,
                            'vendas' => 15,
                            'unidades_vendidas' => 18
                        ],
                        [
                            'nome' => 'Blusa Plus Size Básica',
                            'sku' => 'BL-001',
                            'preco' => 45.90,
                            'vendas' => 12,
                            'unidades_vendidas' => 15
                        ]
                    ]
                ]);
                break;
            default:
                echo json_encode(['error' => 'Ação não especificada']);
        }
    } else {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

function getEstatisticas($pdo) {
    // Estatísticas gerais
    $stats = [];
    
    // Total de vendas (últimos 30 dias)
    $sql = "SELECT 
                COUNT(*) as total_pedidos,
                SUM(total) as total_vendas,
                AVG(total) as ticket_medio
            FROM pedidos 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
              AND status != 'cancelado'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $vendas = $stmt->fetch();
    
    $stats['vendas'] = [
        'total_pedidos' => (int)$vendas['total_pedidos'],
        'total_vendas' => (float)$vendas['total_vendas'],
        'ticket_medio' => (float)$vendas['ticket_medio']
    ];
    
    // Total de produtos
    $sql = "SELECT COUNT(*) as total FROM produtos WHERE status = 'ativo'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $stats['produtos'] = (int)$stmt->fetchColumn();
    
    // Total de clientes
    $sql = "SELECT COUNT(*) as total FROM clientes WHERE ativo = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $stats['clientes'] = (int)$stmt->fetchColumn();
    
    // Pedidos pendentes
    $sql = "SELECT COUNT(*) as total FROM pedidos WHERE status = 'pendente'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $stats['pedidos_pendentes'] = (int)$stmt->fetchColumn();
    
    // Comparação com mês anterior
    $sql = "SELECT 
                COUNT(*) as total_pedidos,
                SUM(total) as total_vendas
            FROM pedidos 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY)
              AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
              AND status != 'cancelado'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $mes_anterior = $stmt->fetch();
    
    $stats['comparacao'] = [
        'crescimento_pedidos' => $mes_anterior['total_pedidos'] > 0 ? 
            (($vendas['total_pedidos'] - $mes_anterior['total_pedidos']) / $mes_anterior['total_pedidos']) * 100 : 0,
        'crescimento_vendas' => $mes_anterior['total_vendas'] > 0 ? 
            (($vendas['total_vendas'] - $mes_anterior['total_vendas']) / $mes_anterior['total_vendas']) * 100 : 0
    ];
    
    echo json_encode([
        'success' => true,
        'data' => $stats
    ]);
}

function getPedidosRecentes($pdo) {
    $limit = $_GET['limit'] ?? 5;
    
    $sql = "SELECT 
                p.*,
                c.nome as cliente_nome,
                c.email as cliente_email
            FROM pedidos p
            LEFT JOIN clientes c ON p.cliente_id = c.id
            ORDER BY p.created_at DESC
            LIMIT ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$limit]);
    $pedidos = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $pedidos
    ]);
}

function getProdutosPopulares($pdo) {
    $limit = $_GET['limit'] ?? 5;
    
    $sql = "SELECT 
                p.nome,
                p.sku,
                p.preco,
                COUNT(pi.id) as vendas,
                SUM(pi.quantidade) as unidades_vendidas
            FROM produtos p
            LEFT JOIN pedido_itens pi ON p.id = pi.produto_id
            LEFT JOIN pedidos ped ON pi.pedido_id = ped.id
            WHERE ped.status != 'cancelado' OR ped.status IS NULL
            GROUP BY p.id, p.nome, p.sku, p.preco
            ORDER BY vendas DESC, unidades_vendidas DESC
            LIMIT ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$limit]);
    $produtos = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $produtos
    ]);
}

function getVendasPorPeriodo($pdo) {
    $periodo = $_GET['periodo'] ?? '7d'; // 7d, 30d, 90d
    
    switch ($periodo) {
        case '7d':
            $interval = 'INTERVAL 7 DAY';
            $group_by = 'DATE(created_at)';
            break;
        case '30d':
            $interval = 'INTERVAL 30 DAY';
            $group_by = 'DATE(created_at)';
            break;
        case '90d':
            $interval = 'INTERVAL 90 DAY';
            $group_by = 'DATE(created_at)';
            break;
        default:
            $interval = 'INTERVAL 30 DAY';
            $group_by = 'DATE(created_at)';
    }
    
    $sql = "SELECT 
                $group_by as data,
                COUNT(*) as total_pedidos,
                SUM(total) as total_vendas,
                AVG(total) as ticket_medio
            FROM pedidos 
            WHERE created_at >= DATE_SUB(NOW(), $interval)
              AND status != 'cancelado'
            GROUP BY $group_by
            ORDER BY data";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $vendas = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $vendas
    ]);
}
?> 