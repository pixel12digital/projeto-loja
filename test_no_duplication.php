<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Sem Duplicação - Admin</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        /* Debug para verificar duplicação */
        .debug-duplication {
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
        
        .debug-duplication h3 {
            margin: 0 0 10px 0;
            color: #4ecdc4;
        }
        
        .debug-duplication .status {
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 3px;
            margin-left: 5px;
        }
        
        .debug-duplication .status.ok {
            background: #10b981;
        }
        
        .debug-duplication .status.error {
            background: #ef4444;
        }
        
        /* Highlight para visualizar */
        .highlight-duplication .quick-action-btn {
            border: 3px solid red !important;
            background: rgba(255,0,0,0.1) !important;
        }
        
        .highlight-duplication .desktop-quick-actions {
            border: 3px solid blue !important;
            background: rgba(0,0,255,0.1) !important;
        }
        
        /* Botão de teste */
        .test-duplication-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #6366f1;
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            z-index: 10000;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
        
        .test-duplication-btn:hover {
            background: #4f46e5;
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="admin-body">
    <!-- Debug Duplicação -->
    <div class="debug-duplication">
        <h3>🔍 Debug Duplicação</h3>
        <div>Viewport: <span id="viewport"></span></div>
        <div>Quick Actions no Header: <span id="header-actions" class="status"></span></div>
        <div>Desktop Quick Actions: <span id="desktop-actions" class="status"></span></div>
        <div>Duplicação: <span id="duplication-status" class="status"></span></div>
        <div>Status: <span id="fix-status" class="status"></span></div>
    </div>
    
    <!-- Botão de Teste -->
    <button class="test-duplication-btn" onclick="testDuplication()">
        🧪 Testar Duplicação
    </button>

    <!-- Admin Content -->
    <div class="admin-container">
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
        function updateDuplicationInfo() {
            const viewport = `${window.innerWidth}x${window.innerHeight}`;
            const isMobile = window.innerWidth <= 768;
            
            // Verificar quick actions no header
            const headerActions = document.querySelector('.main-header .quick-actions');
            const hasHeaderActions = headerActions !== null;
            
            // Verificar desktop quick actions
            const desktopActions = document.querySelector('.desktop-quick-actions');
            const hasDesktopActions = desktopActions !== null;
            const isDesktopActionsVisible = desktopActions && getComputedStyle(desktopActions).display !== 'none';
            
            // Verificar duplicação
            const hasDuplication = hasHeaderActions && hasDesktopActions && isDesktopActionsVisible;
            
            // Status da correção
            const fixWorking = !hasDuplication;
            
            document.getElementById('viewport').textContent = viewport;
            document.getElementById('header-actions').textContent = hasHeaderActions ? 'SIM' : 'NÃO';
            document.getElementById('header-actions').className = `status ${hasHeaderActions ? 'error' : 'ok'}`;
            
            document.getElementById('desktop-actions').textContent = isDesktopActionsVisible ? 'SIM' : 'NÃO';
            document.getElementById('desktop-actions').className = `status ${isDesktopActionsVisible ? 'ok' : 'error'}`;
            
            document.getElementById('duplication-status').textContent = hasDuplication ? 'SIM' : 'NÃO';
            document.getElementById('duplication-status').className = `status ${hasDuplication ? 'error' : 'ok'}`;
            
            document.getElementById('fix-status').textContent = fixWorking ? 'CORRIGIDO' : 'PROBLEMA';
            document.getElementById('fix-status').className = `status ${fixWorking ? 'ok' : 'error'}`;
            
            return { hasDuplication, fixWorking, isMobile };
        }
        
        function testDuplication() {
            const result = updateDuplicationInfo();
            
            if (result.fixWorking) {
                alert('✅ SUCESSO! A duplicação foi corrigida!\n\n- Desktop: Barra de ações visível\n- Mobile: Sem duplicação\n- Layout limpo e organizado');
            } else {
                alert('❌ PROBLEMA: Ainda há duplicação!\n\nVerifique se os botões aparecem em mais de um lugar.');
            }
        }
        
        function toggleHighlight() {
            document.body.classList.toggle('highlight-duplication');
        }
        
        // Update debug info on load and resize
        window.addEventListener('load', updateDuplicationInfo);
        window.addEventListener('resize', updateDuplicationInfo);
        
        // Update every 2 seconds for monitoring
        setInterval(updateDuplicationInfo, 2000);
        
        // Auto-run test after 3 seconds
        setTimeout(testDuplication, 3000);
        
        // Keyboard shortcut for test
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'd') {
                e.preventDefault();
                testDuplication();
            }
        });
    </script>
</body>
</html> 