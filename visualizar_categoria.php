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

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se foi solicitada a exclusão de uma compra
if (isset($_GET['excluir'])) {
    // Conectar novamente ao banco de dados para realizar a exclusão
    $conn = new mysqli($host, $username, $password, $dbname);

    // Verificar se a conexão foi bem-sucedida
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Obter o ID da compra a ser excluída
    $id_categoria = $_GET['excluir'];

    // Preparar a consulta de exclusão
    $sql_excluir = "DELETE FROM categorias WHERE id_categoria = ?";
    $stmt = $conn->prepare($sql_excluir);
    $stmt->bind_param("i", $id_categoria);

    // Executar a exclusão
    if ($stmt->execute()) {
        echo "<script>alert('Compra excluída com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao excluir a compra. Tente novamente.');</script>";
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();

    // Redirecionar para a mesma página para atualizar a lista de compras
    header("Location: visualizar_categoria.php");
    exit;
}

// Consultar todas as compras cadastradas
$sql = "SELECT * FROM categorias";
$result = $conn->query($sql);

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/visualizar_compras.css">
    <title>Visualizar Categorias</title>
    <link rel="shortcut icon" href="img/compras.png" type="image/png">
</head>

<body>
    <div class="container">
        <img src="./img/logo1.png" alt="Logo">
        <h2>Compras Cadastradas</h2>

        <table>
            <thead>
                <tr>
                    <th>Nome do Categoria</th>
                  
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['nome_categoria']; ?></td>
                          
                            <td>
                                <!-- Aqi edita a compra -->
                                <a href="editar_categoria.php?idcategoria=<?php echo $row['id_categoria']; ?>" class="button">Editar</a>
                                <!-- Aqi exclui a compra -->
                                <a href="visualizar_compras.php?excluir=<?php echo $row['id']; ?>" class="button" onclick="return confirm('Tem certeza que deseja excluir esta compra?')">Excluir</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="5">Nenhuma compra registrada.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <button class="button print-button" onclick="window.print()">Imprimir Compras</button>
        <a href="exportar_excel.php">Gerar arquivo Excel</a>
        <a href="menu.php">Voltar</a>
    </div>
</body>

</html>