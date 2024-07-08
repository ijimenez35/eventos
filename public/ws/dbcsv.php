<?php

header('Content-Type: application/json; charset=utf-8');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization");

// php function to convert csv to json format
function csvToJson($fname) {
    // open csv file
    if (!($fp = fopen($fname, 'r'))) {
        die("Can't open file...");
    }
    
    //read csv headers
    $key = fgetcsv($fp,"1024",",");
    
    // parse csv rows into array
    $json = array();
        while ($row = fgetcsv($fp,"1024",",")) {
        $json[] = array_combine($key, $row);
    }
    
    // release file handle
    fclose($fp);
    
    // encode array to json
    return json_encode($json);
}

$month = "04";
$year = "2023";
$baseDatos = "";

if( isset($_REQUEST['db']) ){
    $baseDatos = $_REQUEST['db'];
}

if( isset($_REQUEST['month']) ){
    $month = $_REQUEST['month'];
}

if( isset($_REQUEST['year']) ){
    $year = $_REQUEST['year'];
}

if( $baseDatos != '' ){
    if ( file_exists( "../dbcsv/".$baseDatos.".csv" ) ){
        echo '{"DatosJSON":'.csvToJson("../dbcsv/".$baseDatos.".csv")."}" ;
    }else{
        echo '{"DatosJSON":[]}';
    }
}else{
    if ( file_exists( "../dbcsv/".$year."_".$month.".csv" ) ){
        echo '{"DatosJSON":'.csvToJson("../dbcsv/".$year."_".$month.".csv")."}" ;
    }else{
        echo '{"DatosJSON":[]}';
    }
}



?>