# 🚀 Guia de Instalação - Loja Plus Size

## 📋 Pré-requisitos
- Servidor web com PHP 7.4+ (Apache/Nginx)
- MySQL 5.7+ ou MariaDB 10.2+
- Extensões PHP: PDO, PDO_MySQL, GD, mbstring

## 🔧 Instalação na Hostinger

### 1. **Upload dos Arquivos**
1. Faça upload de todos os arquivos para a pasta `public_html` do seu hosting
2. Ou crie uma subpasta (ex: `loja`) e faça upload dentro dela

### 2. **Configuração do Banco de Dados**
1. Acesse o painel da Hostinger → MySQL Databases
2. Crie um novo banco de dados
3. Crie um usuário e associe ao banco
4. Anote as credenciais:
   - Host: `auth-dbXXXX.hstgr.io`
   - Database: `uXXXXXXX_nome_do_banco`
   - Username: `uXXXXXXX_usuario`
   - Password: `sua_senha`

### 3. **Configuração do Projeto**
1. Copie `config_database.example.php` para `config_database.php`
2. Edite `config_database.php` e atualize as configurações de produção:
   ```php
   define('DB_HOST', 'auth-dbXXXX.hstgr.io');
   define('DB_NAME', 'uXXXXXXX_nome_do_banco');
   define('DB_USER', 'uXXXXXXX_usuario');
   define('DB_PASS', 'sua_senha');
   ```

### 4. **Importar Estrutura do Banco**
1. Acesse o phpMyAdmin da Hostinger
2. Selecione seu banco de dados
3. Vá na aba "Importar"
4. Selecione o arquivo `database.sql`
5. Clique em "Executar"

### 5. **Configurar Permissões**
1. Crie a pasta `uploads/` se não existir
2. Configure permissões 755 para as pastas:
   - `uploads/`
   - `uploads/products/`
   - `uploads/clients/`
   - `uploads/vendors/`

### 6. **Testar Instalação**
1. Acesse: `https://seudominio.com/loja/`
2. Acesse o admin: `https://seudominio.com/loja/admin/`

## 🔧 Instalação Local (XAMPP)

### 1. **Configuração**
1. Coloque os arquivos em `C:\xampp\htdocs\projeto-ecommerce\loja-plus-size\`
2. O arquivo `config_database.php` já está configurado para local

### 2. **Banco de Dados**
1. Inicie o XAMPP (Apache + MySQL)
2. Acesse: `http://localhost/phpmyadmin`
3. Crie um banco chamado `loja_plus_size`
4. Importe o arquivo `database.sql`

### 3. **Acessar**
- Loja: `http://localhost/projeto-ecommerce/loja-plus-size/loja/`
- Admin: `http://localhost/projeto-ecommerce/loja-plus-size/admin/`

## 🔐 Credenciais Padrão
- **Admin**: Não há login implementado ainda (será adicionado em breve)
- **Cliente**: Sistema de cadastro será implementado

## 📁 Estrutura de Arquivos
```
loja-plus-size/
├── admin/           # Painel administrativo
├── loja/            # Front-end da loja
├── assets/          # CSS, JS, imagens
├── uploads/         # Uploads de usuários
├── config_database.php
├── database.sql
└── README.md
```

## 🚨 Troubleshooting

### Erro de Conexão com Banco
- Verifique se as credenciais estão corretas
- Confirme se o banco foi criado
- Teste a conexão no phpMyAdmin

### Página em Branco
- Verifique os logs de erro do PHP
- Confirme se todas as extensões estão instaladas
- Teste com `error_reporting(E_ALL);`

### Uploads Não Funcionam
- Verifique as permissões das pastas
- Confirme se o PHP tem permissão de escrita
- Teste o upload de um arquivo simples

## 📞 Suporte
Para dúvidas ou problemas, consulte:
- Documentação do projeto
- Logs de erro do servidor
- Comunidade de desenvolvedores

---
*Versão: 1.0 | Última atualização: 17/07/2025* 