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
    $id_compra = intval($_GET['excluir']); // Converte para inteiro por segurança

    // Preparar a consulta de exclusão
    $sql_excluir = "DELETE FROM compras WHERE id = ?";
    $stmt = $conn->prepare($sql_excluir);
    $stmt->bind_param("i", $id_compra);

    // Executar a exclusão
    if ($stmt->execute()) {
        echo "<script>alert('Compra excluída com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao excluir a compra. Tente novamente.');</script>";
    }

    // Fechar o statement
    $stmt->close();

    // Redirecionar para a mesma página para atualizar a lista de compras
    header("Location: visualizar_compras.php");
    exit;
}

// Consultar todas as compras cadastradas com as categorias associadas
$sql = "
    SELECT 
        c.id, 
        c.nome, 
        c.quantidade, 
        c.preco, 
        c.data_adicao, 
        cat.nome_categoria 
    FROM 
        compras c
    LEFT JOIN 
        categorias cat ON c.fkidcategoria = cat.id_categoria
";
$result = $conn->query($sql);

// Fechar a conexão ao final
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/visualizar_compras.css">
    <title>Visualizar Compras</title>
</head>

<body>
    <div class="container">
        <img src="./img/logo1.png" alt="Logo">
        <h2>Compras Cadastradas</h2>

        <table>
            <thead>
                <tr>
                    <th>Nome do Produto</th>
                    <th>Quantidade</th>
                    <th>Categoria</th>
                    <th>Preço (R$)</th>
                    <th>Data da Compra</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo $row['quantidade']; ?></td>
                            <td><?php echo htmlspecialchars($row['nome_categoria'] ?? 'Sem Categoria'); ?></td>
                            <td><?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                            <td><?php echo date("d/m/Y - H:i", strtotime($row['data_adicao'])); ?></td>
                            <td>
                                <!-- Editar compra -->
                                <a href="editar_compra.php?id=<?php echo $row['id']; ?>" class="button">Editar</a>
                                <!-- Excluir compra -->
                                <a href="visualizar_compras.php?excluir=<?php echo $row['id']; ?>" class="button" onclick="return confirm('Tem certeza que deseja excluir esta compra?')">Excluir</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6">Nenhuma compra registrada.</td>
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
