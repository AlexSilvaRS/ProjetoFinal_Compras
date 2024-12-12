<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include_once './CLASSES/Database.php';
include_once './CONFIG/config.php';
include_once './CLASSES/Compras.php';

$compra = new Compras($db);
$result = $compra->listarExcel();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Defina os cabeçalhos das colunas
$sheet->setCellValue('A1', 'Nome do Produto');
$sheet->setCellValue('B1', 'Quantidade');
$sheet->setCellValue('C1', 'Preço (R$)');
$sheet->setCellValue('D1', 'Data da Compra');

// Preencha os dados
$row = 2;
foreach ($result as $res) {
    $sheet->setCellValue('A' . $row, $res['nome']);
    $sheet->setCellValue('B' . $row, $res['quantidade']);
    $sheet->setCellValue('C' . $row, number_format($res['preco'], 2, ',', '.'));
    $sheet->setCellValue('D' . $row, date("d/m/Y", strtotime($res['data_compra'])));
    $row++;
}

// Crie o arquivo Excel
$writer = new Xlsx($spreadsheet);

// Evita qualquer tipo de saída (echo, espaços em branco, etc.)
ob_end_clean(); // Limpa o buffer de saída (se existir)

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="compras.xlsx"');
header('Cache-Control: max-age=0');

// Envia o arquivo Excel para o navegador (sem salvar em disco)
$writer->save('php://output');
exit;
?>
