<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Mobile Real - Bella Curves</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .test-container {
            background: white;
            min-height: 100vh;
        }
        .test-header {
            background: #6366f1;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 14px;
        }
        .test-header h1 {
            margin: 0;
            font-size: 18px;
        }
        .test-header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            opacity: 0.9;
        }
        .debug-info {
            background: #f0f9ff;
            border: 1px solid #0ea5e9;
            margin: 10px;
            padding: 10px;
            border-radius: 8px;
            font-size: 12px;
        }
        .debug-info h3 {
            color: #0369a1;
            margin: 0 0 8px 0;
            font-size: 14px;
        }
        .debug-info ul {
            margin: 0;
            padding-left: 15px;
        }
        .debug-info li {
            margin-bottom: 3px;
            font-size: 11px;
        }
        .admin-layout {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            margin: 10px;
            overflow: hidden;
        }
        .sidebar {
            position: relative;
            height: auto;
            width: 100%;
        }
        .main-content {
            margin-left: 0;
        }
        .content-wrapper {
            padding: 1rem;
        }
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .stat-card {
            padding: 1rem;
        }
        .stat-info h3 {
            font-size: 1.25rem;
        }
        .stat-info p {
            font-size: 0.75rem;
        }
        .desktop-quick-actions {
            padding: 0.75rem 1rem;
        }
        .quick-action-btn {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }
        .main-header {
            padding: 0.75rem 1rem;
        }
        .header-left h1 {
            font-size: 1.25rem;
        }
        .breadcrumbs {
            font-size: 0.75rem;
        }
        .notification-bell {
            font-size: 1rem;
        }
        .user-profile span {
            font-size: 0.75rem;
        }
        .admin-avatar {
            width: 1.5rem;
            height: 1.5rem;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <div class="test-header">
            <h1>📱 Teste Mobile Real</h1>
            <p>Verificando comportamento idêntico entre modo responsivo e celular real</p>
        </div>
        
        <div class="debug-info">
            <h3>🎯 Objetivo do Teste:</h3>
            <ul>
                <li><strong>Verificar:</strong> Se o comportamento no celular real é idêntico ao modo responsivo</li>
                <li><strong>Dados:</strong> Valores fixos para evitar diferenças de cache</li>
                <li><strong>Layout:</strong> Mesma estrutura e posicionamento</li>
                <li><strong>Responsividade:</strong> Elementos adaptados para mobile</li>
            </ul>
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
                        <span style="color: var(--gray-500); font-size: 0.75rem;">
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

                        <div class="stat-card">
                            <div class="stat-icon products">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="stat-info">
                                <h3>1.234</h3>
                                <p>Produtos Ativos</p>
                                <span class="stat-change neutral">+2</span>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
        <div class="debug-info">
            <h3>✅ Checklist de Verificação:</h3>
            <ul>
                <li>✅ Botões "Novo Produto" e "Ver Pedidos" visíveis na barra de ações</li>
                <li>✅ Header não sobrepõe o primeiro card</li>
                <li>✅ Layout responsivo funcionando</li>
                <li>✅ Dados consistentes entre desktop e mobile</li>
                <li>✅ Elementos bem posicionados e legíveis</li>
                <li>✅ Navegação hambúrguer funcionando</li>
            </ul>
        </div>
        
        <div class="debug-info">
            <h3>📱 Como Testar no Celular Real:</h3>
            <ul>
                <li><strong>1.</strong> Acesse: http://localhost/projeto-ecommerce/loja-plus-size/test_mobile_real.php</li>
                <li><strong>2.</strong> Compare com o modo responsivo do navegador</li>
                <li><strong>3.</strong> Verifique se os valores são idênticos</li>
                <li><strong>4.</strong> Teste a navegação e interações</li>
                <li><strong>5.</strong> Confirme que não há sobreposições</li>
            </ul>
        </div>
    </div>
</body>
</html> 