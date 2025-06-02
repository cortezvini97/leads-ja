<?php

namespace App\Helper;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GenerateXLSX
{
    private $leads;

    public function __construct($leads)
    {
        $this->leads = $leads;
    }

    public function generate():string {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', "Nome");
        $sheet->setCellValue('C1', "Cidade");
        $sheet->setCellValue('D1', "Estado");
        $sheet->setCellValue('E1', "E-mail");
        $sheet->setCellValue('F1', "Telefone");
        $sheet->setCellValue('G1', "Categoria");


        $row = 2;

        foreach($this->leads as $lead){
            $id = $lead->getId();
            $nome = $lead->getNome();
            $cidade = $lead->getCidade();
            $estado = $lead->getEstado();
            $email = $lead->getEmail();
            $telefone = $lead->getTelefone();
            $categoria = $lead->getCategoria();
            $sheet->setCellValue('A' . $row, $id);
            $sheet->setCellValue('B' . $row, $nome);
            $sheet->setCellValue('C' . $row, $cidade);
            $sheet->setCellValue('D' . $row, $estado);
            $sheet->setCellValue('E' . $row, $email);
            $sheet->setCellValue('F' . $row, $telefone);
            $sheet->setCellValue('G' . $row, $categoria);
            $row++;
        }
        
        $writer = new Xlsx($spreadsheet);
        ob_start(); // inicia buffer de saída
        $writer->save('php://output');
        $excelData = ob_get_clean(); // captura os bytes do buffer
        $base64 = base64_encode($excelData);
        return $base64;
    }
}