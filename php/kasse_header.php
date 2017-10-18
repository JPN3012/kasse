<?php
/**
 * @author Sven Haberzettl <von.ultimo@gmail.com>
 * @author Jan Nemeth <jpnemeth3012@gmail.com>
 * Version: 0.1
 */
function kasse_header()
{
    echo "
    <div class=\"container\">
    <header>
        <img class=\"header-img\" src=\"/kasse/pics/logo.png\"><br/>
        <div>";
            if ($_SESSION['usergroup'] < 5) {echo "
            <div class=\"dropdown\">
                <button class=\"button-primary\">Ausgaben</button>
                <div class=\"dropdown-content\">";
                    if ($_SESSION['usergroup'] < 5) {echo "<a href='get_booking.php'>Buchung anzeigen</a>";}
                    if ($_SESSION['usergroup'] < 5) {echo "<a href=\"get_konto.php\">Kontostand anzeigen</a>";}
                echo "</div>
            </div>";}
            if ($_SESSION['usergroup'] < 3) {echo "
            <div class=\"dropdown\">
                <button class=\"button-primary\">Eingaben</button>
                <div class=\"dropdown-content\">";
                    if ($_SESSION['usergroup'] < 3) {echo "<a href=\"add_booking.php\">Buchung anlegen</a>";}
                    if ($_SESSION['usergroup'] < 3) {echo "<a href=\"correctBooking.php\">letzte Buchung korrigieren unfertig</a>";}
                echo"</div>
            </div> ";}
            if ($_SESSION['usergroup'] < 3) {echo "
            <div class=\"dropdown\">
                <button class=\"button-primary\">Nutzerverwaltung</button>
                <div class=\"dropdown-content\">";
                    if ($_SESSION['usergroup'] < 3) {echo "<a href=\"memberlist.php\">Mitgliederliste anzeigen</a>";}
                    if ($_SESSION['usergroup'] < 3) {echo "<a href=\"addUser.php\">Nutzer hinzufügen</a>";}
                    if ($_SESSION['usergroup'] < 3) {echo "<a href=\"updateUser.php\">Nutzer aktualisieren</a>";}
                echo"</div>
            </div>";}
            if ($_SESSION['usergroup'] < 3) {echo "
            <div class=\"dropdown\">
                <button class=\"button-primary\">Datenbankverwaltung</button>
                <div class=\"dropdown-content\">";
                    if ($_SESSION['usergroup'] < 5) {echo "<a href=\"addPurpose.php\">Verwendungszweck hinzufügen</a>";}
                    if ($_SESSION['usergroup'] < 5) {echo "<a href=\"addClub.php\">Verein hinzufügen</a>";}
                    if ($_SESSION['usergroup'] < 5) {echo "<a href=\"#\">Buchung löschen unfertig</a>";}
                    echo"</div>
                </div>";}
            if ($_SESSION['usergroup'] < 100) {echo "
            <div class=\"dropdown\">
                <a href=\"/kasse/php/logout.php\"><button class=\"button-primary\" id=\"logout\"><strong>Logout</strong></button></a>
            </div>";}
echo"            
        </div>
    </header>
</div>";}
