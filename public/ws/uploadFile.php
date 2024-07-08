<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
error_reporting(2047);

ini_set('upload_max_filesize', '64M');  
ini_set('post_max_size', '64M');  
ini_set('max_input_time', 300);  
ini_set('max_execution_time', 300);  

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");

header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");


$varesponse = array();
//$vaSplit=explode('\\',$_SERVER['DOCUMENT_ROOT']); 
//$GLOBALS['vsRutaDocmRoot'] = '/'.$vaSplit[1].'/common';

// directorio actual
//echo getcwd() . "\n";

// directorio actual
// echo getcwd() . "\n";

chdir('..'); // para subir una carpeta /home/webersmx/public_html/sidali
// /arch/img/
$GLOBALS['vsRutaDocmRoot'] = getcwd();
//echo $GLOBALS['vsRutaDocmRoot']; // /home/solucio1/public_html
//echo $_SERVER['DOCUMENT_ROOT']; ///home/webersmx/public_html

//exit(); 

if (!empty($_FILES)) {
    $targetPath = $GLOBALS['vsRutaDocmRoot'].'/' . $_REQUEST['ruta'] . '/';
    if(isset($_REQUEST['multiple'])) {
		$FilesAux = fixGlobalFilesArray($_FILES['objFile']);
	} else {
		$FilesAux = array($_FILES['objFile']);
	}
	
	//Validaciones de archivos
	foreach($FilesAux as $file) {
	    $ext = pathinfo($file['tmp_name'], PATHINFO_EXTENSION);
	    
	    if( $ext == 'tmp' ){
			$ext = f_filename_extension( $file['name'] ); 
		}
		$ext = strtolower($ext);
		
		
		
	}
	
	//Guardado de archivos
	foreach($FilesAux as $file) {
		//echo $file['error']; exit();
		if( $file['error'] == 0 ) {
			$tempFile = $file['tmp_name'];
			if(isset($_REQUEST['nombre'])){
			    $nameFile = $_REQUEST['nombre'];
			    if(strpos($nameFile,'.')!==true){
					$ext = pathinfo($file['tmp_name'], PATHINFO_EXTENSION);
					if( $ext == 'tmp' ){
						$ext = f_filename_extension( $file['name'] ); 
					}
					$size = getimagesize($file['tmp_name']);
					/*
					if ($size['mime'] == "image/gif"){ $ext = 'gif';
					}else if( $size['mime'] == "video/quicktime" ){ $ext = 'mov';
					}else if( $size['mime'] == "video/3gpp" ){ $ext = '3gp';
					}else if( $size['mime'] == "video/x-msvideo" ){ $ext = 'avi';
					}else if( $size['mime'] == "video/mp4" ){ $ext = 'mp4';
					}else if( $size['mime'] == "video/x-ms-wmv" ){ $ext = 'wmv';
					}else if( $size['mime'] == "image/jpeg" ){ $ext = 'jpg';
					}else if( $size['mime'] == "image/png" ){ $ext = 'png';
					}else if( $size['mime'] == "image/bmp" ){ $ext = 'bmp';
					}else if( $size['mime'] == "image/jpg"){ $ext = 'jpg'; 
					}else if( $size['mime'] == "application/pdf"){ $ext = 'pdf'; 
					}else if( $size['mime'] == "text/csv"){ $ext = 'csv'; }
					*/
					
					if( $ext == '' ){
					    $ext = f_filename_extension( $file['name'] ); 
					}
					
					$nameFile = $nameFile.".".$ext;
				}
			    $varesponse = f_GuardaArchivo($tempFile,$nameFile,$targetPath, $file);
				$vaResponse_JSON["DatosJSON"][] = $varesponse;
			}else{
			    $varesponse = f_GuardaArchivo($tempFile, f_QuitaAcentos($file['name']), $targetPath, $file);
				$vaResponse_JSON["DatosJSON"][] = $varesponse;
			}
		}
	}
	
    
} else {
	//##### Error!!!!
	$vaResponse_JSON["DatosJSON"][] = array( 'file' => 'ERROR', 'nombre' => 'ERROR', 'path' =>  'ERROR', 'Error: ' => 'Sin archivos' );
}

//### Respuesta enviada al cliente
echo json_encode($vaResponse_JSON); 

function f_filename_extension($filename) {
    $pos = strrpos($filename, '.');
    if($pos===false) {
        //return false;
        return '';
    } else {
        return substr($filename, $pos+1);
    }
}

function f_GuardaArchivo($poFile,$psFilename, $psTarget, $pofile){ 
	$psTargetPath =  str_replace('//','/',$GLOBALS['vsRutaDocmRoot'].'/' . $_REQUEST['ruta'] . '/');
	$psFilePath =  $psTargetPath . $psFilename;
	
	//echo $psFilename; exit();
	
	//echo '1';
	
	$psFilePath =  f_NormlizaCadena($psFilePath);
	//################################################
	//## Adecuación para crear los directorios que no 
	//## existan, LFRIAS 15feb2011
	//################################################
	//echo $psTargetPath;
	//exit();
	if(file_exists($psTargetPath)==false){ 
		mkdir($psTargetPath, 0777, true); 
		chmod($psTargetPath, 0777); 
	}
	
	//Si el archivo existe se renombra para no plancharlo
	if( file_exists($psFilePath)==true ){ 
		rename($psFilePath, pathinfo($psFilePath, PATHINFO_DIRNAME)."/".pathinfo($psFilePath, PATHINFO_FILENAME).date("YmdHis").".".pathinfo($psFilePath, PATHINFO_EXTENSION));
	}
	
	/*
	echo "Existe:".file_exists($psFilePath);
	echo "-";
	echo "Ruta:".$psFilePath;
	echo "-";
	echo "Nuevonombre: ".pathinfo($psFilePath, PATHINFO_DIRNAME)."/".pathinfo($psFilePath, PATHINFO_FILENAME).date("YmdHis").".".pathinfo($psFilePath, PATHINFO_EXTENSION);
	echo "-";
	echo "Directorio:".pathinfo($psFilePath, PATHINFO_DIRNAME);
	exit();
	*/
	
	try {

		if (!move_uploaded_file($poFile, $psFilePath )) {
			throw new Exception('No se puede mover');
		}
		
		return array( 'file' => str_replace('\\','/',str_replace($_SERVER['DOCUMENT_ROOT'],'',$psFilePath)), 'nombre' => f_NormlizaCadena($psFilename), 'path' =>  $_REQUEST['ruta'].'/' );
		
	} catch (Exception $e) {
		return array( 'file' => "Error", 'nombre' => f_NormlizaCadena($psFilename), 'path' =>  $_REQUEST['ruta'].'/', 'Error:' => $e->getMessage() );
	}
	//copy($poFile,$psFilePath.$vsNombArch);
}

function f_QuitaAcentos($psCadena){
	//### Chrome
	
	$psCadena = str_replace(chr(195).chr(128),'A',$psCadena); //À
	$psCadena = str_replace(chr(195).chr(129),'A',$psCadena); //Á
	$psCadena = str_replace(chr(195).chr(130),'A',$psCadena); //Â 
	$psCadena = str_replace(chr(195).chr(131),'A',$psCadena); //Ã 
	$psCadena = str_replace(chr(195).chr(132),'A',$psCadena); //Ä 
	$psCadena = str_replace(chr(195).chr(133),'A',$psCadena); //Å 
	$psCadena = str_replace(chr(195).chr(136),'E',$psCadena); //È
	$psCadena = str_replace(chr(195).chr(137),'E',$psCadena); //É
	$psCadena = str_replace(chr(195).chr(138),'E',$psCadena); //Ê
	$psCadena = str_replace(chr(195).chr(139),'E',$psCadena); //Ë
	$psCadena = str_replace(chr(195).chr(140),'I',$psCadena); //Ì
	$psCadena = str_replace(chr(195).chr(141),'I',$psCadena); //Í
	$psCadena = str_replace(chr(195).chr(142),'I',$psCadena); //Î
	$psCadena = str_replace(chr(195).chr(143),'I',$psCadena); //Ï
	$psCadena = str_replace(chr(195).chr(145),'N',$psCadena); //Ñ
	$psCadena = str_replace(chr(195).chr(146),'O',$psCadena); //Ò
	$psCadena = str_replace(chr(195).chr(147),'O',$psCadena); //Ó
	$psCadena = str_replace(chr(195).chr(148),'O',$psCadena); //Ô
	$psCadena = str_replace(chr(195).chr(149),'O',$psCadena); //Õ
	$psCadena = str_replace(chr(195).chr(150),'O',$psCadena); //Ö
	$psCadena = str_replace(chr(195).chr(153),'U',$psCadena); //Ù
	$psCadena = str_replace(chr(195).chr(154),'U',$psCadena); //Ú
	$psCadena = str_replace(chr(195).chr(155),'U',$psCadena); //Û
	$psCadena = str_replace(chr(195).chr(156),'U',$psCadena); //Ü
	$psCadena = str_replace(chr(195).chr(157),'Y',$psCadena); //Ý
	$psCadena = str_replace(chr(195).chr(160),'a',$psCadena); //à
	$psCadena = str_replace(chr(195).chr(161),'a',$psCadena); //á
	$psCadena = str_replace(chr(195).chr(162),'a',$psCadena); //â
	$psCadena = str_replace(chr(195).chr(163),'a',$psCadena); //
	$psCadena = str_replace(chr(195).chr(164),'a',$psCadena); //ä
	$psCadena = str_replace(chr(195).chr(165),'a',$psCadena); //
	$psCadena = str_replace(chr(195).chr(168),'e',$psCadena); //è
	$psCadena = str_replace(chr(195).chr(169),'e',$psCadena); //é
	$psCadena = str_replace(chr(195).chr(170),'e',$psCadena); //ê
	$psCadena = str_replace(chr(195).chr(171),'e',$psCadena); //ë
	$psCadena = str_replace(chr(195).chr(172),'i',$psCadena); //ì
	$psCadena = str_replace(chr(195).chr(173),'i',$psCadena); //í
	$psCadena = str_replace(chr(195).chr(174),'i',$psCadena); //î
	$psCadena = str_replace(chr(195).chr(175),'i',$psCadena); //ï
	$psCadena = str_replace(chr(195).chr(177),'n',$psCadena); //ñ
	$psCadena = str_replace(chr(195).chr(178),'o',$psCadena); //ò
	$psCadena = str_replace(chr(195).chr(179),'o',$psCadena); //ò
	$psCadena = str_replace(chr(195).chr(180),'o',$psCadena); //ò
	$psCadena = str_replace(chr(195).chr(181),'o',$psCadena); //ò
	$psCadena = str_replace(chr(195).chr(185),'u',$psCadena); //ù
	$psCadena = str_replace(chr(195).chr(186),'u',$psCadena); //ù
	$psCadena = str_replace(chr(195).chr(187),'u',$psCadena); //ù
	$psCadena = str_replace(chr(195).chr(188),'u',$psCadena); //ù 
	$psCadena = str_replace(chr(195).chr(189),'y',$psCadena); //ý
	$psCadena = str_replace(chr(195).chr(191),'y',$psCadena); //ÿ 
	
	$psCadena = utf8_encode($psCadena);
	
	$psCadena = str_replace('á','a',$psCadena); $psCadena =  str_replace('é','e',$psCadena); $psCadena =  str_replace('í','i',$psCadena); $psCadena =  str_replace('ó','o',$psCadena); $psCadena =  str_replace('ú','u',$psCadena);
	$psCadena = str_replace('Á','A',$psCadena); $psCadena =  str_replace('É','E',$psCadena); $psCadena =  str_replace('Í','I',$psCadena); $psCadena =  str_replace('Ó','O',$psCadena); $psCadena =  str_replace('Ú','U',$psCadena);	
	$psCadena = str_replace('à','a',$psCadena); $psCadena =  str_replace('è','e',$psCadena); $psCadena =  str_replace('ì','i',$psCadena); $psCadena =  str_replace('ò','o',$psCadena); $psCadena =  str_replace('ù','u',$psCadena);
	$psCadena = str_replace('À','A',$psCadena); $psCadena =  str_replace('È','E',$psCadena); $psCadena =  str_replace('Ì','I',$psCadena); $psCadena =  str_replace('Ò','O',$psCadena); $psCadena =  str_replace('Ù','U',$psCadena);
	$psCadena = str_replace('ä','a',$psCadena); $psCadena =  str_replace('ë','e',$psCadena); $psCadena =  str_replace('ï','i',$psCadena); $psCadena =  str_replace('ö','o',$psCadena); $psCadena =  str_replace('ü','u',$psCadena);
	$psCadena = str_replace('Ä','A',$psCadena); $psCadena =  str_replace('Ë','E',$psCadena); $psCadena =  str_replace('Ï','I',$psCadena); $psCadena =  str_replace('Ö','O',$psCadena); $psCadena =  str_replace('Ü','U',$psCadena);
	$psCadena = str_replace('â','a',$psCadena); $psCadena =  str_replace('ê','e',$psCadena); $psCadena =  str_replace('î','i',$psCadena); $psCadena =  str_replace('ô','o',$psCadena); $psCadena =  str_replace('û','u',$psCadena);
	$psCadena = str_replace('Â','A',$psCadena); $psCadena =  str_replace('Ê','E',$psCadena); $psCadena =  str_replace('Î','I',$psCadena); $psCadena =  str_replace('Ô','O',$psCadena); $psCadena =  str_replace('Û','U',$psCadena);
	$psCadena = str_replace('ñ','n',$psCadena);	
	$psCadena = str_replace('Ñ','N',$psCadena);

	//### Esta linea quita caracteres raros de la cadena y depende de la linea 248 - $psCadena = utf8_encode($psCadena);
	//### Firefox
	
	$psCadena = str_replace('I','',$psCadena); //á
	$psCadena = str_replace('I','',$psCadena); //ü
	$psCadena = str_replace('I','',$psCadena); //ñ
	$psCadena = str_replace('I','',$psCadena); //à
	$psCadena = str_replace('I','',$psCadena); //â
	$psCadena = str_replace('I','',$psCadena); //Å
	
	//$psCadena = str_replace('´','',$psCadena); 
	$psCadena = str_replace('^','',$psCadena); 
	$psCadena = str_replace('¿','',$psCadena); 
	$psCadena = str_replace('?','',$psCadena); 
	
	//$psCadena = str_replace(chr(117).chr(73),'u',$psCadena); 
	//$psCadena = str_replace('','',$psCadena); 
	//$psCadena =  str_replace('I€','',$psCadena); $psCadena =  str_replace('€','',$psCadena); $psCadena =  str_replace('aI`','a',$psCadena); 

	$psCadena = preg_replace('/[^A-Za-z0-9\.\-\_]/', "_", $psCadena); 
	$psCadena = str_replace('A__','',$psCadena); 
	return $psCadena;
}

function f_NormlizaCadena($psCadena){
	$psCadena =  str_replace(' ','_',$psCadena);
	$psCadena =  str_replace(',','_',$psCadena);
	
	$psCadena =  str_replace('á','a',$psCadena);
	$psCadena =  str_replace('é','e',$psCadena);
	$psCadena =  str_replace('í','i',$psCadena);
	$psCadena =  str_replace('ó','o',$psCadena);
	$psCadena =  str_replace('ú','u',$psCadena);
	
	$psCadena =  str_replace('ü','u',$psCadena);
	$psCadena =  str_replace('ñ','n',$psCadena);	
	
	$psCadena =  str_replace('Á','A',$psCadena);
	$psCadena =  str_replace('É','E',$psCadena);
	$psCadena =  str_replace('Í','I',$psCadena);
	$psCadena =  str_replace('Ó','O',$psCadena);
	$psCadena =  str_replace('Ú','U',$psCadena);	
	$psCadena =  str_replace('Ü','U',$psCadena);
	$psCadena =  str_replace('Ñ','N',$psCadena);
	
	$psCadena =  str_replace('À','A',$psCadena);
	$psCadena =  str_replace('È','E',$psCadena);
	$psCadena =  str_replace('Ì','I',$psCadena);
	$psCadena =  str_replace('Ò','O',$psCadena);
	$psCadena =  str_replace('Ù','U',$psCadena);
	
	$psCadena =  str_replace('à','a',$psCadena);
	$psCadena =  str_replace('è','e',$psCadena);
	$psCadena =  str_replace('ì','i',$psCadena);
	$psCadena =  str_replace('ò','o',$psCadena);
	$psCadena =  str_replace('ù','u',$psCadena);
	
	return $psCadena;
}

?>