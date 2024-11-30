<?php
// This is ment to be used outside of app, just run:
// php [filename] in terminal to create new file from source xlsx
require_once 'vendor/autoload.php';

use Shuchkin\SimpleXLSX;

function convertExcelToCSV($inputFile, $outputFile) {
    if ($xlsx = SimpleXLSX::parse($inputFile)) {
        $fp = fopen($outputFile, 'w');
        foreach ($xlsx->rows() as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
        return true;
    } else {
        return SimpleXLSX::parseError();
    }
}

// Convert file
echo "Convert file:";
$inputFile = __DIR__ . '/../temp/alkon-hinnasto-tekstitiedostona.xlsx';
$outputFile = __DIR__ . '/../temp/hinnasto.csv';

echo convertExcelToCSV($inputFile, $outputFile);

// Trim first three rows
$filename = $outputFile;
$lines = file($filename);
$lines = array_slice($lines, 3);
file_put_contents($filename, implode('', $lines));

