<?php
/**
 * Hier werden sämtlichen Datenbankeingaben gescrieben.
 * @author Sven Haberzettl <von.ultimo@gmail.com>
 * @author Jan Nemeth <jan.nemeth@web.de>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * */

include_once "lib.php";
include_once "db_request.php";

function addBuchung($zweck, $betrag, $von, $zu, $logid, $anmerkung)
    /*
     *
     */
{
    $bnr = getEntrys("buchung") + 1;
    $kontostandVon=getIt("user", "id",$von, "kontostand");
    $kontostandZu=getIt("user", "id",$zu, "kontostand");
    $database = connect();
    $buchung= "INSERT INTO buchung (buchungsnummer, zwecknummer, datum, betrag, user_von, user_zu, log, anmerkung) 
            VALUES ('$bnr', '$zweck', NOW(), '$betrag', '$von', '$zu', '$logid', '$anmerkung');";
    $abgang= "UPDATE user SET kontostand = $kontostandVon-$betrag WHERE id=$von;";
    $zugang= "UPDATE user SET kontostand = $kontostandZu+$betrag WHERE id=$zu";
    $database->query($abgang);
    $database->query($zugang);
    $database->query($buchung);
    $database->close();

}

function correctBuchung($zweck, $betrag, $von, $zu, $logid, $anmerkung)
    /*
     * --NICHT FERTIG--
     * @todo Buchung auf Nutzerkonten / vorher abziehen!
     */
{
    $bnr = getEntrys("buchung");
    $kontostandVon=getIt("user", "id",$von, "kontostand");
    $kontostandZu=getIt("user", "id",$zu, "kontostand");
    $alterBetrag=getIt("buchung", "buchungsnummer",$bnr, "betrag");
    $database = connect();
    //alte Buchung rückgängig machen
    $revAbgang= "UPDATE user SET kontostand = $kontostandVon+$alterBetrag WHERE id=$von;";
    $revZugang= "UPDATE user SET kontostand = $kontostandZu-$alterBetrag WHERE id=$zu";
    $database->query($revAbgang);
    $database->query($revZugang);
    $buchung= "UPDATE buchung SET buchungsnummer = $bnr, zwecknummer = $zweck, datum = NOW(), betrag = $betrag, user_von = $von, user_zu = $zu, log = $logid, anmerkung = '$anmerkung';";
    //neue Buchung auf Kontostand schreiben
    $abgang= "UPDATE user SET kontostand = $kontostandVon-$betrag WHERE id=$von;";
    $zugang= "UPDATE user SET kontostand = $kontostandZu+$betrag WHERE id=$zu";
    $database->query($abgang);
    $database->query($zugang);
    $database->query($buchung);
    $database->close();

}

function addVerwendungszweck($beschreibung)
    /*
     * Fügt einen neuen Eintrag mit der übergebenen Beschreibung in die Tabelle verwendungszweck ein.
     */
{
    $database = connect();
    $id = getEntrys('verwendungszweck') + 1;
    $sql = "INSERT INTO `verwendungszweck` (`Beschreibung`, `zwecknummer`) VALUES ('$beschreibung',$id);";
    $database->query($sql);
    $database->close();
}

function addUser($vorname, $nachname, $email, $passwort, $verein, $usrgrp, $hausbewohner)
{
    /**
     * Fügt einen Nutzer mit den übergebenen Parametern in die Tabelle user ein.
     */
    $pw_hash=password_hash($passwort, PASSWORD_DEFAULT);
    $database = connect();
    $id = getEntrys('user') + 1;
    $sql = "INSERT INTO user (id, vorname, nachname, email, kontostand, zinsen, passwort, verein, gruppe, hausbewohner) 
            VALUES  ('$id', '$vorname', '$nachname', '$email', '0', '0', '$pw_hash', '$verein', '$usrgrp', '$hausbewohner');";
    $database->query($sql);
    $database->close();

}

function addPurpose($purpose){
    /*
     */
    $database = connect();
    $id = getEntrys('verwendungszweck') + 1;
    $sql="INSERT INTO verwendungszweck VALUES ('$id', '$purpose');";
    $database->query($sql);
    $database->close();
}

function addClub($club){
    /*
     */
    $database = connect();
    $id = getEntrys('verein') + 1;
    $sql="INSERT INTO verein VALUES ('$id', '$club');";
    $database->query($sql);
    $database->close();
}

function getUserUpdate($user){
    /*
     */
    $database = connect();
    $sql = "SELECT * FROM user WHERE id=$user;";
    $result = $database->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo
                "<label for='vorname'>Vorname</label><input name='vorname' type='text' value='" . $row["vorname"] . "'>\n".
                "<label for='nachname'>Nachname</label><input name='nachname' type='text' value='" . $row["nachname"] . "'>\n".
                "<label for='email'>E-Mail-Adresse</label><input name='email' type='email' value='" . $row["email"] . "'>\n".
                "<label for='zinsen'>Zinsbefreit?</label><select name='zinsen'><option value='0'>Nein</option><option value='1'>Ja</option></select>\n".
                "<label for='hausbewohner'>Hausbewohner?</label><select name='hausbewohner'><option value='0'>Nein</option><option value='1'>Ja</option></select>\n".
                "<label for='passwort'>Passwort</label><input name='passwort' type='password'>\n".
                "<label for='passwort2'>Passwort wiederholen</label><input name='passwort2' type='password'>\n".
                "<label for='verein'>Verein</label>"."<select name='verein'>".getVereinOption($row["verein"])."</select>\n".
                "<label for='gruppe'>Gruppe</label>"."<select name='gruppe'>".getGruppeOption($row["gruppe"] )."</select>\n"
            ;
        }
    $database->close();
}

function getCorrectBooking(){
    /*
     */
    $database = connect();
    $bnr=getEntrys('buchung');
    $sql = "SELECT * FROM buchung WHERE buchungsnummer=$bnr;";
    $result = $database->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo
            "<label for='zwecknummer'>Verwendungszweck</label>"."<select name='zwecknummer'>".getVerwendungszweckOptionS($row["zwecknummer"])."</select>\n".
            "<label for='betrag'>Betrag</label><input name='betrag' type='text' value='" . $row["betrag"] . "'>\n".
            "<label for='userFrom'>Abgehendes Konto</label><select name='userFrom'>".getUserOptionS($row["user_von"])."</select>\n".
            "<label for='userTo'>Zugehendes Konto</label><select name='userTo'>".getUserOptionS($row["user_zu"])."</select>\n".
            "<label for='comment'>Anmerkung</label><input name='comment' value='".$row["anmerkung"]."'>\n"
        ;
    }
    $database->close();

}

function updateUser($id, $vorname, $nachname, $email, $zinsen, $hausbewohner, $passwort, $verein, $gruppe){
    /*
     */
    if($passwort!=""){
        $pwHash=password_hash($passwort, 1);
        $sql="UPDATE user SET vorname='$vorname', nachname='$nachname', email='$email', zinsen='$zinsen', verein='$verein', gruppe='$gruppe', hausbewohner='$hausbewohner', passwort='$pwHash' WHERE id='$id';";
    }else{
        $sql="UPDATE user SET vorname='$vorname', nachname='$nachname', email='$email', zinsen='$zinsen', verein='$verein', gruppe='$gruppe', hausbewohner='$hausbewohner' WHERE id='$id';";
    }
    $database = connect();
    $database->query($sql);
    $database->close();
}