<?php
if (session_status() === PHP_SESSION_NONE) {
session_start();
}

$query = "SELECT * FROM utilisateurs WHERE id = :id";
$res= $pdo->prepare($query);
$res->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
$res-> execute();

if ($res->rowCount() > 0){
    $user = $res->fetch(PDO::FETCH_ASSOC);
    $_SESSION['prenom'] = $user['prenom'];
} else {
    $_SESSION['user_id']= null;
}