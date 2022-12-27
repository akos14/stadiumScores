<?php
    session_start();
    function compareDate( $a, $b ) {
        if((strtotime($b["date"]) - strtotime($a["date"])) === 0){
            return -1;
        }
        return strtotime($b["date"]) - strtotime($a["date"]);
    }

    $error = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $matches = json_decode(file_get_contents('matches.json'), true);
        $teams = json_decode(file_get_contents('teams.json'), true);
        $comms = json_decode(file_get_contents('comments.json'), true);
        $users = json_decode(file_get_contents('users.json'), true);
        $teammatches = [];
        if(isset($teams[$id])){
            $team = $teams[$id];
            if(count($_POST) > 0){
                $notes = $_POST['notes'] ?? "";
        
                if(trim($notes) === ''){
                    $error = "Üres hozzászólás nem küldhető be!";
                } else {
                    $comment = [
                        "author" => $_SESSION['userid'],
                        "id" => uniqid(),
                        "text" => $notes,
                        "teamid" => $team['id'],
                        "date" => gmdate("Y-m-d H:i:s", strtotime('+ 1 hours'))
                    ];
                    $comms[$comment['id']] = $comment;
                    file_put_contents('comments.json', json_encode($comms, JSON_PRETTY_PRINT));
                }       
            }
            foreach($matches as $match) {
                if(strcmp($match['home']['id'], $id) === 0 || strcmp($match['away']['id'], $id) === 0){
                    array_push($teammatches, $match);
                }
            }
            $comments = array_filter($comms, fn($c) => strcmp($c['teamid'], $id) === 0);
            usort($comments, 'compareDate');
        } else {
            header('location: index.php');
        }
    } else {
        header('location: index.php');
    }

    function matchColor($teamid, $match){
        if(strcmp($match['home']['score'], "") === 0 || strcmp($match['away']['score'], "") === 0){
            return "";
        }
        if($match['home']['score'] > $match['away']['score']){
            $winner = $match['home']['id'];
        } else if($match['home']['score'] < $match['away']['score']){
            $winner = $match['away']['id'];
        } else {
            $winner = NULL;
        }
        if($winner !== NULL && strcmp($teamid, $winner) === 0){
            return "green";
        } else if ($winner !== NULL){
            return "red";
        } else {
            return "orange";
        }
    }

    function result($color){
        if(strcmp($color, "green") === 0){
            return "GY";
        } else if(strcmp($color, "red") === 0){
            return "V";
        } else if(strcmp($color, "orange") === 0){
            return "D";
        } else {
            return "";
        }

    }

    $loggedin = (isset($_SESSION['userid']));
    $isAdmin = $loggedin && $users[$_SESSION['userid']]['isAdmin'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Csapatrészletek - <?= $team['name'] ?></title>
</head>
<body>
    <a href="index.php">Főoldal</a>
    <h1><?= $team['name'] ?> - Csapatrészletek</h1>
    <h2>Adatok</h2>
    <p>Név: <?= $team['name'] ?></p>
    <p>Város: <?= $team['city'] ?></p>
    <h2>Meccsek</h2>
    <table>
    <?php foreach($teammatches as $m): ?>
        <tr>
            <td><?= $teams[$m['home']['id']]['name'] ?> - <?= $teams[$m['away']['id']]['name'] ?></td>
            <td><?= $m['date'] ?></td>
        </tr>
        <tr>
            <?php $color = matchColor($team['id'], $m) ?>
            <?php if(isset($m['home']['score']) && isset($m['away']['score'])): ?>
                <td style="text-align: center; color: <?= $color ?>"><?= $m['home']['score'] ?> - <?= $m['away']['score'] ?></td>
                <td style="text-align: center; color: <?= $color ?>"><?= result($color) ?></td>
                <?php if($isAdmin): ?>
                    <td><a href="modify.php?id=<?= $m['id'] ?>&teamid=<?=$team['id']?>">Módosítás</a></td>
                <?php endif; ?>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </table>
    <h2 id="v">Hozzászólások</h2>
    <?php if(!$loggedin): ?>
        <p>Új hozzászólás írásához be kell jelentkezned!</p>
        <a href="login.php"><button id="detailsbutton">Bejelentkezés</button></a>
        <a href="register.php"><button id="detailsbutton">Regisztráció</button></a>
    <?php else: ?>
        <h3>Új hozzászólás:</h3>
        <span style="color: red"><?= $error ?></span>
        <form action="details.php?id=<?= $team['id'] ?>#v" method="post" novalidate>
            <textarea name="notes" placeholder="Írd le a véleményed..."></textarea><br>
            <button type="submit" id="detailssendbutton">Küldés</button>
        </form>
    <?php endif; ?>    
    <table id="comments">
        <?php foreach($comments as $c): ?>
            <tr>
                <td><?= $users[$c['author']]['username'] ?></td>
                <td></td>
                <td style="text-align: right"><?= substr($c['date'], 0, strlen($c['date']) - 3) ?></td>                
            </tr>
            <tr>
                <td></td>
                <td><?= $c['text'] ?></td>
                <td></td>
                <?php if($isAdmin): ?>
                    <td><a href="delete.php?id=<?= $c['id'] ?>&teamid=<?= $team['id'] ?>">Törlés</a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>