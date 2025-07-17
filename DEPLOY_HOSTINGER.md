# 🚀 DEPLOY HOSTINGER - Guia Passo a Passo

## 📋 **PREPARAÇÃO ANTES DO DEPLOY**

### ✅ **O que já está configurado:**
- ✅ Banco de dados: `u819562010_lojaplussize`
- ✅ Usuário: `u819562010_lojaplussize`
- ✅ Senha: `Los@ngo081081`
- ✅ Arquivos de configuração atualizados
- ✅ Estrutura SQL completa pronta

---

## 🎯 **PASSO 1: ACESSO AO PAINEL HOSTINGER**

1. **Acesse:** https://hpanel.hostinger.com
2. **Login** com suas credenciais
3. **Selecione** o site: `peru-turkey-621361.hostingersite.com`

---

## 📊 **PASSO 2: CONFIGURAR BANCO DE DADOS**

### **2.1 Acessar phpMyAdmin:**
1. No painel Hostinger: **Bancos de Dados > Gerenciar**
2. Clique em **Entrar no phpMyAdmin**
3. Selecione banco: `u819562010_lojaplussize`

### **2.2 Importar Estrutura:**
1. No phpMyAdmin: **Importar**
2. **Escolher arquivo:** `database.sql`
3. **Executar** - Aguardar conclusão
4. **Verificar:** Deve criar 13 tabelas + dados

### **2.3 Verificar Importação:**
```sql
-- Execute estas queries para validar:
SHOW TABLES;
SELECT COUNT(*) FROM produtos;
SELECT COUNT(*) FROM categorias;
```

---

## 📁 **PASSO 3: UPLOAD DOS ARQUIVOS**

### **3.1 Via File Manager (Recomendado):**
1. **Website > File Manager**
2. Navegue até: `/public_html/`
3. **Upload** de toda pasta `loja-plus-size/`
4. **Extrair** se necessário

### **3.2 Via FTP (Alternativo):**
```
Host: peru-turkey-621361.hostingersite.com
Usuário: [seu usuário FTP]
Senha: [sua senha FTP]
Pasta: /public_html/loja-plus-size/
```

### **3.3 Estrutura Final no Servidor:**
```
/public_html/
└── loja-plus-size/
    ├── admin/
    ├── assets/
    ├── config.php
    ├── config_database.php
    ├── database.sql
    ├── index.php
    └── README.md
```

---

## ⚙️ **PASSO 4: CONFIGURAR PERMISSÕES**

### **4.1 Permissões Necessárias:**
```bash
# Via File Manager (clique direito > Permissões):
assets/         - 755
assets/images/  - 755
admin/          - 755

# Ou via terminal se disponível:
chmod -R 755 assets/
chmod -R 755 admin/
```

---

## 🧪 **PASSO 5: TESTES DE FUNCIONAMENTO**

### **5.1 Teste de Conexão:**
1. **Acesse:** `https://peru-turkey-621361.hostingersite.com/loja-plus-size/config_database.php`
2. **Deve aparecer:** ✅ Conexões funcionando!

### **5.2 Teste da Loja:**
1. **Frontend:** `https://peru-turkey-621361.hostingersite.com/loja-plus-size/`
2. **Verificar:** 
   - ✅ Página carrega
   - ✅ Produtos aparecem
   - ✅ Design está correto

### **5.3 Teste do Admin:**
1. **Admin:** `https://peru-turkey-621361.hostingersite.com/loja-plus-size/admin/`
2. **Verificar:**
   - ✅ Dashboard aparece
   - ✅ Produtos listados
   - ✅ Interface funcional

---

## 🔧 **PASSO 6: CONFIGURAÇÕES FINAIS**

### **6.1 Atualizar URLs nos Configs:**

**Edite `config.php`:**
```php
define('HTTP_SERVER', 'https://peru-turkey-621361.hostingersite.com/loja-plus-size/');
define('HTTPS_SERVER', 'https://peru-turkey-621361.hostingersite.com/loja-plus-size/');
```

**Edite `admin/config.php`:**
```php
define('HTTP_SERVER', 'https://peru-turkey-621361.hostingersite.com/loja-plus-size/admin/');
define('HTTP_CATALOG', 'https://peru-turkey-621361.hostingersite.com/loja-plus-size/');
```

### **6.2 Configurar SSL:**
1. **Painel Hostinger > SSL**
2. **Ativar SSL gratuito**
3. **Forçar HTTPS** (recomendado)

---

## ✅ **CHECKLIST FINAL DE DEPLOY**

```
[ ] Banco criado e importado (13 tabelas)
[ ] Arquivos enviados para servidor
[ ] Permissões configuradas (755)
[ ] URLs atualizadas nos configs
[ ] Teste de conexão OK
[ ] Frontend funcionando
[ ] Admin panel funcionando
[ ] SSL configurado
[ ] Backup do banco feito
```

---

## 🆘 **SOLUÇÃO DE PROBLEMAS**

### **❌ Erro de Conexão:**
```php
// Verifique em config.php:
define('DB_HOSTNAME', 'localhost');  // Correto para Hostinger
define('DB_USERNAME', 'u819562010_lojaplussize');
define('DB_PASSWORD', 'Los@ngo081081');
define('DB_DATABASE', 'u819562010_lojaplussize');
```

### **❌ Página em Branco:**
1. **Ativar erros:** Adicione no início do `index.php`:
```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

### **❌ Imagens não Carregam:**
1. **Verificar permissões** da pasta `assets/images/`
2. **Upload imagens reais** para substituir placeholders

### **❌ Admin não Funciona:**
1. **Verificar** se `admin/config.php` está correto
2. **Limpar cache** do navegador
3. **Testar** em navegador anônimo

---

## 📱 **URLS FINAIS DE ACESSO**

```
🛍️  LOJA FRONTEND:
https://peru-turkey-621361.hostingersite.com/loja-plus-size/

⚙️  PAINEL ADMIN:
https://peru-turkey-621361.hostingersite.com/loja-plus-size/admin/

🧪  TESTE CONEXÃO:
https://peru-turkey-621361.hostingersite.com/loja-plus-size/config_database.php
```

---

## 💾 **BACKUP E MANUTENÇÃO**

### **Backup Regular:**
```sql
-- Via phpMyAdmin: Exportar > SQL
-- Arquivo: backup_loja_YYYYMMDD.sql
```

### **Monitoramento:**
```sql
-- Verificar produtos
SELECT COUNT(*) FROM produtos WHERE status = 'ativo';

-- Verificar pedidos (quando houver)
SELECT COUNT(*) FROM pedidos WHERE DATE(created_at) = CURDATE();
```

---

## 🎉 **DEPLOY CONCLUÍDO!**

Após seguir todos os passos, sua **Loja Plus Size** estará:

- ✅ **Online** e funcionando
- ✅ **Banco** configurado com produtos
- ✅ **Admin** pronto para gestão
- ✅ **SSL** ativo e seguro
- ✅ **Pronta** para receber clientes!

**🚀 Boa sorte com sua loja Plus Size!** 