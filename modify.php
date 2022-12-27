<?php
    session_start();

    $users = json_decode(file_get_contents('users.json'), true);

    function compareDate( $a, $b ) {
        return strtotime($b) - strtotime($a);
    }

    if(count($_GET) > 0 && isset($_GET['id']) && isset($_GET['teamid']) && $users[$_SESSION['userid']]['isAdmin']){
        $matches = json_decode(file_get_contents('matches.json'), true);
        $teampageid = $_GET['teamid'];
        if(isset($matches[$_GET['id']])){
            $match = $matches[$_GET['id']];
            $teams = json_decode(file_get_contents('teams.json'), true);
            $home_score = $match['home']['score'];
            $away_score = $match['away']['score'];
            $date = $match['date'];
            if(count($_POST) > 0) {
                $home_score = $_POST['home_score'] ?? '';
                $away_score = $_POST['away_score'] ?? '';
                $date = $_POST['date'] ?? '';
                
                $errors = [];

                if((trim($home_score) === '' && trim($away_score) !== '') || (trim($home_score) !== '' && trim($away_score) === ''))
                    $errors['score'] = "Hibás eredmény megadás!";
                else if(!($home_score === '' || $away_score === '') && (filter_var($home_score, FILTER_VALIDATE_INT) === false || filter_var($away_score, FILTER_VALIDATE_INT) === false))
                    $errors['score'] = "Gólszám csak szám lehet!";
                else if(!($home_score === '' || $away_score === '') && ($home_score < 0 || $away_score < 0))
                    $errors['score'] = "Gólszám nem lehet negatív!";

                if(trim($date) === '')
                    $errors['date'] = "Dátum megadása kötelező!";
                else if(trim($home_score) !== '' && trim($away_score) !== '' && compareDate($date, date("Y-m-d")) < 0)
                    $errors['date'] = "Eredménnyel rendelkező meccs nem lehet mai dátumnál később!";                    

                if(count($errors) > 0) {
                    $errors = array_map(fn($e) => "<span style='color:red'>$e</span>", $errors);
                } else {
                    $newMatch = [
                        "id" => $match['id'],
                        "home" => [
                            "id" => $match['home']['id'],
                            "score" => $home_score
                        ],
                        "away" => [
                            "id" => $match['away']['id'],
                            "score" => $away_score
                        ],
                        "date" => $date
                    ];
                    $matches[$match['id']] = $newMatch;
                    file_put_contents('matches.json', json_encode($matches, JSON_PRETTY_PRINT));
                    header("Location: details.php?id=$teampageid");
                }
            }
        } else {
            header('Location: index.php');
        }
    } else {
        header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Meccs szerkesztés</title>
</head>
<body>
    <a href="index.php">Főoldal</a>
    <h1>Meccs adatainak módosítása</h1>
    <h2><?= $teams[$match['home']['id']]['name'] ?> - <?= $teams[$match['away']['id']]['name'] ?></h2>
    <form action="modify.php?id=<?= $match['id'] ?>&teamid=<?= $teampageid ?>" method="post" novalidate>
        <label for="score">Hazai gólszám: <input type="number" name="home_score" value="<?= $home_score ?>"><br>
        Vendég gólszám: <input type="number" name="away_score" value="<?= $away_score ?>"> <?= $errors['score'] ?? "" ?> </label><br>
        <label for="date">Dátum: <input type="date" name="date" value="<?= $date ?>"> <?= $errors['date'] ?? "" ?></label><br>
        <button id="modify" type="submit">Módosítás</button>
    </form>
    <a href="details.php?id=<?=$teampageid?>"><button>Mégsem</button></a>
</body>
</html>