<?php
    // страница продукти
    $products = [];

    $search = $_GET['search'] ?? '';
    // заявка към базата данни
    $sql = 'SELECT * FROM products WHERE title LIKE :search';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => '%' . $search . '%']);

    while ($row = $stmt->fetch()) {
        $fav_query = "SELECT id FROM favorite_products_users WHERE user_id = :user_id AND product_id = :product_id";
        $fav_stmt = $pdo->prepare($fav_query);
        $fav_params = [
            ':user_id' => $_SESSION['user_id'] ?? 0,
            ':product_id' => $row['id']
        ];
        $fav_stmt->execute($fav_params);
        $row['is_favorite'] = $fav_stmt->fetch() ? 1 : 0;

        $products[] = $row;
    }

    if (mb_strlen($search) > 0) {
        setcookie('last_search', $search, time() + 3600, '/', '', false, false);
    }
?>

<div class="row">
    <form class="mb-4" method="GET">
        <div class="input-group">
            <input type="hidden" name="page" value="products">
            <input type="text" class="form-control" placeholder="Търси продукт" name="search" value="<?php echo $search ?>">
            <button class="btn btn-primary" type="submit">Търсене</button>
        </div>
    </form>

    <div class="alert alert-info">
        Последно търсене: <?php echo $_COOKIE['last_search'] ?? 'няма' ?>
    </div>
</div>
<div class="d-flex flex-wrap justify-content-between">
    <?php
        foreach ($products as $product) {
            $fav_button = '';
            if (isset($_SESSION['username'])) {
                if ($product['is_favorite'] == '1') {
                    $fav_button = '
                        <div class="card-footer text-center">
                            <button type="button" class="btn btn-sm btn-danger remove-favorite" data-product="' . $product['id'] . '">Премахни от любими</button>
                        </div>
                    ';
                } else {
                    $fav_button = '
                        <div class="card-footer text-center">
                            <button type="button" class="btn btn-sm btn-primary add-favorite" data-product="' . $product['id'] . '">Добави в любими</button>
                        </div>
                    ';
                }
            }

            echo '
                <div class="card mb-4" style="width: 18rem;">
                    <div class="card-header d-flex flex-row justify-content-between">
                        <a href="?page=edit_product&product_id=' . $product['id'] . '" class="btn btn-sm btn-warning">Редактирай</a>
                        <form method="POST" action="./handlers/handle_delete_product.php">
                            <input type="hidden" name="product_id" value="' . $product['id'] . '">
                            <button type="submit" class="btn btn-sm btn-danger">Изтрий</button>
                        </form>
                    </div>
                    <img src="uploads/' . htmlspecialchars($product['image']) . '" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($product['title']) . '</h5>
                        <p class="card-text">' . htmlspecialchars($product['price']) . '</p>
                    </div>
                    ' . $fav_button . '
                </div>
            ';
        }
    ?>
</div>