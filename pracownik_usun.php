<?php
session_name("PSIN");
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="serwisy, internetowe, programowanie">
    <meta name="description" content="Strona utworzona w ramach listy C8.">
    <meta name="author" content="Szymon Grzesiak">
    <meta name="viewport" content="width=device-width">
    <title>Programowanie serwisów internetowych – lista C8.</title>
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

<?php
require_once("navbar.php");
?>


<div class="container">
    <div class="wrapper">
        <?php
        if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == false) || (!isset($_SESSION['zalogowany'])) || (!isset($_SESSION['uzytkownik']))) {

            print("<h2>Odmowa dostępu</h2>");

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

            print("<p class='error'>Ta funkcja jest dostępna tylko dla zalogowanych użytkowników!</p>");

            print("<div class='add'>");
            print("<button class='btn add' onclick='window.location.href = \"logowanie_formularz.php\";'>Wróć</button>");
            print("</div>");

        } else if(($_SESSION['zalogowany']) && (isset($_SESSION['uzytkownik']))) {
            if (isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == false) || (!isset($_SESSION['zalogowany'])) || (!isset($_SESSION['uzytkownik']))) {

                print("<h2>Odmowa dostępu</h2>");

                // Faktyczne zakończenie sesji użytkownika.
                $_SESSION["zalogowany"] = false;

                if (isset($_SESSION["uzytkownik"])) {
                    unset($_SESSION["uzytkownik"]);
                }
                if (isset($_SESSION["Imie"])) {
                    unset($_SESSION["Imie"]);
                }
                if (isset($_SESSION["Nazwisko"])) {
                    unset($_SESSION["Nazwisko"]);
                }
                session_destroy(); // Zniszczenie sesji i wszystkich zmiennych.

                print("<p class='error'>Ta funkcja jest dostępna tylko dla zalogowanych użytkowników!</p>");

                print("<div class='add'>");
                print("<button class='btn add' onclick='window.location.href = \"logowanie_formularz.php\";'>Wróć</button>");
                print("</div>");

            } else if (($_SESSION['zalogowany']) && (isset($_SESSION['uzytkownik']))) {
                // Sprawdzenie czy w żadaniu http został przekazany klucz wiersza.
                if (!isset($_GET['IdPracownik']) // dane są nieprawidłowe
                    || (trim($_GET['IdPracownik']) == '')
                    || !is_numeric($_GET['IdPracownik'])) {

                    print("<div class='add'>");
                    print("<p class='msg error data'>Nie można usunąć danych pracownika, poniewaz nie został on wybrany..</p>");
                    print("<button class='btn add' onclick='window.location.href = \"tabela.php\";'>Wróć</button>");
                    print("</div>");
                    die();
                } else { // Jeżeli został przekazany klucz wiersza do usunięcia.

                    //Pobranie zmiennych wysłanych z formularza.
                    $IdPracownik = trim($_GET['IdPracownik']);
                    print("<h2 id='usuwanieDanychPracownika'>Usuwanie danych pracownika</h2>");

                    print("<div class='add'>");
                    print("<p class='msg warn'>Czy na pewno usunąć dane pracownika o identyfikatorze <strong>$IdPracownik</strong></p>");
                    print("<div class='buttony'>");
                    print("<button class='btn del' id='del' onclick=\"window.location.href='pracownik_usun_potw.php?IdPracownik=$IdPracownik'\">Tak, usuń</button>");
                    print("<button class='btn usun' id='keep' onclick='window.location.href = \"tabela.php\";'>Nie, wróć do wykazu</button>");
                    print("</div>");
                    print("</div>");


                } // Jeżeli połaczenie zostało nawiązane.
            }
        }
        ?>

    </div>
</div>

<?php
require_once("footerAndJSLinks.php");
?>
</body>
</html>