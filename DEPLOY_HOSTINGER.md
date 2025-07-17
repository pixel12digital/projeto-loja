# 🚀 Guia de Deploy na Hostinger - Deploy Automático

Este guia mostra como fazer o deploy do projeto na Hostinger **sem precisar editar arquivos manualmente**.

## ✅ Pré-requisitos

- Conta na Hostinger com plano que suporte PHP e MySQL
- Acesso ao painel da Hostinger (hPanel)
- Acesso SSH (opcional, mas recomendado)

## 📋 Passo a Passo

### 1. Preparar o Repositório

Certifique-se de que o repositório está atualizado com as configurações automáticas:

```bash
# Local
git add .
git commit -m "Configuração automática para deploy"
git push origin main
```

### 2. Acessar o Servidor

#### Via SSH (Recomendado)
```bash
ssh u819562010@seudominio.com
cd public_html
```

#### Via File Manager (Alternativo)
- Acesse o hPanel da Hostinger
- Vá em "Gerenciador de Arquivos"
- Navegue até `public_html`

### 3. Fazer Deploy

#### Opção A: Clone via SSH
```bash
# Remover arquivos padrão (se existirem)
rm -rf *

# Clonar o repositório
git clone https://github.com/seu-usuario/loja-plus-size.git .

# Ou se preferir manter em subpasta:
# git clone https://github.com/seu-usuario/loja-plus-size.git loja
```

#### Opção B: Upload via File Manager
1. Baixe o ZIP do repositório no GitHub
2. Faça upload via File Manager
3. Extraia os arquivos

### 4. Configurar Banco de Dados

#### 4.1 Criar Banco de Dados
1. No hPanel, vá em "Bancos de Dados" > "MySQL"
2. Crie um novo banco de dados
3. Anote as credenciais:
   - **Host**: `auth-db1067.hstgr.io`
   - **Nome**: `u819562010_lojaplussize`
   - **Usuário**: `u819562010_lojaplussize`
   - **Senha**: (a que você definiu)

#### 4.2 Importar Estrutura
1. Acesse o phpMyAdmin
2. Selecione o banco criado
3. Vá em "Importar"
4. Selecione o arquivo `database.sql`
5. Clique em "Executar"

### 5. Configurar Variáveis de Ambiente

#### 5.1 Via hPanel
1. No hPanel, vá em "Configurações Avançadas" > "Variáveis de Ambiente"
2. Adicione as seguintes variáveis:

```
DB_HOST=auth-db1067.hstgr.io
DB_NAME=u819562010_lojaplussize
DB_USER=u819562010_lojaplussize
DB_PASS=sua_senha_aqui
```

#### 5.2 Via .htaccess (Alternativo)
Se a Hostinger não suportar variáveis de ambiente, crie um arquivo `.htaccess`:

```apache
SetEnv DB_HOST auth-db1067.hstgr.io
SetEnv DB_NAME u819562010_lojaplussize
SetEnv DB_USER u819562010_lojaplussize
SetEnv DB_PASS sua_senha_aqui
```

### 6. Configurar Permissões

```bash
# Via SSH
chmod 755 uploads/
chmod 755 uploads/products/
chmod 755 uploads/clients/
chmod 755 uploads/vendors/

# Ou via File Manager
# Clique com botão direito nas pastas e defina permissão 755
```

### 7. Testar o Site

Acesse seu domínio:
- **Site Principal**: https://seudominio.com/
- **Loja**: https://seudominio.com/loja/
- **Admin**: https://seudominio.com/admin/

## 🔄 Atualizações Futuras

### Via SSH (Recomendado)
```bash
# No servidor
cd public_html
git pull origin main
```

### Via File Manager
1. Baixe a nova versão do GitHub
2. Faça upload dos arquivos atualizados
3. Substitua os arquivos existentes

**Importante**: As variáveis de ambiente permanecem intactas após atualizações!

## 🐛 Solução de Problemas

### Erro 500
1. **Verifique os logs**:
   ```bash
   # Via SSH
   tail -f error_log
   
   # Ou no hPanel: Logs > Error Logs
   ```

2. **Verifique as variáveis de ambiente**:
   ```php
   // Adicione temporariamente no index.php
   var_dump(getenv('DB_HOST'));
   var_dump(getenv('DB_NAME'));
   ```

### Erro de Conexão com Banco
1. Verifique se as credenciais estão corretas
2. Verifique se o banco foi importado
3. Teste a conexão via phpMyAdmin

### Páginas não carregam
1. Verifique se o mod_rewrite está habilitado
2. Verifique as permissões dos arquivos
3. Verifique se o PHP está na versão correta (7.4+)

## 🔐 Segurança

- ✅ Credenciais em variáveis de ambiente
- ✅ Nenhuma senha no código
- ✅ Configuração automática por ambiente
- ✅ Arquivos sensíveis protegidos

## 📞 Suporte

Se encontrar problemas:

1. **Verifique os logs de erro**
2. **Teste localmente primeiro**
3. **Compare com a configuração local**
4. **Entre em contato com o suporte da Hostinger**

## ✅ Checklist de Deploy

- [ ] Repositório atualizado
- [ ] Banco de dados criado
- [ ] Estrutura importada
- [ ] Variáveis de ambiente configuradas
- [ ] Permissões definidas
- [ ] Site testado
- [ ] Admin funcionando
- [ ] Loja funcionando

---

**🎉 Parabéns! Seu site está no ar com deploy automático!** 