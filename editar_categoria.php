<?php
session_start();

// Verifica se o usuário está logado, senão redireciona para o login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Conexão com o banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "compras";

$conn = new mysqli($host, $username, $password, $dbname);

// Aqui vejo se a conexão esta funcionandol
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o ID da compra foi passado na URL
if (isset($_GET['idcategoria'])) {
    $id_categoria = $_GET['idcategoria'];

    // Consulta a compra com o ID fornecido
    $sql = "SELECT * FROM categorias WHERE id_categoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<script>alert('Categoria não encontrada.'); window.location.href = 'visualizar_categoria.php';</script>";
        exit;
    }

    // Obter os dados da compra
    $categoria = $result->fetch_assoc();

    // Fechar a conexão
    $stmt->close();
} else {
    echo "<script>alert('ID não fornecido.'); window.location.href = 'visualizar_categoria.php';</script>";
    exit;
}

// Verificar se o formulário foi enviado para editar a compra
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
   

    // Atualizar os dados da compra
    $sql_atualizar = "UPDATE categorias SET nome_categoria = ? WHERE id_categoria = ?";
    $stmt = $conn->prepare($sql_atualizar);
    $stmt->bind_param("sidi", $nome,$id_categoria);

    if ($stmt->execute()) {
        echo "<script>alert('Compra atualizada com sucesso!'); window.location.href = 'visualizar_compras.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar a compra. Tente novamente.');</script>";
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/editar_compra.css">
    <title>Editar Compra</title>
    <link rel="shortcut icon" href="img/compras.png" type="image/png">
    
</head>

<body>
    <div class="container">
        <img src="./img/logo1.png" alt="Logo">
        <h2>Editar Compra</h2>

        <form method="POST" action="editar_compra.php?id=<?php echo $compra['id']; ?>">
            <label for="nome">Nome do Produto:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $compra['nome']; ?>" required>

            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" value="<?php echo $compra['quantidade']; ?>" required>

            <label for="preco">Preço (R$):</label>
            <input type="number" id="preco" name="preco" value="<?php echo $compra['preco']; ?>" step="0.01" required>

            <button type="submit" class="button">Atualizar Compra</button>
        </form>

        <a href="visualizar_compras.php">Voltar</a>
    </div>
</body>

</html>
