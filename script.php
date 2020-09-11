<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Funkcije u tijelima javne vlasti</title>
    </head>
    <body>
        <?php
        libxml_use_internal_errors(true);
        // SPAJANJE 
        $servername = "localhost";
        $username = "karlo";
        $password = "";
        $db = "baza_funkcije";

        $conn = new mysqli($servername, $username, $password, $db);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Uspiješno spojeno na bazu.\n";
              
        // Create database
        
        $upit = 'CREATE DATABASE IF NOT EXISTS baza_funkcije';
        if ($conn->query($upit) === TRUE) {
          echo "Baza kreirana.\n";
        } else {
          echo "Error creating database: " . $conn->error;
        }
        
        $conn->select_db("baza_funkcije");
        //echo "faza OK.\n";
        
        $affectedRow = 0;
//        
        // UCITAVANJE XML-A
        $xml = simplexml_load_file("FUNKCIJE_U_TIJELIMA_JAVNE_VLASTI.xml") 
                or die("Error: Nije dobro ucitan xml");
        

//        
        // SQL ZA TABLICE
            
        $stvoriFunkcije='CREATE TABLE IF NOT EXISTS funkcije (
            funID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            korID INTEGER UNSIGNED NOT NULL,
            funkcija VARCHAR(60) NOT NULL,
            ime VARCHAR(40) NOT NULL,
            prezime VARCHAR(40) NOT NULL,
            od VARCHAR(40) NOT NULL,
            do VARCHAR(40) NOT NULL,
            institucija VARCHAR(80) NOT NULL,
            PRIMARY KEY (funID),
            FOREIGN KEY(korID) REFERENCES korisnici(korID)
            )
            ENGINE = MyISAM';
        
        //KREIRANJE TABLICE
        
        if ($conn->query($stvoriFunkcije) === TRUE) {
            echo "Tablica funkcije kreirana.\n";
        } else {
             echo "Error creating table: " . $conn->error;
        }
        if ($conn->query('ALTER TABLE funkcije AUTO_INCREMENT=1') === TRUE) {
            echo "Tablica id krece od 1 .\n";
        }
        
        //test();
        
        // UBACIVANJE XML-A U SQL BAZU
        
        foreach ($xml->children() as $row) {
            $funkcija = $row->Funkcija;
            $ime = fromXMLtoStringToSepIme($row->NositeljFunkcije);
            $prezime = fromXMLtoStringToSepPrezime($row->NositeljFunkcije);
            $od = $row->Mandat;
            if((strpos($od,'/') == true)){
            $od = fromXMLtoStringToSepDateOd($row->Mandat);
            }else{
                $od = trimOd($row->Mandat);
            }
            $do = $row->Mandat;
            if((strpos($do,'/') == true)){
            $do = fromXMLtoStringToSepDateDo($row->Mandat);
            }else{
                $do = trimOd($row->Mandat);
            }
            $institucija = $row->Institucija;

            $sql = "INSERT INTO funkcije(funkcija,ime,prezime,od,do,institucija) VALUES ('" . $funkcija . "','" . $ime . "','" . $prezime . 
                    "','" . $od . "','" . $do . "','" . $institucija ."')";
            

            $result = $conn->query($sql);
            
            if (! empty($result)) {
                $affectedRow ++;
                
            } else {
                $error_message = mysqli_error($conn) . "\n";
            }
            
            
        }
        
        $sql_korisnici='CREATE TABLE IF NOT EXISTS korisnici (
        korID INT NOT NULL AUTO_INCREMENT,
        ime VARCHAR(50) NOT NULL UNIQUE,
        PRIMARY KEY(korID),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )';
    if ($conn->query($sql_korisnici) === TRUE) {
              echo "kreirana tablica korisnici.\n";
            } else {
              echo "Error creating TABLICA KORISNICI: " . $conn->error;
            }
        if ($conn->query('ALTER TABLE korisnici AUTO_INCREMENT=1') === TRUE) {
            echo "Tablica id krece od 1 .\n";
        }
        // BRISANJ TABLICE
        //brisiTablicu();
        //header("location:unosKorisnika.php");
        
        
        
        //FUNKCIJE
        function test(){
            echo 'test funkcije';
        }
        function fromXMLtoStringToSepIme($a){
            $dijelovi = explode(",", $a);
            $trimmed_ime = trim($dijelovi[1]);
             return $trimmed_ime;
        }
        function fromXMLtoStringToSepPrezime($a){
            $dijelovi = explode(",", $a);
            $trimmed_prezime = trim($dijelovi[0]);
             return $trimmed_prezime;
        }
        
        function fromXMLtoStringToSepDateOd($a){
            $dijelovi = explode("/", $a);
            $trimmed_od = trim($dijelovi[0],"[]");
             return $trimmed_od;
        }
        
        function fromXMLtoStringToSepDateDo($a){
            $dijelovi = explode("/", $a);
            $trimmed_do = trim($dijelovi[1],"[]");
             return $trimmed_do;
        }
        
        function trimOd($a){
            $trimmed_od = trim($a[0],"[]");
             return $trimmed_od;
        }
        
        function trimDo($a){
            $trimmed_do = trim($a[1],"[]");
             return $trimmed_do;
        }
        
        function brisiTablicu(){
            $brisiFunkcije="DELETE FROM funkcije";
        global $conn;
        if ($conn->query($brisiFunkcije) === TRUE) {
            printf("Tablica obrisana.\n");
        } else {
             echo "Error creating table: " . $conn->error;
        }
        }
        
        
        // prekini spajanje
        $conn->close();
        ?>
    </body>
</html>
