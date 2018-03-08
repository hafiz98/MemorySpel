<?php
    $conn =  new mysqli("localhost", "root", "", "memoryspel");

    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    if ($resource = mysqli_query($conn, " SELECT * FROM `level` ")) // Makes an value from mysqli query.
    {
        while($result = mysqli_fetch_assoc($resource)) // Makes an array, the name of the array is guestbook. you can know it from the brickets[].
        {
            $level[$result['id']] = $result['level'];
        }
    }
    else
    {
        echo "There is a problem:"; // Message says that there is a problem.
        die(mysqli_error($connect)); // Shows the $connect variable.
    }

    if (isset($_GET['level'])){ // Als er een level gekozen is
        setcookie('level', $_GET['level'], time() + (86400 * 30),"/");

        echo '<style> #containerKaart, #containerLeft, #containerRight{display: block;} </style>';
        echo '<style> #containerKeuze{display: none} </style>';

        if($_GET['level'] == 4){
            $level = 3;
            echo '<style> #progressbar{display: block;} </style>';
        }
        else
        {
            $level = $_GET['level'];
            echo '<style> #progressbar{display: none;} </style>';
        }

        if ($resource = mysqli_query($conn, " SELECT * FROM `kaarten` WHERE `level` = '{$level}' UNION ALL SELECT * FROM `kaarten` WHERE `level` = '{$level}' ")) // Makes an value from mysqli query.
        {
            while($result = mysqli_fetch_assoc($resource)) // Makes an array, the name of the array is guestbook. you can know it from the brickets[].
            {
                $kaarten[] = $result;
                shuffle($kaarten);
            }
        }
        else
        {
            echo "There is a problem:"; // Message says that there is a problem.
            die(mysqli_error($conn)); // Shows the $connect variable.
        }
    }
    else // Als er geen level gekozen is
    {
        echo '<style> #containerKaart, .containerTijd, .containerClicks, .containerGevonden, #containerLeft, .containerReset{display: none;} #containerKeuze{display: block}</style>';
    }


    if (isset($_GET['level'])){
        if ($resource = mysqli_query($conn, " SELECT * FROM `resultaten` WHERE `level` = '{$_GET['level']}' ORDER BY `klik` ASC, `tijd` ASC LIMIT 3 ")) // Makes an value from mysqli query. // klik
        {
            while($result = mysqli_fetch_assoc($resource)) // Makes an array, the name of the array is guestbook. you can know it from the brickets[].
            {
                $highscores[] = $result;
            }
        }
        else
        {
            echo "There is a problem:"; // Message says that there is a problem.
            die(mysqli_error($conn)); // Shows the $connect variable.
        }

    }

    if (isset($_GET['ajax'])){

        $conn->query("INSERT INTO `resultaten` VALUES (NULL, NOW(), '{$_GET['tijd']}', '{$_GET['klik']}', '{$_SERVER['REMOTE_ADDR']}', '{$_GET['naam']}','{$_GET['gevonden']}', '{$_COOKIE['level']}')  ");
    }



   // echo '<pre>'; print_r( $kaarten  ); echo '</pre>';

?>
<!doctype html>
<html lang="en">
<head>

    <script src="cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>

    <title>Memory spelen</title>
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div id="containerLeft">
<?php
    if (isset($_GET['level'])) {
?>
    <div id="containerLeftTop">
        <h1>Highscores</h1>
    </div>

    <div  class="containerHighscores">

            <div class="tabLevels">
                <button class="tablinks <?php echo($_GET['level'] == 1 ? "active" : "") ?>">Level 1</button>
                <button class="tablinks <?php echo($_GET['level'] == 2 ? "active" : "") ?>">Level 2</button>
                <button class="tablinks <?php echo($_GET['level'] == 3 ? "active" : "") ?>">Level 3</button>
                <button class="tablinks <?php echo($_GET['level'] == 4 ? "active" : "") ?>">Level 4</button>
            </div>

<?php
            foreach ($highscores as $plaats => $highscore) {
?>

                <div id="containerScore" style="border-bottom: 1px double #E67E22; display: flex; justify-content: center;">

                    <img id="fotoPlaats" width="150" height="150" src="img/<?= $plaats ?>plaats"/>

                    <ul style="list-style-type: none; ">
                        <li><b>Naam: </b><?= $highscore['naam'] ?></li>
                        <li><b>Datum: </b><?= $highscore['datum'] ?></li>
                        <li><b>Tijd: </b><?= $highscore['tijd'] ?></li>
                        <li><b>Gevonden: </b><?= $highscore['gevonden'] ?></li>
                        <li><b>Level: </b><?= $highscore['level'] ?></li>
                        <li><b>Klik: </b><?= $highscore['klik'] ?></li>
                    </ul>

                </div>

<?php
            }
}
?>




    </div>

</div>

<?php
    if (isset($_GET['level'])) {
?>

    <div id="containerRight">

        <div id="containerRightTop">
            <h1>Status</h1>
        </div>

        <h5 id="titleLeft">Tijd</h5>
        <p id="tijd">00:00:00</p>
        <h5 id="titleRight">Clicks</h5>
        <p id="clicks">0</p>
        <h5 id="titleRight">Gevonden</h5>
        <p id="gevonden">0</p>
        <h5 id="titleRight">Reset</h5>
        <input type="button" id="reset" value="Reset" />

    </div>

<?php
}
?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="GET">
    <div id="container">
        <div id="containerMiddleTop">
            <h1 id="titleTop">
                <?php
                    if (isset($_GET['level'])){
                        echo 'Klik op een kaart om het spel te starten';
                    }
                    else
                    {
                        echo 'Kies een hieronder een level';
                    }
                ?>
            </h1>
            <div id="progressbar"></div>
        </div>
        <div id="containerMiddle">

    <?php
    if (isset($_GET['level'])){
                foreach ($kaarten as $cards){
    ?>
                    <div id="containerKaart" class="card kaart<?=$cards['naam']?>" data-kaart="<?=$cards['naam']?>" onclick="kaart(this)">
                        <img class="foto figure" width="150" height="150" src="<?=$cards['url']?>"/>
                        <img class="back figure" width="150" height="150" src="img/back.jpg"/>
                    </div>
    <?php
               }
    }
    ?>
            <div id="containerKeuze">
                <select id="level" name="level" required="required">
                    <option disabled="disabled" selected="selected">Kies een level</option>
    <?php
                    foreach ($level as $id => $level){
                        echo '<option value="'.$id.'">' . $level. '</option>';
                    }
    ?>
                </select>
                <br/>
                <input type="submit" value="Speel het spel"/>
            </div>
            <div id="containerFormulier">
                <?php
                if (isset($_GET['level'])){
                    echo '
                    <input id="naam" type="text" name="naam" placeholder="Naam" required="required"/>
                    <br/>
                    
                    <label id="submit">Opslaan</label>
                    <br/>
                    
                    <input id="terug" type="button" name="terug" value="Ga terug naar hoofdpagina" />
                    
                    ';
                }
                ?>
            </div>
        </div>
    </div>
</form>

<footer>
    <ul>
        <li>Gemaakt door: Hafiz Elkilic</li>
        <li>Datum: 8 maart 2018</li>
    </ul>
</footer>

<script type="text/javascript" src="main.js"></script>
<script type="text/javascript" src="progressbar.js"></script>
</body>
</html>