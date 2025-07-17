<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de Navegação - Admin</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .test-info {
            background: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 2rem;
        }
        .test-info h3 {
            color: #0369a1;
            margin-bottom: 0.5rem;
        }
        .test-info ul {
            margin: 0;
            padding-left: 1.5rem;
        }
        .test-info li {
            margin-bottom: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar Overlay (Mobile) -->
        <div class="sidebar-overlay"></div>
        
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-store"></i> Bella Curves</h2>
                <span>Painel Admin</span>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li class="active">
                        <a href="#dashboard">
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#produtos">
                            <i class="fas fa-box"></i>
                            <span>Produtos</span>
                        </a>
                    </li>
                    <li>
                        <a href="#categorias">
                            <i class="fas fa-tags"></i>
                            <span>Categorias</span>
                        </a>
                    </li>
                    <li>
                        <a href="#pedidos">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Pedidos</span>
                        </a>
                    </li>
                    <li>
                        <a href="#clientes">
                            <i class="fas fa-users"></i>
                            <span>Clientes</span>
                        </a>
                    </li>
                    <li>
                        <a href="#configuracoes">
                            <i class="fas fa-cog"></i>
                            <span>Configurações</span>
                        </a>
                    </li>
                    <li class="separator">
                        <a href="../" target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                            <span>Ver Loja</span>
                        </a>
                    </li>
                    <li>
                        <a href="#logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Sair</span>
                        </a>
                    </li>
                </ul>
            </nav>
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
                    <div class="quick-actions">
                        <a href="#produtos" class="quick-action-btn">
                            <i class="fas fa-plus"></i>
                            Novo Produto
                        </a>
                        <a href="#pedidos" class="quick-action-btn primary">
                            <i class="fas fa-eye"></i>
                            Ver Pedidos
                        </a>
                    </div>
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

            <!-- Content -->
            <div class="content-wrapper" id="dashboard">
                <div class="test-info">
                    <h3>🧪 Teste de Navegação Responsiva</h3>
                    <ul>
                        <li><strong>Desktop:</strong> Sidebar sempre visível, atalhos rápidos na horizontal</li>
                        <li><strong>Mobile:</strong> Sidebar oculta, botão hambúrguer para abrir, overlay para fechar</li>
                        <li><strong>Breadcrumbs:</strong> Navegação atualizada automaticamente</li>
                        <li><strong>Atalhos Rápidos:</strong> Mudam conforme a seção ativa</li>
                        <li><strong>Responsivo:</strong> Layout adapta-se a diferentes tamanhos de tela</li>
                    </ul>
                </div>

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

                    <div class="stat-card">
                        <div class="stat-icon customers">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>892</h3>
                            <p>Clientes</p>
                            <span class="stat-change positive">+15</span>
                        </div>
                    </div>
                </div>

                <div style="padding: 2rem; text-align: center; color: #6b7280;">
                    <h3>🎯 Teste de Funcionalidades</h3>
                    <p>Clique nos itens do menu para testar a navegação e breadcrumbs</p>
                    <p>Redimensione a janela para testar a responsividade</p>
                </div>
            </div>

            <!-- Outras seções (ocultas por padrão) -->
            <div class="content-wrapper" id="produtos" style="display: none;">
                <div class="page-header">
                    <h2>Gerenciar Produtos</h2>
                    <button class="btn-primary" onclick="showAddProduct()">
                        <i class="fas fa-plus"></i> Novo Produto
                    </button>
                </div>
                <div style="padding: 2rem; text-align: center; color: #6b7280;">
                    <h3>📦 Seção de Produtos</h3>
                    <p>Breadcrumbs e atalhos rápidos foram atualizados automaticamente</p>
                </div>
            </div>

            <div class="content-wrapper" id="pedidos" style="display: none;">
                <div class="page-header">
                    <h2>Gerenciar Pedidos</h2>
                    <button class="btn-primary" onclick="showAddOrder()">
                        <i class="fas fa-plus"></i> Novo Pedido
                    </button>
                </div>
                <div style="padding: 2rem; text-align: center; color: #6b7280;">
                    <h3>🛒 Seção de Pedidos</h3>
                    <p>Breadcrumbs e atalhos rápidos foram atualizados automaticamente</p>
                </div>
            </div>

            <div class="content-wrapper" id="clientes" style="display: none;">
                <div class="page-header">
                    <h2>Gerenciar Clientes</h2>
                    <button class="btn-primary" onclick="showAddCustomer()">
                        <i class="fas fa-plus"></i> Novo Cliente
                    </button>
                </div>
                <div style="padding: 2rem; text-align: center; color: #6b7280;">
                    <h3>👥 Seção de Clientes</h3>
                    <p>Breadcrumbs e atalhos rápidos foram atualizados automaticamente</p>
                </div>
            </div>

            <div class="content-wrapper" id="categorias" style="display: none;">
                <div class="page-header">
                    <h2>Gerenciar Categorias</h2>
                    <button class="btn-primary" onclick="showAddCategory()">
                        <i class="fas fa-plus"></i> Nova Categoria
                    </button>
                </div>
                <div style="padding: 2rem; text-align: center; color: #6b7280;">
                    <h3>🏷️ Seção de Categorias</h3>
                    <p>Breadcrumbs e atalhos rápidos foram atualizados automaticamente</p>
                </div>
            </div>

            <div class="content-wrapper" id="configuracoes" style="display: none;">
                <div class="page-header">
                    <h2>Configurações do Sistema</h2>
                </div>
                <div style="padding: 2rem; text-align: center; color: #6b7280;">
                    <h3>⚙️ Seção de Configurações</h3>
                    <p>Breadcrumbs e atalhos rápidos foram atualizados automaticamente</p>
                </div>
            </div>
        </main>
    </div>

    <script src="assets/js/admin.js"></script>
    <script>
        // Inicializar navegação
        document.addEventListener('DOMContentLoaded', function() {
            initSidebar();
            
            // Mostrar notificação de teste
            setTimeout(() => {
                showNotification('Navegação responsiva carregada com sucesso!', 'success');
            }, 1000);
        });
    </script>
</body>
</html> 