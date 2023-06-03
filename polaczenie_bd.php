<?php

        $serwer = "PC_SZYMON_HUBER\SQL1";
        $baza_danych = "B17_P4";

        try {
            $polaczenie = new PDO("sqlsrv:server=$serwer;Database=$baza_danych");
            // Ustawienie trybu obsugi wyjątków.
            $polaczenie->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Ustawienie kodowania znaków w polach tekstowych (UTF-8).
            $polaczenie->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
        } catch (Exception $e) {
            print("<p class='msg error'>Nie można połączyć się z bazą danych - $serwer. <br/>
            Szczegóły błędu: ".$e->getMessage()."</p>");

            die(print_r($e, true));
        }
?>

