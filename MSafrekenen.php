<html>
<head>
<?php INCLUDE 'connectiondbs.php'?>
	 <link rel="icon" type="image/x-icon" href="Images/favicon.ico"> 
    <link rel="stylesheet" href="MSafrekenen.css">
</head>
<form method="post">
    <div class="container">
        <div class="nav">
            <ul class="nav_ul_container">
                <li><a class="active" href="MestdagSecurity.php">Home</a></li>
                <li><a href="MSservices.php" disabled>Services</a></li>
                <div class="nav_right">
                    <li>
                        <?php
                        session_start();
                        if(isset($_SESSION['Gebruikersnaam']))
                        {
                            ?>
                                    <input value="<?php echo $_SESSION['Gebruikersnaam'];?>" type="submit" name="Sdestroy" class="Sdestroy">
                                    </button>
                            <?php
                            if(isset($_POST['Sdestroy']))
                            {
                                session_destroy();
                                header("Location: MSservices.php");
                            }         
                        }
                        else
                        {
                            echo "<a href='MSloginpage.php'>Inloggen</a>";
                        }
                        ?>
                    </li>
                    <li>
                        <img class="nav_img" src="Images/MSsecurityLogosmall">
                    </li>
                </div>
            </ul>
        </div>
        <div class="textbody">
                <?php
                    foreach($_SESSION['ServiceID'] as $result)
                    {
                        $sqlServices="SELECT * FROM tblvooraad WHERE id=$result";
                        $getServices=$db->query($sqlServices);
                        while ($row=$getServices->fetch_assoc()) 
                        {
                            ?>
                                <div class="card">
                                    <img src="Images/<?php echo $row['fotoURL'];?>.png" class="card-img-top" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['Service']; ?></h5>
                                        <p class="card-text"><?php echo $row['ServiceDescription']; ?></p>
                                        <p class="card-prijs"><?php echo $row['Prijs'];?></p>       
                                    </div>
                                </div>
                            <?php
                        }
                    }
                ?>
        </div>
        <div class="bestellen">
            <table class="besteltbl">
                <tr>
                    <td><h2>overzicht</h2></td>
                </tr>
                <?php
                    $x=0;
                    $totprijs=0;
                    foreach($_SESSION['ServiceID'] as $result)
                    {
                        $sqlServices="SELECT * FROM tblvooraad WHERE id=$result";
                        $getServices=$db->query($sqlServices);
                        while ($row=$getServices->fetch_assoc())
                        {
                            $prijs=$row['Prijs']*$_SESSION['ServiceAantal'][$x];
                            echo "<tr><td>".$row['Service']."</td><td>$prijs</td></tr>";
                            $totprijs=$totprijs+$prijs;
                            $x++;
                        }
                    }
                    echo "<tr><td>totaalprijs</td><td>".$totprijs."</td></tr>";
                    ?>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td> <button name="bestellen">Bestellen</button></td>
                </tr>
            </table>
        </div>
        <?php
            if (isset($_POST['bestellen']))
            {
                $KlantID=$_SESSION['KlantID'];
                $sql="INSERT INTO tblbestellingen (KlantID,Service1,Hoeveelheid1,Service2,Hoeveelheid2,Service3,Hoeveelheid3,Service4,Hoeveelheid4,Service5,Hoeveelheid5)
                VALUES ('$KlantID',".$_SESSION['ServiceID'][0].",".$_SESSION['ServiceAantal'][0].",".$_SESSION['ServiceID'][1].",".$_SESSION['ServiceAantal'][1].",
                ".$_SESSION['ServiceID'][2].",".$_SESSION['ServiceAantal'][2].",".$_SESSION['ServiceID'][3].",".$_SESSION['ServiceAantal'][3].",".$_SESSION['ServiceID'][4].",".$_SESSION['ServiceAantal'][4].")";
                $db->query($sql);
                /*switch(count($_SESSION['ServiceID']))
                {
                    case 0:
                        echo"Je hebt niets besteld";
                        break;
                    case 1:
                        $sql="INSERT INTO tblbestellingen (KlantID,Service1,Hoeveelheid1)
                        VALUES ('$KlantID',".$_SESSION['ServiceID'][0].",".$_SESSION['ServiceAantal'][0].")";
                        $db->query($sql);
                        break;
                    case 2:
                        $sql="INSERT INTO tblbestellingen (KlantID,Service1,Hoeveelheid1,Service2,Hoeveelheid2)
                        VALUES ('$KlantID',".$_SESSION['ServiceID'][0].",".$_SESSION['ServiceAantal'][0].",".$_SESSION['ServiceID'][1].",".$_SESSION['ServiceAantal'][1].")";
                        $db->query($sql);
                        break;
                    case 3:
                        $sql="INSERT INTO tblbestellingen (KlantID,Service1,Hoeveelheid1,Service2,Hoeveelheid2,Service3)
                        VALUES ('$KlantID',".$_SESSION['ServiceID'][0].",".$_SESSION['ServiceAantal'][0].",".$_SESSION['ServiceID'][1].",".$_SESSION['ServiceAantal'][1].",
                        ".$_SESSION['ServiceID'][2].",".$_SESSION['ServiceAantal'][2].")";
                        $db->query($sql);
                        break;
                    case 4:
                        $sql="INSERT INTO tblbestellingen (KlantID,Service1,Hoeveelheid1,Service2,Hoeveelheid2,Service3,Hoeveelheid3,Service4,Hoeveelheid4)
                        VALUES ('$KlantID',".$_SESSION['ServiceID'][0].",".$_SESSION['ServiceAantal'][0].",".$_SESSION['ServiceID'][1].",".$_SESSION['ServiceAantal'][1].",
                        ".$_SESSION['ServiceID'][2].",".$_SESSION['ServiceAantal'][2].",".$_SESSION['ServiceID'][3].",".$_SESSION['ServiceAantal'][3].")";
                        $db->query($sql);
                        break;
                    case 5:
                        $sql="INSERT INTO tblbestellingen (KlantID,Service1,Hoeveelheid1,Service2,Hoeveelheid2,Service3,Hoeveelheid3,Service4,Hoeveelheid4,Service5,Hoeveelheid5)
                        VALUES ('$KlantID',".$_SESSION['ServiceID'][0].",".$_SESSION['ServiceAantal'][0].",".$_SESSION['ServiceID'][1].",".$_SESSION['ServiceAantal'][1].",
                        ".$_SESSION['ServiceID'][2].",".$_SESSION['ServiceAantal'][2].",".$_SESSION['ServiceID'][3].",".$_SESSION['ServiceAantal'][3].",".$_SESSION['ServiceID'][4].",".$_SESSION['ServiceAantal'][4].")";
                        $db->query($sql);
                        break;
                }*/
                $receiver = "kobe.mestdag@gmail.com";
                $subject = "Email Test via PHP using Localhost";
                $body = "Hi, there...This is a test email send from Localhost.";
                $sender = "MestdagSec";
                if(mail($receiver, $subject, $body, $sender)){
                    echo "Email sent successfully to $receiver";
                }else{
                    echo "Sorry, failed while sending mail!";
                }
            }
        ?>
    </div>
</form>
<body>
</body>
</html>