// Loja Plus Size JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initCart();
    initSearch();
    initProductInteractions();
    initNewsletter();
    initMobileMenu();
});

// Cart Management
let cart = JSON.parse(localStorage.getItem('bellacurves_cart')) || [];

function initCart() {
    updateCartCount();
    
    // Add to cart buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-to-cart')) {
            const productCard = e.target.closest('.product-card');
            if (productCard) {
                addToCart(productCard);
            }
        }
    });
}

function addToCart(productCard) {
    const product = {
        id: Date.now(), // Simulated ID
        name: productCard.querySelector('h3').textContent,
        price: productCard.querySelector('.current-price').textContent.replace('R$ ', ''),
        image: productCard.querySelector('img').src,
        quantity: 1
    };
    
    // Check if product already exists
    const existingProduct = cart.find(item => item.name === product.name);
    
    if (existingProduct) {
        existingProduct.quantity += 1;
        showNotification('Quantidade atualizada no carrinho!', 'success');
    } else {
        cart.push(product);
        showNotification('Produto adicionado ao carrinho!', 'success');
    }
    
    saveCart();
    updateCartCount();
}

function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    saveCart();
    updateCartCount();
    showNotification('Produto removido do carrinho!', 'info');
}

function updateCartCount() {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;
        
        // Animate if items were added
        if (totalItems > 0) {
            cartCount.style.transform = 'scale(1.2)';
            setTimeout(() => {
                cartCount.style.transform = 'scale(1)';
            }, 200);
        }
    }
}

function saveCart() {
    localStorage.setItem('bellacurves_cart', JSON.stringify(cart));
}

function getCartTotal() {
    return cart.reduce((total, item) => {
        const price = parseFloat(item.price.replace(',', '.'));
        return total + (price * item.quantity);
    }, 0);
}

// Search Functionality
function initSearch() {
    const searchInput = document.querySelector('.header-search input');
    const searchButton = document.querySelector('.header-search button');
    
    if (searchInput && searchButton) {
        searchButton.addEventListener('click', function(e) {
            e.preventDefault();
            performSearch(searchInput.value);
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch(this.value);
            }
        });
        
        // Live search suggestions
        searchInput.addEventListener('input', function() {
            if (this.value.length >= 2) {
                showSearchSuggestions(this.value);
            } else {
                hideSearchSuggestions();
            }
        });
    }
}

function performSearch(query) {
    if (!query.trim()) {
        showNotification('Digite algo para buscar!', 'warning');
        return;
    }
    
    const products = document.querySelectorAll('.product-card');
    let found = 0;
    
    products.forEach(product => {
        const title = product.querySelector('h3').textContent.toLowerCase();
        const isMatch = title.includes(query.toLowerCase());
        
        if (isMatch) {
            product.style.display = 'block';
            product.style.order = '-1'; // Move matched items to top
            found++;
        } else {
            product.style.display = 'none';
        }
    });
    
    if (found === 0) {
        showNotification(`Nenhum produto encontrado para "${query}"`, 'info');
    } else {
        showNotification(`${found} produto(s) encontrado(s)`, 'success');
    }
    
    // Scroll to products section
    document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
}

function showSearchSuggestions(query) {
    // Simulated suggestions
    const suggestions = [
        'Vestido floral',
        'Blusa social',
        'Calça jeans',
        'Conjunto íntimo',
        'Vestido longo',
        'Blusa básica'
    ].filter(item => item.toLowerCase().includes(query.toLowerCase()));
    
    if (suggestions.length > 0) {
        createSuggestionBox(suggestions);
    }
}

function createSuggestionBox(suggestions) {
    // Remove existing suggestions
    const existing = document.querySelector('.search-suggestions');
    if (existing) {
        existing.remove();
    }
    
    const suggestionBox = document.createElement('div');
    suggestionBox.className = 'search-suggestions';
    suggestionBox.style.cssText = `
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        z-index: 1000;
        max-height: 200px;
        overflow-y: auto;
    `;
    
    suggestions.forEach(suggestion => {
        const item = document.createElement('div');
        item.textContent = suggestion;
        item.style.cssText = `
            padding: 0.75rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s;
        `;
        
        item.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f9fafb';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.backgroundColor = 'transparent';
        });
        
        item.addEventListener('click', function() {
            document.querySelector('.header-search input').value = suggestion;
            performSearch(suggestion);
            hideSearchSuggestions();
        });
        
        suggestionBox.appendChild(item);
    });
    
    const searchContainer = document.querySelector('.header-search');
    searchContainer.style.position = 'relative';
    searchContainer.appendChild(suggestionBox);
}

function hideSearchSuggestions() {
    const suggestions = document.querySelector('.search-suggestions');
    if (suggestions) {
        suggestions.remove();
    }
}

// Product Interactions
function initProductInteractions() {
    // Quick view functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('quick-view')) {
            const productCard = e.target.closest('.product-card');
            showProductQuickView(productCard);
        }
    });
    
    // Product image hover effects
    const productImages = document.querySelectorAll('.product-image img');
    productImages.forEach(img => {
        img.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        img.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
}

function showProductQuickView(productCard) {
    const modal = createQuickViewModal(productCard);
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
    
    // Animate in
    setTimeout(() => {
        modal.style.opacity = '1';
        modal.querySelector('.quick-view-content').style.transform = 'scale(1)';
    }, 10);
}

function createQuickViewModal(productCard) {
    const product = {
        name: productCard.querySelector('h3').textContent,
        price: productCard.querySelector('.current-price').textContent,
        oldPrice: productCard.querySelector('.old-price')?.textContent || '',
        image: productCard.querySelector('img').src,
        sizes: productCard.querySelector('.sizes').textContent
    };
    
    const modal = document.createElement('div');
    modal.className = 'quick-view-modal';
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    `;
    
    modal.innerHTML = `
        <div class="quick-view-content" style="
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        ">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.5rem; font-weight: 600;">${product.name}</h2>
                <button class="close-quick-view" style="
                    background: none;
                    border: none;
                    font-size: 1.5rem;
                    cursor: pointer;
                    color: #6b7280;
                ">&times;</button>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <img src="${product.image}" alt="${product.name}" style="
                        width: 100%;
                        height: 300px;
                        object-fit: cover;
                        border-radius: 0.5rem;
                    ">
                </div>
                
                <div>
                    <div style="margin-bottom: 1rem;">
                        <span style="font-size: 1.5rem; font-weight: 600; color: #8b4f6b;">${product.price}</span>
                        ${product.oldPrice ? `<span style="font-size: 1rem; color: #6b7280; text-decoration: line-through; margin-left: 0.5rem;">${product.oldPrice}</span>` : ''}
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Tamanhos:</label>
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            ${product.sizes.split('|').map(size => `
                                <button class="size-option" style="
                                    padding: 0.5rem 1rem;
                                    border: 1px solid #d1d5db;
                                    border-radius: 0.375rem;
                                    background: white;
                                    cursor: pointer;
                                    transition: all 0.2s;
                                " onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='white'">${size.trim()}</button>
                            `).join('')}
                        </div>
                    </div>
                    
                    <button class="add-to-cart-quick" style="
                        width: 100%;
                        background: linear-gradient(135deg, #d4a574, #8b4f6b);
                        color: white;
                        border: none;
                        padding: 0.75rem 1.5rem;
                        border-radius: 0.5rem;
                        font-weight: 600;
                        cursor: pointer;
                        transition: transform 0.2s;
                    " onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        Adicionar ao Carrinho
                    </button>
                </div>
            </div>
            
            <div>
                <h3 style="font-weight: 600; margin-bottom: 1rem;">Descrição do Produto</h3>
                <p style="color: #6b7280; line-height: 1.6;">
                    Peça exclusiva da coleção Bella Curves, desenvolvida especialmente para valorizar suas curvas com 
                    elegância e conforto. Tecido de alta qualidade, modelagem diferenciada e acabamento impecável.
                </p>
            </div>
        </div>
    `;
    
    // Close modal functionality
    modal.querySelector('.close-quick-view').addEventListener('click', function() {
        closeQuickView(modal);
    });
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeQuickView(modal);
        }
    });
    
    // Add to cart from quick view
    modal.querySelector('.add-to-cart-quick').addEventListener('click', function() {
        addToCart(productCard);
        closeQuickView(modal);
    });
    
    // Size selection
    modal.querySelectorAll('.size-option').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all
            modal.querySelectorAll('.size-option').forEach(btn => {
                btn.style.backgroundColor = 'white';
                btn.style.borderColor = '#d1d5db';
            });
            
            // Add active class to clicked
            this.style.backgroundColor = '#d4a574';
            this.style.borderColor = '#d4a574';
            this.style.color = 'white';
        });
    });
    
    return modal;
}

function closeQuickView(modal) {
    modal.style.opacity = '0';
    modal.querySelector('.quick-view-content').style.transform = 'scale(0.9)';
    
    setTimeout(() => {
        document.body.removeChild(modal);
        document.body.style.overflow = 'auto';
    }, 300);
}

// Newsletter
function initNewsletter() {
    const newsletterForm = document.querySelector('.newsletter-form');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('input[type="email"]').value;
            
            if (validateEmail(email)) {
                // Simulate subscription
                showNotification('Obrigada! Você receberá nossas novidades em breve.', 'success');
                this.reset();
                
                // Store subscriber (simulation)
                const subscribers = JSON.parse(localStorage.getItem('newsletter_subscribers')) || [];
                if (!subscribers.includes(email)) {
                    subscribers.push(email);
                    localStorage.setItem('newsletter_subscribers', JSON.stringify(subscribers));
                }
            } else {
                showNotification('Por favor, insira um e-mail válido.', 'error');
            }
        });
    }
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Mobile Menu
function initMobileMenu() {
    const mobileMenuToggle = createMobileMenuToggle();
    
    // Add to header if mobile
    if (window.innerWidth <= 768) {
        const headerMain = document.querySelector('.header-main');
        headerMain.insertBefore(mobileMenuToggle, headerMain.firstChild);
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        const existingToggle = document.querySelector('.mobile-menu-toggle');
        const headerMain = document.querySelector('.header-main');
        
        if (window.innerWidth <= 768 && !existingToggle) {
            headerMain.insertBefore(createMobileMenuToggle(), headerMain.firstChild);
        } else if (window.innerWidth > 768 && existingToggle) {
            existingToggle.remove();
        }
    });
}

function createMobileMenuToggle() {
    const toggle = document.createElement('button');
    toggle.className = 'mobile-menu-toggle';
    toggle.innerHTML = '<i class="fas fa-bars"></i>';
    toggle.style.cssText = `
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #374151;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 0.375rem;
        display: none;
    `;
    
    if (window.innerWidth <= 768) {
        toggle.style.display = 'block';
    }
    
    toggle.addEventListener('click', function() {
        toggleMobileMenu();
    });
    
    return toggle;
}

function toggleMobileMenu() {
    const nav = document.querySelector('.main-nav');
    const isOpen = nav.style.display === 'block';
    
    if (isOpen) {
        nav.style.display = 'none';
    } else {
        nav.style.display = 'block';
        nav.style.position = 'absolute';
        nav.style.top = '100%';
        nav.style.left = '0';
        nav.style.right = '0';
        nav.style.background = 'white';
        nav.style.boxShadow = '0 4px 6px -1px rgb(0 0 0 / 0.1)';
        nav.style.borderRadius = '0.5rem';
        nav.style.padding = '1rem';
        nav.style.margin = '0.5rem';
        nav.style.zIndex = '1000';
    }
}

// Notifications
function showNotification(message, type = 'info') {
    // Remove existing notification
    const existing = document.querySelector('.notification');
    if (existing) {
        existing.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        color: white;
        font-weight: 500;
        z-index: 9999;
        max-width: 300px;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    `;
    
    // Set color based on type
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
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : type === 'warning' ? 'exclamation' : 'info'}-circle"></i>
            <span>${message}</span>
        </div>
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
    }, 4000);
}

// Smooth scrolling for anchor links
document.addEventListener('click', function(e) {
    if (e.target.tagName === 'A' && e.target.getAttribute('href').startsWith('#')) {
        e.preventDefault();
        const targetId = e.target.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
});

// Lazy loading for images
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Initialize lazy loading if supported
if ('IntersectionObserver' in window) {
    initLazyLoading();
}

// Cart preview on hover
document.addEventListener('mouseenter', function(e) {
    if (e.target.closest('.cart-link')) {
        showCartPreview();
    }
}, true);

document.addEventListener('mouseleave', function(e) {
    if (e.target.closest('.cart-link')) {
        setTimeout(() => {
            const preview = document.querySelector('.cart-preview');
            if (preview && !preview.matches(':hover')) {
                hideCartPreview();
            }
        }, 100);
    }
}, true);

function showCartPreview() {
    if (cart.length === 0) return;
    
    const existing = document.querySelector('.cart-preview');
    if (existing) return;
    
    const preview = document.createElement('div');
    preview.className = 'cart-preview';
    preview.style.cssText = `
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        width: 300px;
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
        padding: 1rem;
    `;
    
    let previewHTML = '<h3 style="margin-bottom: 1rem; font-size: 1rem; font-weight: 600;">Seu Carrinho</h3>';
    
    cart.forEach(item => {
        previewHTML += `
            <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                <img src="${item.image}" alt="${item.name}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 0.375rem;">
                <div style="flex: 1;">
                    <h4 style="font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem;">${item.name}</h4>
                    <p style="font-size: 0.75rem; color: #6b7280;">Qtd: ${item.quantity}</p>
                    <p style="font-size: 0.875rem; font-weight: 600; color: #8b4f6b;">R$ ${item.price}</p>
                </div>
            </div>
        `;
    });
    
    previewHTML += `
        <div style="border-top: 1px solid #e5e7eb; padding-top: 1rem; margin-top: 1rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                <span style="font-weight: 600;">Total:</span>
                <span style="font-weight: 600; color: #8b4f6b;">R$ ${getCartTotal().toFixed(2).replace('.', ',')}</span>
            </div>
            <button style="
                width: 100%;
                background: linear-gradient(135deg, #d4a574, #8b4f6b);
                color: white;
                border: none;
                padding: 0.75rem;
                border-radius: 0.375rem;
                font-weight: 600;
                cursor: pointer;
            ">Ver Carrinho</button>
        </div>
    `;
    
    preview.innerHTML = previewHTML;
    
    const cartLink = document.querySelector('.cart-link');
    cartLink.style.position = 'relative';
    cartLink.appendChild(preview);
}

function hideCartPreview() {
    const preview = document.querySelector('.cart-preview');
    if (preview) {
        preview.remove();
    }
} 