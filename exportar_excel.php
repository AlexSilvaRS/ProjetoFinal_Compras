<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Sao_Paulo');

// Verifica se o autoload do Composer está correto
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// Inclui as classes necessárias
include_once './CLASSES/Database.php';
include_once './CONFIG/config.php';
include_once './CLASSES/Compras.php';

try {
    // Cria instância da classe Compras
    $compra = new Compras($db);
    
    // Recupera os resultados
    $result = $compra->listarExcel();
    
    // Verifica se $result não está vazio
    if (empty($result)) {
        die("Nenhum resultado encontrado.");
    }

    // Cria nova planilha
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Defina os cabeçalhos das colunas
    $sheet->setCellValue('A1', 'Nome do Produto');
    $sheet->setCellValue('B1', 'Quantidade');
    $sheet->setCellValue('C1', 'Preço (R$)');
    $sheet->setCellValue('D1', 'Data da Compra');
    

    // Preenche os dados
    $row = 2;
    foreach ($result as $res) {
        $sheet->setCellValue('A' . $row, $res['nome']);
        $sheet->setCellValue('B' . $row, $res['quantidade']);
        $sheet->setCellValue('C' . $row, number_format($res['preco'], 2, ',', '.'));

        // Tratamento da data
        if (!empty($res['data_adicao']) && $res['data_adicao'] !== '0000-00-00 00:00:00') {
            try {
                // Converte a data para timestamp
                $timestamp = strtotime($res['data_adicao']);
                
                if ($timestamp !== false) {
                    $excelDateValue = Date::PHPToExcel($timestamp);
                    
                    $sheet->setCellValue('D' . $row, $excelDateValue);
                    $sheet->getStyle('D' . $row)
                          ->getNumberFormat()
                          ->setFormatCode('DD/MM/YYYY HH:MM:SS');
                } else {
                    $sheet->setCellValue('D' . $row, 'Data inválida');
                }
            } catch (Exception $e) {
                $sheet->setCellValue('D' . $row, 'Erro: ' . $e->getMessage());
            }
        } else {
            $sheet->setCellValue('D' . $row, 'Sem data');
        }
        
        // Adiciona categoria
     
        
        $row++;
    }

    // Cria o arquivo Excel
    $writer = new Xlsx($spreadsheet);

    // Limpa qualquer saída anterior
    ob_clean();

    // Cabeçalhos para download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="compras.xlsx"');
    header('Cache-Control: max-age=0');

    // Salva o arquivo
    $writer->save('php://output');
    exit;

} catch (Exception $e) {
    // Tratamento de erro
    echo "Erro: " . $e->getMessage();
    exit;
}