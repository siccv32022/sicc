<?php
// Declaramos la librería

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$writer = new Xlsx($spreadsheet);
?>