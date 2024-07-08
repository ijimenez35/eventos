<?php

require('conexion.php');
include_once 'lib/BeforeValidException.php';
include_once 'lib/ExpiredException.php';
include_once 'lib/SignatureInvalidException.php';
include_once 'lib/JWT.php';
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization");

$cnxn = new Conexion;

$host= $cnxn->host;
$userdb=$cnxn->username;
$passdb=$cnxn->password;
$db_name=$cnxn->db_name;
$tbl_name=$cnxn->tbl_name;

$Login = $_POST['email'] ? $_POST['email'] : '';
$Password = $_POST['cntr'] ? $_POST['cntr'] : '';

/*
SELECT 
id, 
cntr, 
nombre, 
aPaterno, 
aMaterno, 
correo, 
telefono, 
fechaAlta, 
idEstatus
FROM usuarios 
where correo = '@login' and cntr = '@password' and idEstatus = 1
*/

header('Content-type: text/json');
header('Content-type: application/json');

//$json = "{\"DatosJSON\":[";
$json = "";

try{ // Connect to server and select databse.
	//$link = mysql_connect("$host", "$userdb", "$passdb")or die("cannot connect"  . mysql_error());
	$mysqli = new mysqli("$host", "$userdb", "$passdb", "$db_name");
	
	//mysql_select_db("$db_name")or die("cannot select DB" . mysql_error());
	//mysql_select_db("$db_name");
	
	$myFile = "../txt/sql/login.sql";
	if( $_REQUEST['email'] == '' || $_REQUEST['cntr'] == ''){
	    $json .= "{\"estatus\": \"error\", \"observaciones\": \"parametros faltantes\"}";
	}else{
		if(!file_exists($myFile)){
		    $json .= "{\"estatus\": \"error\", \"observaciones\": \"consulta no encontrada en el servidor!!\", \"archivo\": \"$myFile\"}";
		}else{
			$fh = fopen($myFile, 'r');
			$sql = fread($fh, filesize($myFile));
			fclose($fh);
			$super_globals = array('_GET', '_POST');
			foreach($super_globals as $sg1){
				foreach($GLOBALS[$sg1] as $k1=>$v1){
					$ret1[$k1] = $v1;
					//if($k1 != '_query'){
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
			//echo $sql; exit();
			try {
			    //Coneccion a la db 
			    $con = mysqli_connect("$host", "$userdb", "$passdb","$db_name");
			    // Execute multi query
                if (mysqli_multi_query($con, $sql)) {
                    do {
                        // Store first result set
                        if ($result = mysqli_store_result($con)) {
                          // the last consult
                            if( !mysqli_more_results($con) ){ 
                                $numOfCols = mysqli_fetch_fields($result);
            					$numOfRows = mysqli_num_rows($result);
            					$info = mysqli_fetch_assoc($result);
            					if($numOfRows > 0){
            						do {
            						    $estatus = "exito"; $idUser = ""; $nombre = ""; $aPaterno = ""; $email = "";
            						    $json .= "{";
            							$json .= "\"estatusUsuario\":\"exito\"";
            							foreach($info as $column => $value) {
            								if($json[strlen($json)-1] != "{"){
            									$json .= ",";
            								}
            								$json .= "\"".utf8_encode($column)."\":\"".utf8_encode($value)."\"";
            								//Variable para mi token
            								//if( utf8_encode($column) == 'estatusUsuario' ){ $estatus = utf8_encode($value); }
            								if( utf8_encode($column) == 'id' ){ $idUser = utf8_encode($value); }
                            				if( utf8_encode($column) == 'nombre' ){ $nombre = utf8_encode($value); }
                            				if( utf8_encode($column) == 'aPaterno' ){ $aPaterno = utf8_encode($value); }
                            				if( utf8_encode($column) == 'correo' ){ $email = utf8_encode($value); }
            							}
            							//Genero el JWT
                            			if( $estatus == 'exito' && $idUser != "" && $nombre != "" && $aPaterno != "" && $email != "" ){
                            			    $token = generaToken($idUser,$nombre,$aPaterno,$email);
                            			    if($json[strlen($json)-1] != "{"){ $json .= ","; }
                            			    $json .= "\"token\":\"".utf8_encode($token)."\"";
                            			}
            							$json .= "}";
            						}
            						//while ($info = mysql_fetch_array($result, MYSQL_ASSOC));
							        while ($info = $result->fetch_array());
            						mysqli_free_result($result);
            					}else{
            					    $json .= "{";
                                	$json .= "\"estatus\": \"error\"";
                                	$json .= "}";
            					}
                          }

                          //while ($row = mysqli_fetch_row($result)) {
                            //printf("%s\n", $row[0]);
                          //}
                          
                          //mysqli_free_result($result);
                          
                        }
                        
                        // if there are more result-sets, the print a divider
                        //if (mysqli_more_results($con)) {
                          //printf("-------------\n");
                        //}
                        
                     //Prepare next result set
                    } while (mysqli_next_result($con));
                    
                }else{
                    $json .= "{";
					$json .= "\"estatus\": \"error 4\", \"observaciones\": \"".utf8_encode(mysqli_error())."\", \"query\":\"".utf8_encode($sql)."\"";
					$json .= "}";
                }
			} catch (Exception $e) {
			    $json .= "{";
    			$json .= "\"estatus\": \"error\", \"observaciones\": \"".utf8_encode($e->getMessage())."\"";
    			$json .= "\"query\": \"".utf8_encode($sql)."\", \"caught_exception\": \"".utf8_encode($e->getMessage())."\"";
    			$json .= "}";
			}
			//mysql_close($link); // Cerrar la conexion
			$mysqli -> close();
		}
	}
} catch (Exception $e) {
    $json .= "{";
	$json .= "\"estatus\": \"error\", \"observaciones\": \"".utf8_encode($e->getMessage())."\"";
	$json .= "\"query\": \"".utf8_encode($sql)."\", \"caught_exception\": \"".utf8_encode($e->getMessage())."\"";
	$json .= "}";
}

//$json .= "]}";
$json .= "";
echo $json;

function generaToken($idUser,$nombre,$aPaterno,$email){
    
    $key = "solucionaforeAdmin";
    $token = array(
        "iss" => "http://solucionafore.com",
        "aud" => "http://solucionafore.com",
        "iat" => 1356999524,
        "nbf" => 1357000000,
        "data" => array(
            "id" => $idUser,
            "nombre" => $nombre,
            "aPaterno" => $aPaterno,
            "email" => $email
        )
    );
    
    $jwt = JWT::encode($token, $key);
    
    return $jwt;
    //return "";
    
}
?>
