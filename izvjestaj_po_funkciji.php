<?php
ob_start();
require 'fpdf.php';
$servername = "localhost";
            $username0 = "karlo";
            $password = "";
            $db = "baza_funkcije";
            $conn = new mysqli($servername, $username0, $password, $db);

$sql_funkc = '';
if($_POST['funkc'] === "asc"){
    global $sql_funkc;
    $sql_funkc="SELECT DISTINCT ime,prezime,od,do,institucija from funkcije WHERE funkcija='". $_POST['funkcija1'] ."' order by od asc";
    
}
else if($_POST['funkc'] === "desc")
        {
        global $sql_funkc;
        $sql_funkc="SELECT DISTINCT ime,prezime,od,do,institucija from funkcije WHERE funkcija='". $_POST['funkcija1'] ."' order by od desc";
        
}
$podaci = mysqli_query($conn, $sql_funkc);
class mojPDF extends FPDF{
    
    function vrhTableNaziv(){
        
        $this->SetFont('Times','',12);
        $this->cell(70,10,$_POST['funkcija1'],1,0,'L');
        $this->Ln();
    }
    function vrhTable(){
        
        $this->SetFont('Times','',12);
        $this->cell(25,10,"ime",1,0,'C');
        $this->cell(30,10,"prezime",1,0,'C');
        $this->cell(25,10,"od",1,0,'C');
        $this->cell(25,10,"do",1,0,'C');
        $this->cell(100,10,"institucija",1,0,'L');
        $this->Ln();
    }
function pogledTable($sql_podaci){
    
        $this->SetFont('Times','',8);
        while($data = mysqli_fetch_array($sql_podaci))
        {
            $this->cell(25,10,$data['ime'],1,0,'C');
            $this->cell(30,10,$data['prezime'],1,0,'C');
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