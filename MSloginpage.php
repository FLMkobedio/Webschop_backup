<html>
<head>
    <?php INCLUDE 'connectiondbs.php'?>
    <?php session_start(); ?>
<link rel="icon" type="image/x-icon" href="Images/favicon.ico"> 
<link rel="stylesheet" href="MSloginpage.css">
</head>
<body>
<form method="post">
<div class="container">
    <div class="nav">
        <ul class="nav_ul_container">
            <li><a class="active" href="MestdagSecurity.php">Home</a></li>
            <li><a href="MSservices.php" disabled>Services</a></li>
            <div class="nav_right">
                <li>
                    <img class="nav_img" src="Images/MSsecurityLogosmall">
                </li>
            </div>
        </ul>
    </div>
    <div class="textBody">
        <table class="log_reg_tbl">
            <tr>
                <td><h2>Inloggen</h2></td>
            </tr>
            <tr>
                <td>Gebruikersnaam</td>
                <td> <input type="text" name="username"> </td>
            </tr>
            <tr>
                <td>Wachtwoord</td>
                <td> <input type="text" name="password"> </td>
            </tr>
            <tr>
            </br>
                </br>
                <td><h2>Registreren</h2></td>
            </tr>
            <tr>
                <td>Gebruikersnaam</td>
                <td> <input type="text" name="rGebruikersnaam"> </td>
            </tr>
            <tr>
                <td>Wachtwoord</td>
                <td> <input type="password" name="rWachtwoord"> </td>
            </tr>
            <tr>
                <td>Wachtwoord</td>
                <td> <input type="password" name="rWachtwoord2"> </td>
            </tr>
            <tr>
                <td>Naam</td>
                <td> <input type="text" name="rNaam"> </td>
            </tr>
            <tr>
                <td>Voornaam</td>
                <td> <input type="text" name="rVoornaam"> </td>
            </tr>
            <tr>
                <td>Gmail</td>
                <td> <input type="text" name="rGmail"> </td>
            </tr>
            <tr>
                <td> <button name="registreren">Registreren</button></td>
                <td> <button name="login">Login</button></td>
            </tr>
        </table>
    </div>
</div>
<?php
if(isset($_POST['username']) AND isset($_POST['password']) AND isset($_POST['login']))
{
    $Gebruikersnaam = $_POST['username'];
    $sqlPW="SELECT * FROM tblklanten WHERE Gebruikersnaam='$Gebruikersnaam'";
    $PWcheck=$db->query($sqlPW);
    while($row=$PWcheck->fetch_assoc())
    {
        if($_POST["password"]==$row['Wachtwoord']){
            $Naam=$row['Naam'];
            $Voornaam=$row['Voornaam'];
            $Gmail=$row['Gmail'];
            $KlantID=$row['KlantID'];
            $_SESSION['Naam']=$Naam;
            $_SESSION['Voornaam']=$Voornaam;
            $_SESSION['Gmail']=$Gmail;
            $_SESSION['KlantID']=$KlantID;
            $_SESSION['Gebruikersnaam']=$Gebruikersnaam;
            header("Location: MSservices.php");
        }
        else{
            echo "fout";
        }
    }
}
if(isset($_POST['registreren'])){
    $rGebruikersnaam = $_POST['rGebruikersnaam'];
    $sqlRegister="SELECT COUNT(1) FROM tblklanten WHERE Gebruikersnaam = '$rGebruikersnaam'";
    $Rquery = $db -> query($sqlRegister);
    $Rcheck=mysqli_fetch_all($Rquery);
    echo $Rcheck[0][0];
    if( 0 == $Rcheck[0][0])
    {
        if($_POST['rWachtwoord']==$_POST['rWachtwoord2'])
        {
            $rNaam = $_POST['rNaam'];
            $rVoornaam = $_POST['rVoornaam'];
            $rWachtwoord = $_POST['rWachtwoord'];
            $rGmail = $_POST['rGmail'];
            $sqlInsert="INSERT INTO tblklanten (Gebruikersnaam, Naam, Voornaam, Wachtwoord, Gmail)
            VALUES ('$rGebruikersnaam','$rNaam', '$rVoornaam', '$rWachtwoord', '$rGmail')";
            if($db->query($sqlInsert) === TRUE)
            {
                $_SESSION['Naam']=$rNaam;
                $_SESSION['Voornaam']=$rVoornaam;
                $_SESSION['Gmail']=$rGmail;
                $_SESSION['KlantID']=$rKlantID;
                $_SESSION['Gebruikersnaam']=$rGebruikersnaam;
                header("Location: MSservices.php");
            } 
            else
            {
                echo "Error: " . $sqlInsert;
            }
        }
    }
}

?>
</div>
</form>
</body>
</html>