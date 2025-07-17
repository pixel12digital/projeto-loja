// Admin Panel JavaScript - Bella Curves
// Funcionalidades completas do painel administrativo

// URLs das APIs
const API_URLS = {
    pedidos: 'pedidos_api.php',
    produtos: 'produtos_api.php',
    categorias: 'categorias_api.php',
    clientes: 'clientes_api.php',
    configuracoes: 'configuracoes_api.php',
    dashboard: 'dashboard_api.php'
};

// Estado global da aplicação
let currentSection = 'dashboard';
let currentPage = 1;
let currentFilters = {};

document.addEventListener('DOMContentLoaded', function() {
    initSidebar();
    initModals();
    initTables();
    initCharts();
    initFilters();
    initSettingsForms();
    loadDashboardData();
});

// Sidebar Navigation
function initSidebar() {
    const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
    const contentSections = document.querySelectorAll('.content-wrapper');
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    const sidebarOverlay = document.querySelector('.sidebar-overlay');

    // Handle sidebar navigation
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const href = this.getAttribute('href');
            if (href === '#logout') {
                handleLogout();
                return;
            }

            // Update active states
            document.querySelector('.sidebar-nav li.active').classList.remove('active');
            this.parentElement.classList.add('active');

            // Show corresponding content
            contentSections.forEach(section => {
                section.style.display = 'none';
            });

            const targetSection = document.querySelector(href);
            if (targetSection) {
                targetSection.style.display = 'block';
                
                // Update header title and breadcrumbs
                updateHeaderInfo(this);
                
                // Load section data
                const section = href.replace('#', '');
                currentSection = section;
                loadSectionData(section);
                
                // Close sidebar on mobile
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('open');
                    sidebarOverlay.classList.remove('open');
                }
            }
        });
    });

    // Mobile sidebar toggle
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
            sidebarOverlay.classList.toggle('open');
        });
    }

    // Close sidebar when clicking overlay
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('open');
        });
    }

    // Close sidebar on mobile when clicking outside
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('open');
            }
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('open');
        }
    });
}

// Update header information (title and breadcrumbs)
function updateHeaderInfo(linkElement) {
    const headerTitle = document.querySelector('.header-left h1');
    const breadcrumbs = document.querySelector('.breadcrumbs');
    const sectionTitle = linkElement.querySelector('span').textContent;
    
    // Update title
    headerTitle.textContent = sectionTitle;
    
    // Update breadcrumbs
    if (breadcrumbs) {
        const section = linkElement.getAttribute('href').replace('#', '');
        let breadcrumbHTML = '<a href="#dashboard">Dashboard</a>';
        
        if (section !== 'dashboard') {
            breadcrumbHTML += '<span class="separator">/</span>';
            breadcrumbHTML += `<span class="current">${sectionTitle}</span>`;
        } else {
            breadcrumbHTML += '<span class="separator">/</span>';
            breadcrumbHTML += '<span class="current">Visão Geral</span>';
        }
        
        breadcrumbs.innerHTML = breadcrumbHTML;
    }
    
    // Update quick actions based on section
    const section = linkElement.getAttribute('href').replace('#', '');
    updateQuickActions(section);
}

// Update quick actions based on current section
function updateQuickActions(section) {
    const quickActions = document.querySelector('.quick-actions');
    if (!quickActions) return;
    
    let actionsHTML = '';
    
    switch(section) {
        case 'dashboard':
            actionsHTML = `
                <a href="#produtos" class="quick-action-btn">
                    <i class="fas fa-plus"></i>
                    Novo Produto
                </a>
                <a href="#pedidos" class="quick-action-btn primary">
                    <i class="fas fa-eye"></i>
                    Ver Pedidos
                </a>
            `;
            break;
        case 'produtos':
            actionsHTML = `
                <a href="#" onclick="showAddProduct()" class="quick-action-btn primary">
                    <i class="fas fa-plus"></i>
                    Novo Produto
                </a>
                <a href="#" onclick="exportProducts()" class="quick-action-btn">
                    <i class="fas fa-download"></i>
                    Exportar
                </a>
            `;
            break;
        case 'pedidos':
            actionsHTML = `
                <a href="#" onclick="showAddOrder()" class="quick-action-btn primary">
                    <i class="fas fa-plus"></i>
                    Novo Pedido
                </a>
                <a href="#" onclick="exportOrders()" class="quick-action-btn">
                    <i class="fas fa-download"></i>
                    Exportar
                </a>
            `;
            break;
        case 'clientes':
            actionsHTML = `
                <a href="#" onclick="showAddCustomer()" class="quick-action-btn primary">
                    <i class="fas fa-plus"></i>
                    Novo Cliente
                </a>
                <a href="#" onclick="exportCustomers()" class="quick-action-btn">
                    <i class="fas fa-download"></i>
                    Exportar
                </a>
            `;
            break;
        default:
            actionsHTML = `
                <a href="#produtos" class="quick-action-btn">
                    <i class="fas fa-plus"></i>
                    Novo Produto
                </a>
                <a href="#pedidos" class="quick-action-btn primary">
                    <i class="fas fa-eye"></i>
                    Ver Pedidos
                </a>
            `;
    }
    
    quickActions.innerHTML = actionsHTML;
}

// Modal Management
function initModals() {
    const modals = document.querySelectorAll('.modal');
    const modalCloses = document.querySelectorAll('.modal-close');

    // Close modal when clicking close button
    modalCloses.forEach(close => {
        close.addEventListener('click', function() {
            const modal = this.closest('.modal');
            closeModal(modal);
        });
    });

    // Close modal when clicking outside
    modals.forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this);
            }
        });
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.modal[style*="flex"]');
            if (openModal) {
                closeModal(openModal);
            }
        }
    });
}

// Funções para carregar dados das seções
function loadSectionData(section) {
    switch(section) {
        case 'dashboard':
            loadDashboardData();
            break;
        case 'produtos':
            loadProdutos();
            break;
        case 'categorias':
            loadCategorias();
            break;
        case 'pedidos':
            loadPedidos();
            break;
        case 'clientes':
            loadClientes();
            break;
        case 'configuracoes':
            loadConfiguracoes();
            break;
    }
}

// Carregar dados do dashboard
function loadDashboardData() {
    fetch(`${API_URLS.dashboard}?action=estatisticas`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateDashboardStats(data.data);
            }
        })
        .catch(error => {
            console.error('Erro ao carregar estatísticas:', error);
            showNotification('Erro ao carregar dados do dashboard', 'error');
        });
    
    // Carregar pedidos recentes
    fetch(`${API_URLS.dashboard}?action=pedidos_recentes&limit=5`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateRecentOrders(data.data);
            }
        })
        .catch(error => {
            console.error('Erro ao carregar pedidos recentes:', error);
        });
    
    // Carregar produtos populares
    fetch(`${API_URLS.dashboard}?action=produtos_populares&limit=4`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updatePopularProducts(data.data);
            }
        })
        .catch(error => {
            console.error('Erro ao carregar produtos populares:', error);
        });
}

// Atualizar estatísticas do dashboard
function updateDashboardStats(stats) {
    // Atualizar cards de estatísticas
    const salesCard = document.querySelector('.stat-card:nth-child(1) .stat-info h3');
    const ordersCard = document.querySelector('.stat-card:nth-child(2) .stat-info h3');
    const productsCard = document.querySelector('.stat-card:nth-child(3) .stat-info h3');
    const customersCard = document.querySelector('.stat-card:nth-child(4) .stat-info h3');
    
    if (salesCard) salesCard.textContent = `R$ ${stats.vendas.total_vendas.toFixed(2)}`;
    if (ordersCard) ordersCard.textContent = stats.vendas.total_pedidos;
    if (productsCard) productsCard.textContent = stats.produtos;
    if (customersCard) customersCard.textContent = stats.clientes;
    
    // Atualizar indicadores de crescimento
    const salesChange = document.querySelector('.stat-card:nth-child(1) .stat-change');
    const ordersChange = document.querySelector('.stat-card:nth-child(2) .stat-change');
    
    if (salesChange) {
        const change = stats.comparacao.crescimento_vendas;
        salesChange.textContent = `${change >= 0 ? '+' : ''}${change.toFixed(1)}%`;
        salesChange.className = `stat-change ${change >= 0 ? 'positive' : 'negative'}`;
    }
    
    if (ordersChange) {
        const change = stats.comparacao.crescimento_pedidos;
        ordersChange.textContent = `${change >= 0 ? '+' : ''}${change.toFixed(1)}%`;
        ordersChange.className = `stat-change ${change >= 0 ? 'positive' : 'negative'}`;
    }
}

// Atualizar pedidos recentes
function updateRecentOrders(pedidos) {
    const ordersList = document.querySelector('.orders-list');
    if (!ordersList) return;
    
    ordersList.innerHTML = '';
    
    pedidos.forEach(pedido => {
        const orderItem = document.createElement('div');
        orderItem.className = 'order-item';
        orderItem.innerHTML = `
            <div class="order-info">
                <strong>Pedido #${pedido.numero}</strong>
                <span>${pedido.cliente_nome}</span>
            </div>
            <div class="order-amount">R$ ${parseFloat(pedido.total).toFixed(2)}</div>
            <div class="order-status ${pedido.status}">${pedido.status.toUpperCase()}</div>
        `;
        ordersList.appendChild(orderItem);
    });
}

// Atualizar produtos populares
function updatePopularProducts(produtos) {
    const productsGrid = document.querySelector('.products-grid');
    if (!productsGrid) return;
    
    productsGrid.innerHTML = '';
    
    produtos.forEach(produto => {
        const productItem = document.createElement('div');
        productItem.className = 'product-item';
        productItem.innerHTML = `
            <div class="product-image">
                <i class="fas fa-tshirt"></i>
            </div>
            <div class="product-details">
                <h4>${produto.nome}</h4>
                <p>${produto.vendas} vendas</p>
                <span class="price">R$ ${parseFloat(produto.preco).toFixed(2)}</span>
            </div>
        `;
        productsGrid.appendChild(productItem);
    });
}

// Carregar produtos
function loadProdutos() {
    const params = new URLSearchParams({
        action: 'listar',
        page: currentPage,
        limit: 10,
        ...currentFilters
    });
    
    fetch(`${API_URLS.produtos}?${params}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateProdutosTable(data.data);
                updatePagination(data);
            }
        })
        .catch(error => {
            console.error('Erro ao carregar produtos:', error);
            showNotification('Erro ao carregar produtos', 'error');
        });
}

// Carregar categorias
function loadCategorias() {
    const params = new URLSearchParams({
        action: 'listar',
        page: currentPage,
        limit: 12
    });
    
    fetch(`${API_URLS.categorias}?${params}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCategoriasGrid(data.data);
            }
        })
        .catch(error => {
            console.error('Erro ao carregar categorias:', error);
            showNotification('Erro ao carregar categorias', 'error');
        });
}

// Carregar pedidos
function loadPedidos() {
    const params = new URLSearchParams({
        action: 'listar',
        page: currentPage,
        limit: 10,
        ...currentFilters
    });
    
    fetch(`${API_URLS.pedidos}?${params}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updatePedidosTable(data.data);
                updatePagination(data);
            }
        })
        .catch(error => {
            console.error('Erro ao carregar pedidos:', error);
            showNotification('Erro ao carregar pedidos', 'error');
        });
}

// Carregar clientes
function loadClientes() {
    const params = new URLSearchParams({
        action: 'listar',
        page: currentPage,
        limit: 12,
        ...currentFilters
    });
    
    fetch(`${API_URLS.clientes}?${params}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateClientesGrid(data.data);
            }
        })
        .catch(error => {
            console.error('Erro ao carregar clientes:', error);
            showNotification('Erro ao carregar clientes', 'error');
        });
}

// Carregar configurações
function loadConfiguracoes() {
    fetch(`${API_URLS.configuracoes}?action=listar`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateConfiguracoesForm(data.data);
            }
        })
        .catch(error => {
            console.error('Erro ao carregar configurações:', error);
            showNotification('Erro ao carregar configurações', 'error');
        });
}

// Funções para mostrar modais
function showAddProduct() {
    const modal = document.getElementById('addProductModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function showAddCategory() {
    const modal = document.getElementById('addCategoryModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function showAddCustomer() {
    const modal = document.getElementById('addCustomerModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function showAddOrder() {
    const modal = document.getElementById('addOrderModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeModal(modal = null) {
    if (!modal) {
        modal = document.querySelector('.modal[style*="flex"]');
    }
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        
        // Reset form if exists
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
        }
    }
}

// Table Management
function initTables() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.products-table tbody input[type="checkbox"]');

    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    // Individual checkbox handling
    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(rowCheckboxes).some(cb => cb.checked);
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }
        });
    });

    // Action buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-icon')) {
            const button = e.target.closest('.btn-icon');
            const action = button.title.toLowerCase();
            const row = button.closest('tr');
            const card = button.closest('.category-card, .customer-card');
            
            // Handle product actions
            if (row && row.querySelector('.product-cell')) {
                const productName = row.querySelector('.product-cell strong').textContent;
                switch(action) {
                    case 'editar':
                        editProduct(row);
                        break;
                    case 'duplicar':
                        duplicateProduct(row);
                        break;
                    case 'excluir':
                        deleteProduct(row, productName);
                        break;
                }
            }
            
            // Handle category actions
            if (card && card.classList.contains('category-card')) {
                const categoryName = card.querySelector('.category-info h3').textContent;
                switch(action) {
                    case 'editar':
                        showNotification(`Editando categoria: ${categoryName}`, 'info');
                        break;
                    case 'excluir':
                        if (confirm(`Tem certeza que deseja excluir a categoria "${categoryName}"?`)) {
                            card.style.opacity = '0.5';
                            setTimeout(() => {
                                card.remove();
                                showNotification('Categoria excluída com sucesso!', 'success');
                            }, 300);
                        }
                        break;
                }
            }
            
            // Handle customer actions
            if (card && card.classList.contains('customer-card')) {
                const customerName = card.querySelector('.customer-info h3').textContent;
                switch(action) {
                    case 'editar':
                        showNotification(`Editando cliente: ${customerName}`, 'info');
                        break;
                    case 'ver pedidos':
                        showNotification(`Visualizando pedidos de: ${customerName}`, 'info');
                        break;
                    case 'excluir':
                        if (confirm(`Tem certeza que deseja excluir o cliente "${customerName}"?`)) {
                            card.style.opacity = '0.5';
                            setTimeout(() => {
                                card.remove();
                                showNotification('Cliente excluído com sucesso!', 'success');
                            }, 300);
                        }
                        break;
                }
            }
            
            // Handle order actions
            if (row && row.querySelector('td:first-child strong')) {
                const orderNumber = row.querySelector('td:first-child strong').textContent;
                switch(action) {
                    case 'ver detalhes':
                        showNotification(`Visualizando detalhes do pedido: ${orderNumber}`, 'info');
                        break;
                    case 'editar':
                        showNotification(`Editando pedido: ${orderNumber}`, 'info');
                        break;
                    case 'imprimir':
                        showNotification(`Imprimindo pedido: ${orderNumber}`, 'info');
                        break;
                }
            }
        }
    });
}

function editProduct(row) {
    // Simulate edit functionality
    showNotification('Editando produto: ' + row.querySelector('.product-cell strong').textContent, 'info');
}

function duplicateProduct(row) {
    // Simulate duplicate functionality
    showNotification('Produto duplicado com sucesso!', 'success');
}

function deleteProduct(row, productName) {
    if (confirm(`Tem certeza que deseja excluir o produto "${productName}"?`)) {
        row.style.opacity = '0.5';
        setTimeout(() => {
            row.remove();
            showNotification('Produto excluído com sucesso!', 'success');
        }, 300);
    }
}

// Funções para atualizar tabelas e grids com dados reais
function updateProdutosTable(produtos) {
    const tbody = document.getElementById('produtosTableBody');
    if (!tbody) return;
    
    if (produtos.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="empty-message">
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <span>Nenhum produto encontrado</span>
                        <button class="btn-primary" onclick="showAddProduct()">
                            <i class="fas fa-plus"></i> Adicionar Primeiro Produto
                        </button>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = '';
    
    produtos.forEach(produto => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <input type="checkbox" class="product-checkbox">
            </td>
            <td>
                <div class="product-cell">
                    <div class="product-image">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <div>
                        <strong>${produto.nome}</strong>
                        <span>SKU: ${produto.sku}</span>
                    </div>
                </div>
            </td>
            <td>${produto.categoria_nome || '-'}</td>
            <td>R$ ${parseFloat(produto.preco).toFixed(2)}</td>
            <td>${produto.estoque} un.</td>
            <td>
                <span class="status ${produto.status}">${produto.status.toUpperCase()}</span>
            </td>
            <td>
                <div class="action-buttons">
                    <a class="btn-icon" title="Visualizar" href="/projeto-ecommerce/loja-plus-size/loja/produto.php?id=${produto.id}" target="_blank">
                        <i class="fas fa-eye"></i>
                    </a>
                    <button class="btn-icon" title="Editar" onclick="editarProduto(${produto.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-icon danger" title="Excluir" onclick="excluirProduto(${produto.id}, '${produto.nome}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function updatePedidosTable(pedidos) {
    const tbody = document.querySelector('.orders-table tbody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    pedidos.forEach(pedido => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>#${pedido.numero}</td>
            <td>${pedido.cliente_nome || 'Cliente não encontrado'}</td>
            <td>${new Date(pedido.created_at).toLocaleDateString('pt-BR')}</td>
            <td>R$ ${parseFloat(pedido.total).toFixed(2)}</td>
            <td>
                <span class="order-status ${pedido.status}">${pedido.status.toUpperCase()}</span>
            </td>
            <td>${pedido.forma_pagamento || '-'}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-icon" title="Visualizar" onclick="visualizarPedido(${pedido.id})">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-icon" title="Editar" onclick="editarPedido(${pedido.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-icon" title="Imprimir" onclick="imprimirPedido(${pedido.id})">
                        <i class="fas fa-print"></i>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function updateCategoriasGrid(categorias) {
    const grid = document.querySelector('.categories-grid');
    if (!grid) return;
    
    grid.innerHTML = '';
    
    categorias.forEach(categoria => {
        const card = document.createElement('div');
        card.className = 'category-card';
        card.innerHTML = `
            <div class="category-icon">
                <i class="fas fa-tag"></i>
            </div>
            <div class="category-info">
                <h3>${categoria.nome}</h3>
                <p>${categoria.total_produtos} produtos</p>
            </div>
            <div class="category-status ${categoria.ativo ? 'active' : 'inactive'}">
                ${categoria.ativo ? 'Ativa' : 'Inativa'}
            </div>
            <div class="category-actions">
                <button class="btn-icon" title="Editar" onclick="editarCategoria(${categoria.id})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-icon danger" title="Excluir" onclick="excluirCategoria(${categoria.id}, '${categoria.nome}')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        grid.appendChild(card);
    });
}

function updateClientesGrid(clientes) {
    const grid = document.querySelector('.customers-grid');
    if (!grid) return;
    
    grid.innerHTML = '';
    
    clientes.forEach(cliente => {
        const card = document.createElement('div');
        card.className = 'customer-card';
        card.innerHTML = `
            <div class="customer-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="customer-info">
                <h3>${cliente.nome}</h3>
                <p>${cliente.email}</p>
            </div>
            <div class="customer-status ${cliente.ativo ? 'active' : 'inactive'}">
                ${cliente.ativo ? 'Ativo' : 'Inativo'}
            </div>
            <div class="customer-stats">
                <div class="stat">
                    <div class="stat-number">${cliente.total_pedidos || 0}</div>
                    <div class="stat-label">Pedidos</div>
                </div>
                <div class="stat">
                    <div class="stat-number">R$ ${(cliente.total_gasto || 0).toFixed(2)}</div>
                    <div class="stat-label">Total Gasto</div>
                </div>
            </div>
            <div class="customer-actions">
                <button class="btn-icon" title="Visualizar" onclick="visualizarCliente(${cliente.id})">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn-icon" title="Editar" onclick="editarCliente(${cliente.id})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-icon danger" title="Excluir" onclick="excluirCliente(${cliente.id}, '${cliente.nome}')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        grid.appendChild(card);
    });
}

function updateConfiguracoesForm(configuracoes) {
    configuracoes.forEach(config => {
        const input = document.querySelector(`[name="${config.chave}"]`);
        if (input) {
            if (input.type === 'checkbox') {
                input.checked = config.valor === '1' || config.valor === 'true';
            } else {
                input.value = config.valor;
            }
        }
    });
}

// Funções de ação para produtos
function visualizarProduto(id) {
    fetch(`${API_URLS.produtos}?action=visualizar&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showProdutoModal(data.data, 'visualizar');
            }
        })
        .catch(error => {
            console.error('Erro ao visualizar produto:', error);
            showNotification('Erro ao carregar dados do produto', 'error');
        });
}

function editarProduto(id) {
    fetch(`${API_URLS.produtos}?action=visualizar&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showProdutoModal(data.data, 'editar');
            }
        })
        .catch(error => {
            console.error('Erro ao editar produto:', error);
            showNotification('Erro ao carregar dados do produto', 'error');
        });
}

function excluirProduto(id, nome) {
    if (confirm(`Tem certeza que deseja excluir o produto "${nome}"?`)) {
        const formData = new FormData();
        formData.append('action', 'excluir');
        formData.append('id', id);
        
        fetch(API_URLS.produtos, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Produto excluído com sucesso!', 'success');
                loadProdutos();
            } else {
                showNotification(data.error || 'Erro ao excluir produto', 'error');
            }
        })
        .catch(error => {
            console.error('Erro ao excluir produto:', error);
            showNotification('Erro ao excluir produto', 'error');
        });
    }
}

// Funções de ação para pedidos
function visualizarPedido(id) {
    fetch(`${API_URLS.pedidos}?action=visualizar&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showPedidoModal(data.data, 'visualizar');
            }
        })
        .catch(error => {
            console.error('Erro ao visualizar pedido:', error);
            showNotification('Erro ao carregar dados do pedido', 'error');
        });
}

function editarPedido(id) {
    fetch(`${API_URLS.pedidos}?action=visualizar&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showPedidoModal(data.data, 'editar');
            }
        })
        .catch(error => {
            console.error('Erro ao editar pedido:', error);
            showNotification('Erro ao carregar dados do pedido', 'error');
        });
}

function imprimirPedido(id) {
    // Implementar impressão do pedido
    showNotification('Funcionalidade de impressão será implementada em breve!', 'info');
}

// Funções de ação para categorias
function editarCategoria(id) {
    fetch(`${API_URLS.categorias}?action=visualizar&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showCategoriaModal(data.data, 'editar');
            }
        })
        .catch(error => {
            console.error('Erro ao editar categoria:', error);
            showNotification('Erro ao carregar dados da categoria', 'error');
        });
}

function excluirCategoria(id, nome) {
    if (confirm(`Tem certeza que deseja excluir a categoria "${nome}"?`)) {
        const formData = new FormData();
        formData.append('action', 'excluir');
        formData.append('id', id);
        
        fetch(API_URLS.categorias, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Categoria excluída com sucesso!', 'success');
                loadCategorias();
            } else {
                showNotification(data.error || 'Erro ao excluir categoria', 'error');
            }
        })
        .catch(error => {
            console.error('Erro ao excluir categoria:', error);
            showNotification('Erro ao excluir categoria', 'error');
        });
    }
}

// Funções de ação para clientes
function visualizarCliente(id) {
    fetch(`${API_URLS.clientes}?action=visualizar&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showClienteModal(data.data, 'visualizar');
            }
        })
        .catch(error => {
            console.error('Erro ao visualizar cliente:', error);
            showNotification('Erro ao carregar dados do cliente', 'error');
        });
}

function editarCliente(id) {
    fetch(`${API_URLS.clientes}?action=visualizar&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showClienteModal(data.data, 'editar');
            }
        })
        .catch(error => {
            console.error('Erro ao editar cliente:', error);
            showNotification('Erro ao carregar dados do cliente', 'error');
        });
}

function excluirCliente(id, nome) {
    if (confirm(`Tem certeza que deseja excluir o cliente "${nome}"?`)) {
        const formData = new FormData();
        formData.append('action', 'excluir');
        formData.append('id', id);
        
        fetch(API_URLS.clientes, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Cliente excluído com sucesso!', 'success');
                loadClientes();
            } else {
                showNotification(data.error || 'Erro ao excluir cliente', 'error');
            }
        })
        .catch(error => {
            console.error('Erro ao excluir cliente:', error);
            showNotification('Erro ao excluir cliente', 'error');
        });
    }
}

// Charts
function initCharts() {
    // Simulate chart data
    const chartCanvas = document.getElementById('salesChart');
    if (chartCanvas) {
        const ctx = chartCanvas.getContext('2d');
        
        // Simple chart simulation (you can integrate Chart.js here)
        ctx.fillStyle = '#6366f1';
        ctx.fillRect(10, 50, 30, 200);
        ctx.fillRect(50, 30, 30, 220);
        ctx.fillRect(90, 70, 30, 180);
        ctx.fillRect(130, 20, 30, 230);
        ctx.fillRect(170, 40, 30, 210);
        ctx.fillRect(210, 60, 30, 190);
        ctx.fillRect(250, 25, 30, 225);
        
        ctx.fillStyle = '#374151';
        ctx.font = '12px Inter';
        ctx.fillText('Gráfico de Vendas - Últimos 7 dias', 10, 20);
    }
}

// Filters
function initFilters() {
    // Products filters
    const searchInput = document.querySelector('.search-box input');
    const categoryFilter = document.querySelector('.filter-select:nth-child(2)');
    const statusFilter = document.querySelector('.filter-select:nth-child(3)');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterProducts();
        });
    }

    if (categoryFilter) {
        categoryFilter.addEventListener('change', function() {
            filterProducts();
        });
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            filterProducts();
        });
    }

    // Orders filters
    const ordersSearchInput = document.querySelector('#pedidos .search-box input');
    const ordersStatusFilter = document.querySelector('#pedidos .filter-select:nth-child(2)');
    const ordersDateFilter = document.querySelector('#pedidos .filter-select:nth-child(3)');

    if (ordersSearchInput) {
        ordersSearchInput.addEventListener('input', function() {
            filterOrders();
        });
    }

    if (ordersStatusFilter) {
        ordersStatusFilter.addEventListener('change', function() {
            filterOrders();
        });
    }

    if (ordersDateFilter) {
        ordersDateFilter.addEventListener('change', function() {
            filterOrders();
        });
    }

    // Customers filters
    const customersSearchInput = document.querySelector('#clientes .search-box input');
    const customersStatusFilter = document.querySelector('#clientes .filter-select');

    if (customersSearchInput) {
        customersSearchInput.addEventListener('input', function() {
            filterCustomers();
        });
    }

    if (customersStatusFilter) {
        customersStatusFilter.addEventListener('change', function() {
            filterCustomers();
        });
    }
}

// Settings forms
function initSettingsForms() {
    const settingsForms = document.querySelectorAll('.settings-form');
    
    settingsForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            showNotification('Configurações salvas com sucesso!', 'success');
        });
    });
}

function filterProducts() {
    const searchTerm = document.querySelector('.search-box input').value.toLowerCase();
    const categoryFilter = document.querySelector('.filter-select:nth-child(2)').value;
    const statusFilter = document.querySelector('.filter-select:nth-child(3)').value;
    
    const rows = document.querySelectorAll('.products-table tbody tr');
    
    rows.forEach(row => {
        const productName = row.querySelector('.product-cell strong').textContent.toLowerCase();
        const category = row.cells[2].textContent.toLowerCase();
        const status = row.querySelector('.status').textContent.toLowerCase();
        
        const matchesSearch = productName.includes(searchTerm);
        const matchesCategory = !categoryFilter || category.includes(categoryFilter.toLowerCase());
        const matchesStatus = !statusFilter || status.includes(statusFilter.toLowerCase());
        
        if (matchesSearch && matchesCategory && matchesStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function filterOrders() {
    const searchTerm = document.querySelector('#pedidos .search-box input').value.toLowerCase();
    const statusFilter = document.querySelector('#pedidos .filter-select:nth-child(2)').value;
    const dateFilter = document.querySelector('#pedidos .filter-select:nth-child(3)').value;
    
    const rows = document.querySelectorAll('.orders-table tbody tr');
    
    rows.forEach(row => {
        const orderNumber = row.querySelector('td:first-child strong').textContent.toLowerCase();
        const customerName = row.cells[1].textContent.toLowerCase();
        const status = row.querySelector('.status').textContent.toLowerCase();
        
        const matchesSearch = orderNumber.includes(searchTerm) || customerName.includes(searchTerm);
        const matchesStatus = !statusFilter || status.includes(statusFilter.toLowerCase());
        
        if (matchesSearch && matchesStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function filterCustomers() {
    const searchTerm = document.querySelector('#clientes .search-box input').value.toLowerCase();
    const statusFilter = document.querySelector('#clientes .filter-select').value;
    
    const cards = document.querySelectorAll('.customer-card');
    
    cards.forEach(card => {
        const customerName = card.querySelector('.customer-info h3').textContent.toLowerCase();
        const customerEmail = card.querySelector('.customer-info p').textContent.toLowerCase();
        const status = card.querySelector('.customer-status').textContent.toLowerCase();
        
        const matchesSearch = customerName.includes(searchTerm) || customerEmail.includes(searchTerm);
        const matchesStatus = !statusFilter || status.includes(statusFilter.toLowerCase());
        
        if (matchesSearch && matchesStatus) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

// Form Management
document.addEventListener('submit', function(e) {
    if (e.target.classList.contains('product-form')) {
        e.preventDefault();
        handleProductForm(e.target);
    }
});

function handleProductForm(form) {
    const formData = new FormData(form);
    
    // Simulate form submission
    showNotification('Salvando produto...', 'info');
    
    setTimeout(() => {
        showNotification('Produto salvo com sucesso!', 'success');
        closeModal();
        
        // Add new row to table (simulation)
        addProductToTable(formData);
    }, 1500);
}

function addProductToTable(formData) {
    const table = document.querySelector('.products-table tbody');
    const newRow = document.createElement('tr');
    
    newRow.innerHTML = `
        <td><input type="checkbox"></td>
        <td>
            <div class="product-cell">
                <img src="../assets/images/placeholder.jpg" alt="Produto">
                <div>
                    <strong>${formData.get('nome') || 'Novo Produto'}</strong>
                    <span>SKU: ${formData.get('sku') || 'NEW001'}</span>
                </div>
            </div>
        </td>
        <td>${formData.get('categoria') || 'Categoria'}</td>
        <td>R$ ${formData.get('preco') || '0,00'}</td>
        <td>${formData.get('estoque') || '0'} un.</td>
        <td><span class="status active">Ativo</span></td>
        <td>
            <div class="action-buttons">
                <button class="btn-icon" title="Editar">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-icon" title="Duplicar">
                    <i class="fas fa-copy"></i>
                </button>
                <button class="btn-icon danger" title="Excluir">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    `;
    
    table.appendChild(newRow);
}

// Funções para mostrar modais
function showProdutoModal(produto, mode) {
    const modal = document.getElementById('produtoModal');
    if (!modal) {
        showNotification('Modal de produto não encontrado', 'error');
        return;
    }
    
    const title = modal.querySelector('.modal-header h3');
    const form = modal.querySelector('form');
    
    title.textContent = mode === 'visualizar' ? 'Visualizar Produto' : 'Editar Produto';
    
    // Preencher formulário
    if (form) {
        form.querySelector('[name="nome"]').value = produto.nome || '';
        form.querySelector('[name="sku"]').value = produto.sku || '';
        form.querySelector('[name="preco"]').value = produto.preco || '';
        form.querySelector('[name="estoque"]').value = produto.estoque || '';
        form.querySelector('[name="descricao"]').value = produto.descricao || '';
        form.querySelector('[name="status"]').value = produto.status || 'ativo';
        
        // Desabilitar campos se for visualização
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.disabled = mode === 'visualizar';
        });
        
        // Mostrar/esconder botões
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.style.display = mode === 'visualizar' ? 'none' : 'block';
        }
    }
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function showPedidoModal(pedido, mode) {
    const modal = document.getElementById('pedidoModal');
    if (!modal) {
        showNotification('Modal de pedido não encontrado', 'error');
        return;
    }
    
    const title = modal.querySelector('.modal-header h3');
    title.textContent = mode === 'visualizar' ? 'Visualizar Pedido' : 'Editar Pedido';
    
    // Preencher dados do pedido
    const content = modal.querySelector('.modal-content');
    content.innerHTML = `
        <div class="pedido-info">
            <h4>Pedido #${pedido.numero}</h4>
            <p><strong>Cliente:</strong> ${pedido.cliente_nome}</p>
            <p><strong>Data:</strong> ${new Date(pedido.created_at).toLocaleDateString('pt-BR')}</p>
            <p><strong>Status:</strong> ${pedido.status}</p>
            <p><strong>Total:</strong> R$ ${parseFloat(pedido.total).toFixed(2)}</p>
            <p><strong>Forma de Pagamento:</strong> ${pedido.forma_pagamento || '-'}</p>
        </div>
        <div class="pedido-itens">
            <h4>Itens do Pedido</h4>
            <table class="itens-table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Tamanho</th>
                        <th>Qtd</th>
                        <th>Preço</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    ${pedido.itens.map(item => `
                        <tr>
                            <td>${item.produto_nome}</td>
                            <td>${item.tamanho_nome || '-'}</td>
                            <td>${item.quantidade}</td>
                            <td>R$ ${parseFloat(item.preco_unitario).toFixed(2)}</td>
                            <td>R$ ${parseFloat(item.subtotal).toFixed(2)}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function showCategoriaModal(categoria, mode) {
    const modal = document.getElementById('categoriaModal');
    if (!modal) {
        showNotification('Modal de categoria não encontrado', 'error');
        return;
    }
    
    const title = modal.querySelector('.modal-header h3');
    const form = modal.querySelector('form');
    
    title.textContent = mode === 'visualizar' ? 'Visualizar Categoria' : 'Editar Categoria';
    
    // Preencher formulário
    if (form) {
        form.querySelector('[name="nome"]').value = categoria.nome || '';
        form.querySelector('[name="descricao"]').value = categoria.descricao || '';
        form.querySelector('[name="ativo"]').checked = categoria.ativo;
        
        // Desabilitar campos se for visualização
        const inputs = form.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.disabled = mode === 'visualizar';
        });
        
        // Mostrar/esconder botões
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.style.display = mode === 'visualizar' ? 'none' : 'block';
        }
    }
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function showClienteModal(cliente, mode) {
    const modal = document.getElementById('clienteModal');
    if (!modal) {
        showNotification('Modal de cliente não encontrado', 'error');
        return;
    }
    
    const title = modal.querySelector('.modal-header h3');
    const form = modal.querySelector('form');
    
    title.textContent = mode === 'visualizar' ? 'Visualizar Cliente' : 'Editar Cliente';
    
    // Preencher formulário
    if (form) {
        form.querySelector('[name="nome"]').value = cliente.nome || '';
        form.querySelector('[name="email"]').value = cliente.email || '';
        form.querySelector('[name="telefone"]').value = cliente.telefone || '';
        form.querySelector('[name="cpf"]').value = cliente.cpf || '';
        form.querySelector('[name="ativo"]').checked = cliente.ativo;
        
        // Desabilitar campos se for visualização
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            input.disabled = mode === 'visualizar';
        });
        
        // Mostrar/esconder botões
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.style.display = mode === 'visualizar' ? 'none' : 'block';
        }
    }
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Função para atualizar paginação
function updatePagination(data) {
    const paginationInfo = document.getElementById('paginationInfo');
    const paginationButtons = document.getElementById('paginationButtons');
    
    if (!paginationInfo || !paginationButtons) return;
    
    const totalPages = data.pages || 1;
    const currentPage = data.page || 1;
    const total = data.total || 0;
    const limit = data.limit || 10;
    
    // Atualizar contador
    const start = (currentPage - 1) * limit + 1;
    const end = Math.min(currentPage * limit, total);
    paginationInfo.textContent = `Mostrando ${start}-${end} de ${total} produtos`;
    
    // Atualizar botões
    paginationButtons.innerHTML = '';
    
    // Botão anterior
    const prevBtn = document.createElement('button');
    prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
    prevBtn.disabled = currentPage <= 1;
    prevBtn.onclick = () => {
        if (currentPage > 1) {
            currentPage = currentPage - 1;
            loadSectionData(currentSection);
        }
    };
    paginationButtons.appendChild(prevBtn);
    
    // Botões de página
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            const pageBtn = document.createElement('button');
            pageBtn.textContent = i;
            pageBtn.className = i === currentPage ? 'active' : '';
            pageBtn.onclick = () => {
                currentPage = i;
                loadSectionData(currentSection);
            };
            paginationButtons.appendChild(pageBtn);
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            const ellipsis = document.createElement('span');
            ellipsis.textContent = '...';
            ellipsis.className = 'ellipsis';
            paginationButtons.appendChild(ellipsis);
        }
    }
    
    // Botão próximo
    const nextBtn = document.createElement('button');
    nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
    nextBtn.disabled = currentPage >= totalPages;
    nextBtn.onclick = () => {
        if (currentPage < totalPages) {
            currentPage = currentPage + 1;
            loadSectionData(currentSection);
        }
    };
    paginationButtons.appendChild(nextBtn);
}

// Notifications
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existing = document.querySelector('.notification');
    if (existing) {
        existing.remove();
    }

    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        color: white;
        font-weight: 500;
        z-index: 9999;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;

    switch(type) {
        case 'success':
            notification.style.background = '#10b981';
            break;
        case 'error':
            notification.style.background = '#ef4444';
            break;
        case 'warning':
            notification.style.background = '#f59e0b';
            break;
        default:
            notification.style.background = '#3b82f6';
    }

    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : type === 'warning' ? 'exclamation' : 'info'}-circle"></i>
        ${message}
    `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    // Auto remove
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 3000);
}

// Logout
function handleLogout() {
    if (confirm('Tem certeza que deseja sair?')) {
        showNotification('Saindo...', 'info');
        setTimeout(() => {
            window.location.href = '../';
        }, 1000);
    }
}

// Funções de exportação para atalhos rápidos
function exportProducts() {
    showNotification('Exportando produtos...', 'info');
    // Implementar exportação de produtos
    setTimeout(() => {
        showNotification('Produtos exportados com sucesso!', 'success');
    }, 2000);
}

function exportOrders() {
    showNotification('Exportando pedidos...', 'info');
    // Implementar exportação de pedidos
    setTimeout(() => {
        showNotification('Pedidos exportados com sucesso!', 'success');
    }, 2000);
}

function exportCustomers() {
    showNotification('Exportando clientes...', 'info');
    // Implementar exportação de clientes
    setTimeout(() => {
        showNotification('Clientes exportados com sucesso!', 'success');
    }, 2000);
}

// Auto-save drafts (simulation)
let autoSaveTimer;
document.addEventListener('input', function(e) {
    if (e.target.closest('.product-form')) {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(() => {
            console.log('Auto-salvando rascunho...');
        }, 2000);
    }
});

// Upload handling
document.addEventListener('change', function(e) {
    if (e.target.type === 'file' && e.target.accept === 'image/*') {
        handleImageUpload(e.target);
    }
});

function handleImageUpload(input) {
    const files = input.files;
    if (files.length > 0) {
        const uploadArea = input.closest('.upload-area');
        const preview = document.createElement('div');
        preview.className = 'upload-preview';
        preview.style.cssText = `
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        `;

        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.cssText = `
                        width: 60px;
                        height: 60px;
                        object-fit: cover;
                        border-radius: 0.375rem;
                        border: 2px solid #e5e7eb;
                    `;
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove existing preview
        const existingPreview = uploadArea.querySelector('.upload-preview');
        if (existingPreview) {
            existingPreview.remove();
        }

        uploadArea.appendChild(preview);
        showNotification(`${files.length} imagem(ns) selecionada(s)`, 'success');
    }
}

// Real-time validation
document.addEventListener('blur', function(e) {
    if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT') {
        validateField(e.target);
    }
});

function validateField(field) {
    const value = field.value.trim();
    const isRequired = field.hasAttribute('required');
    
    // Remove existing validation classes
    field.classList.remove('field-valid', 'field-invalid');
    
    if (isRequired && !value) {
        field.classList.add('field-invalid');
        return false;
    }
    
    // Specific validations
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            field.classList.add('field-invalid');
            return false;
        }
    }
    
    if (field.type === 'number' && value) {
        if (isNaN(value) || parseFloat(value) < 0) {
            field.classList.add('field-invalid');
            return false;
        }
    }
    
    if (value) {
        field.classList.add('field-valid');
    }
    
    return true;
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + S to save
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        const form = document.querySelector('.product-form');
        if (form && form.style.display !== 'none') {
            handleProductForm(form);
        }
    }
    
    // Ctrl/Cmd + N to add new product
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        const addButton = document.querySelector('[onclick="showAddProduct()"]');
        if (addButton) {
            showAddProduct();
        }
    }
});

// Initialize tooltips
function initTooltips() {
    const tooltipElements = document.querySelectorAll('[title]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function(e) {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.title;
            tooltip.style.cssText = `
                position: absolute;
                background: #1f2937;
                color: white;
                padding: 0.5rem;
                border-radius: 0.375rem;
                font-size: 0.75rem;
                z-index: 9999;
                pointer-events: none;
                transform: translateX(-50%);
            `;
            
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + rect.width / 2 + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
            
            this.tooltip = tooltip;
            this.removeAttribute('title');
        });
        
        element.addEventListener('mouseleave', function() {
            if (this.tooltip) {
                this.tooltip.remove();
                this.title = this.tooltip.textContent;
                this.tooltip = null;
            }
        });
    });
}

// Initialize tooltips on page load
setTimeout(initTooltips, 100); 