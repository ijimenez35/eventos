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
$pdf->Image('../img/doc/encabezado.jpg', 75 , 0 , 60, 20);
$pdf->Image('../img/doc/pie.jpg', 0 , 285 , 210, 12);

$pdf->SetY(23);
$pdf->SetFont('Arial','B',10);
$pdf->Cell($anchoPagina,10,'Prospectación de Nueva Afiliación','0', '0', 'C');
$pdf->SetY(28);
$pdf->Cell($anchoPagina,10,'AFORE XXI','0', '0', 'C');


//Fecha
$pdf->SetY(38);
$pdf->SetFont('Arial','',12);
$pdf->Cell($anchoPagina,7,$month.' '.$year,'B', '0', 'R');

$pdf->SetY(50);
$pdf->SetFont('Arial','B',10);
$pdf->Cell($anchoPagina,10,'AFORE XXI BANORTE','0', '0', 'L');
$pdf->SetY(55);
$pdf->Cell($anchoPagina,10,'P R E S E N T E','0', '0', 'L');



//Contenido
$pdf->SetY(70);
$pdf->SetFont('Arial','',12);
$pdf->Cell($anchoPagina,10,'     A. ANÁLISIS DE MERCADO OBJETIVO','0', '0', 'L');

$pdf->SetY(83);
$pdf->MultiCell($anchoPagina,6, "En cumplimiento a lo dispuesto en el contrato celebrado entre Afore XXI Banorte y A TRABAJAR SOLUCIONES DE EMPLEO, S.A. de C.V., en el que se acuerda prestar los servicios de “Análisis de Mercado y Trámites relacionados con la Prospectación de Nueva Afiliación”, a través de este documento realizamos la entrega correspondiente al servicio prestado por A TRABAJAR.\n 
De acuerdo con la base de prospectos potenciales, se procesa un cruce de información para identificar los domicilios y ubicaciones por código postal. Con la información obtenida se realiza un análisis del espacio geográfico donde se ubican y se obtienen características demográficas y económicas de las viviendas con características similares.\n
El objetivo del análisis es identificar prospectos con perfiles adecuados a las necesidades de la AFORE.\n
Asimismo, se obtienen datos de ocupación de las unidades económicas encontradas en la misma área geográfica de estudio. Podremos localizar en un mapa interactivo la ubicación exacta de cada unidad económica.", '0', 'J', false );

//Prospectos
$pdf->AddPage();
$pdf->Image('../img/doc/encabezado.jpg', 75 , 0 , 60, 20);
$pdf->Image('../img/doc/pie.jpg', 0 , 285 , 210, 12);
$pdf->SetY(23);
$pdf->SetFont('Arial','BU',10);
$pdf->Cell($anchoPagina,10,'MUESTRA PARA ANÁLISIS DE PROSPECTOS','0', '0', 'C');


$pdf->SetY(45);
$pdf->SetFont('Arial','B',10);
//Cabeceras de la tabla
$pdf->SetFillColor(220,220,220);
$pdf->SetDrawColor(220,220,220);
$pdf->Cell(35,10,'NO. DE CONTROL','1', '0', 'C', true);
$pdf->Cell(60,10,'CURP','1', '0', 'C', true);
$pdf->Ln();
$columna = 1;

$pdf->SetFillColor(255,255,255);
foreach($voJSON->DatosJSON as $JSON){
    
    if( $columna == 1 && $pdf->GetY() > 260){ //Otra columna
        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY(105, 45);
        //Cabeceras de la tabla
        $pdf->SetFillColor(220,220,220);
        $pdf->SetDrawColor(220,220,220);
        $pdf->Cell(35,10,'NO. DE CONTROL','1', '0', 'C', true);
        $pdf->Cell(60,10,'CURP','1', '0', 'C', true);
        $pdf->Ln();
        $columna = 2;
    }else 
    
    if( $columna == 2 && $pdf->GetY() > 260 ){ //Pagina nueva
        $columna = 1;
        $pdf->AddPage();
        $pdf->Image('../img/doc/encabezado.jpg', 75 , 0 , 60, 20);
        $pdf->Image('../img/doc/pie.jpg', 0 , 285 , 210, 12);
        $pdf->SetY(23);
        $pdf->SetFont('Arial','BU',10);
        $pdf->Cell($anchoPagina,10,'MUESTRA PARA ANÁLISIS DE PROSPECTOS','0', '0', 'C');
        $pdf->SetY(45);
        $pdf->SetFont('Arial','B',10);
        //Cabeceras de la tabla
        $pdf->SetFillColor(220,220,220);
        $pdf->SetDrawColor(220,220,220);
        $pdf->Cell(35,10,'NO. DE CONTROL','1', '0', 'C', true);
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
    $pdf->Image('../img/doc/encabezado.jpg', 75 , 0 , 60, 20);
    $pdf->Image('../img/doc/pie.jpg', 0 , 285 , 210, 12);
    
    $pdf->SetY(23);
    $pdf->SetTextColor(255,191,0); //Amarillo
    $pdf->SetFont('Arial','B',13);
    $pdf->SetDrawColor(0,0,0);
    $pdf->Cell($anchoPagina,10,'No. Control '.utf8_decode($JSON->nmroCntr) ,'B', '0', 'L', true);
    
    $pdf->SetY(40);
    $pdf->SetTextColor(0,0,0); //Negro
    $pdf->SetFont('Arial','',11);
    $pdf->Cell($anchoPagina/2, 10, '•  CURP: '.utf8_decode($JSON->curp) ,'0', '0', 'L');
    $pdf->Cell($anchoPagina/2, 10, '•  Municipio: '.utf8_decode($JSON->mncp) ,'0', '0', 'L');
    $pdf->Ln();
    $pdf->Cell($anchoPagina/2, 10, '•  Sexo: '.utf8_decode($JSON->sexo) ,'0', '0', 'L');
    $pdf->Cell($anchoPagina/2, 10, '•  CP: '.utf8_decode($JSON->cp) ,'0', '0', 'L');
    $pdf->Ln();
    $pdf->Cell($anchoPagina/2, 10, '•  Edad: '.utf8_decode($JSON->edad) ,'0', '0', 'L');
    $pdf->Cell($anchoPagina/2, 10, '•  AGEB: '.utf8_decode($JSON->ageb) ,'0', '0', 'L');
    $pdf->Ln();
    $pdf->Cell($anchoPagina/2, 10, '•  Estado: '.utf8_decode($JSON->estd) ,'0', '0', 'L');
    $pdf->SetY(78);
    $pdf->Cell($anchoPagina,10, '' ,'B', '0', 'L', true);
    
    $pdf->SetY(95);
    $pdf->SetTextColor(0,144,204); //Azul #0090CC
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell($anchoPagina,10, 'AGEB '.utf8_decode($JSON->ageb) ,'0', '0', 'L', true);
    //imagen de control 0100100012579.png
    if( file_exists( '../img_claveunica/'.utf8_decode($JSON->cve_unica).'.jpg' ) ){
        $pdf->Image( '../img_claveunica/'.utf8_decode($JSON->cve_unica).'.jpg', 20 , 120 , 170, 120);
    }
    
    //$pdf->Image( '../img_claveunica/0100100012668.jpg', 20 , 120 , 170, 120);
    //Fin Pagina 1
    
    //Pagina 2
    $pdf->AddPage();
    $pdf->Image('../img/doc/encabezado.jpg', 75 , 0 , 60, 20);
    $pdf->Image('../img/doc/pie.jpg', 0 , 285 , 210, 12);
    $pdf->SetY(23);
    $pdf->SetTextColor(0,0,0); //Negro
    $pdf->SetFont('Arial','BU',10);
    $pdf->Cell($anchoPagina,10,'Datos socioeconomicos y económicos' ,'0', '0', 'L', true);
    $pdf->SetY(30);
    $pdf->Cell($anchoPagina,10,'Número de viviendas '.utf8_decode($JSON->v) ,'0', '0', 'R', true);
    
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
    $pdf->Image('../img/doc/encabezado.jpg', 75 , 0 , 60, 20);
    $pdf->Image('../img/doc/pie.jpg', 0 , 285 , 210, 12);
    $pdf->SetY(23);
    $pdf->SetTextColor(0,0,0); //Negro
    $pdf->SetFont('Arial','BU',11);
    $pdf->Cell($anchoPagina,10,'Datos de unidades económicas' ,'0', '0', 'L', true);
    $pdf->SetY(35);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell($anchoPagina,10,'AGEB '.utf8_decode($JSON->ageb) ,'0', '0', 'R', true);
    
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
    $pdf->Cell(160, 5, "Dar click aquí",'0', '0', 'C', true, "http://www.solucionafore.com/html_claveunica/".utf8_decode($JSON->cve_unica).".html");
    
    //$pdf->WriteHTML('<a href="http://www.solucionafore.com/html_claveunica/'.utf8_decode($JSON->{"ID"}).'_'.utf8_decode($JSON->cve_unica).'.html" target="_blank">html2</a>' , true, false, true, false, '');
    
    //Fin Pagina 3
}

if( $vista == 'D'){
    $pdf->Output('D','Reporte '.$month.'.pdf');
}else{
    $pdf->Output('I','Reporte '.$month.'.pdf');
}
?>