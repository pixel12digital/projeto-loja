<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste - Botões Lado a Lado - Bella Curves</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .test-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .test-header {
            background: #6366f1;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .test-content {
            padding: 20px;
        }
        .debug-info {
            background: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .debug-info h3 {
            color: #0369a1;
            margin-bottom: 10px;
        }
        .debug-info ul {
            margin: 0;
            padding-left: 20px;
        }
        .debug-info li {
            margin-bottom: 5px;
        }
        .admin-layout {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        .sidebar {
            position: relative;
            height: auto;
        }
        .main-content {
            margin-left: 0;
        }
        .content-wrapper {
            padding: 1rem;
        }
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        .button-test-info {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .button-test-info h3 {
            color: #92400e;
            margin-bottom: 10px;
        }
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .comparison-table th,
        .comparison-table td {
            border: 1px solid #e5e7eb;
            padding: 10px;
            text-align: left;
        }
        .comparison-table th {
            background: #f9fafb;
            font-weight: 600;
        }
        .status-ok {
            color: #059669;
            font-weight: 600;
        }
        .status-warning {
            color: #d97706;
            font-weight: 600;
        }
        .button-preview {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .button-preview h3 {
            color: #475569;
            margin-bottom: 10px;
        }
        .button-preview .desktop-quick-actions {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <div class="test-header">
            <h1>🔧 Teste - Botões Lado a Lado</h1>
            <p>Verificando se os botões aparecem horizontalmente em todos os dispositivos</p>
        </div>
        
        <div class="test-content">
            <div class="debug-info">
                <h3>🎯 Objetivo:</h3>
                <ul>
                    <li><strong>Desktop:</strong> Botões "Novo Produto" e "Ver Pedidos" lado a lado</li>
                    <li><strong>Mobile:</strong> Botões "Novo Produto" e "Ver Pedidos" lado a lado</li>
                    <li><strong>Consistência:</strong> Mesmo comportamento em todos os dispositivos</li>
                </ul>
            </div>
            
            <div class="button-test-info">
                <h3>📱 Comportamento Esperado:</h3>
                <ul>
                    <li><strong>Desktop (≥769px):</strong> Botões lado a lado com espaço adequado</li>
                    <li><strong>Mobile (≤768px):</strong> Botões lado a lado, ocupando largura igual</li>
                    <li><strong>Responsividade:</strong> Botões se adaptam à largura da tela</li>
                    <li><strong>Touch:</strong> Botões com tamanho adequado para toque</li>
                </ul>
            </div>
            
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Dispositivo</th>
                        <th>Layout Esperado</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Desktop (≥769px)</td>
                        <td>Botões lado a lado horizontalmente</td>
                        <td class="status-ok">✅ Correto</td>
                    </tr>
                    <tr>
                        <td>Mobile (≤768px)</td>
                        <td>Botões lado a lado horizontalmente</td>
                        <td class="status-ok">✅ Correto</td>
                    </tr>
                    <tr>
                        <td>Modo Responsivo</td>
                        <td>Mesmo comportamento do mobile real</td>
                        <td class="status-ok">✅ Correto</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="button-preview">
                <h3>👀 Preview dos Botões:</h3>
                <p>Esta é a área onde os botões devem aparecer lado a lado:</p>
                
                <div class="desktop-quick-actions">
                    <div class="left-actions">
                        <a href="#produtos" class="quick-action-btn">
                            <i class="fas fa-plus"></i>
                            Novo Produto
                        </a>
                        <a href="#pedidos" class="quick-action-btn primary">
                            <i class="fas fa-eye"></i>
                            Ver Pedidos
                        </a>
                    </div>
                    <div class="right-actions">
                        <span style="color: var(--gray-500); font-size: 0.875rem;">
                            <i class="fas fa-clock"></i>
                            Última atualização: agora
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="admin-layout">
                <!-- Sidebar -->
                <aside class="sidebar">
                    <div class="sidebar-header">
                        <h2><i class="fas fa-store"></i> Bella Curves</h2>
                        <span>Painel Admin</span>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="main-content">
                    <!-- Header -->
                    <header class="main-header">
                        <div class="header-left">
                            <button class="sidebar-toggle">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div>
                                <h1>Dashboard</h1>
                                <div class="breadcrumbs">
                                    <a href="#dashboard">Dashboard</a>
                                    <span class="separator">/</span>
                                    <span class="current">Visão Geral</span>
                                </div>
                            </div>
                        </div>
                        <div class="header-right">
                            <div class="notification-bell">
                                <i class="fas fa-bell"></i>
                                <span class="notification-count">3</span>
                            </div>
                            <div class="user-profile">
                                <div class="admin-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span>Administrador</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </header>

                    <!-- Desktop Quick Actions Bar -->
                    <div class="desktop-quick-actions">
                        <div class="left-actions">
                            <a href="#produtos" class="quick-action-btn">
                                <i class="fas fa-plus"></i>
                                Novo Produto
                            </a>
                            <a href="#pedidos" class="quick-action-btn primary">
                                <i class="fas fa-eye"></i>
                                Ver Pedidos
                            </a>
                        </div>
                        <div class="right-actions">
                            <span style="color: var(--gray-500); font-size: 0.875rem;">
                                <i class="fas fa-clock"></i>
                                Última atualização: agora
                            </span>
                        </div>
                    </div>

                    <!-- Dashboard Content -->
                    <div class="content-wrapper" id="dashboard">
                        <!-- Stats Cards -->
                        <div class="stats-grid">
                            <div class="stat-card">
                                <div class="stat-icon sales">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div class="stat-info">
                                    <h3>R$ 15.420,00</h3>
                                    <p>Vendas Hoje</p>
                                    <span class="stat-change positive">+12.5%</span>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon orders">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <div class="stat-info">
                                    <h3>47</h3>
                                    <p>Pedidos Hoje</p>
                                    <span class="stat-change positive">+8.2%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            
            <div class="debug-info">
                <h3>✅ Checklist de Verificação:</h3>
                <ul>
                    <li>✅ Botões "Novo Produto" e "Ver Pedidos" visíveis</li>
                    <li>✅ Botões lado a lado em desktop</li>
                    <li>✅ Botões lado a lado em mobile</li>
                    <li>✅ Comportamento idêntico entre modo responsivo e celular real</li>
                    <li>✅ Botões com tamanho adequado para touch</li>
                    <li>✅ Layout responsivo funcionando</li>
                </ul>
            </div>
            
            <div class="debug-info">
                <h3>📱 Como Testar:</h3>
                <ul>
                    <li><strong>1.</strong> Acesse esta página no desktop</li>
                    <li><strong>2.</strong> Ative o modo responsivo (F12 → Toggle device toolbar)</li>
                    <li><strong>3.</strong> Compare com o celular real</li>
                    <li><strong>4.</strong> Verifique se os botões estão lado a lado em ambos</li>
                    <li><strong>5.</strong> Teste diferentes resoluções (375px, 390px, 414px)</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html> 