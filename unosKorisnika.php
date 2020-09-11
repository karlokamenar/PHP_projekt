<?php
session_start();
    $servername = "localhost";
            $username0 = "karlo";
            $password = "";
            $db = "baza_funkcije";

            $conn = new mysqli($servername, $username0, $password, $db);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            //echo "Uspiješno spojeno na bazu.\n";
            
    $username = "";
    $username_err = "";
    $username1 = "";
    $username1_err = "";
    
    
    if(isset($_POST['stvori_novog'])){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Unesite ime.";
    } else{
        if (!preg_match("/^[A-Za-z0-9]+$/", $_POST["username"])) {
            $username_err = "ime nesmije sadrzavati znakove!";
        }
        else{
            $username = trim($_POST["username"]);
            $_SESSION["username"] = $username;
        }
        // Prepare a select statement
        $sql = "INSERT INTO korisnici(ime) VALUES ('".$username ."')";
        //$grant = "";
        
        if($conn->query($sql) === true){
            
            // Bind variables to the prepared statement as parameters
            echo 'uspijesno dodan korisnik';
            header("location:welcome.php");
            } else{
                echo "Oops! Nesto je krivo. Pokusajte ponovo za imenom koje vec nije uneseno.";
            }

            // Close statement
            
        }
    }
    if(isset($_POST['nastavi_postojecim'])){
 
    // Validate username
    if(empty(trim($_POST["username1"]))){
        $username1_err = "Unesite ime.";
    } else{
        if (!preg_match("/^[A-Za-z0-9]+$/", $_POST["username1"])) {
            $username1_err = "ime nesmije sadrzavati znakove!";
        }
        else{
            $username1 = trim($_POST["username1"]);
            $_SESSION["username"] = $username1;
        }
        // Prepare a select statement
        $sql1 = "SELECT COUNT(ime) FROM korisnici WHERE ime= '".$username1."'";
        $broji_korisnike = mysqli_fetch_array($conn->query($sql1));
        //$grant = "";
        
        if($broji_korisnike[0] != '0'){
            
            // Bind variables to the prepared statement as parameters
            echo 'korisnik pronaden';
            var_dump($broji_korisnike);
            header("location:welcome.php");
            } else{
                echo "Oops! Korisnik '".$username1."' nije pronaden.";
            }

            // Close statement
            
        }
    }
    
        
        $conn->close();
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Registracija</h2>
        <p>Ispunite da unesete novog korisnika. (naziv korisnika smije sadržavati samo slova i brojke)</p>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Korisničko ime</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            
            <div class="form-group">
                <input type="submit" name='stvori_novog' class="btn btn-primary" value="Stvori">
                
                <input type="reset" class="btn btn-default" value="Briši">
            </div>
            <p>Ako već imate stvorenog korisnika, unesite korisničko ime za nastavak.</p>
            
            <div class="form-group <?php echo (!empty($username1_err)) ? 'has-error' : ''; ?>">
                <label>Korisničko ime</label>
                <input type="text" name="username1" class="form-control" value="<?php echo $username1; ?>">
                <span class="help-block"><?php echo $username1_err; ?></span>
            </div>  
            <div class="form-group">
                
                <input type="submit" name='nastavi_postojecim' class="btn btn-primary" value="Nastavi s postojećim korisnikom">
                <input type="reset" class="btn btn-default" value="Briši">
            </div>
            
        </form>
        <a href="pocetna.php">Povratak na početnu</a>
    </div>    
</body>
</html>