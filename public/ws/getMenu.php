<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization");

header('Content-type: text/json');
header('Content-type: application/json');

include_once 'lib/BeforeValidException.php';
include_once 'lib/ExpiredException.php';
include_once 'lib/SignatureInvalidException.php';
include_once 'lib/JWT.php';
use \Firebase\JWT\JWT;

$key = "sidaliAdmin";
$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9zaWFmdXQub3JnIiwiYXVkIjoiaHR0cDpcL1wvd2ViZXJzbXguY29tIiwiaWF0IjoxMzU2OTk5NTI0LCJuYmYiOjEzNTcwMDAwMDAsImRhdGEiOnsiaWQiOiIxIiwibm9tYnJlIjoiaXNyYWVsIGFicmFoYW0iLCJhUGF0ZXJubyI6ImppbWVuZXoiLCJlbWFpbCI6ImlqaW1lbmV6MzVAZ21haWwuY29tIn19.dDy8MjnlNUgyFFrp-tOGhnO8_2E_RHztxAc50IutzZs";

$decoded = JWT::decode($token, $key, array('HS256'));

$id = $decoded->data->id;
$correo = $decoded->data->email;

try{ // Connect to server and select databse.
    
	$myFile = "../txt/json/menu/2/0.json";
	
	if(!file_exists($myFile)){	
		echo '{"DatosJSON": []}';
	}else{
		$fh = fopen($myFile, 'r');
		$json = fread($fh, filesize($myFile));
		fclose($fh);
		echo $json;
	}
} catch (Exception $e) {
	echo '{"DatosJSON": []}';
}


?>