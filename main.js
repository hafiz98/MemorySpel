var click = 0;
var keuze = "";
var counter = 1;
var geheugen = [];
var plaats = 0;
var gevonden = 0;
var start = true;
var progress = true;
var bar;
// NIet te snel achter elkaar laten draaien. error bij functiue addclass van kaarten


var counter = 0;
var timer = null;

function tictac(){
    counter++;

    var time = new Date(1000 * counter).toISOString().substr(11, 8)
    $("#tijd").html(time);
}

function reset(){
    clearInterval(timer);
    counter = 0;
}

function startInterval(){
    timer = setInterval("tictac()", 1000);
}

//Dit is een terug knop
$( '#terug' ).click(function(){
    reload();
});



function kaart(kaart){
    $( "#titleTop" ).html("Het spel is gestart!");
    $(kaart).addClass("flipped");
    click++;
    var kaartje = $(kaart).data("kaart");
    geheugen[plaats] = kaartje;
    plaats++;

    if (click % 2 == 0) {// controleer hier die twee kaarten
        plaats = 0;
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
            setTimeout(function () { // Open draaien
                $('.kaart' + kaartje).addClass("flipped");
                if (readCookie("level") == 4){
                    bar.destroy();
                    if (gevonden !== 10){
                        progressbarCall();
                    }
                }
            }, 1000);
            setTimeout(function () { // dicht draaien
                $('.kaart' + kaartje).removeClass("flipped");
                $('.kaart' + kaartje).animate({opacity: 0}, 1000);
                $('.kaart' + kaartje).css("visibility", "hidden");
            }, 1000);

            gevonden++;

            $( "#gevonden" ).html(gevonden);

            if (gevonden == 10) { // Als alle kaarten gevond

                clearInterval(timer);

                if (readCookie("level") == 4){
                    bar.stop();
                }

                var time = new Date(1000 * counter).toISOString().substr(11, 8);

                setTimeout(function () {
                    $( "#titleTop" ).html("Gefeliciteerd!\n\nJe hebt " + click + "X geklikt en duurde " + time + "." + "Vul je naam hieronder in zodat je highscores opgeslagen kan worden in onze database!");
                    $( "#containerFormulier" ).css("display", "block", "!important");
                    $( "#containerKaart, #containerLeft, #containerRight, #progressbar, #terug" ).css("display", "none", "!important");
                }, 1000);

                $('#submit').click (function(){
                    if ($('#naam').val() !== ""){
                        $.get( "index.php?ajax=1&klik="+click+"&tijd="+time+"&gevonden="+gevonden+"&naam=" + $("#naam").val() );
                        $( "#titleTop" ).html("Uw gegevens zijn opgeslagen in de database!");
                        $( "#containerFormulier" ).css("display", "block", "!important");
                        $( "#terug" ).css("display", "block", "!important");
                        $( "#naam, #submit" ).css("display", "none", "!important");
                    }
                    else
                    {
                        alert("Vul een naam in A.U.B");
                    }
                });

            }
        }
        else { // Als beide kaarten fout zijn
            setTimeout(function () {
                $('.kaart' + geheugen[0]).removeClass("flipped");
                $('.kaart' + geheugen[1]).removeClass("flipped");
            }, 1000);
        }
    }

    $( "#clicks" ).html(click);

    if (start == true){
        startInterval();
        start = false;
    }
    if (progress == true && readCookie("level") == 4){
        if (gevonden !== 10){
            progressbarCall();
            progress = false;
        }
    }
}

function progressbarCall(){
    bar = new ProgressBar.Line(progressbar, {
        duration: 10000,
        color: '#E67E22',
        trailColor: '#eee',
        trailWidth: 3
    });

    bar.animate(1.0, function() {
        if (gevonden == 0){ // Als de gebruiker niks heeft gevonden
            $( "#titleTop" ).html("Helaas je tijd is om.");
            $( "#containerFormulier" ).css("display", "block", "!important");
            $( "#containerKaart, #containerLeft, #containerRight, #progressbar, #naam, #submit" ).css("display", "none", "!important");
            $( "#terug" ).css("display", "block", "!important");
        }
        else // Als de gebruiker iets heeft gevonden
        {
            if (gevonden !== 10){

                var time = new Date(1000 * counter).toISOString().substr(11, 8);

                $( "#titleTop" ).html("Gefeliciteerd!\n\nJe hebt " + click + "X geklikt en duurde " + time + " en je hebt" + gevonden + " paar/paren gevonden. Vul je naam hieronder in zodat je highscores opgeslagen kan worden in onze database!");
                $( "#containerFormulier" ).css("display", "block", "!important");
                $( "#containerKaart, #containerLeft, #containerRight, #progressbar, #terug" ).css("display", "none", "!important");

                $('#submit').click (function(){
                    if ($('#naam').val() !== ""){
                        $.get( "index.php?ajax=1&klik="+click+"&tijd="+time+"&gevonden="+gevonden+"&naam=" + $("#naam").val() );
                        $( "#titleTop" ).html("Uw gegevens zijn opgeslagen in de database!");
                        $( "#containerFormulier" ).css("display", "block", "!important");
                        $( "#terug" ).css("display", "block", "!important");
                        $( "#naam, #submit" ).css("display", "none", "!important");
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


function reload() {
    window.location.href = window.location.protocol +'//'+ window.location.host + window.location.pathname;
}

function readCookie(value){
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


$( '#reset' ).click(function(){
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