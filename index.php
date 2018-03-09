<?php require ('inc/settings.php'); ?>
<!doctype html>
<html lang="en">
<head>
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <title>Memory spelen by Haffoo</title>
</head>
<body>
<div id="containerLeft">
<?php if (isset($_GET['level'])) { ?> <!--als er een level gekozen is-->
    <div id="containerLeftTop">
        <h1>Highscores</h1>
    </div>
    <div  class="containerHighscores">
            <div class="tabLevels">
                <button class="tablinks <?php echo($_GET['level'] == 1 ? "active" : "") ?>">Level 1</button>
                <button class="tablinks <?php echo($_GET['level'] == 2 ? "active" : "") ?>">Level 2</button>
                <button class="tablinks <?php echo($_GET['level'] == 3 ? "active" : "") ?>">Level 3</button>
                <button class="tablinks <?php echo($_GET['level'] == 4 ? "active" : "") ?>">Level 4</button>
            </div><!--einde tabLevels-->
                <?php foreach ($highscores as $plaats => $highscore) { ?>
                    <div id="containerScore" style="border-bottom: 1px double #E67E22; display: flex; justify-content: center;">
                        <img id="fotoPlaats" width="150" height="150" src="img/<?=$plaats?>plaats"/>
                        <ul style="list-style-type: none; ">
                            <li><b>Naam: </b><?=$highscore['naam']?></li>
                            <li><b>Datum: </b><?=$highscore['datum']?></li>
                            <li><b>Tijd: </b><?=$highscore['tijd']?></li>
                            <li><b>Gevonden: </b><?=$highscore['gevonden']?></li>
                            <li><b>Level: </b><?=$highscore['level']?></li>
                            <li><b>Klik: </b><?=$highscore['klik']?></li>
                        </ul>
                    </div><!--einde containerScore-->
<?php
            }
}
?>
    </div><!--einde containerHighscores-->
</div><!--einde containerLeft-->

<?php if (isset($_GET['level'])) { ?>
    <div id="containerRight">
        <div id="containerRightTop">
            <h1>Status</h1>
        </div><!--einde containerRightTop-->
        <h5 id="titleLeft">Tijd</h5>
        <p id="tijd">00:00:00</p>
        <h5 id="titleRight">Clicks</h5>
        <p id="clicks">0</p>
        <h5 id="titleRight">Gevonden</h5>
        <p id="gevonden">0</p>
        <h5 id="titleRight">Reset</h5>
        <input type="button" id="reset" value="Reset" />
        <br/><br/>
        <input type="button" id="terug" value="Terug naar hoofdpagina" />
    </div><!--einde containerRight-->
<?php } ?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="GET">
    <div id="container">
        <div id="containerMiddleTop">
            <h1 id="titleTop">
                <?php
                    if (isset($_GET['level'])){ // als er een level bestaat
                        echo 'Klik op een kaart om het spel te starten';
                    }
                    else
                    {
                        echo 'Kies een hieronder een level';
                    }
                ?>
            </h1>
            <div id="progressbar"></div>
            <br/>
        </div><!--einde containerMiddleTop-->
        <div id="containerMiddle">

    <?php if (isset($_GET['level'])){ // als er een level bestaat
                foreach ($kaarten as $cards){ ?>  <!--alle kaarten worden hier opgehaald-->
                    <div id="containerKaart" class="card kaart<?=$cards['naam']?>" data-kaart="<?=$cards['naam']?>" onclick="kaart(this)">
                        <img class="foto figure" width="150" height="150" src="<?=$cards['url']?>"/>
                        <img class="back figure" width="150" height="150" src="img/back.jpg"/>
                    </div>
    <?php
               }
    } ?>
            <div id="containerKeuze">
                <select id="level" name="level" required="required">
                    <option disabled="disabled" selected="selected">Kies een level</option>
                    <?php foreach ($level as $id => $level){
                                echo '<option value="'.$id.'">' . $level. '</option>';
                    }?>
                </select>
                <br/><input type="submit" value="Speel het spel"/><!--submit knop-->
            </div><!--einde containerKeuze-->
            <div id="containerFormulier">
                <?php
                    if (isset($_GET['level'])){ // als er een level bestaat
                        echo '
                        <input id="naam" type="text" name="naam" placeholder="Naam" required="required"/><br/><br/>
                        <label id="submit">Opslaan</label><br/>       
                        <input id="terug" type="button" name="terug" value="Ga terug naar hoofdpagina" />';
                    }
                ?>
            </div><!--einde containerFormulier-->
        </div><!--einde containerMiddle-->
    </div><!--einde container-->
</form><!--einde formulier-->

<footer>
        <h3>Gemaakt door: Hafiz Elkilic</h3>
        <h3>Datum: 8 maart 2018</h3>
</footer><!--einde footer-->

<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/progressbar.js"></script>
</body>
</html>