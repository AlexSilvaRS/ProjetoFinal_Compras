<?php

include_once'./CLASSES/Database.php';
include_once'./CONFIG/config.php';
include_once'./CLASSES/Compras.php';

$compra = new Compras($db);

$result =  $compra->listarExcel();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<h2>Lista em ordem de Cadastro</h2>

<table>
    <thead>
        <tr>
            <th>Nome do Produto</th>
            <th>Quantidade</th>
            <th>Preço (R$)</th>
            <th>Data da Compra</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($result as $res):?>
                <tr>
                    <td><?php echo $res['nome']; ?></td>
                    <td><?php echo $res['quantidade']; ?></td>
                    <td><?php echo number_format($res['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo date("d/m/Y", strtotime($res['data_compra'])); ?></td>
              
                </tr>
            <?php endforeach; ?>
        
    </tbody>
</table>
<form action="exportar_excel.php" method="post">
    <button type="submit">Exportar para Excel</button>
</form>


</body>
</html>
