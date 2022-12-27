<?php
    session_start();
    $matches = json_decode(file_get_contents('matches.json'), true);
    $teams = json_decode(file_get_contents('teams.json'), true);

    $played = array_filter($matches, fn($m) => strcmp($m['home']['score'], "") !== 0 && strcmp($m['away']['score'], "") !== 0);
    
    function compareDate( $a, $b ) {
        if((strtotime($b["date"]) - strtotime($a["date"])) === 0){
            return -1;
        }
        return strtotime($b["date"]) - strtotime($a["date"]);
    }
    usort($played, 'compareDate');
    $played = array_slice($played, 0, 5, true);

    $loggedin = (isset($_SESSION['userid']));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Főoldal - Eötvös Loránd Stadion</title>
</head>

<body>
    <h1>Eötvös Lóránd Stadion - Főoldal </h1>
    <?php if(!$loggedin): ?>
        <a href="register.php"><button id="indexbutton">Regisztráció</button></a>
        <a href="login.php"><button id="indexbutton">Bejelentkezés</button></a>
    <?php else: ?>
        <a href="logout.php"><button id="indexbutton">Kijelentkezés</button></a>
    <?php endif; ?>
    <p>Az Eötvös Loránd Stadion végre megjelent az interneten is! A weboldalon megtalálod 
        a nálunk játszott meccseket, követni tudod a csapatok eredményeit és kommentelhetsz az oldalukra.</p>
    <h2>Csapatok</h2>
    <?php foreach($teams as $t): ?>
        <li>
            <a href="details.php?id=<?=$t['id'] ?>"><?= $t['name'] ?></a>
        </li>
    <?php endforeach; ?>
    <h2>Legutóbbi 5 meccs</h2>
    <table>
    <?php foreach($played as $m): ?>
        <tr>
            <td><?= $teams[$m['home']['id']]['name'] ?> - <?= $teams[$m['away']['id']]['name'] ?></td>
            <td><?= $m['date'] ?></td>
        </tr>
        <tr>
            <td style="text-align: center"><?= $m['home']['score'] ?> - <?= $m['away']['score'] ?></td>
            <td></td>
        </tr>
    <?php endforeach; ?>
    </table>
</body>

</html>