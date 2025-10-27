# 🍰 Sistema de Gestão da Doceria

Sistema completo para gestão de confeitaria com controle de insumos, compras, estoque e alertas.

## 🚀 Funcionalidades Implementadas

### ✅ Backend APIs
- **API de Insumos**: Cadastro, listagem, edição e exclusão de insumos
- **API de Compras**: Registro de compras com cálculo automático de custo unitário
- **API de Cálculos**: Cálculos de custo unitário, médio ponderado e análise de custos
- **API de Alertas**: Sistema de alertas para estoque mínimo e zerado
- **API de Receitas**: Gestão completa de receitas com ingredientes e custos
- **API de Validade**: Controle de validade de insumos com alertas automáticos

### ✅ Banco de Dados
- **Modelo completo** com tabelas para insumos, compras, receitas, controle de validade e alertas
- **Índices otimizados** para melhor performance
- **Dados de exemplo** incluindo receitas prontas para teste

### ✅ Frontend
- **Interface moderna** com design responsivo
- **Formulários dinâmicos** com validação em tempo real
- **Cálculo automático** de custo unitário e custo de receitas
- **Sistema de alertas** visual para estoque e validade
- **Gestão completa de receitas** com ingredientes e produção
- **Controle de validade** com alertas automáticos

## 📋 Estrutura do Projeto

```
PHP_confeitaria/
├── api/                    # APIs REST
│   ├── insumos.php        # API para gerenciar insumos
│   ├── compras.php        # API para registrar compras
│   ├── calculos.php       # API para cálculos de custo
│   ├── alertas.php        # API para alertas de estoque
│   ├── receitas.php       # API para gerenciar receitas
│   └── validade.php       # API para controle de validade
├── config/                # Configurações
│   └── database.php       # Conexão com banco de dados
├── database/              # Scripts de banco
│   └── schema.sql         # Schema completo do banco
├── models/                # Modelos de dados
│   ├── Insumo.php         # Modelo de insumos
│   ├── Compra.php         # Modelo de compras
│   ├── CalculadoraCusto.php # Cálculos de custo
│   ├── AlertaEstoque.php  # Alertas de estoque
│   ├── Receita.php        # Modelo de receitas
│   └── ControleValidade.php # Controle de validade
├── scripts/               # Scripts utilitários
│   ├── verificar_alertas.php # Verificação automática de alertas
│   └── verificar_validade.php # Verificação automática de validade
├── views/                # Interface do usuário
│   ├── home.php          # Página inicial
│   ├── registrar_compras.php # Registro de compras
│   ├── gerenciar_insumos.php # Gestão de insumos
│   ├── gerenciar_receitas.php # Gestão de receitas
│   ├── header.php        # Cabeçalho
│   └── footer.php        # Rodapé
└── assets/               # Recursos estáticos
    └── style.css         # Estilos CSS
```

## 🛠️ Instalação

### 1. Configurar Banco de Dados
```sql
-- Execute o arquivo database/schema.sql no seu MySQL
mysql -u root -p < database/schema.sql
```

### 2. Configurar Conexão
Edite o arquivo `config/database.php` com suas credenciais:
```php
private $host = 'localhost';
private $db_name = 'confeitaria_db';
private $username = 'seu_usuario';
private $password = 'sua_senha';
```

### 3. Configurar Servidor Web
- Coloque os arquivos em um servidor web (Apache/Nginx)
- Certifique-se que o PHP tem extensão PDO habilitada
- Configure o DocumentRoot para apontar para a pasta do projeto

### 4. Configurar Cron Jobs (Opcional)
Para verificação automática de alertas e validade:
```bash
# Adicione ao crontab para executar diariamente
0 9 * * * /usr/bin/php /caminho/para/scripts/verificar_alertas.php
0 8 * * * /usr/bin/php /caminho/para/scripts/verificar_validade.php
```

## 📖 Como Usar

### 1. Cadastrar Insumos
- Acesse "Gerenciar Insumos" na página inicial
- Clique em "Novo Insumo"
- Preencha os dados obrigatórios (nome, unidade de medida)
- Defina estoque mínimo para receber alertas

### 2. Registrar Compras
- Acesse "Registrar Compras"
- Selecione o insumo da lista
- Informe quantidade e preço total
- O sistema calcula automaticamente o custo unitário
- O estoque é atualizado automaticamente

### 3. Gerenciar Receitas
- Acesse "Gerenciar Receitas" na página inicial
- Crie novas receitas com ingredientes e instruções
- Adicione ingredientes às receitas existentes
- Registre produções para contabilizar uso de insumos
- Monitore custos de produção automaticamente

### 4. Controle de Validade
- Cadastre lotes de insumos com datas de validade
- Monitore alertas de produtos próximos ao vencimento
- Controle consumo por lote (FIFO - First In, First Out)
- Receba alertas automáticos de produtos vencidos

### 5. Monitorar Alertas
- Os alertas são gerados automaticamente quando o estoque fica baixo
- Alertas de validade são gerados para produtos próximos ao vencimento
- Visualize alertas em "Gerenciar Insumos" e "Gerenciar Receitas"
- Marque como visualizado após resolver o problema

## 🔧 APIs Disponíveis

### Insumos (`/api/insumos.php`)
- `GET` - Listar todos os insumos
- `GET?id=X` - Buscar insumo específico
- `POST` - Criar novo insumo
- `PUT` - Atualizar insumo
- `DELETE` - Excluir insumo

### Compras (`/api/compras.php`)
- `GET` - Listar todas as compras
- `GET?insumo_id=X` - Compras por insumo
- `POST` - Registrar nova compra
- `GET?estatisticas=1` - Estatísticas de compras

### Cálculos (`/api/calculos.php`)
- `GET?custo_unitario=1` - Calcular custo unitário
- `GET?custo_medio_ponderado=1` - Custo médio ponderado
- `POST` - Calcular custo de produção
- `POST` - Calcular margem de lucro

### Alertas (`/api/alertas.php`)
- `GET?verificar_alertas=1` - Verificar novos alertas
- `GET?nao_visualizados=1` - Listar alertas não visualizados
- `POST` - Marcar alerta como visualizado
- `GET?estatisticas=1` - Estatísticas de alertas

### Receitas (`/api/receitas.php`)
- `GET` - Listar todas as receitas
- `GET?id=X` - Buscar receita específica com ingredientes
- `POST` - Criar nova receita
- `POST` - Adicionar ingrediente à receita
- `POST` - Registrar produção
- `PUT` - Atualizar receita
- `DELETE` - Excluir receita

### Validade (`/api/validade.php`)
- `GET` - Listar todos os lotes
- `GET?proximos_vencer=1` - Lotes próximos ao vencimento
- `GET?vencidos=1` - Lotes vencidos
- `GET?alertas=1` - Alertas de validade
- `POST` - Cadastrar novo lote
- `POST` - Consumir quantidade do lote
- `GET?verificar_alertas=1` - Verificar alertas de validade

## 🎯 Próximos Passos

- [x] Sistema de receitas e cálculo de custo de produção
- [x] Controle de validade de insumos
- [ ] Relatórios de vendas e lucratividade
- [ ] Integração com sistema de vendas
- [ ] Dashboard com gráficos
- [ ] Sistema de usuários e permissões
- [ ] Backup automático do banco de dados
- [ ] Sistema de pedidos e encomendas

## 🐛 Solução de Problemas

### Erro de Conexão com Banco
- Verifique as credenciais em `config/database.php`
- Certifique-se que o MySQL está rodando
- Verifique se o banco `confeitaria_db` existe

### APIs não Respondem
- Verifique se o servidor web está configurado corretamente
- Certifique-se que a extensão PDO está habilitada no PHP
- Verifique os logs de erro do servidor

### Alertas não Funcionam
- Execute manualmente: `php scripts/verificar_alertas.php`
- Verifique se há insumos com estoque mínimo definido
- Confirme se o cron job está configurado corretamente

## 📝 Licença

Este projeto foi desenvolvido como parte de um projeto de extensão em PHP.