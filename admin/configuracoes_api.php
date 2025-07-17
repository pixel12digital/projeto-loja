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
            listarConfiguracoes($pdo);
            break;
        case 'buscar':
            buscarConfiguracao($pdo);
            break;
        case 'atualizar':
            atualizarConfiguracao($pdo);
            break;
        case 'criar':
            criarConfiguracao($pdo);
            break;
        case 'excluir':
            excluirConfiguracao($pdo);
            break;
        default:
            echo json_encode(['error' => 'Ação não especificada']);
    }
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

function listarConfiguracoes($pdo) {
    $sql = "SELECT * FROM configuracoes ORDER BY chave";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $configuracoes = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $configuracoes
    ]);
}

function buscarConfiguracao($pdo) {
    $chave = $_GET['chave'] ?? $_POST['chave'] ?? '';
    
    if (empty($chave)) {
        echo json_encode(['error' => 'Chave da configuração não especificada']);
        return;
    }
    
    $sql = "SELECT * FROM configuracoes WHERE chave = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$chave]);
    $configuracao = $stmt->fetch();
    
    if (!$configuracao) {
        echo json_encode(['error' => 'Configuração não encontrada']);
        return;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $configuracao
    ]);
}

function atualizarConfiguracao($pdo) {
    $chave = $_POST['chave'] ?? '';
    $valor = $_POST['valor'] ?? '';
    
    if (empty($chave)) {
        echo json_encode(['error' => 'Chave da configuração não especificada']);
        return;
    }
    
    // Verificar se configuração existe
    $stmt = $pdo->prepare("SELECT id FROM configuracoes WHERE chave = ?");
    $stmt->execute([$chave]);
    if (!$stmt->fetch()) {
        echo json_encode(['error' => 'Configuração não encontrada']);
        return;
    }
    
    // Atualizar configuração
    $sql = "UPDATE configuracoes SET valor = ?, updated_at = NOW() WHERE chave = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$valor, $chave]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Configuração atualizada com sucesso'
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao atualizar configuração']);
    }
}

function criarConfiguracao($pdo) {
    $chave = $_POST['chave'] ?? '';
    $valor = $_POST['valor'] ?? '';
    $tipo = $_POST['tipo'] ?? 'text';
    $descricao = $_POST['descricao'] ?? '';
    
    if (empty($chave)) {
        echo json_encode(['error' => 'Chave da configuração é obrigatória']);
        return;
    }
    
    // Verificar se chave já existe
    $stmt = $pdo->prepare("SELECT id FROM configuracoes WHERE chave = ?");
    $stmt->execute([$chave]);
    if ($stmt->fetch()) {
        echo json_encode(['error' => 'Configuração com esta chave já existe']);
        return;
    }
    
    $sql = "INSERT INTO configuracoes (chave, valor, tipo, descricao) VALUES (?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$chave, $valor, $tipo, $descricao]);
    
    if ($result) {
        $config_id = $pdo->lastInsertId();
        echo json_encode([
            'success' => true,
            'message' => 'Configuração criada com sucesso',
            'config_id' => $config_id
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao criar configuração']);
    }
}

function excluirConfiguracao($pdo) {
    $chave = $_POST['chave'] ?? '';
    
    if (empty($chave)) {
        echo json_encode(['error' => 'Chave da configuração não especificada']);
        return;
    }
    
    // Verificar se é uma configuração protegida
    $configuracoes_protegidas = [
        'loja_nome', 'loja_email', 'loja_telefone', 'loja_endereco',
        'frete_gratis_valor', 'moeda_simbolo', 'timezone'
    ];
    
    if (in_array($chave, $configuracoes_protegidas)) {
        echo json_encode(['error' => 'Não é possível excluir configurações protegidas']);
        return;
    }
    
    $stmt = $pdo->prepare("DELETE FROM configuracoes WHERE chave = ?");
    $result = $stmt->execute([$chave]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Configuração excluída com sucesso'
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao excluir configuração']);
    }
}
?> 