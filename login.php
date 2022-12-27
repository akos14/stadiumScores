<?php
    session_start();

    $un = $_POST['un'] ?? '';
    $pw = $_POST['pw'] ?? '';

    if(count($_POST) > 0){

        $errors = [];

        $users = json_decode(file_get_contents('users.json'), true);
        $user = array_keys(array_filter($users, fn($u) => $u['username'] == $un));
        $id = $user[0] ?? null;

        if(trim($un) === ''){
            $errors['un'] = "Felhasználónév megadása kötelező!";
            $pw = '';
        }
        if(trim($pw) === ''){
            $errors['pw'] = "Jelszó megadása kötelező!";
        }
        else if($id !== null){
            if(password_verify($pw, $users[$id]['password'])){
                $_SESSION['userid'] = $id;
                header('Location: index.php');
            }                
            else
                $errors['pw'] = "Helytelen jelszó!";
        } else 
            $errors['un'] = "Nem létező felhasználó!";
        
        if(count($errors) > 0) {
            $errors = array_map(fn($e) => "<span style='color:red'>$e</span>", $errors);
            $pw = '';
        }
    }
    else if(isset($_SESSION['userid'])) {
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
    <title>Bejelentkezés - Eötvös Loránd Stadion</title>
</head>
<body>
    <a href="index.php">Főoldal</a>
    <h1>Eötvös Lóránd Stadion - Bejelentkezés</h1>
    <form method= "post" action="login.php" novalidate>
        Felhasználónév: <input type="text" name="un" value="<?= $un ?>"> <?= $errors['un'] ?? '' ?><br>
        Jelszó: <input type="password" name="pw"> <?= $errors['pw'] ?? '' ?><br>
        <button id="loginbutton" type="submit">Bejelentkezés</button>
    </form>
    <a href="register.php"><button>Regisztráció</button></a>
</body>
</html>