📚 Sistema de Biblioteca

Sistema web de gerenciamento de biblioteca desenvolvido em PHP e MySQL.

O projeto permite cadastrar e gerenciar livros e autores, além de possuir autenticação de usuários e sistema de empréstimos.

Funcionalidades
Livros
Cadastrar livros
Listar livros
Editar livros
Excluir livros
Associar livros a autores
Usuários
Criar conta
Login
Logout
Sessões de usuário
Proteção de páginas privadas
Senhas armazenadas utilizando password_hash()
Empréstimos
Solicitar empréstimo de um livro
Impedir empréstimo de livros que já estão emprestados
Visualizar os próprios empréstimos
Devolver livros
Controlar data de empréstimo e devolução
Controlar status do empréstimo
Tecnologias
PHP 8
MySQL
HTML5
CSS3
Apache
XAMPP
Banco de dados

O sistema utiliza um banco de dados relacional com as seguintes entidades principais:

usuarios
    │
    │
    ▼
emprestimos
    │
    │
    ▼
livro
    │
    │
    ▼
autor

Os empréstimos possuem relacionamento com o usuário e com o livro.

Como executar
1. Instale o XAMPP

Instale o XAMPP e inicie:

Apache
MySQL
2. Clone o projeto

Coloque o projeto dentro da pasta:

htdocs/
3. Crie o banco de dados

No phpMyAdmin, crie um banco chamado:

biblioteca

Depois execute o script SQL do projeto para criar as tabelas.

4. Configure o banco

Configure as informações de conexão no arquivo database.php.

Exemplo:

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "biblioteca"
);
5. Execute

Acesse:

http://localhost/website/
Objetivo

Projeto desenvolvido para praticar desenvolvimento web, PHP, SQL, autenticação, sessões, CRUD e relacionamentos em banco de dados.
