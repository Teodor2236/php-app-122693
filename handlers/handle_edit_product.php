<?php

require_once('../functions.php');
require_once('../db.php');

// debug($_POST);
// debug($_FILES);
// exit;

$title = $_POST['title'] ?? '';
$price = $_POST['price'] ?? '';
$product_id = intval($_POST['product_id'] ?? 0);

if (mb_strlen($title) <= 0 || mb_strlen($price) <= 0 || $product_id <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Моля попълнете всички полета!";
    header('Location: ../index.php?page=edit_product&product_id=' . $product_id);
    exit;
}

$img_uploaded = false;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $new_filename = time() . '_' . $_FILES['image']['name'];
    $upload_dir = '../uploads/';

    // проверка дали директорията съществува
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Грешка при запис на файла!";
        header('Location: ../index.php?page=edit_product&product_id=' . $product_id);
        exit;
    } else {
        $img_uploaded = true;
    }
}

$query = '';
if ($img_uploaded) {
    $query = "UPDATE products SET title = :title, price = :price, image = :image WHERE id = :id";
} else {
    $query = "UPDATE products SET title = :title, price = :price WHERE id = :id";
}
$stmt = $pdo->prepare($query);
$params = [
    ':title' => $title,
    ':price' => $price,
    ':id' => $product_id
];
if ($img_uploaded) {
    $params[':image'] = $new_filename;
}

if ($stmt->execute($params)) {
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = "Продуктът беше редактиран успешно!";
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешка при редакция на продукт!";
}

header('Location: ../index.php?page=edit_product&product_id=' . $product_id);
exit;


?>