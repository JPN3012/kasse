<?php
/**
 * @author Sven Haberzettl <von.ultimo@gmail.com>
 * @author Jan Nemeth <jpnemeth3012@gmail.com>
 * Version: 0.1
 */
session_start();
if ($_SESSION["usergroup"] != 1) {
    die('<meta http-equiv="refresh" content="0;URL=/kasse/index.php">');
}
require_once "../db_abfragen.php";
$user = getUser($_SESSION["userid"]);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Kasse für <?php echo $user; ?></title>
    <script src="/kasse/js/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="/kasse/css/skeleton.css">
    <link rel="stylesheet" href="/kasse/css/custom.css">
    <script src="/kasse/js/lib.js"></script>
</head>
<body>
<div class="container">
    <header>
        <img class="header-img" src="/kasse/pics/logo.png"><br/>
        <ul class="dropdown">
            <li>
                <button class="dropdown-buttom">Abfragen</button>
                <ul class="dropdown-content">
                    <li><a href="#">Nutzerliste</a></li>
                    <li><a href="#">Nutzerliste</a></li>
                    <li><a href="#">Nutzerliste</a></li>
                    <li><a href="#">Nutzerliste</a></li>
                </ul>
            </li>
            <li>
                <button class="button-primary">Auswertungen</button>
            </li>
            <li>
                <button class="button-primary">Eingaben</button>
            </li>
            <li>
                <button class="button-primary">Nutzerverwaltung</button>
                <ul class="dropdown-content">
                    <li><a href="#">Nutzerliste</a></li>
                    <li><a href="#">Nutzerliste</a></li>
                    <li><a href="#">Nutzerliste</a></li>
                    <li><a href="#">Nutzerliste</a></li>
                </ul>
            </li>
            <li>
                <button class="button-primary" id="logout"><strong>Logout</strong></button>
            </li>
        </ul>
    </header>
    <br/>
    <h4>Hallo <?php echo $user; ?>, dein Kontostand bertägt:
        <strong><?php echo getKontostand($_SESSION["userid"]); ?></strong></h4>
    <div class="container" id="Ausgabe">
        <button class="button-primary">Das ist ein Knopf!</button>
        Hier kommt die Ausgabe hin.
        <br/>
        <?php getUserTable(); ?>
        <br/>
        <?php getBuchung("30", "2", "2"); ?>
    </div>

</div>

</body>
</html>
