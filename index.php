<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <title>Cadastrar Compras</title>
    
</head>

<body>
    <div class="container">
        <!-- Logo -->
        <img src="./img/logo1.png" alt="Logo"> <!-- Substitua "logo.png" pelo caminho da sua imagem -->
        <h2>Cadastro de Compras</h2>
        <form action="index.php" method="POST">
            <div class="form-group"> 
                <label for="nome">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group"> 
                <label for="quantidade">Quantidade:</label> 
                <input type="number" id="quantidade" name="quantidade" required>
            </div>
            <div class="form-group"> 
                <label for="preco">Preço (R$):</label> 
                <input type="number" id="preco" name="preco" step="0.01" required>
            </div> 
            <button type="submit" class="button">Cadastrar</button>
        </form>

        <?php 
        $host = "localhost"; 
        $username = "root"; 
        $password = ""; 
        $dbname = "compras"; 
        $conn = new mysqli($host, $username, $password, $dbname); // Conexão com o banco

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") { 
            $nome = $_POST['nome']; 
            $quantidade = $_POST['quantidade']; 
            $preco = $_POST['preco']; 
            $sql = "INSERT INTO compras (nome, quantidade, preco) VALUES ('$nome', '$quantidade', '$preco')"; 
            if ($conn->query($sql) === TRUE) { 
                echo "<p>Compra cadastrada com sucesso!</p>"; 
            } else { 
                echo "Erro: " . $sql . "<br>" . $conn->error; 
            } 
        } 
        $conn->close(); 
        ?>
    </div>
</body> 

</html>
