<?php
    session_start();

    $users = json_decode(file_get_contents('users.json'), true);

    if(isset($_GET['teamid'])){
        $teampageid = $_GET['teamid'];
    } else {
        header("Location: index.php");
    }

    if(count($_GET) > 0 && isset($_GET['id']) && $users[$_SESSION['userid']]['isAdmin']){
        $comments = json_decode(file_get_contents('comments.json'), true);
        if(isset($comments[$_GET['id']])) {
            unset($comments[$_GET['id']]);
        }
        file_put_contents('comments.json', json_encode($comments, JSON_PRETTY_PRINT));
        header("Location: details.php?id=$teampageid#comments");
    } else {
        header("Location: index.php");
    }
?>