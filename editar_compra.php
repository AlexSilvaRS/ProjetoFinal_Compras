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

// Verificar se a conexão está funcionando
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Inicializar variáveis
$mensagem = "";
$erro = "";

// Verificar se o ID da compra foi passado na URL
if (isset($_GET['id'])) {
    $id_compra = $_GET['id'];

    // Consulta a compra com o ID fornecido
    $sql = "SELECT * FROM compras WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_compra);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<script>alert('Compra não encontrada.'); window.location.href = 'visualizar_compras.php';</script>";
        exit;
    }

    // Obter os dados da compra
    $compra = $result->fetch_assoc();
    $stmt->close();

    // Consultar as categorias existentes
    $sql_categorias = "SELECT * FROM categorias";
    $categorias = $conn->query($sql_categorias);
} else {
    echo "<script>alert('ID não fornecido.'); window.location.href = 'visualizar_compras.php';</script>";
    exit;
}

// Verificar se o formulário foi enviado para editar a compra
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];
    $fkidcategoria = $_POST['categoria'];

    // Atualizar os dados da compra
    $sql_atualizar = "UPDATE compras SET nome = ?, quantidade = ?, preco = ?, fkidcategoria = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_atualizar);
    $stmt->bind_param("sidii", $nome, $quantidade, $preco, $fkidcategoria, $id_compra);

    if ($stmt->execute()) {
        $mensagem = "Compra atualizada com sucesso!";
    } else {
        $erro = "Erro ao atualizar a compra. Tente novamente.";
    }

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
</head>

<body>
    <div class="container">
        <img src="./img/logo1.png" alt="Logo">
        <h2>Editar Compra</h2>

        <!-- Exibir mensagem de sucesso ou erro -->
        <?php if (!empty($mensagem)) { ?>
            <p class="success"><?php echo $mensagem; ?></p>
        <?php } ?>

        <?php if (!empty($erro)) { ?>
            <p class="error"><?php echo $erro; ?></p>
        <?php } ?>

        <!-- Formulário de edição -->
        <form method="POST" action="editar_compra.php?id=<?php echo $compra['id']; ?>">
            <label for="nome">Nome do Produto:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($compra['nome']); ?>" required>

            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" value="<?php echo $compra['quantidade']; ?>" required>

            <label for="preco">Preço (R$):</label>
            <input type="number" id="preco" name="preco" value="<?php echo $compra['preco']; ?>" step="0.01" required>

            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria" required>
                <option value="">Selecione uma categoria</option>
                <?php while ($categoria = $categorias->fetch_assoc()) { ?>
                    <option value="<?php echo $categoria['id_categoria']; ?>" 
                        <?php echo $categoria['id_categoria'] == $compra['fkidcategoria'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($categoria['nome_categoria']); ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit" class="button">Atualizar Compra</button>
        </form>

        <a href="visualizar_compras.php">Voltar</a>
    </div>
</body>

</html>
