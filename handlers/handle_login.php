<?php

require_once('../functions.php');
require_once('../db.php');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// проверим дали потребителят съществува
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute([':email' => $email]);
$user = $stmt->fetch();

$error = 'Грешен имейл или парола!';

if (!$user) {
    $_SESSION['flash']['message']['text'] = $error;
    $_SESSION['flash']['message']['type'] = 'danger';
    header('Location: ../index.php?page=login');
    exit;
} else {
    if (password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['username'] = $user['names'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_id'] = $user['id'];

        setcookie('last_login', $user['email'], time() + 3600, '/', 'localhost', false, false);

        header('Location: ../index.php?page=home');
        exit;
    } else {
        $_SESSION['flash']['message']['text'] = $error;
        $_SESSION['flash']['message']['type'] = 'danger';
        header('Location: ../index.php?page=login');
        exit;
    }
}

?>