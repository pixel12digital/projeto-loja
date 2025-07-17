<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Teste Cross-Platform - Bella Curves</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f5f5f5;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: transparent;
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
            /* Garantir compatibilidade cross-platform */
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            /* Melhorar touch em iOS */
            -webkit-tap-highlight-color: transparent;
            /* Prevenir zoom em iOS */
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
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
        .platform-info {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 10px;
            margin: 10px;
            font-size: 11px;
        }
        .platform-info h3 {
            color: #92400e;
            margin: 0 0 5px 0;
            font-size: 13px;
        }
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 11px;
        }
        .comparison-table th,
        .comparison-table td {
            border: 1px solid #e5e7eb;
            padding: 5px;
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
        .device-detection {
            background: #ecfdf5;
            border: 1px solid #10b981;
            border-radius: 8px;
            padding: 10px;
            margin: 10px;
            font-size: 11px;
        }
        .device-detection h3 {
            color: #065f46;
            margin: 0 0 5px 0;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <div class="test-header">
            <h1>📱 Teste Cross-Platform</h1>
            <p>Verificando comportamento idêntico entre Android e iOS</p>
        </div>
        
        <div class="device-detection">
            <h3>🔍 Detecção de Dispositivo:</h3>
            <div id="device-info">
                <p><strong>User Agent:</strong> <span id="user-agent"></span></p>
                <p><strong>Plataforma:</strong> <span id="platform"></span></p>
                <p><strong>Largura da Tela:</strong> <span id="screen-width"></span>px</p>
                <p><strong>Altura da Tela:</strong> <span id="screen-height"></span>px</p>
                <p><strong>Pixel Ratio:</strong> <span id="pixel-ratio"></span></p>
                <p><strong>Navegador:</strong> <span id="browser"></span></p>
            </div>
        </div>
        
        <div class="debug-info">
            <h3>🎯 Objetivo do Teste:</h3>
            <ul>
                <li><strong>Verificar:</strong> Se os botões têm comportamento idêntico em Android e iOS</li>
                <li><strong>Layout:</strong> Botões lado a lado em ambas as plataformas</li>
                <li><strong>Touch:</strong> Interação adequada em ambas as plataformas</li>
                <li><strong>Responsividade:</strong> Adaptação correta às diferentes densidades</li>
            </ul>
        </div>
        
        <div class="platform-info">
            <h3>📱 Diferenças entre Android e iOS:</h3>
            <ul>
                <li><strong>Viewport:</strong> iOS pode ter comportamento diferente</li>
                <li><strong>Touch:</strong> iOS tem delay de 300ms por padrão</li>
                <li><strong>Flexbox:</strong> Pequenas diferenças na implementação</li>
                <li><strong>Densidade:</strong> Diferentes pixel ratios</li>
            </ul>
        </div>
        
        <table class="comparison-table">
            <thead>
                <tr>
                    <th>Plataforma</th>
                    <th>Comportamento Esperado</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Android (Chrome)</td>
                    <td>Botões lado a lado, touch responsivo</td>
                    <td class="status-ok">✅ Testar</td>
                </tr>
                <tr>
                    <td>Android (Samsung Internet)</td>
                    <td>Botões lado a lado, touch responsivo</td>
                    <td class="status-ok">✅ Testar</td>
                </tr>
                <tr>
                    <td>iOS (Safari)</td>
                    <td>Botões lado a lado, touch responsivo</td>
                    <td class="status-ok">✅ Testar</td>
                </tr>
                <tr>
                    <td>iOS (Chrome)</td>
                    <td>Botões lado a lado, touch responsivo</td>
                    <td class="status-ok">✅ Testar</td>
                </tr>
            </tbody>
        </table>
        
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
                    </div>
                </div>
            </main>
        </div>
        
        <div class="debug-info">
            <h3>✅ Checklist Cross-Platform:</h3>
            <ul>
                <li>✅ Botões lado a lado em Android</li>
                <li>✅ Botões lado a lado em iOS</li>
                <li>✅ Touch responsivo em ambas plataformas</li>
                <li>✅ Layout adaptado às densidades</li>
                <li>✅ Sem problemas de zoom em iOS</li>
                <li>✅ Compatibilidade com diferentes navegadores</li>
            </ul>
        </div>
        
        <div class="debug-info">
            <h3>📱 Como Testar:</h3>
            <ul>
                <li><strong>1.</strong> Acesse esta página no Android (Chrome/Samsung)</li>
                <li><strong>2.</strong> Acesse esta página no iOS (Safari/Chrome)</li>
                <li><strong>3.</strong> Compare o comportamento dos botões</li>
                <li><strong>4.</strong> Teste o toque nos botões</li>
                <li><strong>5.</strong> Verifique se não há zoom indesejado</li>
            </ul>
        </div>
    </div>

    <script>
        // Detecção de dispositivo
        function detectDevice() {
            const userAgent = navigator.userAgent;
            const platform = navigator.platform;
            const screenWidth = window.screen.width;
            const screenHeight = window.screen.height;
            const pixelRatio = window.devicePixelRatio;
            
            let browser = 'Desconhecido';
            if (userAgent.includes('Chrome')) browser = 'Chrome';
            else if (userAgent.includes('Safari')) browser = 'Safari';
            else if (userAgent.includes('Firefox')) browser = 'Firefox';
            else if (userAgent.includes('SamsungBrowser')) browser = 'Samsung Internet';
            
            document.getElementById('user-agent').textContent = userAgent.substring(0, 50) + '...';
            document.getElementById('platform').textContent = platform;
            document.getElementById('screen-width').textContent = screenWidth;
            document.getElementById('screen-height').textContent = screenHeight;
            document.getElementById('pixel-ratio').textContent = pixelRatio;
            document.getElementById('browser').textContent = browser;
        }
        
        // Executar detecção quando a página carregar
        window.addEventListener('load', detectDevice);
        
        // Prevenir zoom em iOS
        document.addEventListener('touchstart', function(event) {
            if (event.touches.length > 1) {
                event.preventDefault();
            }
        }, { passive: false });
        
        let lastTouchEnd = 0;
        document.addEventListener('touchend', function(event) {
            const now = (new Date()).getTime();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    </script>
</body>
</html> 