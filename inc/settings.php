<?php
$conn =  new mysqli("localhost", "root", "", "memoryspel"); // connectie

if ($conn->connect_error){ // als de connectie niet werkt
    die("Connection failed: " . $conn->connect_error); // laat de error zien
}

if ($resource = mysqli_query($conn, " SELECT * FROM `level` ")) // selecteer alle levels
{
    while($result = mysqli_fetch_assoc($resource))
    {
        $level[$result['id']] = $result['level']; // $level is een array en wordt gevuld met alle gegevens van levels
    }
}
else // als het selecteren van alle levels niet lukt
{
    echo "There is a problem: ";
    die(mysqli_error($connect)); // laat de error zien
}

if (isset($_GET['level'])){ // Als er een level gekozen is

    setcookie('level', $_GET['level'], time() + (86400 * 30),"/"); // cookie aanmaken genaamd level en de value wordt dan de level
    echo '<style> #containerKaart, #containerLeft, #containerRight{display: block;} </style>';
    echo '<style> #containerKeuze{display: none} </style>';

    if($_GET['level'] == 4){ // als het level 4 is
        $level = 3; // variabel level wordt 3
        echo '<style> #progressbar{display: block;} </style>'; // maar dan wordt de progressbar wel zichtbaar
    }
    else
    {
        $level = $_GET['level']; // variabel level word gekozen level
        echo '<style> #progressbar{display: none;} </style>';
    }

    if ($resource = mysqli_query($conn, " SELECT * FROM `kaarten` WHERE `level` = '{$level}' UNION ALL SELECT * FROM `kaarten` WHERE `level` = '{$level}' ")) // selecteert twee maal de kaarten
    {
        while($result = mysqli_fetch_assoc($resource)) // Makes an array, the name of the array is guestbook. you can know it from the brickets[].
        {
            $kaarten[] = $result; // $kaarten is een array en wordt gevuld door de resultaat van de query
            shuffle($kaarten); // shuffle alle kaarten van de array $kaarten
        }
    }
    else
    {
        echo "There is a problem:";
        die(mysqli_error($conn)); // laat de error zien
    }

    if ($resource = mysqli_query($conn, " SELECT * FROM `resultaten` WHERE `level` = '{$_GET['level']}' ORDER BY `klik` ASC, `tijd` ASC LIMIT 3 ")) // selecteerd alle resultaten waarbij de level het gekozen level is
    {
        while($result = mysqli_fetch_assoc($resource))
        {
            $highscores[] = $result; // $highscores is een array en wordt gevuld door de resultaat van de query
        }
    }
    else
    {
        echo "There is a problem:";
        die(mysqli_error($conn)); // laat de error zien
    }
}
else // Als er geen level gekozen is
{
    echo '<style> #containerKaart, .containerTijd, .containerClicks, .containerGevonden, #containerLeft, .containerReset{display: none;} #containerKeuze{display: block}</style>';
}



    if (isset($_GET['ajax'])){ // als de submitm knop van is gedrukt
        $conn->query("INSERT INTO `resultaten` VALUES (NULL, NOW(), '{$_GET['tijd']}', '{$_GET['klik']}', '{$_SERVER['REMOTE_ADDR']}', '{$_GET['naam']}','{$_GET['gevonden']}', '{$_COOKIE['level']}')  "); // stuur alle gevens van de speler naar de database
    }