<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="serwisy, internetowe, programowanie">
    <meta name="description" content="Strona utworzona w ramach listy C3.">
    <meta name="author" content="Szymon Grzesiak">
    <meta name="viewport" content="width=device-width">
    <title>Programowanie serwisów internetowych – lista C7.</title>
    <link rel="stylesheet" href="styles/app.css">
    <link rel="stylesheet" href="styles/basicStyles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Bitter:wght@300;400;500;700&family=Mukta:wght@300;400;500;700&family=Nunito:wght@200&family=Rubik:wght@300;400;500;700&display=swap"
      rel="stylesheet"
    >
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'  type="text/css" rel='stylesheet'>

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


    <div class="sidebar">
      <div class="hamburger">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
      </div>
      <div class="user">
            <div id="img"></div>
            <p class="bold">Jasberry</p>
            <p>Admin</p>
      </div>
      <ul>
        <li>
          <a href="#">
            <i class="bx bxs-grid-alt"></i>
            <span class="nav-item">Dashboard</span>
            <span class="tooltip">Dashboard</span>
          </a>

        </li>
        <li>
          <a href="#">
            <i class="bx bxs-shopping-bag"></i>
            <span class="nav-item">Products</span>
            <span class="tooltip">Products</span>

          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-list-check"></i>
            <span class="nav-item">Categories</span>
            <span class="tooltip">Categories</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bxs-food-menu"></i>
            <span class="nav-item">Orders</span>
            <span class="tooltip">Orders</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-body"></i>
            <span class="nav-item">Customers</span>
            <span class="tooltip">Customers</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-location-plus"></i>
            <span class="nav-item">Shipping</span>
            <span class="tooltip">Shipping</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-cog"></i>
            <span class="nav-item">Settings</span>
            <span class="tooltip">Settings</span>
          </a>
        </li>
      </ul>
    </div>


    <div class="container">
      <h1>Welcome to the Delivery Parcel Site</h1>
      <div class="content">
      <div class="pack">
        <span class="registerSpan">Rejestracja</span>
        <form id="formRegister" action="tabela.php" method="get">

          <fieldset>
            <legend>Dane Osobowe</legend>
            <div class="labelInputBox">
              <label for="wiersze">Liczba wierszy*</label>
              <input
                class="inputs"
                name="wiersze"
                type="text"
                id="wiersze"
                maxlength="4"
              >
            </div>
            <div class="labelInputBox">
              <label for="kolumny">Liczba kolumn*</label>
              <input
                class="inputs"
                id="kolumny"
                name="kolumny"
                type="text"
                maxlength="4"
              >
            </div>
            <div class="labelInputBox">
              <label for="zakresOd">Zakres liczb od*</label>
              <input
                class="inputs"
                id="zakresOd"
                name="zakresOd"
                type="text"
                maxlength="10"
              >

            </div>
            <div class="labelInputBox">
              <label for="zakresDo">Zakres liczb do*</label>
              <input
                class="inputs"
                id="zakresDo"
                name="zakresDo"
                type="text"
                maxlength="10"
              >
            </div>
            <div class="labelInputBox">
              <label for="liczbaSzukana">Liczba szukana*</label>
              <input
                class="inputs"
                id="liczbaSzukana"
                name="liczbaSzukana"
                type="text"
                maxlength="10"
              >
            </div>
            <div class="labelInputBox">
            <label for="cbxZaznaczaj">Zaznaczaj szukane liczby</label>
              <input
                id="cbxZaznaczaj"
                name="cbxZaznaczaj"
                type="checkbox"
              >
            </div>
          </fieldset>

          <fieldset>
            <legend>Podsumowania liczb</legend>
            <div class="cbxStyle">
                <label for="brak"><input class="radio"  type="radio" id="brak" name="rbtDosw" value="brak" checked>Brak</label>
                <label for="wierszeCbx"><input class="radio" type="radio" id="wierszeCbx" name="rbtDosw" value="wierszeCbx">Wiersze</label>
                <label for="kolumnyCbx"> <input class="radio" type="radio" id="kolumnyCbx" name="rbtDosw" value="kolumnyCbx">Kolumny</label>
                <label for="wierszeIKolumny"> <input class="radio" type="radio" id="wierszeIKolumny" name="rbtDosw" value="wierszeIKolumny">Wiersze i Kolumny</label>
             </div>
          </fieldset>


          <div class="buttons">
            <input class="btn" type="submit" value="Generuj tabelę">
            <input class="btn" type="reset" value="Reset">
          </div>
        </form>
      </div>
      </div>

    </div>
    <footer>
      <div>
        <ul>
          <li><a href="#polityka">Polityka Firmy</a></li>
          <li><a href="#Zwroty">Zwroty</a></li>
          <li><a href="#oFirmie">O Firmie</a></li>
          <li><a href="#kontakt">Kontakt</a></li>
          <li><a href="#info">Info</a></li>
        </ul>
      </div>
    </footer>
  <script type="text/javascript" src="/index.js"></script>
  </body>
</html>