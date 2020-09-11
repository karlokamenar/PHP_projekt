<?php
if(isset($_POST['stvori_bazu_tablice'])){
 
    include_once 'script.php';
    
    }
    if(isset($_POST['na_reg'])){
 
    header('location:unosKorisnika.php');
    
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Početna</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 600px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Izaberite opcije:</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>1.) Napravi bazu i tablice(funkcije i korisnici)</label>
                <input type="submit" name='stvori_bazu_tablice' class="btn btn-primary" value="Napravi"> 
            </div>
            <div class="form-group">
                <label>2.) Registracija ili prijava(korisnik)</label>
                <input type="submit" name='na_reg' class="btn btn-primary" value="Napravi"> 
            </div>
        </form>
    </div>    
</body>
</html>

