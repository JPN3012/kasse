<!DOCTYPE html>
<html lang="de">
<head>
    <?php
    include "php/db_abfragen.php";
    include "php/db_eingaben.php";
    include "php/auswertungen.php";
    ?>
    <meta charset="UTF-8">
    <title>Kasse</title>
    <link rel="stylesheet" href="css/skeleton.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/lib.js"></script>
</head>
<body>


<script>
    $(document).ready(function () {


        $("input").click(function () {
            $(this).fadeOut(1200);
            $(this).fadeIn(1500);
        });

    })
</script>

<div class="container">
    <h3 class="title">Herzlich willkommen!</h3>

    <div class="offset-by-one">

        <p>
            Der Kontostand von <?php echo getUser(2); ?> beträgt: <?php echo getKontostand(2); ?>.
            <br/>
            Anmelden du dich musst!<br/>
            <?php echo getUserGroup(12) ?>
        </p>
        <?php getBuchungVon(10, 1) ?>
        <?php echo getEntrys("user") ?>
        <?php echo addVerwendungszweck("test") ?>
        <?php getRechnung(1)?>
    </div>
</body>
</html>