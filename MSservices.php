<html>
<head>
<?php INCLUDE 'connectiondbs.php'?>
	 <link rel="icon" type="image/x-icon" href="Images/favicon.ico"> 
    <link rel="stylesheet" href="MSservices.css">
</head>
<body>
<?php
    session_start();
    $sqlServices="SELECT * FROM tblvooraad";
    $getServices=$db->query($sqlServices);
    $i=0;
?>
<form method="post">
<div class="container">
    <div class="nav">
        <ul class="nav_ul_container">
            <li><a class="active" href="MestdagSecurity.php">Home</a></li>
            <li><a href="#Services" disabled>Services</a></li>
            <li><a href="#Abouth">About</a></li>
            <button type="submit" name="btnshoppingcart" class="imgshopping"> <img class="shoppingcart" src="Images/shoppingcart.png"></button>
            <?php
                if(isset($_POST['btnshoppingcart']))
                {
                    if(isset($_SESSION['Gebruikersnaam']))
                    {
                        foreach($getServices as $result)
                        {
                            $ID=$result['ID'];
                            if($_POST["aantal$ID"]!= 0){
                                $_SESSION['ServiceID'][$i]=$result['ID'];
                                $_SESSION['ServiceAantal'][$i]=$_POST["aantal$ID"];
                                $_SESSION['ServiceURL'][$i]=$result['FotoURL'];
                                $_SESSION['Service'][$i]=$result['ServiceDescription'];
                                $i++;
                            }
                        }
                        header("Location: MSafrekenen.php");
                    }
                    else
                    {
                        header("Location: MSloginpage.php");
                    }
                }
            ?>
            <div class="nav_right">
                 <li>
                        <?php
                        if(isset($_SESSION['Gebruikersnaam']))
                        {
                            ?>
                                <a>
                                    <input value="<?php echo $_SESSION['Gebruikersnaam'];?>" type="submit" name="Sdestroy">
                                    </button>
                                </a>
                                <?php
                                if(isset($_POST['Sdestroy']))
                                {
                                    session_destroy();
                                    header("Location: MSservices.php");
                                }
                            
                        }
                        else{
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
	<div class="homebody">  
		<div class="titelBody">
			<h1>Our different services.</h1>
		</div>
        <div class="cardgroup">
            <?php
            foreach($getServices as $result)
            {
                ?>
                    <div class="card">
                        <img src="Images/<?php echo $result['fotoURL'];?>.png" class="card-img-top" alt=" <?php echo $result['fotoURL']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $result['Service']; ?></h5>
                            <p class="card-text"><?php echo $result['ServiceDescription']; ?></p>
                            <select class="select" name="aantal<?php echo $result['ID'];?>" id="aantal">
                                <option>0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                <?php
            }
            ?>
        </div>
	</div>
</div>
</form>
</body>
</html>