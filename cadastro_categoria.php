<?php

require_once('./config/config.php');
require_once('./CLASSES/Database.php');

require_once('./CLASSES/Categorias.php');


session_start();


$cat = new Categorias($db);



// Verifica se o usuário está logado, senão redireciona para o login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Lógica de cadastro de produto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
 

    // Inserir dados no banco de dados
     $cat->registrar($nome);
}   
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/cadastro_produto.css">
    <title>Cadastro de Categoria</title>
   
</head>

<body>
    <div class="container">
    <img src="./img/logo1.png" alt="Logo">  
        <h2>Cadastro de Produto</h2>

        <?php if (isset($mensagem)) { ?>
            <p class="success"><?php echo $mensagem; ?></p>
        <?php } ?>

        <?php if (isset($erro)) { ?>
            <p class="error"><?php echo $erro; ?></p>
        <?php } ?>

        <form  method="POST">
            <div class="form-group">
                <label for="nome">Nome do Categoria:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
           
            <button type="submit" name="cadastrar" class="button">Cadastrar Categoria</button><br>

            </form>

            <a href="visualizar_compras.php">Ir para Compras Cadastradas</a><br>

            <a href="menu.php">Voltar</a>
        
    </div>
</body>

</html>
