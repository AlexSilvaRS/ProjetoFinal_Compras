<?php

require_once('./config/config.php');
require_once('./CLASSES/Database.php');
require_once('./CLASSES/Compras.php');
require_once('./CLASSES/Categorias.php');

session_start();

$compra = new Compras($db);
$cat = new Categorias($db);

$listaCat = $cat->lerTodos();

// Verifica se o usuário está logado, senão redireciona para o login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Lógica de cadastro de produto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $fkidcategoria = $_POST['categoria'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];
    $data_compra = $_POST['data_compra'];

    // Inserir dados no banco de dados
    if ($compra->registrar($nome, $fkidcategoria, $quantidade, $preco, $data_compra)) {
        $mensagem = "Produto cadastrado com sucesso!";
    } else {
        $erro = "Erro ao cadastrar o produto. Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/cadastro_produto.css">
    <title>Cadastro de Produto</title>
</head>

<body>
    <div class="container">
        <img src="./img/logo1.png" alt="Logo">
        <h2>Cadastro de Produto</h2>

        <!-- Mensagens de sucesso ou erro -->
        <?php if (isset($mensagem)) { ?>
            <p class="success"><?php echo $mensagem; ?></p>
        <?php } ?>

        <?php if (isset($erro)) { ?>
            <p class="error"><?php echo $erro; ?></p>
        <?php } ?>

        <form action="cadastro_produto.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="categoria">Categoria:</label>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecione a categoria</option>
                    <?php
                    // Preenchendo a combobox com as categorias do banco
                    foreach ($listaCat as $categoria) {
                        echo "<option value='{$categoria['id_categoria']}'>{$categoria['nome_categoria']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" required>
            </div>
            <div class="form-group">
                <label for="preco">Preço (R$):</label>
                <input type="number" id="preco" name="preco" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="data_compra">Data da Compra:</label>
                <input type="datetime-local" id="data_compra" name="data_compra" required>
            </div>
            <button type="submit" name="cadastrar" class="button">Cadastrar Produto</button><br>
        </form>

        <a href="visualizar_compras.php">Ir para Compras Cadastradas</a><br>
        <a href="menu.php">Voltar</a>
    </div>
</body>

</html>
