<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Layout Mobile - Admin</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        /* Debug específico para mobile */
        .debug-info {
            position: fixed;
            top: 10px;
            left: 10px;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
            z-index: 9999;
            max-width: 300px;
        }
        
        .debug-info h3 {
            margin: 0 0 10px 0;
            color: #ff6b6b;
        }
        
        .debug-info p {
            margin: 5px 0;
            font-family: monospace;
        }
        
        .debug-highlight {
            border: 2px solid red !important;
            background: rgba(255,0,0,0.1) !important;
        }
        
        .debug-header {
            border: 2px solid blue !important;
            background: rgba(0,0,255,0.1) !important;
        }
        
        .debug-card {
            border: 2px solid green !important;
            background: rgba(0,255,0,0.1) !important;
        }
        
        .debug-z-index {
            position: relative;
        }
        
        .debug-z-index::after {
            content: 'z-index: ' attr(data-z-index);
            position: absolute;
            top: -20px;
            left: 0;
            background: red;
            color: white;
            padding: 2px 5px;
            font-size: 10px;
            border-radius: 3px;
        }
        
        /* Teste de correções */
        .mobile-fix-1 .header {
            position: relative !important;
            z-index: 100 !important;
        }
        
        .mobile-fix-1 .content-wrapper {
            padding-top: 0 !important;
        }
        
        .mobile-fix-2 .header {
            position: sticky !important;
            top: 0 !important;
            z-index: 100 !important;
        }
        
        .mobile-fix-2 .content-wrapper {
            padding-top: 20px !important;
        }
        
        .mobile-fix-3 .header {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1000 !important;
        }
        
        .mobile-fix-3 .content-wrapper {
            padding-top: 120px !important;
        }
        
        .mobile-fix-4 .header {
            position: relative !important;
            z-index: 10 !important;
        }
        
        .mobile-fix-4 .stat-card:first-child {
            margin-top: 20px !important;
            position: relative !important;
            z-index: 20 !important;
        }
        
        .mobile-fix-5 .header {
            position: relative !important;
            z-index: 1 !important;
        }
        
        .mobile-fix-5 .content-wrapper {
            position: relative !important;
            z-index: 2 !important;
        }
        
        .mobile-fix-5 .stat-card:first-child {
            margin-top: 30px !important;
        }
        
        /* Botões de teste */
        .debug-controls {
            position: fixed;
            bottom: 10px;
            left: 10px;
            background: rgba(0,0,0,0.9);
            color: white;
            padding: 15px;
            border-radius: 10px;
            z-index: 10000;
            max-width: 350px;
        }
        
        .debug-controls h3 {
            margin: 0 0 10px 0;
            color: #4ecdc4;
        }
        
        .debug-controls button {
            display: block;
            width: 100%;
            margin: 5px 0;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .debug-controls .fix-btn {
            background: #4ecdc4;
            color: white;
        }
        
        .debug-controls .reset-btn {
            background: #ff6b6b;
            color: white;
        }
        
        .debug-controls .highlight-btn {
            background: #feca57;
            color: black;
        }
        
        .debug-controls .info-btn {
            background: #48dbfb;
            color: white;
        }
    </style>
</head>
<body class="admin-body">
    <!-- Debug Info -->
    <div class="debug-info">
        <h3>🔍 Debug Mobile Layout</h3>
        <p><strong>Viewport:</strong> <span id="viewport-size"></span></p>
        <p><strong>Header Height:</strong> <span id="header-height"></span></p>
        <p><strong>First Card Top:</strong> <span id="first-card-top"></span></p>
        <p><strong>Overlap:</strong> <span id="overlap-status"></span></p>
        <p><strong>Z-Index Header:</strong> <span id="header-zindex"></span></p>
        <p><strong>Z-Index Content:</strong> <span id="content-zindex"></span></p>
    </div>
    
    <!-- Debug Controls -->
    <div class="debug-controls">
        <h3>🎛️ Controles de Debug</h3>
        <button class="highlight-btn" onclick="highlightElements()">🔍 Destacar Elementos</button>
        <button class="fix-btn" onclick="applyFix(1)">Fix 1: Relative Header</button>
        <button class="fix-btn" onclick="applyFix(2)">Fix 2: Sticky Header</button>
        <button class="fix-btn" onclick="applyFix(3)">Fix 3: Fixed Header</button>
        <button class="fix-btn" onclick="applyFix(4)">Fix 4: Z-Index Adjust</button>
        <button class="fix-btn" onclick="applyFix(5)">Fix 5: Content Z-Index</button>
        <button class="reset-btn" onclick="resetFixes()">🔄 Reset</button>
        <button class="info-btn" onclick="showInfo()">ℹ️ Info</button>
    </div>

    <!-- Admin Content -->
    <div class="admin-container">
        <!-- Header -->
        <header class="header debug-header" data-z-index="100">
            <div class="header-left">
                <button class="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1>Dashboard</h1>
            </div>
            <div class="header-right">
                <div class="notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-count">3</span>
                </div>
                <div class="user-menu">
                    <i class="fas fa-user"></i>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </header>

        <!-- Sidebar -->
        <aside class="sidebar">
            <nav class="sidebar-nav">
                <ul>
                    <li class="active"><a href="#dashboard"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li><a href="#produtos"><i class="fas fa-box"></i><span>Produtos</span></a></li>
                    <li><a href="#pedidos"><i class="fas fa-shopping-cart"></i><span>Pedidos</span></a></li>
                    <li><a href="#categorias"><i class="fas fa-tags"></i><span>Categorias</span></a></li>
                    <li><a href="#clientes"><i class="fas fa-users"></i><span>Clientes</span></a></li>
                    <li><a href="#configuracoes"><i class="fas fa-cog"></i><span>Configurações</span></a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-wrapper">
                <!-- Breadcrumbs -->
                <div class="breadcrumbs">
                    <a href="#dashboard">Dashboard</a>
                    <span class="separator">/</span>
                    <span class="current">Visão Geral</span>
                </div>

                <!-- Quick Actions -->
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

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card debug-card" data-z-index="1">
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-info">
                            <h3>R$ 12.450,00</h3>
                            <p>Vendas do Mês</p>
                            <span class="stat-change positive">+15%</span>
                        </div>
                    </div>
                    
                    <div class="stat-card debug-card" data-z-index="1">
                        <div class="stat-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="stat-info">
                            <h3>156</h3>
                            <p>Pedidos</p>
                            <span class="stat-change positive">+8%</span>
                        </div>
                    </div>
                    
                    <div class="stat-card debug-card" data-z-index="1">
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-info">
                            <h3>89</h3>
                            <p>Produtos</p>
                            <span class="stat-change positive">+12%</span>
                        </div>
                    </div>
                    
                    <div class="stat-card debug-card" data-z-index="1">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>234</h3>
                            <p>Clientes</p>
                            <span class="stat-change positive">+5%</span>
                        </div>
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="chart-section">
                    <h2>Vendas dos Últimos 7 Dias</h2>
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Debug Functions
        function updateDebugInfo() {
            const viewport = `${window.innerWidth}x${window.innerHeight}`;
            const header = document.querySelector('.header');
            const firstCard = document.querySelector('.stat-card:first-child');
            
            const headerHeight = header ? header.offsetHeight : 0;
            const firstCardTop = firstCard ? firstCard.offsetTop : 0;
            const headerZIndex = header ? getComputedStyle(header).zIndex : 'auto';
            const contentZIndex = document.querySelector('.content-wrapper') ? 
                getComputedStyle(document.querySelector('.content-wrapper')).zIndex : 'auto';
            
            const overlap = firstCardTop < headerHeight ? 'SIM' : 'NÃO';
            
            document.getElementById('viewport-size').textContent = viewport;
            document.getElementById('header-height').textContent = headerHeight + 'px';
            document.getElementById('first-card-top').textContent = firstCardTop + 'px';
            document.getElementById('overlap-status').textContent = overlap;
            document.getElementById('header-zindex').textContent = headerZIndex;
            document.getElementById('content-zindex').textContent = contentZIndex;
        }
        
        function highlightElements() {
            const header = document.querySelector('.header');
            const firstCard = document.querySelector('.stat-card:first-child');
            const content = document.querySelector('.content-wrapper');
            
            header.classList.toggle('debug-highlight');
            firstCard.classList.toggle('debug-highlight');
            content.classList.toggle('debug-highlight');
        }
        
        function applyFix(fixNumber) {
            // Remove all fix classes
            document.body.classList.remove('mobile-fix-1', 'mobile-fix-2', 'mobile-fix-3', 'mobile-fix-4', 'mobile-fix-5');
            
            // Apply specific fix
            document.body.classList.add(`mobile-fix-${fixNumber}`);
            
            console.log(`Aplicado Fix ${fixNumber}`);
            updateDebugInfo();
        }
        
        function resetFixes() {
            document.body.classList.remove('mobile-fix-1', 'mobile-fix-2', 'mobile-fix-3', 'mobile-fix-4', 'mobile-fix-5');
            console.log('Fixes resetados');
            updateDebugInfo();
        }
        
        function showInfo() {
            alert(`Debug Mobile Layout - Admin

Problema: Card sendo sobreposto pelo header no mobile

Fixes disponíveis:
1. Relative Header - Header com position relative
2. Sticky Header - Header com position sticky
3. Fixed Header - Header com position fixed
4. Z-Index Adjust - Ajuste de z-index do primeiro card
5. Content Z-Index - Ajuste de z-index do conteúdo

Use os botões para testar cada fix e ver qual resolve o problema.`);
        }
        
        // Update debug info on load and resize
        window.addEventListener('load', updateDebugInfo);
        window.addEventListener('resize', updateDebugInfo);
        
        // Update every second for real-time monitoring
        setInterval(updateDebugInfo, 1000);
    </script>
</body>
</html> 