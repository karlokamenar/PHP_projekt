<?php
ob_start();
require 'fpdf.php';
$servername = "localhost";
            $username0 = "karlo";
            $password = "";
            $db = "baza_funkcije";
            $conn = new mysqli($servername, $username0, $password, $db);
$sql="SELECT DISTINCT institucija,funkcija from funkcije";
$podaci = mysqli_query($conn, $sql);
class mojPDF extends FPDF{
    
    function vrhTable(){
        
        $this->SetFont('Times','',12);
        $this->cell(100,10,"institucija",1,0,'L');
        $this->cell(70,10,"funkcija",1,0,'L');
        $this->Ln();
    }
function pogledTable($sql_podaci){
    
        $this->SetFont('Times','',8);
        while($data = mysqli_fetch_array($sql_podaci))
        {
            $this->cell(100,10,$data['institucija'],1,0,'L');
            $this->cell(70,10,$data['funkcija'],1,0,'L');
            $this->Ln();
        }
        }
}//class kraj

$pdf1 = new mojPDF('l','mm','A4');
$pdf1->AliasNbPages();
$pdf1->AddPage('l','A4');
$pdf1->vrhTable();
$pdf1->pogledTable($podaci);
$pdf1->OutPut();

        
ob_flush();
?>