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
	
	$myFile = "../txt/sql/slct/".$_REQUEST['_cnsl'].".sql";
	
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
		
		if( isset($_REQUEST['_vq']) ){
		    if($_REQUEST['_vq']){
		        	echo $sql."<br>";
		            exit();
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
			    $mysqli = mysqli_connect("$host", "$username", "$password","$db_name");
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
                            //$info = mysqli_fetch_assoc($result);
                            $numOfRows = mysqli_num_rows($result);
                            //echo "IF(".$numOfRows.")->".$part."<br><br><br>" ;
                            /*
                            do {
                                if($numOfRows > 0){
                    			    if($json != "{\"DatosJSON\":["){ $json .= ","; }
                			    	$json = generaColumnas( $info, $json );
                    			}
                    		}while ($info = mysqli_fetch_array($result, MYSQL_ASSOC));
                    		*/
                    		while ($info = mysqli_fetch_array($result)) { //for every fetch we'll get one row.
                                if($json != "{\"DatosJSON\":["){ $json .= ","; }
                    			$json = generaColumnas( $info, $json );
                            }
                        
                    		mysqli_free_result($result);
                    	}
                    	//Error
                    	if( $mysqli->error ){
                    	    if( $mysqli->error != "Commands out of sync; you can't run this command now"){
                    	        if($json != "{\"DatosJSON\":["){ $json .= ","; }
                        	    $json .= "{";
            					$json .= "\"estatus\": \"error SP\", \"observaciones\": \"".utf8_encode( $mysqli->error )."\", \"query\":\"".utf8_encode($part)."\"";
            					$json .= "}";
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
                                	//$info = mysqli_fetch_assoc($result);
                                	if($numOfRows > 0){
                                	    /*
                                		do {
                                		    if($json != "{\"DatosJSON\":["){ $json .= ","; }
                                			$json = generaColumnas( $info, $json );
                                		}
                                		while ($info = mysqli_fetch_array($result, MYSQL_ASSOC));
                                		*/
                                		while ($info = mysqli_fetch_array($result)) { //for every fetch we'll get one row.
                                            if($json != "{\"DatosJSON\":["){ $json .= ","; }
                                			$json = generaColumnas( $info, $json );
                                        }
                        
                                	}
                                }
                                mysqli_free_result($result);
                            }
                        } while ($mysqli->next_result());
                    }
                    //Error
                    if( $mysqli->error ){
                	    if( $mysqli->error != "Commands out of sync; you can't run this command now"){
                	        if($json != "{\"DatosJSON\":["){ $json .= ","; }
                    	    $json .= "{";
            				$json .= "\"estatus\": \"error SP\", \"observaciones\": \"".utf8_encode( $mysqli->error )."\", \"query\":\"".utf8_encode($part)."\"";
            				$json .= "}";
                	    }
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
                        //$info = mysqli_fetch_assoc($result);
                        $numOfRows = mysqli_num_rows($result);
                        //echo "IF(".$numOfRows.")->".$part."<br><br><br>" ;
                        /*
                        do {
                			if($numOfRows){
                			    if($json != "{\"DatosJSON\":["){ $json .= ","; }
            			    	$json = generaColumnas( $info, $json );
                			}
                		}
                		while ($info = mysqli_fetch_array($result, MYSQL_ASSOC));
                		*/
                		while ($info = mysqli_fetch_array($result)) { //for every fetch we'll get one row.
                            if($json != "{\"DatosJSON\":["){ $json .= ","; }
                			$json = generaColumnas( $info, $json );
                        }
                		mysqli_free_result($result);
                	}
                	
                	if( $mysqli->error ){
                	    if( $mysqli->error != "Commands out of sync; you can't run this command now"){
                	        if($json != "{\"DatosJSON\":["){ $json .= ","; }
                    	    $json .= "{";
        					$json .= "\"estatus\": \"error SP\", \"observaciones\": \"".utf8_encode( $mysqli->error )."\", \"query\":\"".utf8_encode($part)."\"";
        					$json .= "}";
                	    }
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
                            	//$info = mysqli_fetch_assoc($result);
                            	if($numOfRows > 0){
                            	    /*
                            		do {
                            			if($json != "{\"DatosJSON\":["){ $json .= ","; }
                            			$json = generaColumnas( $info, $json );
                            		}
                            		while ($info = mysqli_fetch_array($result, MYSQL_ASSOC));
                            		*/
                            		while ($info = mysqli_fetch_array($result)) { //for every fetch we'll get one row.
                                        if($json != "{\"DatosJSON\":["){ $json .= ","; }
                            			$json = generaColumnas( $info, $json );
                                    }
                            	}
                            }
                            $mysqli->free();
                        }
                	
                    } while ($mysqli->next_result());
                }
                //Error
                if( $mysqli->error ){
            	    if( $mysqli->error != "Commands out of sync; you can't run this command now"){
            	        if($json != "{\"DatosJSON\":["){ $json .= ","; }
                	    $json .= "{";
        				$json .= "\"estatus\": \"error SP\", \"observaciones\": \"".utf8_encode( $mysqli->error )."\", \"query\":\"".utf8_encode($part)."\"";
        				$json .= "}";
            	    }
            	}
            }
        }
    } else {
        //$mysqli->multi_query($sql);
        //while ($mysqli->next_result()) {;}
        if ( $mysqli->multi_query($sql) ) {
            
            $contador = 0;
        
            do {
                if ($result = $mysqli->store_result()) { 
                    if(!$mysqli->more_results() ){ 
                        //$numOfCols = $mysqli->fetch_fields($result);
                    	$numOfRows = mysqli_num_rows($result);
                    	//$info = mysqli_fetch_assoc($result);
                    	if($numOfRows > 0){
                    	    /*
                    		do {
                    		    $contador = $contador + 1;
                    			if($json != "{\"DatosJSON\":["){ $json .= ","; }
                    			$json = generaColumnas( $info, $json );
                    		}
                    		while ($info = mysqli_fetch_array($result, MYSQL_ASSOC));
                    		*/
                    		while ($info = mysqli_fetch_array($result)) { //for every fetch we'll get one row.
                                if($json != "{\"DatosJSON\":["){ $json .= ","; }
                    			$json = generaColumnas( $info, $json );
                            }
                    	}
                    }
                    mysqli_free_result($result);
                }
                
                if( $mysqli->error ){
            	    if( $mysqli->error != "Commands out of sync; you can't run this command now"){
            	        if($json != "{\"DatosJSON\":["){ $json .= ","; }
                	    $json .= "{";
    					$json .= "\"estatus\": \"error SP\", \"observaciones\": \"".utf8_encode( $mysqli->error )."\", \"query\":\"".utf8_encode($sql)."\"";
    					$json .= "}";
            	    }
            	}
                	
            } while ($mysqli->next_result());
            
            //echo "aqui ".$contador;
            //exit();
            
        }
        
        if( $mysqli->error ){
    	    if( $mysqli->error != "Commands out of sync; you can't run this command now"){
    	        if($json != "{\"DatosJSON\":["){ $json .= ","; }
        	    $json .= "{";
				$json .= "\"estatus\": \"error SP\", \"observaciones\": \"".utf8_encode( $mysqli->error )."\", \"query\":\"".utf8_encode($part)."\"";
				$json .= "}";
    	    }
    	}
    }
    return $json;
}

function generaColumnas( $info, $json ){
    $json .= "{";
    foreach($info as $column => $value) {
	    //if( utf8_encode($column) != 'codigo' ){
	        if($json[strlen($json)-1] != "{"){ $json .= ","; }
		    $json .= "\"".utf8_encode($column)."\":\"".utf8_encode($value)."\"";
	    //}
	}
    $json .= "}";
    return $json;
}

?>