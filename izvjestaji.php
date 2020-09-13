<?php
//ob_start();
include 'spajanje_na_bazu.php';

$funkcija1= ""; $ime1= ""; $prezime1= ""; $datum1=""; $institucija1 = "";

if(isset($_POST['izv_po_ime_prezime'])){
    
    $ime1=$_POST['ime1'];$prezime1=$_POST['prezime1'];

    $sql="SELECT DISTINCT funkcija,od,do,institucija from funkcije WHERE ime='". $_POST['ime1'] ."' AND prezime='". $_POST['prezime1'] ."' order by od asc";
$podaci = mysqli_query($conn, $sql);
    if ($podaci->num_rows > 0) {
  // output data of each row
  echo "<table border='1'><tr><th>".$_POST['ime1'] ."</th><th>".$_POST['prezime1'] ."</th></tr>";
 echo "<table border='1'><tr><th>funkcija</th><th>od</th><th>do</th><th>institucija</th></tr>";
        
  while($row = $podaci->fetch_assoc()) {
    echo "<tr><td>". $row["funkcija"]."</td><td>". $row["od"]."</td><td>". $row["do"]."</td><td>". $row["institucija"]."</td></tr>";
    
  }
  echo "</table>";
} else {
        $ime1=$_POST['ime1'];$prezime1=$_POST['prezime1'];

  echo "0 results po osobi";
}
//exit;
}
if(isset($_POST['izv_po_ime_prezime_csv'])){
    
        $ime1=$_POST['ime1'];$prezime1=$_POST['prezime1'];

    $sql="SELECT DISTINCT funkcija,od,do,institucija from funkcije WHERE ime='". $_POST['ime1'] ."' AND prezime='". $_POST['prezime1'] ."' order by od asc";
$podaci = mysqli_query($conn, $sql);
    if ($podaci->num_rows > 0) {
//$naziv = "'"$_POST['ime1'] .' '". $_POST['prezime1'] ."'";
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=izv_po_ime_prezime.csv');
    
    $output = fopen("php://output", "w");
    fputcsv($output, array($_POST['ime1'],$_POST['prezime1']),';',' ');
    fputcsv($output, array('funkcija','od','do','institucija'),';',' ');
    while ($row = mysqli_fetch_assoc($podaci))
        {
        fputcsv($output, array($row['funkcija'],$row['od'],$row['do'],$row['institucija']),";",' ');
                
        }
        fclose($output);
        
} else {
        $ime1=$_POST['ime1'];$prezime1=$_POST['prezime1'];

  echo "0 results po osobi";
}
        exit;
}
if(isset($_POST['izv_po_ime_prezime_pdf'])){

        $sql="SELECT DISTINCT funkcija,od,do,institucija from funkcije WHERE ime='". $_POST['ime1'] ."' AND prezime='". $_POST['prezime1'] ."' order by od asc";
$podaci = mysqli_query($conn, $sql);
        if ($podaci->num_rows > 0) {
    include 'izvjestaj_po_osobi.php';

    
    } else {
        $ime1=$_POST['ime1'];$prezime1=$_POST['prezime1'];

  echo "0 results po osobi";
}
       exit;
        
}
if(isset($_POST['izv_po_funkc'])){
    $funkcija1=$_POST['funkcija1'];
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
    if ($podaci->num_rows > 0) {
  /// output data of each row
        echo "<table border='1'><tr><th>".$_POST['funkcija1'] ."</th></tr>";
  echo "<table border='1'><tr><th>ime</th><th>prezime</th><th>od</th><th>do</th><th>institucija</th></tr>";
        
  while($row = $podaci->fetch_assoc()) {
    echo "<tr><td>". $row["ime"]."</td><td>". $row["prezime"]."</td><td>". $row["od"]."</td><td>". $row["do"]."</td><td>". $row["institucija"]."</td></tr>";
    
  }
  echo "</table>";
}  else {
        $funkcija1=$_POST['funkcija1'];

  echo "0 results po funkc";
}
//exit;
}
if(isset($_POST['izv_po_funkc_csv'])){

        $sql_funkc = '';
if($_POST['funkc'] === "asc"){
    global $sql_funkc;
    $sql_funkc="SELECT ime,prezime,od,do,institucija from funkcije WHERE funkcija='". $_POST['funkcija1'] ."' order by od asc";
    
}
else if($_POST['funkc'] === "desc")
        {
        global $sql_funkc;
        $sql_funkc="SELECT ime,prezime,od,do,institucija from funkcije WHERE funkcija='". $_POST['funkcija1'] ."' order by od desc";
        
}
$podaci = mysqli_query($conn, $sql_funkc);
        if ($podaci->num_rows > 0) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array($_POST['funkcija1']),';',' ');
    fputcsv($output, array('ime','prezime','od','do','institucija'),';',' ');
    while ($row = mysqli_fetch_assoc($podaci))
        {
        fputcsv($output, array($row['ime'] ,$row['prezime'],$row['od'],$row['do'],$row['institucija']),";",' ');
                
        }
        fclose($output);
        exit;
}
else{
    echo "greska, ne postoji ta funkcija " . $conn->error;
}
}
if(isset($_POST['izv_po_funkc_pdf'])){

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
        if ($podaci->num_rows > 0) {
            include 'izvjestaj_po_funkciji.php';

    
    } else {
        $funkcija1=$_POST['funkcija1'];

  echo "0 results po funkciji za pdf";
}
       exit;
        
}
if(isset($_POST['izv_po_instut'])){
    
    $sql="SELECT DISTINCT institucija,funkcija from funkcije";
    $podaci = mysqli_query($conn, $sql);
    if ($podaci->num_rows > 0) {
  // output data of each row
  
  while($row = $podaci->fetch_assoc()) {
    echo "<table border='1'><tr><th>Institucija</th><th>"  . $row["institucija"]. "</th></tr>";
    echo "<tr><td>Funkcija</td><td>"  . $row["funkcija"]. "</td></tr>";
    echo "</table>";
  }
} else {
  echo "0 results po institucijama";
}
exit;
}
if(isset($_POST['izv_po_instut_csv'])){

        $sql="SELECT DISTINCT institucija,funkcija from funkcije";
        $podaci = mysqli_query($conn, $sql);
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('institucija','funkcija'),';',' ');
    while ($row = mysqli_fetch_assoc($podaci))
        {
        fputcsv($output, array($row['institucija'],$row['funkcija']),";",' ');
                
        }
        fclose($output);
        exit;
}
if(isset($_POST['izv_po_instut_pdf'])){

        
        
    include 'izvjestaj_po_inst.php';

    
    
       exit;
        
}

if(isset($_POST['izv_po_datumu'])){
    if(!preg_match("/^[0-9-]+$/", $_POST['datum1'])){
        echo "greska, datum moze imati samo znamenke i '-': " . $conn->error;
    }
    else{

$sql="SELECT DISTINCT ime,prezime,funkcija,od,do,institucija from funkcije ";
$podaci = mysqli_query($conn, $sql);
    if ($podaci->num_rows > 0) {
  // output data of each row
  
  echo "<table border='1'><tr><th>funkcija</th><th>ime</th><th>prezime</th><th>od</th><th>do</th><th>institucija</th></tr>";
        
  while($row = $podaci->fetch_assoc()) {
      if(strtotime($_POST['datum1']) >= strtotime($row['od']) && strtotime($_POST['datum1']) <= strtotime($row['do'])){
    echo "<tr><td>". $row["funkcija"]."</td><td>". $row["ime"]."</td><td>". $row["prezime"]."</td><td>". $row["od"]."</td><td>". $row["do"]."</td><td>". $row["institucija"]."</td></tr>";
    

    //var_dump($row);
    
      }
  }
  
  echo "</table>";
} else {
  echo "0 results po zadanom datumu";
}
}
}
if(isset($_POST['izv_po_datumu_csv'])){

        
$sql="SELECT DISTINCT ime,prezime,funkcija,od,do,institucija from funkcije ";
$podaci = mysqli_query($conn, $sql);
        if ($podaci->num_rows > 0) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('funkcija','ime','prezime','od','do','institucija'),';',' ');
    while ($row = mysqli_fetch_assoc($podaci)){
        
      if(strtotime($_POST['datum1']) >= strtotime($row['od']) && strtotime($_POST['datum1']) <= strtotime($row['do'])){
        fputcsv($output, array($row['funkcija'],$row['ime'],$row['prezime'],$row['od'],$row['do'],$row['institucija']),";",' ');
                
        }
        }
        fclose($output);
        exit;
        }

}
if(isset($_POST['izv_po_datumu_pdf'])){

        
        
    include 'izvjestaj_po_datumu.php';

    
    
       exit;
        
}
//ob_end_flush();
?>
<div class='body-content'>
    <div class='izvjestaji'>
            <h2>Izaberite tip i način izvješaja: </h2>
            <form class="form2" action=" izvjestaji.php" method="post" enctype="multipart/form-data" autocomplete="off">
                <div style="color:red">Izvještaj funkcija po imenu i prezimenu: </div><br/>
                Unesite ime za izvještaj: 
                    <input type="text" placeholder='Ime' name='ime1'value="<?php echo $ime1; ?>"  required /><br/>
                Unesite prezime za izvještaj: 
                    <input type="text" placeholder='Prezime' name='prezime1'value="<?php echo $prezime1; ?>"  required /><br/>
                    <input type="submit" value='Izvjestaj-uzlazno' name='izv_po_ime_prezime' class='btn btn-block btn-primary' />
                    <input type="submit" value='Izvjestaj u csv' name='izv_po_ime_prezime_csv' class='btn btn-block btn-primary' />
                    <input type="submit" value='Izvjestaj u pdf' name='izv_po_ime_prezime_pdf' class='btn btn-block btn-primary' />
                </form>
                    <br/>
                    <br/>
                    <div style="color:red">Izvještaj osoba po funkciji: </div><br/>
                <form class="form3" action=" izvjestaji.php" method="post" enctype="multipart/form-data" autocomplete="off">
                    Unesite funkiju za izvještaj: 
                    <input type="text" placeholder='Funkcija' name='funkcija1'value="<?php echo $funkcija1; ?>"  required /><br/>
                    Izaberite nacin sortiranja:
                    <select name="funkc" >
                        <option value="asc">uzlazno</option>
                        <option value="desc">silazno</option>
                    </select><br/>
                    <input type="submit" value='Izvjestaj' name='izv_po_funkc' class='btn btn-block btn-primary' />
                    <input type="submit" value='Izvjestaj u csv' name='izv_po_funkc_csv' class='btn btn-block btn-primary' />
                    <input type="submit" value='Izvjestaj u pdf' name='izv_po_funkc_pdf' class='btn btn-block btn-primary' />
                </form>
                    <br/>
                    <br/>
                <form class="form4" action=" izvjestaji.php" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div style="color:red">Izvještaj funkcija po institucijama: </div><br/>
                    <input type="submit" value='Izvjestaj' name='izv_po_instut' class='btn btn-block btn-primary' />
                    <input type="submit" value='Izvjestaj u csv' name='izv_po_instut_csv' class='btn btn-block btn-primary' />
                    <input type="submit" value='Izvjestaj u pdf' name='izv_po_instut_pdf' class='btn btn-block btn-primary' />
                </form>
                    <br/>
                    <br/>
                <form class="form5" action=" izvjestaji.php" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div style="color:red">Izvještaj svih osoba koje su obnašale neku funkciju na zadani datum:  </div><br/>
                    Unesite željeni datum: <input type="text" placeholder='Datum' name='datum1'value="<?php echo $datum1; ?>" required /><br/>
                    <input type="submit" value='Izvjestaj' name='izv_po_datumu' class='btn btn-block btn-primary' />
                    <input type="submit" value='Izvjestaj u csv' name='izv_po_datumu_csv' class='btn btn-block btn-primary' />
                    <input type="submit" value='Izvjestaj u pdf' name='izv_po_datumu_pdf' class='btn btn-block btn-primary' />
                </form>
                    <br/>
                    <button onclick="location.href='welcome.php'">Povratak na prethodnu stranicu</button><br/>
                    <button onclick="location.href='pocetna.php'">Povratak na početnu stranicu</button>
                    
            </div>
        </div>
