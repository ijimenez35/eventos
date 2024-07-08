<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization");
header('Content-type: text/json');
header('Content-type: application/json');

$tipo = 1;

if(isset($_REQUEST['tipo'])){
    $tipo = $_REQUEST['tipo'];
}

chdir('..'); // para subir una carpeta /home/webersmx/public_html/sidali
// /arch/img/
$GLOBALS['vsRutaDocmRoot'] = getcwd();

$json = "{\"DatosJSON\":[";

//Borra todos los archivos array_map('unlink', glob("some/dir/*.txt"));

//Mover archivo
if( $tipo == 5 ){
    //copy('image1.jpg', 'del/image1.jpg');
    if( !isset($_REQUEST['archivo']) || !isset($_REQUEST['ruta']) ){
        $json .= "{";
        $json .= "\"estatus\": \"error\", ";
        $json .= "\"mensaje\": \"falta parametro archivo o ruta";
        $json .= "}";
    }else{
        $file_pointer = $GLOBALS['vsRutaDocmRoot'].'/' . $_REQUEST['archivo'] . '';
        
        if(is_file($file_pointer)){
            
            $path_parts = pathinfo($file_pointer);
            $basename = $path_parts['basename'];
            
            $nuevaRuta = $GLOBALS['vsRutaDocmRoot']."/".$_REQUEST['ruta'];
            
            if(file_exists($nuevaRuta)==false){ 
        		mkdir($nuevaRuta, 0777, true); 
        		chmod($nuevaRuta, 0777); 
        	}
            
            if (!rename($file_pointer, $nuevaRuta."/".$basename) ) {  
                $json .= "{";
                $json .= "\"archivo\": \"".$_REQUEST['archivo']."\", ";
                $json .= "\"estatus\": \"error\", ";
                $json .= "\"mensaje\": \"cannot be moved due to an error";
                $json .= "}";
            }  
            else {  
                //Borramos el archivo
                //unlink($file_pointer);
                $json .= "{";
                $json .= "\"archivo\": \"".$nuevaRuta."/".$basename."\", ";
                $json .= "\"estatus\": \"moved\", ";
                $json .= "\"mensaje\": \"has been moved";
                $json .= "}";
            }  
        }else{
            $json .= "{";
            $json .= "\"archivo\": \"".$_REQUEST['archivo']."\", ";
            $json .= "\"estatus\": \"error\", ";
            $json .= "\"mensaje\": \"error en isfile";
            $json .= "}";
        }
    }
}

//Copiar archivo
if( $tipo == 6 ){
    //copy('image1.jpg', 'del/image1.jpg');
    if( !isset($_REQUEST['archivo']) || !isset($_REQUEST['ruta']) ){
        $json .= "{";
        $json .= "\"estatus\": \"error\", ";
        $json .= "\"mensaje\": \"falta parametro archivo o ruta";
        $json .= "}";
    }else{
        $file_pointer = $GLOBALS['vsRutaDocmRoot'].'/' . $_REQUEST['archivo'] . '';
        
        if(is_file($file_pointer)){
            
            $path_parts = pathinfo($file_pointer);
            $basename = $path_parts['basename'];
            
            $nuevaRuta = $GLOBALS['vsRutaDocmRoot']."/".$_REQUEST['ruta'];
            
            if(file_exists($nuevaRuta)==false){ 
        		mkdir($nuevaRuta, 0777, true); 
        		chmod($nuevaRuta, 0777); 
        	}
            
            if (!copy($file_pointer, $nuevaRuta."/".$basename) ) {  
                $json .= "{";
                $json .= "\"archivo\": \"".$_REQUEST['archivo']."\", ";
                $json .= "\"estatus\": \"error\", ";
                $json .= "\"mensaje\": \"cannot be copied due to an error";
                $json .= "}";
            }  
            else {  
                //Borramos el archivo
                //unlink($file_pointer);
                $json .= "{";
                $json .= "\"archivo\": \"".$nuevaRuta."/".$basename."\", ";
                $json .= "\"estatus\": \"copied\", ";
                $json .= "\"mensaje\": \"has been copied";
                $json .= "}";
            }  
        }else{
            $json .= "{";
            $json .= "\"archivo\": \"".$_REQUEST['archivo']."\", ";
            $json .= "\"estatus\": \"error\", ";
            $json .= "\"mensaje\": \"error en isfile";
            $json .= "}";
        }
    }
}



//Contar archivos en el directorio
if( $tipo == 1 ){
    
    $targetPath = $GLOBALS['vsRutaDocmRoot'].'/' . $_REQUEST['ruta'] . '/';

    $directory = $targetPath;
    $filecount = 0;
    $files = glob($directory . "*");
    //$files = glob("*.{jpg,JPG,jpeg,JPEG,png,PNG}", GLOB_BRACE);
    if ($files){
        $filecount = count($files);
    }
    
    $json .= "{";
    $json .= "\"rutaRoot\": \"".$directory."\", ";
    $json .= "\"ruta\": \"".$_REQUEST['ruta']."\", ";
    $json .= "\"archivos\": \"".$filecount."\"";
    $json .= "}";
}

//Listar archivos en el directorio
if( $tipo == 2 ){
    $archivos = [];
    
    $targetPath = $GLOBALS['vsRutaDocmRoot'].'/' . $_REQUEST['ruta'] . '/';
    $directory = $targetPath;
    
    $psPtrn = "*";

    if( isset($_REQUEST['psPtrn']) ){
        $psPtrn = $_REQUEST['psPtrn'];
    }
    
    $files = glob($directory . $psPtrn);

    //Sacamos los archivos
    foreach($files as $i=>$filename){
        if(is_file($filename)){
            array_push($archivos, $filename);
        }   
    }
    
    //Loop through the array that glob returned.
    foreach($archivos as $i=>$filename){
        
        $path_parts = pathinfo($filename);
    
        if( $i != 0 ){
           $json .= ",";
        }
        
        $json .= "{";
        
        //$json .= "\"file\": \"".$filename."\",";
        $json .= "\"fechaCreacion\": \"".date ("Y/m/d H:i:s", filectime($filename))."\",";
        //$json .= "\"nombre\": \"".basename($filename)."\"";
        //$json .= "\"dirname\": \"".$path_parts['dirname']."\",";
        $json .= "\"basename\": \"".$path_parts['basename']."\",";
        $json .= "\"extension\": \"".$path_parts['extension']."\",";
        $json .= "\"filename\": \"".$path_parts['filename']."\"";
        
        $json .= "}";
       
    }
}

//Borar archivo
if( $tipo == 3 ){
    if( !isset($_REQUEST['archivo']) ){
        $json .= "{";
        $json .= "\"archivo\": \"".$_REQUEST['archivo']."\", ";
        $json .= "\"estatus\": \"error\", ";
        $json .= "\"mensaje\": \"falta parametro archivo";
        $json .= "}";
    }else{
        $file_pointer = $GLOBALS['vsRutaDocmRoot'].'/' . $_REQUEST['archivo'] . '';
        if(is_file($file_pointer)){
            if (!unlink($file_pointer)) {  
                $json .= "{";
                $json .= "\"archivo\": \"".$_REQUEST['archivo']."\", ";
                $json .= "\"estatus\": \"error\", ";
                $json .= "\"mensaje\": \"cannot be deleted due to an error";
                $json .= "}";
            }  
            else {  
                $json .= "{";
                $json .= "\"archivo\": \"".$_REQUEST['archivo']."\", ";
                $json .= "\"estatus\": \"deleted\", ";
                $json .= "\"mensaje\": \"has been deleted";
                $json .= "}";
            }  
        }else{
            $json .= "{";
            $json .= "\"archivo\": \"".$_REQUEST['archivo']."\", ";
            $json .= "\"estatus\": \"error\", ";
            $json .= "\"mensaje\": \"error en isfile";
            $json .= "}";
        }
    }
}

//Renombrar archivo
if( $tipo == 4 ){
    //rename('image1.jpg', 'del/image1.jpg');
    if( !isset($_REQUEST['archivo']) || !isset($_REQUEST['nombre']) ){
        $json .= "{";
        $json .= "\"estatus\": \"error\", ";
        $json .= "\"mensaje\": \"falta parametro archivo o nombre";
        $json .= "}";
    }else{
        $file_pointer = $GLOBALS['vsRutaDocmRoot'].'/' . $_REQUEST['archivo'] . '';
        if(is_file($file_pointer)){
            
            $path_parts = pathinfo($file_pointer);
            $ruta = $path_parts['dirname'];
            $ext = $path_parts['extension'];
            
            $newName = $_REQUEST['nombre'];
            
            if (!rename($file_pointer, $ruta."/".$newName.".".$ext )) {  
                $json .= "{";
                $json .= "\"archivo\": \"".$_REQUEST['archivo']."\", ";
                $json .= "\"estatus\": \"error\", ";
                $json .= "\"mensaje\": \"cannot be renamed due to an error";
                $json .= "}";
            }  
            else {  
                $json .= "{";
                $json .= "\"archivo\": \"".$_REQUEST['archivo']."\", ";
                $json .= "\"ruta\": \"$ruta\", ";
                $json .= "\"ext\": \"$ext\", ";
                $json .= "\"estatus\": \"rename\", ";
                $json .= "\"mensaje\": \"has been renamed";
                $json .= "}";
            }  
        }else{
            $json .= "{";
            $json .= "\"archivo\": \"".$_REQUEST['archivo']."\", ";
            $json .= "\"estatus\": \"error\", ";
            $json .= "\"mensaje\": \"error en isfile";
            $json .= "}";
        }
    }
}

$json .= "]}";
echo $json;
?>