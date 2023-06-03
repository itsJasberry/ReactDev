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
            if (!isset($_GET['IdPracownik'])
                || (trim($_GET['IdPracownik']) == '')
                || !is_numeric($_GET['IdPracownik'])
                || !isset($_GET['Imie'])
                || (trim($_GET['Imie']) == '')
                || !isset($_GET['Nazwisko'])
                || (trim($_GET['Nazwisko']) == '')
                || !isset($_GET['NrTelefonu'])
                || (trim($_GET['NrTelefonu']) == '')
                || !isset($_GET['Stanowisko'])
                || (trim($_GET['Stanowisko']) == '')) {

                print("<div class='add'>");
                print("<p class='msg error data'>Nieprawidłowe dane.</p>");
                print("<button class='btn add' onclick='window.location.href = \"tabela.php\";'>Wróć</button>");
                print("</div>");
                die();
            } else {


                // Dane połączenia serwera z baz danych
                require_once("polaczenie_bd.php");

                // Jeżeli próba połaczenia nie powiodła się
                if (isset($polaczenie) && ($polaczenie != null)) {
                    try {
                        $IdPracownik = trim($_GET['IdPracownik']);
                        //$IdPracownik = str_ireplace($tablica_znaki, "", $IdPracownik);
                        $Imie = trim($_GET['Imie']);
                        // $Imie = str_ireplace($tablica_znaki, "", $Imie);
                        $Nazwisko = trim($_GET['Nazwisko']);
                        // $Nazwisko = str_ireplace($tablica_znaki, "", $Nazwisko);
                        $NrTelefonu = trim($_GET['NrTelefonu']);
                        // $NrTelefonu = str_ireplace($tablica_znaki, "", $NrTelefonu);
                        $Stanowisko = trim($_GET['Stanowisko']);
                        // $Stanowisko = str_ireplace($tablica_znaki, "", $Stanowisko);

                        $sql = "EXECUTE dbo.Pracownik_Modyfikuj
                        @Par_IdPracownik = $IdPracownik,
                        @Par_Imie = '$Imie',
                        @Par_Nazwisko = '$Nazwisko',
                        @Par_NrTelefonu = '$NrTelefonu',
                        @Par_Stanowisko = '$Stanowisko'";


                        // Zainicjowanie obiektu klasy PDOStatement.
                        $komenda_sql = $polaczenie->prepare($sql);
                        // Wykonanie polecenia SQL na serverze bd.
                        $komenda_sql->execute();

                        // Jeżeli wykonanie polecenia na serwerze nie powiodło się
                        if ($komenda_sql->rowCount() != 1) {
                            throw new Exception("Zapisanie danych pracownika <strong>$Imie $Nazwisko </strong> nie powiodło się.");
                        } else { // Jeżeli wykonanie polecenia na serwerze powiodło się
                            print("<div class='add'>");
                            print("<p class='msg success'>Dane pracownika <strong>$Imie $Nazwisko </strong> zostały zapisane w bazie.</p>");
                            print("</div>");
                        }


                    } catch (Exception $e) {
                        print("<p class='msg error'>Podczas przetwarzania danych wystąpił błąd<br/>
                                Szczegóły: " . $e->getMessage() . "</p>");
                    } finally {
                        // Jawne zniszczenie obiektu połączenia klasy PDO.
                        $polaczenie = null;
                        print("<div class='add'>");
                        print("<button class='btn add' onclick='window.location.href = \"tabela.php\";'>Wróć</button>");
                        print("</div>");

                    }
                } // Jeżeli połaczenie zostało nawiązane.

            } // Jeżeli dane przesłane z formularza są dokładne
        }
        ?>

    </div>
</div>

<?php
require_once("footerAndJSLinks.php");
?>
</body>
</html>