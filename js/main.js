var click = 0;
var geheugen = [];
var plaats = 0;
var gevonden = 0;
var start = true;
var progress = true;
var bar;
var counter = 0;
var timer = null;

function tictac(){ // teller van tijd
    counter++;
    var time = new Date(1000 * counter).toISOString().substr(11, 8) // seconden veranderen naar HH:MM:SS
    $("#tijd").html(time); // HH:MM:SS gaat in div #tijd
}

function reset(){ // resetten van tijd
    clearInterval(timer); // interval stopt
    counter = 0; // counter wordt gereset
}

function startInterval(){ // starten van tijd
    timer = setInterval("tictac()", 1000); // om de 1000ms wordt de functie tictac herhaald
}


$( '#terug' ).click(function(){ // als je op #terug knop klikt
    window.location.href = window.location.protocol +'//'+ window.location.host + window.location.pathname; // terug naar de hoofdpagina
});



function kaart(kaart){
    $( "#titleTop" ).html("Het spel is gestart!"); // titel van top div verandert naar "Het spel is gestart!"
    $(kaart).addClass("flipped"); // kaart wordt omgedraaid
    click++; // klik + 1
    var kaartje = $(kaart).data("kaart"); // variabel kaartje wordt de naam van de kaart
    geheugen[plaats] = kaartje; // geheugen is een array en die wordt opgevult met de naam van de kaart
    plaats++; // plaats + 1

    if (click % 2 == 0) { // als er twee kaarten zijn geklikt
        plaats = 0; // plaats wordt gereset
        function countInArray(array, what) {
            var count = 0;
            for (var i = 0; i < geheugen.length; i++) {
                if (geheugen[i] === kaartje) {
                    count++;
                }
            }
            return count;
        }
        if (countInArray(geheugen, kaartje) == 2) { // Als beide kaarten goed zijn
            setTimeout(function () { // omdraaien draaien (afbeelding laten zien)
                $('.kaart' + kaartje).addClass("flipped"); // kaart zichtbaar
                if (readCookie("level") == 4){ // als het level 4 is
                    bar.destroy(); // progressbar verwijderen
                    if (gevonden !== 10){  // als niet alle kaarten zijn gevonden
                        progressbarCall(); // progressbar wordt aangeroepen
                    }
                }
            }, 1000);
            setTimeout(function () { // omdraaien draaien (? laten zien)
                $('.kaart' + kaartje).removeClass("flipped"); // kaart onzichtbaar
                $('.kaart' + kaartje).animate({opacity: 0}, 1000); // binnen 1000 miliseconden wordt de opacity 0
                $('.kaart' + kaartje).css("visibility", "hidden"); // het kaart is niet zichtbaar
            }, 1000);

            gevonden++; // gevonden word +1

            $( "#gevonden" ).html(gevonden); // het aantal gevonden in div zetten

            if (gevonden == 10) { // Als alle kaarten gevond

                clearInterval(timer); // timer stopt

                if (readCookie("level") == 4){ // als het level 4 is
                    bar.stop(); // progressbar stopt
                }

                var time = new Date(1000 * counter).toISOString().substr(11, 8); // seconden veranderen naar HH:MM:SS

                setTimeout(function () { // om de 1000ms gebeurd
                    $( "#containerMiddleTop" ).html("<h4>Gefeliciteerd!\n\nJe hebt " + click + "X geklikt en duurde " + time + "." + "\n\nVul je naam hieronder in zodat je highscores opgeslagen kan worden in onze database!</h4><br/><br/>");
                    $( "#containerMiddleTop" ).css("text-align", "center"); //
                    $( "#containerFormulier" ).css("display", "block", "!important");
                    $( "#containerKaart, #containerLeft, #containerRight, #progressbar" ).css("display", "none", "!important");
                }, 1000);

                $('#submit').click (function(){
                    if ($('#naam').val() !== ""){
                        $.get( "index.php?ajax=1&klik="+click+"&tijd="+time+"&gevonden="+gevonden+"&naam=" + $("#naam").val() );
                        $( "#containerKaart, #containerLeft, #containerRight, #progressbar" ).css("display", "none", "!important");
                        $( "#containerMiddleTop" ).html("<h1>Uw gegevens zijn opgeslagen in de database!</h1>");
                        setTimeout(function () { // over 2000ms
                            window.location.href = window.location.protocol +'//'+ window.location.host + window.location.pathname; // pagina wordt herladen
                        }, 2000);

                    }
                    else // als er geen naam is gevuld maar alleen de knop
                    {
                        alert("Vul een naam in A.U.B!");
                    }
                });

            }
        }
        else { // Als beide kaarten fout zijn
            setTimeout(function () { // 1000ms seconden
                $('.kaart' + geheugen[0]).removeClass("flipped"); // eerste geheugen wordt verwijdert
                $('.kaart' + geheugen[1]).removeClass("flipped"); // tweede geheugen wordt verwijdert
            }, 1000);
        }
    }

    $( "#clicks" ).html(click);

    if (start == true){
        startInterval();
        start = false;
    }
    if (progress == true && readCookie("level") == 4){ // als de progress aanstaat en level 4 is
        if (gevonden !== 10){ // als de gebruiker geen 10 kaarten heeft gevonden
            progressbarCall();
            progress = false;
        }
    }
}

function progressbarCall(){ // progressbar
    bar = new ProgressBar.Line(progressbar, {
        duration: 15000, // 15 seconden timer
        color: '#E67E22', // kleur
        trailColor: '#eee', // kleur
        trailWidth: 3 // hoogte
    });

    bar.animate(1.0, function() {
        if (gevonden == 0){ // Als de gebruiker niks heeft gevonden
            $( "#titleTop" ).html("Helaas je tijd is om.");
            $( "#containerKaart, #containerLeft, #containerRight, #progressbar" ).css("display", "none", "!important");

            setTimeout(function () { // terug gaan naar de hoofdpagina
                window.location.href = window.location.protocol +'//'+ window.location.host + window.location.pathname; // pagina wordt herladen
            }, 2000);

        }
        else // Als de gebruiker iets heeft gevonden
        {
            if (gevonden !== 10){

                var time = new Date(1000 * counter).toISOString().substr(11, 8);

                $( "#containerMiddleTop" ).html("<h4>Gefeliciteerd!\n\nJe hebt " + click + "X geklikt en duurde " + time + "." + "\n\nVul je naam hieronder in zodat je highscores opgeslagen kan worden in onze database!</h4><br/><br/>");
                $( "#containerMiddleTop" ).css("text-align", "center");
                $( "#containerFormulier" ).css("display", "block", "!important");
                $( "#containerKaart, #containerLeft, #containerRight, #progressbar" ).css("display", "none", "!important");
                $( "#terug" ).css("display", "none");

                $('#submit').click (function(){
                    if ($('#naam').val() !== ""){
                        $.get( "index.php?ajax=1&klik="+click+"&tijd="+time+"&gevonden="+gevonden+"&naam=" + $("#naam").val() );
                        $( "#containerMiddleTop" ).html("<h1>Uw gegevens zijn opgeslagen in de database!</h1>");
                        $( "#submit, #naam" ).css("display", "none");

                        setTimeout(function () { // terug gaan naar hoofdpagina
                            window.location.href = window.location.protocol +'//'+ window.location.host + window.location.pathname;
                        }, 2000);
                    }
                    else
                    {
                        alert("Vul een naam in A.U.B");
                    }
                });
            }
        }
    });
}

function readCookie(value){ // hier wordt de value van een cookie opgehaald
    var cookieName = value + "="; //Set a variable for the name of the cookie
    var cookieArray = document.cookie.split(';'); //Makes an array from splitting all cookies which is available for user

    for (var i=0; i < cookieArray.length; i++) //For loop trough the whole cookieArray
    {
        var cookie = cookieArray[i]; //Set a variable cookie for the array of all cookies
        while (cookie.charAt(0) === ' ') cookie = cookie.substring(1,cookie.length); //While cookieArray = 0 then is the string of the cookie the length of the cookie
        if (cookie.indexOf(cookieName) === 0) return cookie.substring(cookieName.length,cookie.length); //If there is nothing inside the cookie, ten it returns the length of the cookie
    }
    return null; // returns nothing/null
}

$( '#reset' ).click(function(){ // dit is een reset knop. alle gegevens wordt dat gereset
    start = true;
    click = 0;
    gevonden = 0;
    reset();
    $("#tijd").html("00:00:00");
    $("#clicks").html("0");
    $("#gevonden").html("0");
    $( "#titleTop" ).html("Klik op een kaart om het spel te starten");
    $( "#containerKaart" ).css("display", "block", "!important");
    $('.card').removeClass("flipped");
    $('.card').animate({opacity: 1}, 1000);
    $('.card').css("visibility", "visible");

    if (readCookie("level") == 4){
        bar.destroy();
        progress = true;
    }
});