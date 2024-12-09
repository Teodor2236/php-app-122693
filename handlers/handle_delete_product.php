<?php

require_once('../functions.php');
require_once('../db.php');

// debug($_POST);
// exit;

$id = intval($_POST['product_id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешен идентификатор на продукт!";
    header('Location: ../index.php?page=products');
    exit;
}

$query = "DELETE FROM products WHERE id = :id";
$stmt = $pdo->prepare($query);
if ($stmt->execute(['id' => $id])) {
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = "Продуктът беше изтрит успешно!";
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешка при изтриване на продукт!";
}

header('Location: ../index.php?page=products');
exit;
?>