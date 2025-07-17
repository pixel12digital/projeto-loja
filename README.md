# 🛍️ Loja Plus Size - E-commerce Bella Curves

Um sistema de e-commerce completo desenvolvido em PHP, com painel administrativo robusto e front-end responsivo.

## ✨ Funcionalidades Implementadas

### 🎛️ **Painel Administrativo**
- ✅ Dashboard com estatísticas em tempo real
- ✅ Gestão completa de produtos (CRUD)
- ✅ Gestão de categorias
- ✅ Gestão de pedidos
- ✅ Gestão de clientes
- ✅ Configurações do sistema
- ✅ Sistema de notificações
- ✅ Interface responsiva e moderna

### 🛒 **Loja Pública**
- ✅ Listagem de produtos
- ✅ Página individual de produto
- ✅ Carrinho de compras
- ✅ Checkout básico
- ✅ Layout responsivo

### 🗄️ **Banco de Dados**
- ✅ Estrutura completa e otimizada
- ✅ Dados de exemplo incluídos
- ✅ Configuração automática local/produção

## 🚀 Instalação

### **Local (XAMPP)**
```bash
# 1. Clone o projeto
git clone [url-do-repositorio]

# 2. Configure o banco
# - Inicie XAMPP (Apache + MySQL)
# - Crie banco 'loja_plus_size'
# - Importe database.sql

# 3. Acesse
# Loja: http://localhost/projeto-ecommerce/loja-plus-size/loja/
# Admin: http://localhost/projeto-ecommerce/loja-plus-size/admin/
```

### **Produção (Hostinger)**
Veja o guia completo: [INSTALACAO.md](INSTALACAO.md)

## 📁 Estrutura do Projeto

```
loja-plus-size/
├── admin/                    # Painel administrativo
│   ├── index.php            # Dashboard principal
│   ├── produtos_api.php     # API de produtos
│   ├── pedidos_api.php      # API de pedidos
│   └── ...
├── loja/                     # Front-end da loja
│   ├── index.php            # Listagem de produtos
│   ├── produto.php          # Página do produto
│   ├── carrinho.php         # Carrinho de compras
│   └── checkout.php         # Finalização da compra
├── assets/                   # Recursos estáticos
│   ├── css/                 # Estilos
│   ├── js/                  # JavaScript
│   └── img/                 # Imagens
├── uploads/                  # Uploads de usuários
├── config_database.php      # Configuração do banco
├── database.sql             # Estrutura do banco
└── README.md                # Este arquivo
```

## 🛠️ Tecnologias Utilizadas

- **Backend**: PHP 7.4+, PDO, MySQL
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Banco**: MySQL 5.7+ / MariaDB 10.2+
- **Servidor**: Apache/Nginx

## 📊 Status do Projeto

- **Versão**: 1.0
- **Status**: Em desenvolvimento ativo
- **Progresso**: 13.3% completo

Veja o roadmap completo: [ROADMAP_ECOMMERCE.md](ROADMAP_ECOMMERCE.md)

## 🔧 Configuração

### **Ambiente Local**
O projeto detecta automaticamente se está rodando em localhost e usa as configurações apropriadas.

### **Ambiente de Produção**
1. Copie `config_database.example.php` para `config_database.php`
2. Configure suas credenciais de banco de dados
3. Importe o arquivo `database.sql`

## 🎯 Próximas Implementações

1. **Galeria de imagens avançada** na página de produto
2. **Sistema de cadastro/login** para clientes
3. **Integração de pagamentos** (PIX)
4. **Cálculo de frete** com Correios
5. **E-mails transacionais**

## 📝 Changelog

### **v1.0 (17/07/2025)**
- ✅ Sistema base implementado
- ✅ Painel admin funcional
- ✅ Loja pública básica
- ✅ Banco de dados estruturado
- ✅ Página de produto individual
- ✅ Roadmap de desenvolvimento criado

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 📞 Suporte

- **Documentação**: [INSTALACAO.md](INSTALACAO.md)
- **Roadmap**: [ROADMAP_ECOMMERCE.md](ROADMAP_ECOMMERCE.md)
- **Issues**: Use o sistema de issues do GitHub

---

**Desenvolvido com ❤️ para a Bella Curves** 