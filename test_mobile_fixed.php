<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Mobile Corrigido - Admin</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        /* Debug específico para verificar a correção */
        .debug-overlay {
            position: fixed;
            top: 10px;
            left: 10px;
            background: rgba(0,0,0,0.9);
            color: white;
            padding: 15px;
            border-radius: 8px;
            font-size: 12px;
            z-index: 10000;
            max-width: 300px;
        }
        
        .debug-overlay h3 {
            margin: 0 0 10px 0;
            color: #4ecdc4;
        }
        
        .debug-overlay p {
            margin: 5px 0;
            font-family: monospace;
        }
        
        .debug-overlay .status {
            font-weight: bold;
        }
        
        .debug-overlay .status.ok {
            color: #4ecdc4;
        }
        
        .debug-overlay .status.error {
            color: #ff6b6b;
        }
        
        .debug-overlay .status.warning {
            color: #feca57;
        }
        
        /* Highlight para visualizar elementos */
        .highlight-mode .main-header {
            border: 3px solid blue !important;
            background: rgba(0,0,255,0.1) !important;
        }
        
        .highlight-mode .content-wrapper {
            border: 3px solid green !important;
            background: rgba(0,255,0,0.1) !important;
        }
        
        .highlight-mode .stat-card:first-child {
            border: 3px solid red !important;
            background: rgba(255,0,0,0.1) !important;
        }
        
        /* Controles */
        .debug-controls {
            position: fixed;
            bottom: 10px;
            left: 10px;
            background: rgba(0,0,0,0.9);
            color: white;
            padding: 15px;
            border-radius: 8px;
            z-index: 10000;
        }
        
        .debug-controls button {
            display: block;
            width: 100%;
            margin: 5px 0;
            padding: 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .btn-highlight { background: #feca57; color: black; }
        .btn-test { background: #4ecdc4; color: white; }
        .btn-reset { background: #ff6b6b; color: white; }
        
        /* Indicador visual de sobreposição */
        .overlap-indicator {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255,0,0,0.8);
            color: white;
            padding: 20px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            z-index: 9999;
            display: none;
        }
    </style>
</head>
<body class="admin-body">
    <!-- Debug Overlay -->
    <div class="debug-overlay">
        <h3>🔍 Debug Mobile Layout</h3>
        <p><strong>Viewport:</strong> <span id="viewport"></span></p>
        <p><strong>Header Height:</strong> <span id="header-height"></span></p>
        <p><strong>First Card Top:</strong> <span id="card-top"></span></p>
        <p><strong>Content Top:</strong> <span id="content-top"></span></p>
        <p><strong>Overlap:</strong> <span id="overlap-status" class="status"></span></p>
        <p><strong>Z-Index Header:</strong> <span id="header-zindex"></span></p>
        <p><strong>Z-Index Content:</strong> <span id="content-zindex"></span></p>
        <p><strong>Z-Index First Card:</strong> <span id="card-zindex"></span></p>
        <p><strong>Status:</strong> <span id="fix-status" class="status"></span></p>
    </div>
    
    <!-- Overlap Indicator -->
    <div class="overlap-indicator" id="overlap-indicator">
        ⚠️ SOBREPOSIÇÃO DETECTADA!
    </div>
    
    <!-- Debug Controls -->
    <div class="debug-controls">
        <h3>🎛️ Controles</h3>
        <button class="btn-highlight" onclick="toggleHighlight()">🔍 Highlight</button>
        <button class="btn-test" onclick="testOverlap()">🧪 Testar</button>
        <button class="btn-reset" onclick="resetTest()">🔄 Reset</button>
    </div>

    <!-- Admin Content -->
    <div class="admin-container">
        <!-- Header -->
        <header class="main-header">
            <div class="header-left">
                <button class="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1>Dashboard</h1>
            </div>
            <div class="header-right">
                <div class="notification-bell">
                    <i class="fas fa-bell"></i>
                    <span class="notification-count">3</span>
                </div>
                <div class="user-profile">
                    <i class="fas fa-user"></i>
                    <span>Admin</span>
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
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-info">
                            <h3>R$ 12.450,00</h3>
                            <p>Vendas do Mês</p>
                            <span class="stat-change positive">+15%</span>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="stat-info">
                            <h3>156</h3>
                            <p>Pedidos</p>
                            <span class="stat-change positive">+8%</span>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-info">
                            <h3>89</h3>
                            <p>Produtos</p>
                            <span class="stat-change positive">+12%</span>
                        </div>
                    </div>
                    
                    <div class="stat-card">
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
                <div class="chart-container">
                    <h3>Vendas dos Últimos 7 Dias</h3>
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-bar"></i>
                        <p>Gráfico de Vendas - Últimos 7 dias</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function updateDebugInfo() {
            const viewport = `${window.innerWidth}x${window.innerHeight}`;
            const header = document.querySelector('.main-header');
            const content = document.querySelector('.content-wrapper');
            const firstCard = document.querySelector('.stat-card:first-child');
            
            const headerHeight = header ? header.offsetHeight : 0;
            const contentTop = content ? content.offsetTop : 0;
            const cardTop = firstCard ? firstCard.offsetTop : 0;
            
            const headerZIndex = header ? getComputedStyle(header).zIndex : 'auto';
            const contentZIndex = content ? getComputedStyle(content).zIndex : 'auto';
            const cardZIndex = firstCard ? getComputedStyle(firstCard).zIndex : 'auto';
            
            // Verificar sobreposição
            const overlap = cardTop < headerHeight;
            const overlapStatus = overlap ? 'SIM' : 'NÃO';
            const overlapClass = overlap ? 'error' : 'ok';
            
            // Status da correção
            const fixStatus = !overlap ? 'CORRIGIDO' : 'PROBLEMA';
            const fixClass = !overlap ? 'ok' : 'error';
            
            document.getElementById('viewport').textContent = viewport;
            document.getElementById('header-height').textContent = headerHeight + 'px';
            document.getElementById('card-top').textContent = cardTop + 'px';
            document.getElementById('content-top').textContent = contentTop + 'px';
            document.getElementById('overlap-status').textContent = overlapStatus;
            document.getElementById('overlap-status').className = `status ${overlapClass}`;
            document.getElementById('header-zindex').textContent = headerZIndex;
            document.getElementById('content-zindex').textContent = contentZIndex;
            document.getElementById('card-zindex').textContent = cardZIndex;
            document.getElementById('fix-status').textContent = fixStatus;
            document.getElementById('fix-status').className = `status ${fixClass}`;
            
            // Mostrar indicador de sobreposição
            const indicator = document.getElementById('overlap-indicator');
            if (overlap) {
                indicator.style.display = 'block';
            } else {
                indicator.style.display = 'none';
            }
        }
        
        function toggleHighlight() {
            document.body.classList.toggle('highlight-mode');
        }
        
        function testOverlap() {
            updateDebugInfo();
            const overlap = document.getElementById('overlap-status').textContent === 'SIM';
            
            if (overlap) {
                alert('❌ PROBLEMA: Card ainda está sendo sobreposto pelo header!\n\nTente redimensionar a janela ou testar em um dispositivo móvel real.');
            } else {
                alert('✅ SUCESSO: Correção funcionou! O primeiro card não está mais sendo sobreposto pelo header.');
            }
        }
        
        function resetTest() {
            document.body.classList.remove('highlight-mode');
            document.getElementById('overlap-indicator').style.display = 'none';
            updateDebugInfo();
        }
        
        // Update debug info on load and resize
        window.addEventListener('load', updateDebugInfo);
        window.addEventListener('resize', updateDebugInfo);
        
        // Update every second for real-time monitoring
        setInterval(updateDebugInfo, 1000);
        
        // Test on mobile orientation change
        window.addEventListener('orientationchange', function() {
            setTimeout(updateDebugInfo, 100);
        });
    </script>
</body>
</html> 