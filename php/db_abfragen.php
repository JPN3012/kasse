<?php
/**
 * Hier werden sämtlichen Datenbankabfragen gescrieben.
 * @author Sven Haberzettl <von.ultimo@gmail.com>
 * @author Jan Nemeth <jan.nemeth@web.de>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * */

include "lib.php";

function getEntrys(){
    /*
     * Gibt die Anzahl der Einträge für die übergebene Tabelle zurück
     * __NICHT FERTIG__
     */
}

function getUserTable()
    /**
     * gibt alle Nuter mit <td>Tags aus.
     */
{
    $database = connect();
    $sql = 'SELECT * FROM user;';
    $result = $database->query($sql);
    echo "
    <table>
    <tr>
        <th>id</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>E-Mail</th>  
        <th>Kontostand</th>
        <th>Zinsbefreit</th>
    </tr>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>" .
                "<td>" . $row["id"] . "</td>" .
                "<td>" . $row["vorname"] . "</td>" .
                "<td>" . $row["nachname"] . "</td>" .
                "<td>" . $row["email"] . "</td>" .
                "<td>" . $row["kontostand"] . " €" . "</td>" .
                "<td>" . boolZuText($row["zinsen"]) . "</td>" .
                "</tr>";
        }
    } else {
        echo "Keine Inhalte";
    }
    echo "</table>";
    $database->close();
}

function getBuchungVon($anzahl, $von)
    /**
     * gibt die $anzahl lentzten Buchungen von $von mit <td>Tags aus.
     */
{
    $database = connect();
    $sql = "SELECT * FROM buchung WHERE user_von=$von ORDER BY datum DESC LIMIT $anzahl;";
    $result = $database->query($sql);
    echo "
    <table>
    <tr>
        <th>Buchungsnummer</th>
        <th>Bebucht von</th>
        <th>Gebucht an</th>
        <th>Betrag</th>  
        <th>Gebucht am</th>
        <th>Verwendungszweck</th>
    </tr>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>" .
                "<td>" . $row["buchungsnummer"] . "</td>" .
                "<td>" . getUser($row["user_von"]) . "</td>" .
                "<td>" . getUser($row["user_zu"]) . "</td>" .
                "<td>" . $row["betrag"] . " €" . "</td>" .
                "<td>" . $row["datum"] . "</td>" .
                "<td>" . getVerwendungszweck($row["zwecknummer"]) . "</td>" .
                "</tr>";
        }
    } else {
        echo "Keine Inhalte";
    }
    echo "</table>";
    $database->close();
}

function getVerwendungszweck($zwecknummer)
    /*
       * gibt den Namen des Verwendungszweckes mit der übergebenen zwecknummer zurück.
      */
{
    $database = connect();
    $sql = "SELECT * FROM verwendungszweck WHERE zwecknummer=$zwecknummer;";
    $result = $database->query($sql);
    $row = $result->fetch_assoc();
    $out = $row["Beschreibung"];
    $database->close();
    return $out;
}

function getKontostand($user)
    /*
      * gibt den Kontostand des Nutzers mit der übergebenen id zurück.
     */
{
    $database = connect();
    $sql = "SELECT kontostand FROM user WHERE id=$user;";
    $result = $database->query($sql);
    $row = $result->fetch_assoc();
    $out = $row["kontostand"];
    $database->close();
    return $out . " €";
}

function getUserGroup($gid)
    /*
      * gibt die Grupper zu der übergebenen gid zurück.
     */
{
    $database = connect();
    $sql = "SELECT * FROM usergroup WHERE gid=$gid;";
    $result = $database->query($sql);
    $row = $result->fetch_assoc();
    $out = $row["gname"];
    $database->close();
    if ($out != null) {
        return $out;
    }
    return "Diese Gruppe existiert nicht!";
}

function getUser($user)
    /*
      * gibt den Namen des Nutzers mit der übergebenen id zurück.
     */
{
    $database = connect();
    $sql = "SELECT * FROM user WHERE id=$user;";
    $result = $database->query($sql);
    $row = $result->fetch_assoc();
    $out = $row["vorname"] . " " . $row["nachname"];
    $database->close();
    if ($out != " ") {
        return $out;
    }
    return "Diesr Nutzer existiert nicht!";
}