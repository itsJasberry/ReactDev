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
            // Sprawdzenie czy w żadaniu http został przekazany klucz wiersza.
            if (!isset($_GET['IdPracownik']) // dane są nieprawidłowe
                || (trim($_GET['IdPracownik']) == '')
                || !is_numeric($_GET['IdPracownik'])) {

                print("<div class='add'>");
                print("<p class='msg error data'>Nie można edytować danych pracownika, poniewaz nie został on wybrany..</p>");
                print("<button class='btn add' onclick='window.location.href = \"tabela.php\";'>Wróć</button>");
                print("</div>");
                die();
            } else { // Jeżeli został przekazany klucz wiersza do edycji.

                // Dane połączenia serwera z baz danych
                require_once("polaczenie_bd.php");

                if (isset($polaczenie) && ($polaczenie != null)) { // Jeżeli polączenie zostało nawiązane.
                    try {
                        //Pobranie zmiennych wysłanych z formularza.
                        $IdPracownik = trim($_GET['IdPracownik']);

                        $sql = "SELECT IdPracownik, Imie, Nazwisko, NrTelefonu, Stanowisko
                        FROM dbo.Pracownik
                        WHERE IdPracownik = $IdPracownik;";

// Wykonanie polecenia SQL na serwerze bd.

                        $komenda_sql = $polaczenie->prepare($sql);
                        // Wykonanie polecenia SQL na serverze bd.
                        $komenda_sql->execute();

                        $zbior_wierszy = $komenda_sql->fetchAll(PDO::FETCH_ASSOC);
                        // Jeżeli w wyniku zapytania zwrócony został pusty zbiór wierszy.
                        if ($komenda_sql->rowCount() == 0) {
                             throw new Exception("Zapisanie danych pracownika <strong>$IdPracownik </strong> nie powiodło się.");
                        } else {  // Jeżeli zostały zwrócone wiersze.
                            // Pętla pobierania wierszy ze zbioru (record set).
                            foreach ($zbior_wierszy as $wiersz) {
                                $Imie = $wiersz["Imie"];
                                $Nazwisko = $wiersz["Nazwisko"];
                                $NrTelefonu = $wiersz["NrTelefonu"];
                                $Stanowisko = $wiersz["Stanowisko"];
                            } // while - petla pobierania wierszy ze zbioru


                            print("
                 <div class='login-box' id='editt'>
    <h2>Pracownik</h2>
    <form  id='frmPracownikEdytuj' action='pracownik_edytuj_potw.php' method='get'>
      <div class='user-box'>
       <input name='IdPracownik' type='text' id='IdPracownik' maxlength='10' pattern='[0-9]+' 
       required placeholder=' '  value='$IdPracownik' readonly>
        <label for='IdPracownik'>Identyfikator*</label>
      </div>
      <div class='user-box'>
        <input id='Imie' name='Imie' type='text' maxlength='40' required placeholder=' ' 
        value='$Imie'
        >
        <label for='Imie'>Imię*</label>
      </div>
      <div class='user-box'>
        <input id='Nazwisko' name='Nazwisko' type='text' maxlength='40' required placeholder=' '
        value='$Nazwisko'>
        <label for='Nazwisko'>Nazwisko*</label>
      </div>
      <div class='user-box'>
       <input id='NrTelefonu' name='NrTelefonu' type='text' maxlength='20' 
              pattern= '\+\d{2}\s\d{2}\s\d{4}\s\d{3}|\+\d{2}\s\d{3}\s\d{3}\s\d{3}' 
              required placeholder=' ' value='$NrTelefonu'>
        <label for='NrTelefonu'>Numer Telefonu*</label>
      </div>
      <div class='user-box'>
         <input id='Stanowisko' name='Stanowisko' type='text' maxlength='20' 
         pattern='a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-\.' required placeholder=' ' value='$Stanowisko'>
         <label for='Stanowisko'>Stanowisko*</label>
      </div>
      
      <div class='buttons'>
        <input id='save' class='btn editForm' type='submit' value='Zapisz'>
        <input id='res' class='btn editForm' type='reset' value='Reset'>
        <a class='btn editForm' id='back' href='tabela.php' style='text-decoration: none'>Wróć</a>
      </div>
    </form>
    <img class='biggerImage' src='https://robohash.org/$IdPracownik?set=set4&size=200x200' alt='pracownik_image'>
  </div>
                    ");
                        } // Jezeli zostaly zwrocone dane pracownika

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