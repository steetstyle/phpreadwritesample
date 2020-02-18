<?php
require 'vendor/autoload.php';

use PHPOffice\PhpSpreadsheet\IOFactory;
use PHPOffice\PhpSpreadsheet\Helper\Sample;

$excelArray = [];
if ( $xlsx = SimpleXLSX::parse('test.xlsx') ) {
	foreach ($xlsx->rows() as $row) {
        $founded = false;
        $foundedindex = -1;
        for ($i=0; $i < count($excelArray) ; $i++) { 
            if($excelArray[$i][2] == $row[2] ){
               $founded = true;
               $foundedindex = $i; 
            }
        }

        if($foundedindex != -1){
            $excelArray[$foundedindex][count($excelArray[$foundedindex])] = $row[24];

        }
        else{
            array_push($excelArray,$row);
        }
       
        echo "<br>";
    }
} else {
	echo SimpleXLSX::parseError();
}


foreach ($excelArray as $value) {
   print_r($value);
   echo "<br>";
}

header('Content-Disposition: attachment; filename="data'.date('d-m-y').'.xls"');
header("Content-Type: application/vnd.ms-excel");

$output = fopen('sample.xls', 'w');
fputcsv($output,  $header  , "\t");
foreach ($excelArray as $value) { 
   
    fputcsv($output,  $value ,  "\t" );  
}
fclose($output);

?>