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
                        <a href="#pedidos">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Pedidos</span>
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
                    <h1>Dashboard</h1>
                    <div class="breadcrumbs">
                        <a href="#dashboard">Dashboard</a>
                        <span class="separator">/</span>
                        <span class="current">Visão Geral</span>
                    </div>
                </div>
                <div class="header-right">
                    <div class="user-profile">
                        <div class="admin-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <span>Administrador</span>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="content-wrapper" id="dashboard">
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

                <div class="dashboard-grid">
                    <div class="chart-container">
                        <h3>Vendas dos Últimos 7 Dias</h3>
                        <div class="chart-placeholder">
                            <p>Gráfico será carregado aqui</p>
                        </div>
                    </div>

                    <div class="recent-orders">
                        <h3>Pedidos Recentes</h3>
                        <div class="orders-list">
                            <p>Lista de pedidos será carregada aqui</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="../assets/js/admin.js"></script>
</body>
</html> 