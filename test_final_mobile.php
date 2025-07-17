<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Final Mobile - Admin</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        /* Indicador de sucesso */
        .success-indicator {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(16, 185, 129, 0.9);
            color: white;
            padding: 30px;
            border-radius: 15px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            z-index: 10000;
            display: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        
        .success-indicator.show {
            display: block;
        }
        
        /* Debug simplificado */
        .debug-simple {
            position: fixed;
            top: 10px;
            right: 10px;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
            z-index: 9999;
            max-width: 200px;
        }
        
        .debug-simple .status {
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 3px;
            margin-left: 5px;
        }
        
        .debug-simple .status.ok {
            background: #10b981;
        }
        
        .debug-simple .status.error {
            background: #ef4444;
        }
        
        /* Botão de teste */
        .test-button {
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
        
        .test-button:hover {
            background: #4f46e5;
            transform: translateY(-2px);
        }
        
        /* Highlight para visualizar */
        .highlight-mode .main-header {
            border: 3px solid #3b82f6 !important;
            background: rgba(59, 130, 246, 0.1) !important;
        }
        
        .highlight-mode .content-wrapper {
            border: 3px solid #10b981 !important;
            background: rgba(16, 185, 129, 0.1) !important;
        }
        
        .highlight-mode .stat-card:first-child {
            border: 3px solid #f59e0b !important;
            background: rgba(245, 158, 11, 0.1) !important;
        }
    </style>
</head>
<body class="admin-body">
    <!-- Indicador de Sucesso -->
    <div class="success-indicator" id="success-indicator">
        ✅ CORREÇÃO FUNCIONANDO!<br>
        <small>Primeiro card visível no mobile</small>
    </div>
    
    <!-- Debug Simplificado -->
    <div class="debug-simple">
        <div>Mobile: <span id="mobile-status" class="status"></span></div>
        <div>Overlap: <span id="overlap-status" class="status"></span></div>
        <div>Fix: <span id="fix-status" class="status"></span></div>
    </div>
    
    <!-- Botão de Teste -->
    <button class="test-button" onclick="runFinalTest()">
        🧪 Teste Final
    </button>

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
            const isMobile = window.innerWidth <= 768;
            const header = document.querySelector('.main-header');
            const firstCard = document.querySelector('.stat-card:first-child');
            
            const headerHeight = header ? header.offsetHeight : 0;
            const cardTop = firstCard ? firstCard.offsetTop : 0;
            const overlap = cardTop < headerHeight;
            
            // Status do mobile
            document.getElementById('mobile-status').textContent = isMobile ? 'SIM' : 'NÃO';
            document.getElementById('mobile-status').className = `status ${isMobile ? 'ok' : 'error'}`;
            
            // Status da sobreposição
            document.getElementById('overlap-status').textContent = overlap ? 'SIM' : 'NÃO';
            document.getElementById('overlap-status').className = `status ${overlap ? 'error' : 'ok'}`;
            
            // Status da correção
            const fixWorking = !overlap;
            document.getElementById('fix-status').textContent = fixWorking ? 'OK' : 'ERRO';
            document.getElementById('fix-status').className = `status ${fixWorking ? 'ok' : 'error'}`;
            
            return { isMobile, overlap, fixWorking };
        }
        
        function runFinalTest() {
            const result = updateDebugInfo();
            
            if (result.fixWorking) {
                // Mostrar sucesso
                const indicator = document.getElementById('success-indicator');
                indicator.classList.add('show');
                
                // Esconder após 3 segundos
                setTimeout(() => {
                    indicator.classList.remove('show');
                }, 3000);
                
                console.log('✅ TESTE FINAL: Correção funcionando!');
                alert('🎉 SUCESSO! A correção do layout mobile está funcionando perfeitamente!\n\nO primeiro card não está mais sendo sobreposto pelo header.');
            } else {
                console.log('❌ TESTE FINAL: Problema ainda persiste');
                alert('❌ PROBLEMA: A sobreposição ainda está acontecendo.\n\nTente redimensionar a janela para simular mobile ou testar em um dispositivo real.');
            }
        }
        
        function toggleHighlight() {
            document.body.classList.toggle('highlight-mode');
        }
        
        // Update debug info on load and resize
        window.addEventListener('load', updateDebugInfo);
        window.addEventListener('resize', updateDebugInfo);
        
        // Update every 2 seconds for monitoring
        setInterval(updateDebugInfo, 2000);
        
        // Test on mobile orientation change
        window.addEventListener('orientationchange', function() {
            setTimeout(updateDebugInfo, 100);
        });
        
        // Auto-run test after 3 seconds
        setTimeout(runFinalTest, 3000);
        
        // Keyboard shortcut for test
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 't') {
                e.preventDefault();
                runFinalTest();
            }
        });
    </script>
</body>
</html> 