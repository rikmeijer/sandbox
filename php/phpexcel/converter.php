<?php

define('PHPEXCEL_ROOT', realpath(__DIR__ . '/../../saa/extranet/library') . '/');
require PHPEXCEL_ROOT . '/PHPExcel/Autoloader.php';
require PHPEXCEL_ROOT . '/PHPExcel/PHPExcel.php';

$new_xls_filename = __DIR__ . '/input.xls';

$objExcelReader = new PHPExcel_Reader_Excel5();
$phpExcelSource = $objExcelReader->load($new_xls_filename);

header('Content-Type: text/plain');
print '<?php';
print PHP_EOL . '$excel = new PHPExcel();';

foreach ($phpExcelSource->getAllSheets() as $intSheetIndex => $objSheet) {
    print PHP_EOL . '$sheet_' . $intSheetIndex . ' = new PHPExcel_Worksheet($excel);';
    
    foreach ($objSheet->getRowIterator() as $intRowIndex => $objRow) {
        foreach ($objRow->getCellIterator() as $intCellIndex => $objCell) {
            print PHP_EOL . '$sheet_' . $intSheetIndex . '->setCellValue("' . $objCell->getCoordinate() . '", "' . addcslashes($objCell->getValue(), "\r\n\t\"") . '");';   
        }
    }
    
    print PHP_EOL . '$excel->addSheet($sheet_' . $intSheetIndex . ', ' . $intSheetIndex . ');';
    
}