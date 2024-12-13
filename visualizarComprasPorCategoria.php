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
    header("Location: visualizarComprasPorCategoria.php");
    exit;
}

// Consultar as compras agrupadas por categoria
$sql = "
    SELECT 
        cat.nome_categoria, 
        c.id, 
        c.nome, 
        c.quantidade, 
        c.preco, 
        c.data_adicao
    FROM 
        compras c
    LEFT JOIN 
        categorias cat ON c.fkidcategoria = cat.id_categoria
    ORDER BY 
        cat.nome_categoria, c.data_adicao DESC
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
    <title>Visualizar Compras por Categoria</title>
    <link rel="shortcut icon" href="./img/Logo2.png" type="image/Logo2.png">
</head>

<body>
    <div class="container">
        <img src="./img/logo1.png" alt="Logo">
        <h2>Compras Cadastradas por Categoria</h2>

        <?php
        // Variável para controlar a categoria atual
        $categoria_atual = '';
        $total_categoria = 0; // Inicializa a variável para o total da categoria
        
        // Verificar se há resultados
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Exibe a categoria apenas quando mudar de categoria
                if ($categoria_atual !== $row['nome_categoria']) {
                    if ($categoria_atual !== '') {
                        // Exibe o total da categoria anterior
                        echo "<tr><td colspan='4'><strong>Total: R$ " . number_format($total_categoria, 2, ',', '.') . "</strong></td></tr>";
                        echo '</tbody></table>';
                    }
                    $categoria_atual = $row['nome_categoria'];
                    $total_categoria = 0; // Reseta o total ao mudar de categoria
                    echo "<h3>Categoria: " . htmlspecialchars($categoria_atual) . "</h3>";
                    echo '<table>';
                    echo '<thead><tr>
                            <th>Nome do Produto</th>
                            <th>Quantidade</th>
                            <th>Preço (R$)</th>
                            <th>Data da Compra</th>
                            <th>Ações</th>
                          </tr></thead><tbody>';
                }
                
                // Calcula o total da categoria
                $total_categoria += $row['quantidade'] * $row['preco'];
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nome']); ?></td>
                    <td><?php echo $row['quantidade']; ?></td>
                    <td><?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo date("d/m/Y - H:i", strtotime($row['data_adicao'])); ?></td>
                    <td>
                        <!-- Editar compra -->
                        <a href="editar_compra.php?id=<?php echo $row['id']; ?>" class="button">Editar</a>
                        <!-- Excluir compra -->
                        <a href="visualizarComprasPorCategoria.php?excluir=<?php echo $row['id']; ?>" class="button" onclick="return confirm('Tem certeza que deseja excluir esta compra?')">Excluir</a>
                    </td>
                </tr>
                <?php
            }
            // Exibe o total da última categoria
            echo "<tr><td colspan='4'><strong>Total: R$ " . number_format($total_categoria, 2, ',', '.') . "</strong></td></tr>";
            echo '</tbody></table>';
        } else {
            echo "<p>Nenhuma compra registrada.</p>";
        }
        ?>

        <button class="button print-button" onclick="window.print()">Imprimir Compras</button>
        <a href="exportar_excel.php">Gerar arquivo Excel</a>
        <a href="menu.php">Voltar</a>
    </div>
</body>

</html>

