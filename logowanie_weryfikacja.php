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
<nav>
    <div class="links">
        <ul id="leftLinks">
            <li><a href="tabela.php">Home</a></li>
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
        print("<h1>Logowanie</h1>");

        // Sprawdzenie poprawności danych wprowadzonych przez użykownika w formularzu logowania.
        if (!isset($_POST['Konto']) // dane są nieprawidłowe
            || (trim($_POST['Konto']) == '')
            || (!isset($_POST['Haslo']))
            || (trim($_POST['Haslo']) == '')
        ) {
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


            print("<div class='add'>");
            print("<p class='msg error data'>Nieprawidłowa nazwa konta lub hasło (1)</p>");
            print("<button class='btn add' onclick='window.location.href = \"logowanie_formularz.php\";'>Wróć</button>");
            print("</div>");
            die();
        } else { // Jeżeli użytkownik prowadził dane logowania.

            // Pobranie danych wprowadzonych przez użytkownika.
            $KontoForm = trim($_POST['Konto']);
            $HasloForm = trim($_POST['Haslo']);

            // Zabezpieczenie przed atakami typu "SQL injection".
            // Filtrowanie danych wejściowych.
            // Tablica znaków specjalnych - do usunięcia z ciągu wejściowego.
            $tablica_znaki = array("-", "~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "", "+", "=", "{", "}", "[", "]", "|", "\", : ", ";", "\"", "'", ":", "<", ">", ",", ".", "?", "/");
            $KontoForm = str_ireplace($tablica_znaki, "", $KontoForm);
            // filter_var() ZOBACZYC NA POZNIEJ
            //sanitiize)
            // Dane połączenia serwera z baz danych

            require_once("polaczenie_bd.php");




        if(isset($polaczenie) && ($polaczenie != null)) { // Jeżeli polączenie zostało nawiązane.
            try {

                $sql = "SELECT Imie, Nazwisko, Haslo, DataZarejestrowania
                        FROM dbo.Uzytkownik
                        WHERE Konto = '$KontoForm';";

                // Zainicjowanie obiektu klasy PDOStatement.
                $komenda_sql = $polaczenie->prepare($sql);
                // Wykonanie polecenia SQL na serverze bd.
                $komenda_sql->execute();

                // Jeżeli w wyniku zapytania zwrócony został pusty zbiór wierszy.
                $zbior_wierszy = $komenda_sql->fetchAll(PDO::FETCH_ASSOC);
                if ($komenda_sql->rowCount() == 0) {

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

                    print("<div class='add'>");
                    print("<p class='msg error data'>Nieprawidłowa nazwa konta lub hasło (2)</p>");
                    print("<button class='btn add' onclick='window.location.href = \"logowanie_formularz.php\";'>Wróć</button>");
                    print("</div>");
                    die();


                } else {  // Jeżeli zostały zwrócone wiersze.
                    // Pętla pobierania wierszy ze zbioru (record set).
                    //Pobieranie wiersza z danymi użytkownika.
                    foreach ($zbior_wierszy as $wiersz) {
                        $Imie = $wiersz["Imie"];
                        $Nazwisko = $wiersz["Nazwisko"];
                        $Haslo = $wiersz["Haslo"];
                        $DataZarejestrowania = $wiersz["DataZarejestrowania"];
                    }
                        // Weryfikacja hasła wprowadzonego przez użykownika
                        // zabezpieczenie przed atakami typu "timing attack".
                        if (password_verify($HasloForm, $Haslo) == true) {
                            $_SESSION["zalogowany"] = true;
                            $_SESSION["uzytkownik"] = $KontoForm;
                            $_SESSION["imie"] = $Imie;
                            $_SESSION["nazwisko"] = $Nazwisko;

                            print("<div class='add'>");
                            print("<p class='msg success'>Witaj <strong>$Imie $Nazwisko</strong> <br/>
                           Jesteś zalogowany(a) jako <strong>$KontoForm</strong></p>");
                            print("<button class='btn add' onclick='window.location.href = \"tabela.php\";'>Przejdź do wykazu pracowników</button>");
                            print("<button class='btn add' onclick='window.location.href = \"logowanie_koniec.php\";'>Wyloguj</button>");
                            print("</div>");
                        } // if - jeżeli weryfikacja hasła jest pozytywna
                        else { // Jeżeli hasło jest niepoprawne.

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

                            print("<div class='add'>");
                            print("<p class='msg error data'>Nieprawidłowa nazwa konta lub hasło (3)</p>");
                            print("<button class='btn add' onclick='window.location.href = \"logowanie_formularz.php\";'>Wróć</button>");
                            print("</div>");
                        } // Jeżeli hasło jest niepoprawne.
                        // Zwolnienie pamięci zarezerwowanej na wynik zapytania.
                    } // Jezeli zostaly zwrocone dane pracownika
            } catch (Exception $e) {
                print("<p class='msg error'>Podczas przetwarzania danych wystąpił błąd<br/>
              Szczegóły: " . $e->getMessage() . "</p>");
            } finally {
                // Jawne zniszczenie obiektu połączenia klasy PDO.
                $polaczenie = null;
            }
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