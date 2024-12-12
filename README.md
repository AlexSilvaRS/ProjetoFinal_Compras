# Projeto Final - SISTEMA DE COMPRAS - Desenvolvimento em PHP

## Descrição

Este é o projeto final do curso, onde o objetivo é desenvolver um sistema de compras utilizando PHP, MySQL, HTML, CSS, JavaScript, XAMPP para banco de dados. O sistema tem funcionalidades essenciais de CRUD, autenticação de usuários, validação de dados e uma interface responsiva, além de incluir um requisito especial.

## Tecnologias Utilizadas

- **Linguagens**:
  - PHP
  - MySQL
  - HTML
  - CSS
  - JavaScript
  
- **Frameworks e Bibliotecas**:
  - COMPOSER (Para gerar arquivo em excel)
  
- **Banco de Dados**:
  - MySQL (via XAMPP, utilizando o phpMyAdmin para gerenciamento)

### 1. CRUDs Funcionais
Cada entidade no sistema permiti:
- Criar registros
- Listar registros
- Editar registros
- Excluir registros

### 2. Autenticação de Usuários
- **Login** com senha segura (mínimo 8 caracteres, incluindo letras, números e caracteres especiais)
- **Logout** funcional

### 3. Validação de Dados
- Validações tanto no frontend (JavaScript) quanto no backend (PHP)
  - Campos obrigatórios
  - Formatos válidos (ex.: e-mails, CPF, etc.)

### 4. Interface Responsiva
- Layout adaptável a diferentes tamanhos de tela
  - Uso do Bootstrap ou outro framework para garantir responsividade

## Requisitos Especiais

- **Consumo de API Externa**:
  - API OpenWeather: exibição da previsão do tempo

- **Geração de Relatórios em PDF**:
  - Criação de relatórios dinâmicos que podem ser baixados pelo usuário
  em PDF ou EXCEL.

- **Paginação e Filtro em Listagens**:
  - Implementação de paginação nas tabelas do sistema
  - Inclusão de busca avançada para facilitar a filtragem de dados

## Estrutura do Projeto

A estrutura de pastas para o projeto é a seguinte:

/ProjetoFinal_<COMPRAS>/ /CLASSES/ /CONFIG/ /CSS/ /IMG/ /SRC/ /vendor/ (para bibliotecas externas como PHPMailer ou DOMPDF)/ /PHP/ /COMPOSER/ (Para fazer download dos arquivos em EXCEL) /README.md

### Banco de Dados
- Utilizei o XAMPP para configurar o servidor Apache e MySQL.
- O banco de dados é gerenciado através do **phpMyAdmin**.
- Defini tabelas para as entidades do sistema, como `usuarios`, `compras`, `categorias`.

## Como Executar o Projeto

1. **Instalar o XAMPP**:
   - Baixe e instale o XAMPP (https://www.apachefriends.org/).
   - Inicie o servidor Apache e MySQL.

2. **Criar o Banco de Dados**:
   - Acesse o phpMyAdmin (http://localhost/phpmyadmin) e crie o banco de dados necessário para o projeto.

3. **Configuração do Projeto**:
   - Coloque os arquivos do projeto na pasta `htdocs` do XAMPP.
   - Certifique-se de configurar corretamente as credenciais de conexão ao banco de dados no arquivo PHP responsável pela conexão.

4. **Acessar o Sistema**:
   - Acesse o sistema pelo navegador utilizando `http://localhost/compras/tela_inicial.php>`.

## Estrutura de Entregas

- **Datas Importantes**:
  - **Definição do Tema**: Até [data]
  - **Protótipo Inicial**: Até [data]
  - **Entrega Final**: Até [data]

## Checklist de Requisitos

- [ ] CRUD de **[USUARIOS]**.
- [ ] CRUD de **[COMPRAS]**.
- [ ] CRUD de **[CATEGORIAS]**.
- [ ] Login funcional.
- [ ] Escolha do requisito especial: **[APIOpenWeather]**.
- [ ] Responsividade implementada.
- [ ] Validações no frontend e backend.

---

