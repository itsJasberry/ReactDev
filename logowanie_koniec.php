<?php
session_name("PSIN");
session_start();
unset($_SESSION["licznik"]);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="serwisy, internetowe, programowanie">
    <meta name="description" content="Strona utworzona w ramach listy C8.">
    <meta name="author" content="Szymon Grzesiak">
    <meta name="viewport" content="width=device-width">
    <title>Programowanie serwisów internetowych.</title>
    <link rel="stylesheet" href="styles/app.css">
    <link rel="stylesheet" href="styles/basicStyles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bitter:wght@300;400;500;700&family=Mukta:wght@300;400;500;700&family=Nunito:wght@200&family=Rubik:wght@300;400;500;700&display=swap"
        rel="stylesheet"
    >
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>

<nav>
    <div class="links">
        <ul id="leftLinks">
            <li><a href="#main-layout">Home</a></li>
            <li id="packageHover">
                <a href="sendPackage.html">Send Package</a>
                <div id="dropDown">
                    <ul>
                        <li><a href="#small">Small</a></li>
                        <li><a href="#medium">Medium</a></li>
                    </ul>
                </div>
            </li>
            <li id="packageHover2">
                <a href="#prices">Prices</a>
                <div id="dropDown2">
                    <ul>
                        <li><a href="#send">For sending</a></li>
                        <li><a href="#pick">For picking up</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        <ul id="rightLinks">
            <li><a href="#login">Log in</a></li>
            <li><a href="register.html">Register</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="wrapper">
        <?php
        print("<h2>Koniec sesji użytkownika</h2>");
        print("<div class='add'>");
        print("<p class='msg error data'>Sesja użytkownika została zakończona.</p>");
        print("</div>");
        // Faktyczne zakończenie sesji użytkownika.
        $_SESSION["zalogowany"] = false;

        if(isset($_SESSION["uzytkownik"])) {
            unset($_SESSION["uzytkownik"]);
        }
        if(isset($_SESSION["Imie"])) {
            unset($_SESSION["Imie"]);
        }
        if(isset($_SESSION["Nazwisko"])) {
            unset($_SESSION["Nazwisko"]);
        }
        session_destroy(); // Zniszczenie sesji i wszystkich zmiennych.

            print("<div class='add'>");
            print("<button class='btn add' onclick='window.location.href = \"logowanie_formularz.php\";'>Wróć</button>");
            print("</div>");

        ?>

    </div>
</div>

<?php
require_once("footerAndJSLinks.php");
?>
</body>
</html>