# Loja Plus Size - E-commerce Platform

Sistema de e-commerce completo com painel administrativo, carrinho de compras e integração com banco de dados.

## 🚀 URLs de Acesso

### Ambiente Local (XAMPP)
- **Site Principal**: http://localhost/projeto-ecommerce/loja-plus-size/
- **Loja**: http://localhost/projeto-ecommerce/loja-plus-size/loja/
- **Admin**: http://localhost/projeto-ecommerce/loja-plus-size/admin/
- **Carrinho**: http://localhost/projeto-ecommerce/loja-plus-size/loja/carrinho.php
- **Teste de Navegação**: http://localhost/projeto-ecommerce/loja-plus-size/test_navigation.php

### Produção (Hostinger)
- **Site Principal**: https://seudominio.com/
- **Loja**: https://seudominio.com/loja/
- **Admin**: https://seudominio.com/admin/
- **Carrinho**: https://seudominio.com/loja/carrinho.php
- **Teste de Navegação**: https://seudominio.com/test_navigation.php

## 📋 Pré-requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache/Nginx)
- XAMPP (para desenvolvimento local)

## 🛠️ Instalação

### 1. Clone o repositório
```bash
git clone https://github.com/seu-usuario/loja-plus-size.git
cd loja-plus-size
```

### 2. Configuração do Banco de Dados

#### Local (XAMPP)
1. Inicie o XAMPP (Apache e MySQL)
2. Crie o banco de dados:
```sql
CREATE DATABASE loja_plus_size;
```
3. Importe o arquivo `database.sql` no phpMyAdmin

#### Produção (Hostinger)
1. Acesse o painel da Hostinger
2. Crie um banco de dados MySQL
3. Importe o arquivo `database.sql` via phpMyAdmin
4. Configure as variáveis de ambiente no painel da Hostinger:
   - `DB_HOST`: host do banco (ex: auth-db1067.hstgr.io)
   - `DB_NAME`: nome do banco (ex: u819562010_lojaplussize)
   - `DB_USER`: usuário do banco (ex: u819562010_lojaplussize)
   - `DB_PASS`: senha do banco

### 3. Configuração Automática

O sistema detecta automaticamente se está rodando localmente ou em produção:

- **Local**: Usa configurações padrão do XAMPP
- **Produção**: Usa variáveis de ambiente da Hostinger

**Não é necessário editar arquivos de configuração manualmente!**

### 4. Permissões (Linux/Mac)
```bash
chmod 755 uploads/
chmod 755 uploads/products/
chmod 755 uploads/clients/
chmod 755 uploads/vendors/
```

## 🔧 Configuração das Variáveis de Ambiente (Hostinger)

1. Acesse o painel da Hostinger
2. Vá em "Configurações Avançadas" > "Variáveis de Ambiente"
3. Adicione as seguintes variáveis:
   ```
   DB_HOST=auth-db1067.hstgr.io
   DB_NAME=u819562010_lojaplussize
   DB_USER=u819562010_lojaplussize
   DB_PASS=sua_senha_aqui
   ```

## 📁 Estrutura do Projeto

```
loja-plus-size/
├── admin/                 # Painel administrativo
│   ├── index.php         # Dashboard principal
│   ├── products/         # Gerenciamento de produtos
│   ├── orders/           # Gerenciamento de pedidos
│   └── ...
├── loja/                 # Frontend da loja
│   ├── index.php         # Catálogo de produtos
│   ├── carrinho.php      # Carrinho de compras
│   └── ...
├── api/                  # APIs REST
│   ├── products.php      # API de produtos
│   ├── orders.php        # API de pedidos
│   └── ...
├── uploads/              # Uploads de imagens
├── config_database.php   # Configuração automática do banco
└── database.sql          # Estrutura do banco
```

## 🚀 Deploy Automático

### Primeira vez na Hostinger:
1. Clone o repositório no servidor
2. Configure as variáveis de ambiente no painel
3. Importe o banco de dados
4. Pronto! O site funcionará automaticamente

### Atualizações:
```bash
# No servidor Hostinger
git pull origin main
```
**Não é necessário reconfigurar nada!** O sistema detecta automaticamente o ambiente.

## 🔐 Segurança

- Credenciais de produção são armazenadas em variáveis de ambiente
- Nenhuma senha fica exposta no código
- Configuração automática por ambiente

## 📊 Funcionalidades

### 🎯 **Navegação Responsiva (NOVO!)**

O painel administrativo agora possui uma navegação completamente responsiva:

#### **Desktop (≥768px)**
- Sidebar sempre visível à esquerda
- Atalhos rápidos na horizontal
- Layout otimizado para telas grandes

#### **Mobile (<768px)**
- Sidebar oculta por padrão
- Botão hambúrguer para abrir/fechar
- Overlay para fechar a sidebar
- Atalhos rápidos reorganizados verticalmente
- Layout adaptado para touch

#### **Breadcrumbs Dinâmicos**
- Navegação atualizada automaticamente
- Mostra o caminho atual no sistema
- Links clicáveis para navegação rápida

#### **Atalhos Rápidos Contextuais**
- Mudam conforme a seção ativa
- Ações específicas para cada área
- Acesso rápido às funções principais

#### **Teste de Navegação**
Acesse `test_navigation.php` para testar todas as funcionalidades de navegação.

### Painel Administrativo
- ✅ Dashboard com estatísticas em tempo real
- ✅ Gerenciamento de produtos (CRUD completo)
- ✅ Gerenciamento de pedidos
- ✅ Gerenciamento de categorias
- ✅ Gerenciamento de clientes
- ✅ Relatórios de vendas
- ✅ Configurações do sistema
- ✅ **Navegação responsiva com sidebar mobile**
- ✅ **Breadcrumbs dinâmicos**
- ✅ **Atalhos rápidos contextuais**
- ✅ Sistema de notificações
- ✅ Modais interativos
- ✅ Paginação e filtros
- ✅ Validação de formulários
- ✅ Upload de imagens
- ✅ Atalhos de teclado (Ctrl+S, Ctrl+N)

### Loja (Frontend)
- ✅ Catálogo de produtos
- ✅ Carrinho de compras
- ✅ Sistema de checkout
- ✅ Histórico de pedidos
- ✅ Páginas de produto individuais

### APIs
- ✅ API REST para produtos
- ✅ API REST para pedidos
- ✅ API REST para categorias
- ✅ API REST para clientes
- ✅ API REST para dashboard

## 🐛 Solução de Problemas

### Erro 500
1. Verifique se as variáveis de ambiente estão configuradas (Hostinger)
2. Verifique se o banco de dados foi importado
3. Verifique os logs de erro do servidor

### Erro de Conexão com Banco
1. Verifique se o MySQL está rodando (local)
2. Verifique as credenciais do banco
3. Verifique se o banco de dados existe

### Páginas não carregam
1. Verifique se o Apache está rodando
2. Verifique as permissões dos arquivos
3. Verifique se o mod_rewrite está habilitado

## 📝 Logs de Alterações

### v3.0 - Navegação Responsiva
- ✅ Navegação responsiva com sidebar mobile
- ✅ Breadcrumbs dinâmicos
- ✅ Atalhos rápidos contextuais
- ✅ Layout adaptativo para desktop e mobile
- ✅ Overlay para fechar sidebar no mobile
- ✅ Teste de navegação implementado

### v2.0 - Deploy Automático
- ✅ Configuração automática por ambiente
- ✅ Variáveis de ambiente para produção
- ✅ Deploy sem configuração manual
- ✅ Segurança aprimorada

### v1.0 - Funcionalidades Básicas
- ✅ Painel administrativo completo
- ✅ Sistema de e-commerce básico
- ✅ APIs REST funcionais
- ✅ Interface responsiva

## 🤝 Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature
3. Commit suas mudanças
4. Push para a branch
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.

## 📞 Suporte

Para suporte, entre em contato através do painel administrativo ou abra uma issue no GitHub. 