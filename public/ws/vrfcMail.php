<?php

require('conexion.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization");

$cnxn = new Conexion;

$host= $cnxn->host;
$username=$cnxn->username;
$password=$cnxn->password;
$db_name=$cnxn->db_name;
$tbl_name=$cnxn->tbl_name;

/*
$host="localhost"; // Host name
$username="dbwebctc"; // Mysql username
$password="P@ssw0rd"; // Mysql password
$db_name="dbwebctc"; // Database name
$tbl_name="usuarios"; // Table name
*/

header('Content-type: text/json');
header('Content-type: application/json');

$json = "{\"DatosJSON\":[";

try{ // Connect to server and select databse.
	
	$myFile = "../txt/sql/vrfcMail.sql";
	
	if(!file_exists($myFile)){	
		$json .= "{\"estatus\": \"error\", \"observaciones\": \"Consulta no encontrada en el servidor!!\", \"archivo\": \"$myFile\"}";
	}else{
		$fh = fopen($myFile, 'r');
		$sql = fread($fh, filesize($myFile));
		fclose($fh);
		$super_globals = array('_GET', '_POST');
		foreach($super_globals as $sg1){
			foreach($GLOBALS[$sg1] as $k1=>$v1){
				$ret1[$k1] = $v1;
				if( stripos($k1, "_") !== 0 ){ //No sustituir en el query las variables que tengan como prefijo "_" un guion bajo
					//$sql = str_replace("@".$k1, $v1, $sql);
					if( is_numeric ( $v1 ) ){
					    $sql = "SET @".$k1." = ".utf8_encode($v1)."; \n".$sql;
					}else{
					    $sql = "SET @".$k1." = '".utf8_encode($v1)."'; \n".$sql;
					}
				}
			}
		}
		
		//echo $sql."<br>";
		//exit();
				
		//### Verificar que este bien compilado el query 
		if( strlen($sql) == 0 ){
			$json .= "{";
			$json .= "\"estatus\": \"error 1\", \"observaciones\": \"Consulta vacia\"";
			$json .= "}";
		}else if( substr_count($sql, ' @') > 999 ){
			$json .= "{";
			$json .= "\"estatus\": \"error 2\", \"observaciones\": \"faltan ".substr_count($sql, '@')." parametro(s) por definir\"";
			$json .= "}";
		}else{
			try{
			    //Coneccion a la db 
			    $mysqli = mysqli_connect("$host", "$username", "$password","$db_name");
			    //echo $sql;
			    //exit();
			    $json = mysqli_multi_query_file($mysqli, $sql, $json);
			    mysqli_close($mysqli);
			} catch (Exception $e) {
				$json .= "{\"estatus\": \"error 5\", \"Caught_exception\": \"". utf8_encode($e->getMessage())."\", \"query\": \"".utf8_encode($sql)."\"}";
			}
		}
	}
} catch (Exception $e) {
	$json .= "{\"estatus\": \"error 6\", \"Caught_exception\": \"". utf8_encode($e->getMessage())."\", \"query\": \"".utf8_encode($sql)."\"}";
}

$json .= "]}";
echo $json;

function mysqli_multi_query_file($mysqli, $sql, $json) {
    //$sql = file_get_contents($filename);
    // remove comments
    $sql = preg_replace('#/\*.*?\*/#s', '', $sql);
    $sql = preg_replace('/^-- .*[\r\n]*/m', '', $sql);
    if (preg_match_all('/^DELIMITER\s+(\S+)$/m', $sql, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
        $prev = null;
        $index = 0;
        foreach ($matches as $match) {
            $sqlPart = substr($sql, $index, $match[0][1] - $index); //echo $matches; 
            // move cursor after the delimiter
            $index = $match[0][1] + strlen($match[0][0]);
            if ($prev && $prev[1][0] != ';') {
                $sqlPart = explode($prev[1][0], $sqlPart);
                foreach ($sqlPart as $part) {
                    if (trim($part)) { // no empty queries
                        //$mysqli->query($part);
                        if( $result = $mysqli->query($part) ){
                            if( gettype( $result ) == 'object'){
                    	        $info = mysqli_fetch_assoc($result);
                                $numOfRows = mysqli_num_rows($result);
                                //echo "IF(".$numOfRows.")->".$part."<br><br><br>" ;
                                do {
                        			if($numOfRows){
                        			   if($json != "{\"DatosJSON\":["){ $json .= ","; }
                        			    $json = generaColumnas( $info, $json );
                        			}
                        		}
                        		while ($info = mysqli_fetch_array($result, MYSQLI_ASSOC));
                        		mysqli_free_result($result);
                    	    }else{
                    	        //Regresa true
                    	        if( is_bool($result) ){
                        	        //echo $part; exit();
                        	    }
                    	    }
                    	}
                    }
                }
            } else {
                //lo que no es store procedure
                if (trim($sqlPart)) { // no empty queries
                    //$mysqli->multi_query($sqlPart);
                    //while ($mysqli->next_result()) {;}
                    if ( $mysqli->multi_query($sqlPart) ) {
                        do {
                            if ($result = $mysqli->store_result()) {
                                if(!$mysqli->more_results() ){ 
                                    //$numOfCols = $mysqli->fetch_fields($result);
                                	$numOfRows = mysqli_num_rows($result);
                                	$info = mysqli_fetch_assoc($result);
                                	if($numOfRows > 0){
                                		do {
                                			if($json != "{\"DatosJSON\":["){ $json .= ","; }
                    			            $json = generaColumnas( $info, $json );
                                		}
                                		while ($info = mysqli_fetch_array($result, MYSQLI_ASSOC));
                                	}
                                }
                                mysqli_free_result($result);
                            }
                        } while ($mysqli->next_result());
                    }
                }
            }
            $prev = $match;
        }
        // run the sql after the last delimiter
        $sqlPart = substr($sql, $index, strlen($sql)-$index);
        
        if ($prev && $prev[1][0] != ';') {
            $sqlPart = explode($prev[1][0], $sqlPart);
            foreach ($sqlPart as $part) {
                if (trim($part)) {
                    //$mysqli->query($part);
                    if( $result = $mysqli->query($part) ){
                        $info = mysqli_fetch_assoc($result);
                        $numOfRows = mysqli_num_rows($result);
                        //echo "IF(".$numOfRows.")->".$part."<br><br><br>" ;
                        do {
                			if($numOfRows){
                			    if($json != "{\"DatosJSON\":["){ $json .= ","; }
                    			$json = generaColumnas( $info, $json );
                			}
                		}
                		while ($info = mysqli_fetch_array($result, MYSQLI_ASSOC));
                		mysqli_free_result($result);
                	}
                }
            }
        } else {
            if (trim($sqlPart)) {
                //$mysqli->multi_query($sqlPart);
                //while ($mysqli->next_result()) {;}
                if ( $mysqli->multi_query($sqlPart) ) {
                    do {
                        if ($result = $mysqli->store_result()) { 
                            if(!$mysqli->more_results() ){ 
                                //$numOfCols = $mysqli->fetch_fields($result);
                            	$numOfRows = mysqli_num_rows($result);
                            	$info = mysqli_fetch_assoc($result);
                            	if($numOfRows > 0){
                            		do {
                            		    if($json != "{\"DatosJSON\":["){ $json .= ","; }
                    			        $json = generaColumnas( $info, $json );
                            		}
                            		while ($info = mysqli_fetch_array($result, MYSQLI_ASSOC));
                            	}
                            }
                            $mysqli->free();
                        }
                    } while ($mysqli->next_result());
                }
            }
        }
    } else {
        //$mysqli->multi_query($sql);
        //while ($mysqli->next_result()) {;}
        if ( $mysqli->multi_query($sql) ) {
            do {
                if ($result = $mysqli->store_result()) { 
                    if(!$mysqli->more_results() ){ 
                        //$numOfCols = $mysqli->fetch_fields($result);
                    	$numOfRows = mysqli_num_rows($result);
                    	$info = mysqli_fetch_assoc($result);
                    	if($numOfRows > 0){
                    		do {
                    			if($json != "{\"DatosJSON\":["){ $json .= ","; }
                    			$json = generaColumnas( $info, $json );
                    		}
                    		while ($info = mysqli_fetch_array($result, MYSQLI_ASSOC));
                    	}
                    }
                    mysqli_free_result($result);
                }
            } while ($mysqli->next_result());
        }
    }
    return $json;
}

function generaColumnas( $info, $json ){
    $estatus = ""; $correo = ""; $codigo = "";
    $json .= "{";
    foreach($info as $column => $value) {
	    if( utf8_encode($column) != 'codigo' ){
	        if($json[strlen($json)-1] != "{"){ $json .= ","; }
		    $json .= "\"".utf8_encode($column)."\":\"".utf8_encode($value)."\"";
	    }
		if( utf8_encode($column) == 'estatus' ){ $estatus = utf8_encode($value); }
		if( utf8_encode($column) == 'correo' ){ $correo = utf8_encode($value); }
		if( utf8_encode($column) == 'codigo' ){ $codigo = utf8_encode($value); }
	}
	if( ($estatus == 'insertado' || $estatus ==  'actualizado') && $correo != "" && $codigo != "" ){
	    $json = mailAltaUsuario($correo,$codigo,$json);
	}
    $json .= "}";
    return $json; 
}

function mailAltaUsuario($para, $codigo, $json){
    //Envio de correo para confirmar email
    $to = $para; // para
    $from = "admin@solucionafore.com"; // De quien
    $subjet = "SOLUCION AFORE confirma tu correo electronico"; // Asunto
    $message = "El codigo de verificación para confirmar tu correo electrónico <b>".$para."</b> es:<br><br> <b>".$codigo."</b><br><br> por favor proporcionalo para completar tu registro."; // mensaje
    
    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: '.$from. "\r\n";
    //$headers .= 'Cc: ' . "\r\n";
    // if you want to receive a copy
    $headers .= 'Bcc: ijimenez35@gmail.com' . "\r\n";
    // Mail it
    try{
    	mail($to, $subjet, $message, $headers);
    	
    	if($json[strlen($json)-1] != "{"){
			$json .= ",";
		}
		$json .= "\""."confirmacionCorreo"."\":\""."enviada"."\"";
	
    } catch (Exception $e) {
    	if($json[strlen($json)-1] != "{"){
			$json .= ",";
		}
		$json .= "\""."confirmacionCorreo"."\":\""."error"."\"";
    }
    
    return $json;
}

?>