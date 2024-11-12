# Gerenciamento de Associados
Um software para facilitar a gerência dos associados e suas anuidades.

## Como usar
Primeiramente,

Agora, clone o repositório:
- `git clone ...`

# Sistema de Gerenciamento de Associação - Devs do RN

Este é um sistema simples de gerenciamento de associados para a associação Devs do RN. O sistema permite o cadastro de associados e anuidades, a cobrança e o pagamento das anuidades, além de identificação de associados com pagamento em dia ou em atraso. 

## Funcionalidades

- **Cadastro de Associados**: Nome, E-mail, CPF e Data de Filiação.
- **Cadastro de Anuidades**: Ano e Valor, permitindo o ajuste do valor pelo gerente.
- **Cobrança de Anuidades**: Calcula o valor devido por anuidade e o valor total devido, baseado na data de filiação.
- **Pagamento de Anuidade**: Permite marcar uma anuidade como paga ou como pendente.
- **Listagem de Associados**: Identifica automaticamente os associados em dia ou em atraso com base nas anuidades.

## Pré-requisitos

- `PHP`
- `PostgreSQL`

Garanta também que as seguintes extensões estejam habilitadas na instalação do seu PHP:
- `pdo_pgsql`
- `pgsql`

## Configuração do Projeto

### Passo 1: Clonar o repositório

Clone o repositório do projeto em seu ambiente local com o comando:

```bash
git clone https://github.com/gili-julio/PhpApp.git
```

### Passo 2: Configuração do Banco de Dados

1. Crie um banco de dados PostgreSQL:
```sql
-- Criação do banco de dados
CREATE DATABASE devs_do_rn;
```
2. Importe a estrutura do banco de dados a partir do arquivo `meu_database.sql` que está na raiz do projeto:
```bash
psql -U seu_usuario -d devs_do_rn -f meu_database.sql
```
### Passo 3: Configuração do Projeto

No arquivo `db.php`, configure as informações de conexão do banco de dados de acordo com o seu ambiente:
```php
<?php
$host = 'localhost'; 
$dbname = 'devs_do_rn';
$user = 'seu_usuario';
$password = 'sua_senha';
$pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
?>
```

### Passo 4: Executando o Projeto

1. Inicie um servidor PHP embutido no diretório do projeto:
```bash
php -S localhost:8000
```
2. Acesse a aplicação no navegador:
```url
http://localhost:8000
```

## Estrutura do Projeto
- `index.php`: Página inicial que lista todos os associados e seu status de pagamento.
- `listar_anuidades.php`: Página que lista todas as anuidades e seus valores.
- `cadastrar_associado.php`: Formulário para cadastrar novos associados.
- `cadastrar_anuidade.php`: Formulário para cadastrar e editar anuidades.
- `cobranca_associado.php`: Página para ver um associado específico.