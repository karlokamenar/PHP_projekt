<?php
ob_start();
require 'fpdf.php';
$servername = "localhost";
            $username0 = "karlo";
            $password = "";
            $db = "baza_funkcije";
            $conn = new mysqli($servername, $username0, $password, $db);
$sql="SELECT DISTINCT funkcija,od,do,institucija from funkcije WHERE ime='". $_POST['ime1'] ."' AND prezime='". $_POST['prezime1'] ."' order by od asc";
$podaci = mysqli_query($conn, $sql);
class mojPDF extends FPDF{
    
    function vrhTableNaziv(){
        
        $this->SetFont('Times','',12);
        $this->cell(70,10,$_POST['ime1'],1,0,'C');
        $this->cell(25,10,$_POST['prezime1'],1,0,'C');
        $this->Ln();
    }
    function vrhTable(){
        
        $this->SetFont('Times','',12);
        $this->cell(70,10,"funkcija",1,0,'L');
        $this->cell(25,10,"od",1,0,'C');
        $this->cell(25,10,"do",1,0,'C');
        $this->cell(100,10,"institucija",1,0,'L');
        $this->Ln();
    }
function pogledTable($sql_podaci){
    
        $this->SetFont('Times','',8);
        while($data = mysqli_fetch_array($sql_podaci))
        {
            $this->cell(70,10,$data['funkcija'],1,0,'L');
            $this->cell(25,10,$data['od'],1,0,'C');
            $this->cell(25,10,$data['do'],1,0,'C');
            $this->cell(100,10,$data['institucija'],1,0,'L'); 
            $this->Ln();
        }
        }
}//class kraj

$pdf1 = new mojPDF('l','mm','A4');
$pdf1->AliasNbPages();
$pdf1->AddPage('l','A4');
$pdf1->vrhTableNaziv();
$pdf1->vrhTable();
$pdf1->pogledTable($podaci);
$pdf1->OutPut();

        
ob_flush();
?>