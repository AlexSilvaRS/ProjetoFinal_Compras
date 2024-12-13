<?php
session_start();

// Verifica se o usuário está logado, senão redireciona para o login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/menu.css">
    <title>Menu Principal</title>
    <link rel="shortcut icon" href="img/compras.png" type="image/png">

</head>

<body>

    <!-- <header>
        <div class="container">
            <h1>Clima ao Vivo 🌍</h1>
            <input type="text" id="city" placeholder="Digite o nome da cidade"><br>
            <button class="btn btn-dark" onclick="getWeather()">Buscar Clima</button>

            <div id="weather-info">
                <h2 id="city-name"></h2>
                <p id="temperature"></p>
                <p id="description"></p>
                <p id="humidity"></p>
                <p id="wind-speed"></p>
            </div>
        </div>
    </header> -->

    <div class="container">
        <img src="./img/logo1.png" alt="Logo">
        <h2>Bem-vindo ao Sistema de Compras</h2>
        <p>Escolha uma das opções abaixo:</p>
        <!-- Botões de navegação -->
        <a href="cadastro_produto.php">
            <button class="button">Cadastrar Produto</button>
        </a>
        <a href="cadastro_categoria.php">
            <button class="button">Cadastrar Categoria</button>
        </a>
        <a href="visualizar_compras.php">
            <button class="button">Compras Cadastradas</button>
        </a>
        <a href="visualizarComprasPorCategoria.php">
            <button class="button">Compras por Categoria</button>
        </a>
        
        <a href="login.php">Sair</a>
    </div>
    <script src="./CLASSES/clima.js"></script>
</body>

</html>