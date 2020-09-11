<?php 
//ob_start();
include 'spajanje_na_bazu.php';
session_start();
$funkcija= ""; $ime= ""; $prezime= ""; $od= ""; $do= ""; $institucija = "";

if(isset($_POST['dodaj'])){
    //$korID = "SELECT korID from korisnici WHERE ime = '".$_SESSION['username']."'";
    $sql = "INSERT INTO funkcije(funkcija,ime,prezime,od,do,institucija) VALUES ('" . $_POST['funkcija'] . "','" . $_POST['ime'] . "','" . $_POST['prezime'] . 
                    "','" . $_POST['od'] . "','" . $_POST['do'] . "','" . $_POST['institucija'] . "')";
//provjera funkcije i institucije
$funkc_equals= "SELECT COUNT(funkcija) FROM funkcije WHERE funkcija = '". $_POST['funkcija'] ."'";
$institut_equals = "SELECT COUNT(institucija) FROM funkcije WHERE institucija = '". $_POST['institucija'] ."'";
//$funkc_equals= "SELECT DISTINCT funkcija,institucija FROM funkcije WHERE funkcija = 'predsjednik' AND institucija = 'Hrvatski sabor'";

$broji_funkcije=mysqli_fetch_array($conn->query($funkc_equals));
$broji_redove=mysqli_fetch_array($conn->query($institut_equals));
//provjera ime i prezime
$od_provjera = date(trim($_POST['od']));
$new_od_provjera = date($od_provjera);
$do_provjera = date(trim($_POST['do']));
$prije90 = date('1990-01-01');
$poslijeSad = date('Y-m-d');

if($broji_funkcije[0] != '0' && $broji_redove[0] != '0' && strlen(trim($_POST['ime']))>1 && strlen(trim($_POST['prezime']))>1 && $od_provjera > $prije90 && $od_provjera < $poslijeSad && $do_provjera > $prije90 && $do_provjera < $poslijeSad)
    {
    if($od_provjera < $do_provjera){
        if($conn->query($sql) === true){
            echo 'uspijesno dodana funkcija';
            $funkcija=$_POST['funkcija'];$ime=$_POST['ime'];$prezime=$_POST['prezime'];$od=$_POST['od'];$do=$_POST['do'];$institucija=$_POST['institucija'];
        } 
        else{
            echo "Greška pri unosu datuma, početni mora bit prije završnog!!! " . $conn->error;
        }
    }
    }
if($broji_funkcije[0] === '0' || $broji_redove[0] === '0' || strlen(trim($_POST['ime']))>=1 || strlen(trim($_POST['prezime']))<=1 || $od_provjera <= $prije90 || $do_provjera > $poslijeSad || $do_provjera <= $prije90 || $od_provjera > $poslijeSad)
    {
               
    $funkcija=$_POST['funkcija'];$ime=$_POST['ime'];$prezime=$_POST['prezime'];$od=$_POST['od'];$do=$_POST['do'];$institucija=$_POST['institucija'];

    
     if($broji_funkcije[0] === '0')
        {  
           echo "Greška pri unosu funkcije, mora biti postojeća!!! " . $conn->error;
        }
     if($broji_redove[0] === '0')
        {  
           echo "Greška pri unosu institucije, mora biti postojeća!!! " . $conn->error;
        }
     if(strlen(trim($_POST['ime']))<=1)
        {  
           echo "Greška pri unosu imena, mora sadržavati bar 2 slova!!! " . $conn->error;
        }
     if(strlen(trim($_POST['prezime']))<=1)
        {  
           echo "Greška pri unosu prezimena, mora sadržavati bar 2 slova!!! " . $conn->error;
        }
     if($od_provjera <= $prije90)
        {  
           echo "Greška pri unosu početnog datuma, mora biti poslije 1990-01-01 i prije današnjeg datuma!!! " . $conn->error;
        }
     if($do_provjera > $poslijeSad)
        {  
           echo "Greška pri unosu završnog datuma, mora biti poslije 1990-01-01 i prije današnjeg datuma!!! " . $conn->error;
        }
    if($do_provjera <= $prije90)
        {  
           echo "Greška pri unosu završnog datuma, mora biti poslije 1990-01-01 i prije današnjeg datuma!!! " . $conn->error;
        }
     if($od_provjera > $poslijeSad)
        {  
           echo "Greška pri unosu početnog datuma, mora biti poslije 1990-01-01 i prije današnjeg datuma!!! " . $conn->error;
        }
    }
       
       
}
 ?>
<div class='body-content'>
    <div class='welcome'>
        <h1 style="color:powderblue;"><div class='alert alert-success'>Dobrodošli <?= $_SESSION['username'] ?></div></h1>
            <h2>Dodavanje nove funkcije:</h2>
                <form class="form" action=" welcome.php" method="post" enctype="multipart/form-data" autocomplete="off">
                    Unesite funkciju koja već postoji: <input type="text" placeholder='Funkcija' name='funkcija'value="<?php echo $funkcija; ?>" required /><br/>
                    Unesite ime nove osobe: <input type="text" placeholder='Ime' name='ime'value="<?php echo $ime; ?>"  required /><br/>
                    Unesite prezime nove osobe: <input type="text" placeholder='Prezime' name='prezime'value="<?php echo $prezime; ?>" required /><br/>
                    Unesite datum početka funkcije: <input type="text" placeholder='Od' name='od'value="<?php echo $od; ?>" required /><br/>
                    Unesite datum kraja funkcije: <input type="text" placeholder='Do' name='do'value="<?php echo $do; ?>" required /><br/>
                    Unesite instituciju koja već postoji: <input type="text" placeholder='Institucija' name='institucija'value="<?php echo $institucija; ?>" required /><br/>
                    <input type="submit" value='Dodaj' name='dodaj' class='btn btn-block btn-primary' /><br/>
                </form>
                <br/>
                <a href="unosKorisnika.php">Povratak na registracijsku stranicu</a><br/><br/>
                <a href="pocetna.php">Povratak na početnu stranicu</a><br/><br/>
                <button onclick="location.href='izvjestaji.php'">Pređite na izvještaje</button>
            </div>
        </div>
        




