<?php
session_name("PSIN");
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="serwisy, internetowe, programowanie">
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

  <?php
    require_once("navbar.php");
  ?>


    <div class="container">

      <?php
      $id_sesji = session_id();
      print("<p class='msg'>Identyfikator sesji: $id_sesji</p>");
      print("<p>Statystyka operacji CRUD w tabeli: </p>");
      if (!isset($_SESSION["licznik"]))
      {
        $_SESSION["licznik"] = 1;
      }
      else
      {
        $_SESSION["licznik"]++;
      }


      if (!isset($_SESSION["licznikAdd"]))
      {
        $_SESSION["licznikAdd"] = 0;
      }


      $licznik = $_SESSION["licznik"];
      $licznikAdd = $_SESSION["licznikAdd"];
      print("<p>Strona była wyświetlona $licznik razy.</p>");
      print("<p>Strona była wyświetlona $licznikAdd razy.</p>");

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

        // Dane połączenia serwera z baz danych.


       // Wlaczenie zewnetrznego pliku realizujacego polaczenie z serwerem baz danych.
        // Próba połączenia z serwerem baz danych.
        require_once("polaczenie_bd.php");

        // Jeżeli polączenie zostało nawiązane.
        if(isset($polaczenie) && ($polaczenie != null)) {
          try {
            $kolumna = 'IdPracownik';
            $kierunek = 'ASC';
            if (isset($_GET['sort']) && isset($_GET['order'])) {
              $kolumna = $_GET['sort'];
              $kierunek = $_GET['order'];
            }
            print("
            <form id='filtrForm' method='post'>
              <input type='text' id='filtrInput' name='filtrInput' placeholder='Wyszukaj pracownika'>
              <button type='submit' id='filtrButton' name='submit'>
                <img alt='lupa' class='search-icon' src='http://www.endlessicons.com/wp-content/uploads/2012/12/search-icon.png'>
              </button>
    </form>
            
           
        ");

            print("<h2 class='workers'>Pracownicy</h2>");
            print("<table class='students-table'>
                    <thead> 
                        <tr>
                            <th></th>
                            <th><a href='?sort=IdPracownik&order=" . ($kolumna == 'IdPracownik' && $kierunek == 'ASC' ? 'DESC' : 'ASC') . "'>Identyfikator</a></th>
                            <th><a href='?sort=Imie&order=" . ($kolumna == 'Imie' && $kierunek == 'ASC' ? 'DESC' : 'ASC') . "'>Imię</a></th>
                            <th><a href='?sort=Nazwisko&order=" . ($kolumna == 'Nazwisko' && $kierunek == 'ASC' ? 'DESC' : 'ASC') . "'>Nazwisko</a></th>
                            <th><a href='?sort=NrTelefonu&order=" . ($kolumna == 'NrTelefonu' && $kierunek == 'ASC' ? 'DESC' : 'ASC') . "'>Numer Telefonu</a></th>
                            <th><a href='?sort=Stanowisko&order=" . ($kolumna == 'Stanowisko' && $kierunek == 'ASC' ? 'DESC' : 'ASC') . "'>Stanowisko</a></th>
                            <th></th>
                            <th></th>
                         </tr>
                    </thead>
                    <tbody>");

            // Polecenie SQL pobierające wiersze z tabeli bd.


            $sql = null;
            // Sprawdź, czy formularz został wysłany
            if (isset($_POST['submit'])) {
              $tablica_znaki = array("-", "~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "", "+", "=", "{", "}", "[", "]", "|", "\", : ", ";", "\"", "'", ":", "<", ">", ",", ".", "?", "/");
              $search = $_POST['filtrInput'];;
              $search = str_ireplace($tablica_znaki, "", $search);


              // Zbuduj zapytanie SQL, które wybierze rekordy zawierające szukany tekst w kolumnie "nazwisko"
              $sql = "EXECUTE dbo.Pracownik_Wyszukaj
                      @search = '$search'";

              // Zainicjowanie obiektu klasy PDOStatement.
              $komenda_sql = $polaczenie->prepare($sql);
              // Wykonanie polecenia SQL na serverze bd.
                $komenda_sql->execute();


            } else {
              $sql = " EXECUTE dbo.Pracownik_Pobierz
                       @kolumna = $kolumna,
                       @kierunek = '$kierunek'";


              $komenda_sql = $polaczenie->prepare($sql);
              // Wykonanie polecenia SQL na serverze bd.
              $komenda_sql->execute();
            }


            // Pobranie zbioru wierszy w postaci tablicy asocjacyjnej.
            $zbior_wierszy = $komenda_sql->fetchAll(PDO::FETCH_ASSOC);
            // Jeżeli w wyniku zapytania zwrócony został pusty zbiór wierszy.
            if ($komenda_sql->rowCount() == 0) {
              print("<tr>
                      <td colspan='8'>Brak danych pracowników w bazie.</td>
                  </tr>");
            } else {  // Jeżeli zostały zwrócone wiersze.
              // Pętla pobierania wierszy ze zbioru (record set).
              foreach ($zbior_wierszy as $wiersz) {
                $IdPracownik = $wiersz["IdPracownik"];
                $Imie = $wiersz["Imie"];
                $Nazwisko = $wiersz["Nazwisko"];
                $NrTelefonu = $wiersz["NrTelefonu"];
                $Stanowisko = $wiersz["Stanowisko"];
                print("<tr>
                        <td class='pictureImageThumb'><img alt='$Imie' class='imageThumb' src='https://robohash.org/$IdPracownik?set=set4&size=50x50'></td>
                        <td>$IdPracownik</td>
                        <td>$Imie</td>
                        <td>$Nazwisko</td>
                        <td>$NrTelefonu</td>
                        <td>$Stanowisko</td>
                        <td><a class='btn array edit'  href='pracownik_edytuj.php?IdPracownik=$IdPracownik'>Edytuj</a></td>
                        <td><a class='btn array delete'  href='pracownik_usun.php?IdPracownik=$IdPracownik'>Usuń</a></td>
                    </tr>");

              } // foreach - petla pobierania wierszy ze zbioru

            } // Jezeli zostaly zwrocone wiersze
            print("</tbody>
                      </table>");

            print("<button class='btn' id='toggleFormBtn'>Dodaj pracownika</button>");
            print("
         <div class='login-box' style='display: none;'>
    <h2>Pracownik</h2>
    <form id='frmPracownikDodaj' action='pracownik_dodaj.php' method='get' >
      <div class='user-box'>
       <input name='IdPracownik' type='text' id='IdPracownik' maxlength='10' pattern='[0-9]+' required placeholder=' '>
        <label for='IdPracownik'>Identyfikator*</label>
      </div>
      <div class='user-box'>
        <input id='Imie' name='Imie' type='text' maxlength='40' required placeholder=' ' >
        <label for='Imie'>Imię*</label>
      </div>
      <div class='user-box'>
        <input id='Nazwisko' name='Nazwisko' type='text' maxlength='40' required placeholder=' '>
        <label for='Nazwisko'>Nazwisko*</label>
      </div>
      <div class='user-box'>
       <input id='NrTelefonu' name='NrTelefonu' type='text' maxlength='20' 
              pattern= '\+\d{2}\s\d{2}\s\d{4}\s\d{3}|\+\d{2}\s\d{3}\s\d{3}\s\d{3}' required placeholder=' '>
        <label for='NrTelefonu'>Numer Telefonu*</label>
      </div>
      <div class='user-box'>
         <input id='Stanowisko' name='Stanowisko' type='text' maxlength='20' pattern='a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-\.' required placeholder=' '>
         <label for='Stanowisko'>Stanowisko*</label>
      </div>
      
      <div class='buttons'>
         <input class='btn' type='submit' value='Zapisz'>
         <input class='btn resetForm' type='reset' value='Reset'>
      </div>
    </form>
  </div>
  
        ");
            // koniec bloku try {...}
          }  catch (Exception $e) {
              print("<p class='msg error'>Podczas przetwarzania danych wystąpił błąd<br/>
              Szczegóły: ".$e->getMessage()."</p>");
          } finally {
            // Jawne zniszczenie obiektu połączenia klasy PDO.
              $polaczenie = null;
          }
        } // Jeżeli połaczenie zostało nawiązane.
      }
      ?>


    </div>

  <?php
  require_once("footerAndJSLinks.php");
  ?>

  </body>
</html>