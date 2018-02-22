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

    if (isset($_POST['level'])){ // Als er een level gekozen is
        setcookie('level', $_POST['level'], time() + (86400 * 30),"/");

        echo '<style> #containerKaart, #containerLeft, #containerRight{display: block;} </style>';
        echo '<style> #containerKeuze{display: none} </style>';

        if($_POST['level'] == 4){
            $level = 3;
            echo '<style> #progressbar{display: block;} </style>';
        }
        else
        {
            $level = $_POST['level'];
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
        echo '<style> #containerKaart, .containerTijd, .containerClicks, .containerGevonden, .containerReset{display: none;} #containerKeuze{display: block}</style>';
    }

if ($resource = mysqli_query($conn, " SELECT * FROM `resultaten` ORDER BY `gevonden` DESC, `tijd` ASC LIMIT 3 ")) // Makes an value from mysqli query.
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
    if (isset($_POST['ajax'])){
        echo '<pre>'; print_r($_POST); echo '</pre>';
        $conn->query("INSERT INTO `resultaten` VALUES (NULL, NOW(), '{$_POST['tijd']}', '{$_POST['klik']}', '{$_SERVER['REMOTE_ADDR']}', '{$_POST['naam']}','{$_POST['gevonden']}', '{$_COOKIE['level']}')  ");
    }


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
    <div id="containerLeftTop" class="containerHighscores">
        <h1 id="titleLeft">Highscores</h1><br/>

        <?php
            foreach ($highscores as $plaats => $highscore){
        ?>

        <div id="containerScore" style="border: 1px solid black; display: flex; justify-content: center;">

            <img id="fotoPlaats" width="150" height="150" src="img/<?=$plaats?>plaats"/>

                <ul style="list-style-type: none; ">
                    <li><b>Naam: </b><?=$highscore['naam']?></li>
                    <li><b>Datum: </b><?=$highscore['datum']?></li>
                    <li><b>Tijd: </b><?=$highscore['tijd']?></li>
                    <li><b>Gevonden: </b><?=$highscore['gevonden']?></li>
                    <li><b>Level: </b><?=$highscore['level']?></li>
                </ul>

        </div>


        <?php
            }
        ?>


    </div>
</div>

<div id="containerRight">
    <div id="containerRightTop" class="containerTijd">
        <h1 id="titleLeft">Tijd</h1><br/>
        <h1 id="tijd">00:00:00</h1>
    </div>
    <div id="containerRightTop" class="containerClicks">
        <h1 id="titleRight">Clicks</h1><br/>
        <h1 id="clicks">0</h1>
    </div>
    <div id="containerRightTop" class="containerGevonden">
        <h1 id="titleRight">Gevonden</h1><br/>
        <h1 id="gevonden">0</h1>
    </div>
    <div id="containerRightTop" class="containerReset">
        <h1 id="titleRight">Reset</h1><br/>
        <input type="button" id="reset" value="Reset" />
    </div>
</div>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <div id="container">
        <div id="containerTop">
            <h1 id="titleTop">
                <?php
                    if (isset($_POST['level'])){
                        echo 'Klik op een kaart om het spel te starten';
                    }
                    else
                    {
                        echo 'Kies een hieronder een level';
                    }
                ?>
            </h1>
            <div id="progressbar"></div>
            <div id="containerTime"></div>

        </div>
        <div id="containerMiddle">
    <?php
    if (isset($_POST['level'])){
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
                <input type="submit" />
            </div>
            <div id="containerFormulier">
                <h1>Vul je gegevens in zodat je highscores opgeslagen kan worden in onze database!</h1>
                <br/>
                <?php
                if (isset($_POST['level'])){
                    echo '
                    <input id="naam" type="text" name="naam" placeholder="Naam" /><br/>
                    <input id="submit" type="submit" name="submit" value="Opslaan" /><br/>
                    <input id="terug" type="button" name="terug" value="Terug naar hoofdpagina" /><br/>
                    ';
                }
                ?>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript"src="counter/dist/countUp.min.js"></script>
<script type="text/javascript" src="main.js"></script>
<script type="text/javascript" src="progressbar.js"></script>
</body>
</html>