<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste - Botões de Ação Rápida</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f5f5f5;
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
    </style>
</head>
<body>
    <div class="test-container">
        <div class="test-header">
            <h1>🧪 Teste - Botões de Ação Rápida</h1>
            <p>Verificando se os botões "Novo Produto" e "Ver Pedidos" estão aparecendo corretamente</p>
        </div>
        
        <div class="test-content">
            <div class="debug-info">
                <h3>📋 Informações de Debug:</h3>
                <ul>
                    <li><strong>Objetivo:</strong> Verificar se os botões de ação rápida estão visíveis</li>
                    <li><strong>Localização esperada:</strong> Barra horizontal abaixo do header</li>
                    <li><strong>Botões esperados:</strong> "Novo Produto" e "Ver Pedidos"</li>
                    <li><strong>Responsividade:</strong> Deve funcionar em desktop e mobile</li>
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
            
            <div class="debug-info" style="margin-top: 20px;">
                <h3>✅ Resultado Esperado:</h3>
                <ul>
                    <li>Os botões "Novo Produto" e "Ver Pedidos" devem aparecer em uma barra horizontal</li>
                    <li>A barra deve estar posicionada entre o header e o conteúdo do dashboard</li>
                    <li>Em desktop: botões lado a lado com informações à direita</li>
                    <li>Em mobile: botões centralizados e informações abaixo</li>
                    <li>Não deve haver duplicação de botões no header</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html> 