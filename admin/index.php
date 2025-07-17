<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Bella Curves</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

                <!-- Charts and Recent Activity -->
                <div class="dashboard-grid">
                    <div class="chart-container">
                        <h3>Vendas dos Últimos 7 Dias</h3>
                        <div class="chart-placeholder">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>

                    <div class="recent-orders">
                        <h3>Pedidos Recentes</h3>
                        <div class="orders-list">
                            <div class="order-item">
                                <div class="order-info">
                                    <strong>#1547</strong>
                                    <span>Maria Silva</span>
                                </div>
                                <div class="order-amount">R$ 189,90</div>
                                <div class="order-status pending">Pendente</div>
                            </div>

                            <div class="order-item">
                                <div class="order-info">
                                    <strong>#1546</strong>
                                    <span>Ana Costa</span>
                                </div>
                                <div class="order-amount">R$ 259,80</div>
                                <div class="order-status processing">Processando</div>
                            </div>

                            <div class="order-item">
                                <div class="order-info">
                                    <strong>#1545</strong>
                                    <span>Carla Santos</span>
                                </div>
                                <div class="order-amount">R$ 149,90</div>
                                <div class="order-status completed">Concluído</div>
                            </div>

                            <div class="order-item">
                                <div class="order-info">
                                    <strong>#1544</strong>
                                    <span>Julia Oliveira</span>
                                </div>
                                <div class="order-amount">R$ 329,70</div>
                                <div class="order-status shipped">Enviado</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Products -->
                <div class="top-products">
                    <h3>Produtos Mais Vendidos</h3>
                    <div class="products-grid">
                        <div class="product-item">
                            <div class="product-image">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <div class="product-details">
                                <h4>Vestido Floral Manga Longa</h4>
                                <p>47 vendas este mês</p>
                                <span class="price">R$ 129,90</span>
                            </div>
                        </div>

                        <div class="product-item">
                            <div class="product-image">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <div class="product-details">
                                <h4>Blusa Social Elegante</h4>
                                <p>35 vendas este mês</p>
                                <span class="price">R$ 89,90</span>
                            </div>
                        </div>

                        <div class="product-item">
                            <div class="product-image">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <div class="product-details">
                                <h4>Calça Jeans Skinny</h4>
                                <p>28 vendas este mês</p>
                                <span class="price">R$ 149,90</span>
                            </div>
                        </div>

                        <div class="product-item">
                            <div class="product-image">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <div class="product-details">
                                <h4>Conjunto Íntimo Renda</h4>
                                <p>22 vendas este mês</p>
                                <span class="price">R$ 79,90</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="content-wrapper" id="produtos" style="display: none;">
                <div class="page-header">
                    <h2>Gestão de Produtos</h2>
                    <button class="btn-primary" onclick="showAddProduct()">
                        <i class="fas fa-plus"></i> Novo Produto
                    </button>
                </div>

                <div class="filters-bar">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Buscar produtos...">
                    </div>
                    <select class="filter-select">
                        <option value="">Todas as Categorias</option>
                        <option value="vestidos">Vestidos</option>
                        <option value="blusas">Blusas</option>
                        <option value="calcas">Calças</option>
                        <option value="intimas">Íntimas</option>
                    </select>
                    <select class="filter-select">
                        <option value="">Todos os Status</option>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                        <option value="promocao">Em Promoção</option>
                    </select>
                </div>

                <div class="products-table">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>Produto</th>
                                <th>Categoria</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="produtosTableBody">
                            <!-- Produtos serão carregados dinamicamente via JavaScript -->
                            <tr>
                                <td colspan="7" class="loading-message">
                                    <div class="loading-spinner">
                                        <i class="fas fa-spinner fa-spin"></i>
                                        <span>Carregando produtos...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <span id="paginationInfo">Carregando...</span>
                    <div class="pagination-buttons" id="paginationButtons">
                        <!-- Botões de paginação serão carregados dinamicamente -->
                    </div>
                </div>
                        <button>3</button>
                        <button><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Categories Section -->
            <div class="content-wrapper" id="categorias" style="display: none;">
                <div class="page-header">
                    <h2>Gestão de Categorias</h2>
                    <button class="btn-primary" onclick="showAddCategory()">
                        <i class="fas fa-plus"></i> Nova Categoria
                    </button>
                </div>

                <div class="categories-grid">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-female"></i>
                        </div>
                        <div class="category-info">
                            <h3>Vestidos</h3>
                            <p>47 produtos</p>
                            <span class="category-status active">Ativa</span>
                        </div>
                        <div class="category-actions">
                            <button class="btn-icon" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon danger" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <div class="category-info">
                            <h3>Blusas</h3>
                            <p>32 produtos</p>
                            <span class="category-status active">Ativa</span>
                        </div>
                        <div class="category-actions">
                            <button class="btn-icon" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon danger" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-socks"></i>
                        </div>
                        <div class="category-info">
                            <h3>Calças</h3>
                            <p>28 produtos</p>
                            <span class="category-status active">Ativa</span>
                        </div>
                        <div class="category-actions">
                            <button class="btn-icon" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon danger" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="category-info">
                            <h3>Íntimas</h3>
                            <p>15 produtos</p>
                            <span class="category-status inactive">Inativa</span>
                        </div>
                        <div class="category-actions">
                            <button class="btn-icon" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon danger" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Section -->
            <div class="content-wrapper" id="pedidos" style="display: none;">
                <div class="page-header">
                    <h2>Gestão de Pedidos</h2>
                    <div class="header-actions">
                        <button class="btn-secondary">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                        <button class="btn-primary">
                            <i class="fas fa-plus"></i> Novo Pedido
                        </button>
                    </div>
                </div>

                <div class="filters-bar">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Buscar pedidos...">
                    </div>
                    <select class="filter-select">
                        <option value="">Todos os Status</option>
                        <option value="pendente">Pendente</option>
                        <option value="processando">Processando</option>
                        <option value="enviado">Enviado</option>
                        <option value="entregue">Entregue</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                    <select class="filter-select">
                        <option value="">Últimos 30 dias</option>
                        <option value="7">Últimos 7 dias</option>
                        <option value="90">Últimos 90 dias</option>
                        <option value="365">Último ano</option>
                    </select>
                </div>

                <div class="orders-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Cliente</th>
                                <th>Data</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Pagamento</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>#1547</strong></td>
                                <td>Maria Silva</td>
                                <td>17/07/2025</td>
                                <td>R$ 189,90</td>
                                <td><span class="status pending">Pendente</span></td>
                                <td>PIX</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Ver Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-icon" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon" title="Imprimir">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td><strong>#1546</strong></td>
                                <td>Ana Costa</td>
                                <td>16/07/2025</td>
                                <td>R$ 259,80</td>
                                <td><span class="status processing">Processando</span></td>
                                <td>Cartão</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Ver Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-icon" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon" title="Imprimir">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td><strong>#1545</strong></td>
                                <td>Carla Santos</td>
                                <td>15/07/2025</td>
                                <td>R$ 149,90</td>
                                <td><span class="status completed">Concluído</span></td>
                                <td>PIX</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Ver Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-icon" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon" title="Imprimir">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Customers Section -->
            <div class="content-wrapper" id="clientes" style="display: none;">
                <div class="page-header">
                    <h2>Gestão de Clientes</h2>
                    <button class="btn-primary" onclick="showAddCustomer()">
                        <i class="fas fa-plus"></i> Novo Cliente
                    </button>
                </div>

                <div class="filters-bar">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Buscar clientes...">
                    </div>
                    <select class="filter-select">
                        <option value="">Todos os Status</option>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                        <option value="vip">VIP</option>
                    </select>
                </div>

                <div class="customers-grid">
                    <div class="customer-card">
                        <div class="customer-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="customer-info">
                            <h3>Maria Silva</h3>
                            <p>maria@email.com</p>
                            <p>(11) 99999-9999</p>
                            <span class="customer-status active">Ativa</span>
                        </div>
                        <div class="customer-stats">
                            <div class="stat">
                                <span class="stat-number">12</span>
                                <span class="stat-label">Pedidos</span>
                            </div>
                            <div class="stat">
                                <span class="stat-number">R$ 2.450</span>
                                <span class="stat-label">Total Gasto</span>
                            </div>
                        </div>
                        <div class="customer-actions">
                            <button class="btn-icon" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon" title="Ver Pedidos">
                                <i class="fas fa-shopping-bag"></i>
                            </button>
                            <button class="btn-icon danger" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="customer-card">
                        <div class="customer-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="customer-info">
                            <h3>Ana Costa</h3>
                            <p>ana@email.com</p>
                            <p>(11) 88888-8888</p>
                            <span class="customer-status vip">VIP</span>
                        </div>
                        <div class="customer-stats">
                            <div class="stat">
                                <span class="stat-number">25</span>
                                <span class="stat-label">Pedidos</span>
                            </div>
                            <div class="stat">
                                <span class="stat-number">R$ 5.890</span>
                                <span class="stat-label">Total Gasto</span>
                            </div>
                        </div>
                        <div class="customer-actions">
                            <button class="btn-icon" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon" title="Ver Pedidos">
                                <i class="fas fa-shopping-bag"></i>
                            </button>
                            <button class="btn-icon danger" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="customer-card">
                        <div class="customer-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="customer-info">
                            <h3>Carla Santos</h3>
                            <p>carla@email.com</p>
                            <p>(11) 77777-7777</p>
                            <span class="customer-status active">Ativa</span>
                        </div>
                        <div class="customer-stats">
                            <div class="stat">
                                <span class="stat-number">8</span>
                                <span class="stat-label">Pedidos</span>
                            </div>
                            <div class="stat">
                                <span class="stat-number">R$ 1.200</span>
                                <span class="stat-label">Total Gasto</span>
                            </div>
                        </div>
                        <div class="customer-actions">
                            <button class="btn-icon" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon" title="Ver Pedidos">
                                <i class="fas fa-shopping-bag"></i>
                            </button>
                            <button class="btn-icon danger" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Section -->
            <div class="content-wrapper" id="configuracoes" style="display: none;">
                <div class="page-header">
                    <h2>Configurações do Sistema</h2>
                </div>

                <div class="settings-grid">
                    <div class="settings-card">
                        <div class="settings-header">
                            <i class="fas fa-store"></i>
                            <h3>Configurações da Loja</h3>
                        </div>
                        <form class="settings-form">
                            <div class="form-group">
                                <label>Nome da Loja</label>
                                <input type="text" value="Bella Curves" required>
                            </div>
                            <div class="form-group">
                                <label>Email de Contato</label>
                                <input type="email" value="contato@bellacurves.com" required>
                            </div>
                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="tel" value="(11) 99999-9999">
                            </div>
                            <div class="form-group">
                                <label>Endereço</label>
                                <textarea rows="3">Rua das Flores, 123 - São Paulo, SP</textarea>
                            </div>
                            <button type="submit" class="btn-primary">Salvar Configurações</button>
                        </form>
                    </div>

                    <div class="settings-card">
                        <div class="settings-header">
                            <i class="fas fa-credit-card"></i>
                            <h3>Configurações de Pagamento</h3>
                        </div>
                        <form class="settings-form">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" checked> Aceitar PIX
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" checked> Aceitar Cartão de Crédito
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox"> Aceitar Boleto
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Chave PIX</label>
                                <input type="text" value="contato@bellacurves.com">
                            </div>
                            <button type="submit" class="btn-primary">Salvar Configurações</button>
                        </form>
                    </div>

                    <div class="settings-card">
                        <div class="settings-header">
                            <i class="fas fa-truck"></i>
                            <h3>Configurações de Frete</h3>
                        </div>
                        <form class="settings-form">
                            <div class="form-group">
                                <label>Frete Grátis a partir de</label>
                                <input type="number" value="150" step="0.01"> R$
                            </div>
                            <div class="form-group">
                                <label>Frete padrão</label>
                                <input type="number" value="15.90" step="0.01"> R$
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" checked> Calcular frete por CEP
                                </label>
                            </div>
                            <button type="submit" class="btn-primary">Salvar Configurações</button>
                        </form>
                    </div>

                    <div class="settings-card">
                        <div class="settings-header">
                            <i class="fas fa-bell"></i>
                            <h3>Notificações</h3>
                        </div>
                        <form class="settings-form">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" checked> Email para novos pedidos
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" checked> Email para clientes
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox"> WhatsApp para pedidos
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Email de notificações</label>
                                <input type="email" value="admin@bellacurves.com">
                            </div>
                            <button type="submit" class="btn-primary">Salvar Configurações</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Product Modal -->
    <div class="modal" id="addProductModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Novo Produto</h3>
                <button class="modal-close">&times;</button>
            </div>
            <form class="product-form">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nome do Produto</label>
                        <input type="text" required>
                    </div>
                    
                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Categoria</label>
                        <select required>
                            <option value="">Selecione...</option>
                            <option value="vestidos">Vestidos</option>
                            <option value="blusas">Blusas</option>
                            <option value="calcas">Calças</option>
                            <option value="intimas">Íntimas</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Preço</label>
                        <input type="number" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Preço Promocional</label>
                        <input type="number" step="0.01">
                    </div>
                    
                    <div class="form-group">
                        <label>Estoque</label>
                        <input type="number" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Descrição</label>
                    <textarea rows="4"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Imagens do Produto</label>
                    <div class="image-upload">
                        <div class="upload-area">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Arraste as imagens aqui ou clique para selecionar</p>
                            <input type="file" multiple accept="image/*">
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="btn-primary">Salvar Produto</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Product Modal (View/Edit) -->
    <div class="modal" id="produtoModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Visualizar Produto</h3>
                <button class="modal-close">&times;</button>
            </div>
            <form class="product-form">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nome do Produto</label>
                        <input type="text" name="nome" required>
                    </div>
                    
                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" name="sku" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Categoria</label>
                        <select name="categoria_id" required>
                            <option value="">Selecione...</option>
                            <option value="1">Vestidos</option>
                            <option value="2">Blusas</option>
                            <option value="3">Calças</option>
                            <option value="4">Íntimas</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Preço</label>
                        <input type="number" name="preco" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Preço Promocional</label>
                        <input type="number" name="preco_promocional" step="0.01">
                    </div>
                    
                    <div class="form-group">
                        <label>Estoque</label>
                        <input type="number" name="estoque" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" rows="4"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                        <option value="promocao">Promoção</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal()">Fechar</button>
                    <button type="submit" class="btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Order Modal (View/Edit) -->
    <div class="modal" id="pedidoModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Visualizar Pedido</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="pedido-info">
                    <!-- Conteúdo será preenchido dinamicamente -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal()">Fechar</button>
            </div>
        </div>
    </div>

    <!-- Category Modal (View/Edit) -->
    <div class="modal" id="categoriaModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Visualizar Categoria</h3>
                <button class="modal-close">&times;</button>
            </div>
            <form class="category-form">
                <div class="form-group">
                    <label>Nome da Categoria</label>
                    <input type="text" name="nome" required>
                </div>
                
                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="ativo"> Ativa
                    </label>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal()">Fechar</button>
                    <button type="submit" class="btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Customer Modal (View/Edit) -->
    <div class="modal" id="clienteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Visualizar Cliente</h3>
                <button class="modal-close">&times;</button>
            </div>
            <form class="customer-form">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="tel" name="telefone">
                    </div>
                    
                    <div class="form-group">
                        <label>CPF</label>
                        <input type="text" name="cpf">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="ativo"> Cliente Ativo
                    </label>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal()">Fechar</button>
                    <button type="submit" class="btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/js/admin.js"></script>
</body>
</html> 
</html> 