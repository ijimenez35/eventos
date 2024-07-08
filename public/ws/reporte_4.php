<?php
require('lib/fpdf.php');
//require('lib/html2pdf.php'); //use with WriteHTML

ini_set('memory_limit','1024M');

function getIngresoMensual($clave) {
  //code to be executed;
  //number_format(1.2378147769392E+14,0,'','')
  //cve_unica
  $text = "---";
  if( $clave == "A/B"){
      $text = '+ de $30,000';
  }
  if( $clave == "C+"){
      $text = '$16,000 a $30,000';
  }
  if( $clave == "C"){
      $text = '$9,000 a $15,000';
  }
  if( $clave == "C-"){
      $text = '$7,000 a $8,000';
  }
  if( $clave == "D+"){
      $text = '$5,000 a $6,000';
  }
  if( $clave == "D"){
      $text = '$2,000 a $4,000';
  }
  if( $clave == "E"){
      $text = '$500 a $1,000';
  }
  return $text;
}

function getNumber($number){
    if( is_numeric($number) ){
        return number_format($number,0,'','');
    }else{
        return $number;
    }
}

$pdf = new FPDF();
//$pdf = new PDF_HTML(); //use with WriteHTML
$anchoPagina = 190;
$month = "Agosto";
$year = "2023";
$vista = 'I';

if( isset($_REQUEST['month']) ){
    $month = $_REQUEST['month'];
}

if( isset($_REQUEST['year']) ){
    $year = $_REQUEST['year'];
}

if( isset($_REQUEST['vista']) ){
    $vista = $_REQUEST['vista'];
}

$voJSON=json_decode($_REQUEST['Datos']);

//Portada
$pdf->AddPage();
$pdf->Image('../img/doc/encabezado_4.jpg', 0 , 0 , 210, 32);
$pdf->Image('../img/doc/pie_4.jpg', 0 , 265 , 210, 32);
$pdf->Image('../img/doc/firma_4__.png', 76 , 232 , 60, 12);

$Y_Pagina_1 = 23;
$saltoLinea = 5.5;

//$pdf->SetY( $Y_Pagina_1 + 5 );
//$pdf->SetFont('Arial','B',20);
//$pdf->Cell($anchoPagina,10,'Carta de Entrega','0', '0', 'C');

//Fecha
$pdf->SetY( $Y_Pagina_1 + 15);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(52,114,247);
$pdf->Cell($anchoPagina,7,$month.' '.$year,'', '0', 'R');
$pdf->SetTextColor(0,0,0);

$pdf->SetY( $Y_Pagina_1 + 27);
$pdf->SetFont('Arial','B',12);

$pdf->Cell($anchoPagina,$saltoLinea,'SERVICIOS PROFESIONALES FISCALES OTMAN, S. de R.L. de C.V.','0', '0', 'R');
$pdf->Ln();
$pdf->Cell($anchoPagina,$saltoLinea,'Calle Pilares 1022, Interior 7','0', '0', 'R');
$pdf->Ln();
$pdf->Cell($anchoPagina,$saltoLinea,'Colonia Letrán Valle, Alcaldía Benito Juárez','0', '0', 'R');
$pdf->Ln();
$pdf->Cell($anchoPagina,$saltoLinea,'Ciudad de México, C.P. 03650','0', '0', 'R');
$pdf->Ln();
$pdf->Cell($anchoPagina,$saltoLinea,'Tel: 5645227922','0', '0', 'R');
$pdf->Ln();
//$pdf->SetFont('Arial','U',12);
$pdf->Cell($anchoPagina,$saltoLinea,'Correo: admin@otman.mx; serviciosotman@gmail.com','0', '0', 'R');
$pdf->Ln(3);

$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->Cell($anchoPagina,$saltoLinea,'AFORE XXI BANORTE','0', '0', 'L');
$pdf->Ln();
$pdf->Cell($anchoPagina,$saltoLinea,'Dirección de Asesoría Previsional','0', '0', 'L');
$pdf->Ln();
$pdf->Cell($anchoPagina,$saltoLinea,'AVENIDA PASEO DE LA REFORMA No. EXTERIOR 489, No. INTERIOR PISO 3,','0', '0', 'L');
$pdf->Ln();
$pdf->Cell($anchoPagina,$saltoLinea,'COLONIA CUAUHTEMOC ALCALDIA, CUAUHTEMOC, ESTADO CIUDAD DE MEXICO','0', '0', 'L');
$pdf->Ln();
$pdf->Cell($anchoPagina,$saltoLinea,'C.P. 06500 ','0', '0', 'L');

//Contenido
$pdf->SetY( $Y_Pagina_1 + 108);
$pdf->SetFont('Arial','',12);
$pdf->MultiCell($anchoPagina,$saltoLinea, "A través de la presente yo, Jonathan Reyes Carbajal representante de Servicios Profesionales Fiscales Otman, S. de R.L. de C.V., hago entrega oficial junto a esta carta de los servicios consistentes en Servicios de Análisis de Mercado y Tramites relacionados con la prospectación de la nueva afiliación, En cumplimiento a lo dispuesto en el contrato celebrado.\n\n 
De acuerdo con la base de prospectos potenciales, se procesa un cruce de información para identificar los domicilios y ubicaciones por código postal. Con la información obtenida se realiza un análisis del espacio geográfico donde se ubican y se obtienen características demográficas y económicas de las viviendas con características similares.\n\n
La información que ha sido suministrada anteriormente ha sido certificada por ambas partes. Por ello afirmamos que hay pleno consentimiento de la entrega y los productos entregados corresponden a los solicitados por AFORE XXI BANORTE", '0', 'J', false );
$pdf->Ln(7);
$pdf->Cell($anchoPagina,$saltoLinea,'Atentamente','0', '0', 'C');
$pdf->Ln(22);
$pdf->Cell($anchoPagina,$saltoLinea,'Jonathan Reyes Carbajal','0', '0', 'C');
$pdf->Ln();
$pdf->Cell($anchoPagina,$saltoLinea,'Representante que entrega los Servicios','0', '0', 'C');

//Prospectos
$pdf->AddPage();
$pdf->Image('../img/doc/encabezado_4.jpg', 0 , 0 , 210, 32);
$pdf->Image('../img/doc/pie_4.jpg', 0 , 265 , 210, 32);
$pdf->SetY(21);
$pdf->SetFont('Arial','BU',10);
//$pdf->Cell($anchoPagina,10,'MUESTRA PARA ANÁLISIS DE PROSPECTOS','0', '0', 'C');

$pdf->SetY( 258);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell($anchoPagina,3.8, "Para la obtención de las identificaciones del CURP se definieron las iniciales de la primera letra y vocal del apellido paterno la primera consonante del apellido materno, la primera letra del nombre, año, mes, día, sexo, entidad de nacimiento y conclave en un total de 18 caracteres.", '0', 'J', false );

$pdf->SetY(35);
$pdf->SetFont('Arial','B',10);
//Cabeceras de la tabla
$pdf->SetFillColor(220,220,220);
$pdf->SetDrawColor(220,220,220);
$pdf->Cell(35,10,'No. De identificación','1', '0', 'C', true);
$pdf->Cell(60,10,'CURP','1', '0', 'C', true);
$pdf->Ln();
$columna = 1;

$pdf->SetFillColor(255,255,255);
foreach($voJSON->DatosJSON as $JSON){
    
    if( $columna == 1 && $pdf->GetY() > 250){ //Otra columna
        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY(105, 35);
        //Cabeceras de la tabla
        $pdf->SetFillColor(220,220,220);
        $pdf->SetDrawColor(220,220,220);
        $pdf->Cell(35,10,'No. De identificación','1', '0', 'C', true);
        $pdf->Cell(60,10,'CURP','1', '0', 'C', true);
        $pdf->Ln();
        $columna = 2;
    }else 
    
    if( $columna == 2 && $pdf->GetY() > 250 ){ //Pagina nueva
        $columna = 1;
        $pdf->AddPage();
        $pdf->Image('../img/doc/encabezado_4.jpg', 0 , 0 , 210, 32);
        $pdf->Image('../img/doc/pie_4.jpg', 0 , 265 , 210, 32);
        $pdf->SetY(23);
        $pdf->SetFont('Arial','BU',10);
        //$pdf->Cell($anchoPagina,10,'MUESTRA PARA ANÁLISIS DE PROSPECTOS','0', '0', 'C');
        $pdf->SetY( 258);
        $pdf->SetFont('Arial','',9);
        $pdf->MultiCell($anchoPagina,3.8, "Para la obtención de las identificaciones del CURP se definieron las iniciales de la primera letra y vocal del apellido paterno la primera consonante del apellido materno, la primera letra del nombre, año, mes, día, sexo, entidad de nacimiento y conclave en un total de 18 caracteres.", '0', 'J', false );

        $pdf->SetY(35);
        $pdf->SetFont('Arial','B',10);
        //Cabeceras de la tabla
        $pdf->SetFillColor(220,220,220);
        $pdf->SetDrawColor(220,220,220);
        $pdf->Cell(35,10,'No. De identificación','1', '0', 'C', true);
        $pdf->Cell(60,10,'CURP','1', '0', 'C', true);
        $pdf->Ln();
    }
    
    if( $columna == 1 ){
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(255,191,0); //Amarillo
        $pdf->SetFont('Arial','',13);
        $pdf->Cell(35,10,utf8_decode($JSON->nmroCntr),'1', '0', 'C');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(60,10,utf8_decode($JSON->curp),'1', '0', 'C');
        $pdf->Ln();
    }else{
        $pdf->SetX(105);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(255,191,0); //Amarillo
        $pdf->SetFont('Arial','',13);
        $pdf->Cell(35,10,utf8_decode($JSON->nmroCntr),'1', '0', 'C');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(60,10,utf8_decode($JSON->curp),'1', '0', 'C');
        $pdf->Ln();
    }
    
    
    
}

//Paginas por Numero de Control
foreach($voJSON->DatosJSON as $JSON){
    
    //Pagina 1
    $pdf->AddPage();
    $pdf->Image('../img/doc/encabezado_4.jpg', 0 , 0 , 210, 32);
    $pdf->Image('../img/doc/pie_4.jpg', 0 , 265 , 210, 32);
    
    $pdf->SetY(40);
    //$pdf->SetTextColor(255,191,0); //Amarillo
    $pdf->SetFont('Arial','',13);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($anchoPagina,10,'No. Control '.utf8_decode($JSON->nmroCntr) ,'', '0', 'L', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(25, 10, ' CURP','1', '0', 'L');
    $pdf->Cell(55, 10, utf8_decode($JSON->curp) ,'1', '0', 'L');
    $pdf->Cell(110, 10, "AGEB" ,'LTR', '0', 'C');
    $pdf->Ln();
    $pdf->Cell(25, 10, ' Sexo','1', '0', 'L');
    $pdf->Cell(55, 10, utf8_decode($JSON->sexo) ,'1', '0', 'L');
    $pdf->Ln();
    $pdf->Cell(25, 10, ' Edad','1', '0', 'L');
    $pdf->Cell(55, 10, utf8_decode($JSON->edad) ,'1', '0', 'L');
    $pdf->Ln();
    $pdf->Cell(25, 10, ' Estado','1', '0', 'L');
    $pdf->Cell(55, 10, utf8_decode($JSON->estd) ,'1', '0', 'L');
    $pdf->Ln();
    $pdf->Cell(25, 10, ' Municipio','1', '0', 'L');
    $pdf->Cell(55, 10, utf8_decode($JSON->mncp) ,'1', '0', 'L');
    $pdf->Ln();
    $pdf->Cell(25, 10, ' C. P.','1', '0', 'L');
    $pdf->Cell(55, 10, utf8_decode($JSON->cp) ,'1', '0', 'L');
    $pdf->Ln();
    $pdf->Cell(25, 10, ' AGEB','1', '0', 'L');
    $pdf->Cell(55, 10, utf8_decode($JSON->ageb) ,'1', '0', 'L');
    $pdf->Ln();
    
    $pdf->SetXY(90,80);
    $pdf->Cell(110, 130, '','LBR', '0', 'L');
    
    if( file_exists( '../img_claveunica/'.utf8_decode($JSON->cve_unica).'.jpg' ) ){
        $pdf->Image( '../img_claveunica/'.utf8_decode($JSON->cve_unica).'.jpg', 95 , 90 , 100, 100);
    }else{
        $pdf->Image( '../img_claveunica/100000000.jpg', 95 , 90 , 100, 100);
    }

    //$pdf->Image( '../img_claveunica/0100100012668.jpg', 20 , 120 , 170, 120);
    //Fin Pagina 1
    
    //Pagina 2
    $pdf->AddPage();
    $pdf->Image('../img/doc/encabezado_4.jpg', 0 , 0 , 210, 32);
    $pdf->Image('../img/doc/pie_4.jpg', 0 , 265 , 210, 32);
    $pdf->SetY(31);
    $pdf->SetTextColor(0,0,0); //Negro
    $pdf->SetFont('Arial','BU',11);
    $pdf->Cell($anchoPagina/2,10,'Datos socioeconomicos y económicos' ,'0', '0', 'L', true);
    //$pdf->SetY(31);
    $pdf->Cell($anchoPagina/2,10,'Número de viviendas '.utf8_decode($JSON->v) ,'0', '0', 'R', true);
    
    $pdf->SetY(42);
    $altoCelda = 10;
    $valor_X_Plus = 6;
    $valor_Y_Plus = 1;
    $imagen_W = 8;
    $imagen_H = 8;
    $pdf->SetFont('Arial','',11);
    $pdf->SetDrawColor(180,180,180);
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda, "" ,'B', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población total' ,'B', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->pt) ,'B', '0', 'C', true);
    $pdf->Image('../img/doc/image5.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población total femenina' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->ptf) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image7.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población total masculina' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->ptm) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image9.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población 18 +' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->p18plus) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image11.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población 18+ femenina' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->p18plusf) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image13.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población 18+ masculina' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->p18plusm) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image15.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población 60+' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->p60) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image17.png', $valor_X + $valor_X_Plus - 4, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Image('../img/doc/image19.png', $valor_X + $valor_X_Plus + 4, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población 60+ femenina' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->p60f) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image21.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población 60+ masculina' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->p60m) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image23.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Grado promedio de escolaridad (años)' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->gpe) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image25.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población Económicamente Activa' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->pea) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image27.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población Económicamente Activa femenina' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->peaf) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image29.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población Económicamente Activa masculina' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->peam) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image31.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población ocupada' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->po) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image33.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población ocupada femenina' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->pof) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image35.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población ocupada masculina' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->pom) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image37.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población afiliada a servicios de salud' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->pass) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image39.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población afiliada al IMSS' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->paIMSS) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image41.png', $valor_X + $valor_X_Plus - 2.5, $valor_Y + $valor_Y_Plus, $imagen_W + 5, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población afiliada al ISSSTE' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->paISSSTE) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image42.png', $valor_X + $valor_X_Plus - 2.5, $valor_Y + $valor_Y_Plus, $imagen_W + 5, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Población afiliada al ISSSTE estatal' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->paISSSTEe) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image42.png', $valor_X + $valor_X_Plus - 2.5, $valor_Y + $valor_Y_Plus, $imagen_W + 5, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Nivel de Condiciones Socioeconómicas' ,'BT', '0', 'L', true);
    $pdf->Cell(50,$altoCelda,utf8_decode($JSON->ncs) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->Cell(20,$altoCelda,"" ,'BT', '0', 'C', true);
    $pdf->Cell(120,$altoCelda,'Ingreso promedio mensual' ,'BT', '0', 'L', true);
    //$pdf->Cell(50,$altoCelda,utf8_decode($JSON->ipm) ,'BT', '0', 'C', true);
    $pdf->Cell(50,$altoCelda,getIngresoMensual(utf8_decode($JSON->ncs)) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image45.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    //$pdf->Ln();
    
    $pdf->SetX(0);
    $pdf->SetY(264);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell($anchoPagina, 5, "*se omiten cifras por tema de confidencialidad de datos. N/D implica información no disponible por la AMAI",'0', '0', 'L', true);
    //Fin Pagina 2
    
    //Pagina 3
    $altoCelda2 = 13;
    $valor_X_Plus = 6.3;
    $valor_Y_Plus = 1.5;
    $imagen_W = 10;
    $imagen_H = 10;
    
    $pdf->AddPage();
    $pdf->Image('../img/doc/encabezado_4.jpg', 0 , 0 , 210, 32);
    $pdf->Image('../img/doc/pie_4.jpg', 0 , 265 , 210, 32);
    
    $pdf->SetY(35);
    $pdf->SetTextColor(0,0,0); //Negro
    $pdf->SetFont('Arial','BU',11);
    $pdf->Cell(140, 10,'Datos de unidades económicas' ,'0', '0', 'L', true);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(50, 10,"AGEB ".utf8_decode($JSON->ageb) ,'0', '0', 'C', true);
    
    $pdf->SetY(50);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(140, $altoCelda2,'Total de unidades económicas' ,'B', '0', 'L', true);
    $pdf->Cell(50, $altoCelda2,utf8_decode($JSON->total_ue) ,'B', '0', 'C', true);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(20, $altoCelda2,'' ,'BT', '0', 'L', true);
    $pdf->Cell(120, $altoCelda2,'0 a 5 empleados' ,'BT', '0', 'L', true);
    $pdf->Cell(50, $altoCelda2,utf8_decode($JSON->{"0-5"}) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image47.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(20, $altoCelda2,'' ,'BT', '0', 'L', true);
    $pdf->Cell(120, $altoCelda2,'6 a 10 empleados' ,'BT', '0', 'L', true);
    $pdf->Cell(50, $altoCelda2,utf8_decode($JSON->{"6-10"}) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image49.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(20, $altoCelda2,'' ,'BT', '0', 'L', true);
    $pdf->Cell(120, $altoCelda2,'11 a 30 empleados' ,'BT', '0', 'L', true);
    $pdf->Cell(50, $altoCelda2,utf8_decode($JSON->{"11-30"}) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image51.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(20, $altoCelda2,'' ,'BT', '0', 'L', true);
    $pdf->Cell(120, $altoCelda2,'31 a 50 empleados' ,'BT', '0', 'L', true);
    $pdf->Cell(50, $altoCelda2,utf8_decode($JSON->{"31-50"}) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image53.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(20, $altoCelda2,'' ,'BT', '0', 'L', true);
    $pdf->Cell(120, $altoCelda2,'51 a 100 empleados' ,'BT', '0', 'L', true);
    $pdf->Cell(50, $altoCelda2,utf8_decode($JSON->{"51-100"}) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image55.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(20, $altoCelda2,'' ,'BT', '0', 'L', true);
    $pdf->Cell(120, $altoCelda2,'101 a 250 empleados' ,'BT', '0', 'L', true);
    $pdf->Cell(50, $altoCelda2,utf8_decode($JSON->{"101-250"}) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image57.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    $valor_X =  $pdf->GetX();
    $valor_Y =  $pdf->GetY();
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(20, $altoCelda2,'' ,'BT', '0', 'L', true);
    $pdf->Cell(120, $altoCelda2,'Más de 250 empleados' ,'BT', '0', 'L', true);
    $pdf->Cell(50, $altoCelda2,utf8_decode($JSON->{"251"}) ,'BT', '0', 'C', true);
    $pdf->Image('../img/doc/image67.png', $valor_X + $valor_X_Plus, $valor_Y + $valor_Y_Plus, $imagen_W, $imagen_H);
    $pdf->Ln();
    
    
    $pdf->SetX(0);
    $pdf->SetY(190);
    
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell($anchoPagina, 5, "Nota:",'0', '0', 'L', true);
    
    $pdf->SetY(210);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(15, 5, "•",'0', '0', 'C', true);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(145,6, "Para visualizar el mapa de geolocalización de cada unidad económica, dar clic en el siguiente vinculo:", '0', 'J', false );
    $pdf->Ln(2);
    $pdf->SetFont('Arial','UB',10);
    
    $pdf->SetTextColor(52,114,247); //Azul vinculo #3472F7
    //$pdf->Cell(160, 5, "Dar click aquí",'0', '0', 'C', true, "http://www.solucionafore.com/html_claveunica/".utf8_decode($JSON->{"ID"})."_".utf8_decode($JSON->cve_unica).".html");
    
    if( file_exists( '../html_claveunica/'.utf8_decode($JSON->cve_unica).'.html' ) ){
        $pdf->Cell(160, 5, "html",'0', '0', 'C', true, "http://www.solucionafore.com/html_claveunica/".utf8_decode($JSON->cve_unica).".html");
    }else{
        $pdf->Cell(160, 5, "html",'0', '0', 'C', true, "http://www.solucionafore.com/html_claveunica/100000000.html");
    }
    
    //$pdf->WriteHTML('<a href="http://www.solucionafore.com/html_claveunica/'.utf8_decode($JSON->{"ID"}).'_'.utf8_decode($JSON->cve_unica).'.html" target="_blank">html2</a>' , true, false, true, false, '');
    
    //Fin Pagina 3
}

if( $vista == 'D'){
    $pdf->Output('D','Reporte '.$month.'.pdf');
}else{
    $pdf->Output('I','Reporte '.$month.'.pdf');
}

?>