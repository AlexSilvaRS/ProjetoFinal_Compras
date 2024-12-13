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

// Lógica de cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar'])) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Validar se as senhas coincidem
    if ($senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem.";
    } else {
        // Prevenção de SQL Injection
        $usuario = $conn->real_escape_string($usuario);
        $senha = $conn->real_escape_string($senha);

        // Verificar se o usuário já existe
        $sql = "SELECT * FROM usuarios WHERE username='$usuario'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $erro = "Usuário já existe. Tente outro nome de usuário.";
        } else {
            // Hash da senha antes de salvar
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            // Inserir o novo usuário no banco de dados
            $sql = "INSERT INTO usuarios (username, password) VALUES ('$usuario', '$senha_hash')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['usuario'] = $usuario; // Logar o usuário automaticamente após cadastro
                header("Location: login.php"); // Redireciona para a página de login
                exit;
            } else {
                $erro = "Erro ao cadastrar usuário: " . $conn->error;
            }
        }
    }
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/cadastro_usuario.css">
    <title>Cadastro de Usuário</title>
    <link rel="shortcut icon" href="img/compras.png" type="image/png">
</head>

<body>
    <div class="container">
        <img src="./img/logo1.png" alt="Logo">
        <h2>Cadastro de Usuário</h2>

        <?php if (isset($erro)) { ?>
            <p class="error"><?php echo $erro; ?></p>
        <?php } ?>

        <form action="cadastro_usuario.php" method="POST">
            <div class="form-group">
                <label for="usuario">Nome de Usuário:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="confirmar_senha">Confirmar Senha:</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" required>
            </div>
            <button type="submit" name="cadastrar" class="button">Cadastrar</button>
        </form>

        <p>Já tem uma conta? <a href="login.php">Faça login aqui</a></p>
    </div>
</body>

</html>