<?php
session_start();

// Variáveis de conexão com o banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "compras";

// Conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Lógica de login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Prevenção de SQL Injection utilizando prepared statements
    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);  // 's' para string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario_data = $result->fetch_assoc();

        // Verificar se a senha confere
        if (password_verify($senha, $usuario_data['password'])) {
            // Login bem-sucedido, armazenar sessão
            $_SESSION['usuario'] = $usuario;
            header("Location: menu.php"); // Redireciona para a página de cadastro de produto após o login
            exit;
        } else {
            $erro = "Usuário ou senha inválidos.";
        }
    } else {
        $erro = "Usuário ou senha inválidos.";
    }

    // Fechar a declaração
    $stmt->close();
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <title>Login de Usuário</title>
    <link rel="shortcut icon" href="./img/Logo2.png" type="image/Logo2.png">

</head>

<body>

    <header>
        <div class="container">
        <h1>Clima ao Vivo 🌍</h1>
            <input type="text" id="city" placeholder="Digite o nome da cidade">
            <button class="btn btn-dark" onclick="getWeather()">Buscar Clima</button>
        </div>
            <div class="weather-info">
                <h2 id="city-name"></h2>
                <p id="temperature"></p>
            </div>
            <div class="weather-info">
                <p id="description"></p>
                <p id="humidity"></p>
                <p id="wind-speed"></p>
            </div>
       
    </header>

    <div class="login-container">
        <img src="./img/Logo1.png" alt="Logo">

        <h2>Login de Usuário</h2>

        <?php if (isset($erro)) { ?>
            <p class="error"><?php echo $erro; ?></p>
        <?php } ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="usuario">Usuário:</label>
                <input type="text" id="usuario" name="usuario" required>

            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit" name="login" class="button">Entrar</button><br>
            <button onclick="window.location.href='tela_inicial.php'" class="button voltar">Voltar</button>

        </form>

        <p>Não tem uma conta? <a href="cadastro_usuario.php">Cadastre-se aqui</a></p>
    </div>
    <script src="./CLASSES/clima.js"></script>
</body>

</html>