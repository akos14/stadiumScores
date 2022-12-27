<?php
    session_start();
    $un = $_POST['un'] ?? '';
    $em = $_POST['em'] ?? '';
    $pw = $_POST['pw'] ?? '';
    $pw2 = $_POST['pw2'] ?? '';
    if(count($_POST) > 0){
        $errors = [];
        $users = json_decode(file_get_contents('users.json'), true);
        $user = array_keys(array_filter($users, fn($u) => $u['username'] == $un));
        $id = $user[0] ?? null;
        
        if(trim($un) === '')
            $errors['un'] = "Felhasználónév megadása kötelező!";
        else if($id !== null)
            $errors['un'] = "A felhasználónév már foglalt!";
        
        if(trim($em) === '')
            $errors['em'] = "E-mail cím megadása kötelező!";
        else if(!filter_var($em, FILTER_VALIDATE_EMAIL))
            $errors['em'] = "E-mail cím nem valid!";
        
        if(trim($pw) === '')
            $errors['pw'] = "Jelszó megadása kötelező!";
        else if(trim($pw2) === '')
            $errors['pw2'] = "Jelszó kétszeres megadása kötelező!";
        else if(strcmp($pw, $pw2))
            $errors['pw'] = "A két jelszó nem egyezik!";

        if(count($errors) > 0) {
            $errors = array_map(fn($e) => "<span style='color:red'>$e</span>", $errors);
            $pw = '';
            $pw2 = '';
        } else {
            $user = [
                "username" => $un,
                "email" => $em,
                "password" => password_hash($pw, PASSWORD_DEFAULT),
                "isAdmin" => false,
                "id" => uniqid()
            ];
            $users[$user['id']] = $user;
            file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));
            header('Location: login.php');
        }
     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Regisztráció</title>
</head>
<body>
    <a href="index.php">Főoldal</a>
    <h1>Eötvös Lóránd Stadion - Regisztráció</h1>
    <form method="post" action="register.php" novalidate>
        Felhasználónév: <input type="text" name="un" value="<?= $un ?>"> <?= $errors['un'] ?? "" ?><br>
        E-mail cím: <input type="text" name="em" value="<?= $em ?>"> <?= $errors['em'] ?? "" ?><br>
        Jelszó: <input type="password" name="pw" value="<?= $pw ?>"> <?= $errors['pw'] ?? "" ?><br>
        Jelszó mégegyszer: <input type="password" name="pw2" value="<?= $pw2 ?>"> <?= $errors['pw2'] ?? "" ?><br>
        <button type="submit" id="loginbutton">Regisztráció</button>
    </form>
    <a href="login.php"><button>Bejelentkezés</button></a>
</body>
</html>