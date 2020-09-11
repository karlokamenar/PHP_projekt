<?php
ob_start();
require 'fpdf.php';
$servername = "localhost";
            $username0 = "karlo";
            $password = "";
            $db = "baza_funkcije";
            $conn = new mysqli($servername, $username0, $password, $db);
$sql_od = "select od from funkcije order by od asc limit 1";
$sql_od_date = date($sql_od);
$sql_do = "select do from funkcije order by do desc limit 1";
$sql_do_date = date($sql_do);
$sad = date('Y-m-d');
//$sql="SELECT ime,prezime,funkcija from funkcije WHERE '". $_POST['datum1'] ."'>= '". $sql_od ."' AND <= '". $sql_do ."'";
$sql="SELECT DISTINCT ime,prezime,funkcija,od,do,institucija from funkcije ";
$podaci = mysqli_query($conn, $sql);
class mojPDF extends FPDF{
    
    function vrhTableNaziv(){
        
        $this->SetFont('Times','',12);
        $this->cell(70,10,$_POST['datum1'],1,0,'C');
        $this->Ln();
    }
    function vrhTable(){
        
        $this->SetFont('Times','',12);
        $this->cell(70,10,"funkcija",1,0,'L');
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
            if(date($_POST['datum1']) >= date($data['od']) && date($_POST['datum1']) <= date($data['do'])){
            $this->cell(70,10,$data['funkcija'],1,0,'L');
            $this->cell(25,10,$data['ime'],1,0,'C');
            $this->cell(30,10,$data['prezime'],1,0,'C');
            $this->cell(25,10,$data['od'],1,0,'C');
            $this->cell(25,10,$data['do'],1,0,'C');
            $this->cell(100,10,$data['institucija'],1,0,'L'); 
            $this->Ln();
        }
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