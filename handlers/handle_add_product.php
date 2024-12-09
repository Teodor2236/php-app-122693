<?php

require_once('../functions.php');
require_once('../db.php');

// debug($_POST);
// debug($_FILES);
// exit;

$title = $_POST['title'] ?? '';
$price = $_POST['price'] ?? '';

if (mb_strlen($title) <= 0 || mb_strlen($price) <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Моля попълнете всички полета!";
    header('Location: ../index.php?page=add_product');
    exit;
}

if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Моля качете изображение!";
    header('Location: ../index.php?page=add_product');
    exit;
}

$new_filename = time() . '_' . $_FILES['image']['name'];
$upload_dir = '../uploads/';

// проверка дали директорията съществува
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешка при запис на файла!";
    header('Location: ../index.php?page=add_product');
    exit;
}

$query = "INSERT INTO products (title, price, image) VALUES (:title, :price, :image)";
$stmt = $pdo->prepare($query);
$params = [
    ':title' => $title,
    ':price' => $price,
    ':image' => $new_filename
];
if ($stmt->execute($params)) {
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = "Продуктът беше добавен успешно!";
    header('Location: ../index.php?page=products');
    exit;
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешка при добавяне на продукт!";
    header('Location: ../index.php?page=add_product');
    exit;
}

?>