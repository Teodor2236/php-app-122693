<?php
// boilerplate index
require_once('functions.php');
require_once('db.php');

$page = $_GET['page'] ?? 'home';

$flash = [];
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

// debug($flash);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лаптопи</title>
    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
    <script>
        $(function() {
            // добавяне
            $(document).on('click', '.add-favorite', function() {
                let btn = $(this);
                let productId = btn.data('product');

                $.ajax({
                    url: './ajax/add_favorite.php',
                    method: 'POST',
                    data: {
                        product_id: productId
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.success) {
                            alert('Продуктът беше добавен в любими');

                            let removeBtn = $(`<button type="button" class="btn btn-sm btn-danger remove-favorite" data-product="${productId}">Премахни от любими</button>`);
                            btn.replaceWith(removeBtn);
                        } else {
                            alert(res.error);
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

            // премахване
            $(document).on('click', '.remove-favorite', function() {
                let btn = $(this);
                let productId = btn.data('product');

                $.ajax({
                    url: './ajax/remove_favorite.php',
                    method: 'POST',
                    data: {
                        product_id: productId
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.success) {
                            alert('Продуктът беше премахнат от любими');

                            let addBtn = $(`<button type="button" class="btn btn-sm btn-primary add-favorite" data-product="${productId}">Добави в любими</button>`);
                            btn.replaceWith(addBtn);
                        } else {
                            alert(res.error);
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">Лаптопи</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?php echo($page == 'home' ? 'active' : '') ?>" aria-current="page" href="?page=home">Начало</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo($page == 'products' ? 'active' : '') ?>" href="?page=products">Продукти</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo($page == 'contacts' ? 'active' : '') ?>" href="?page=contacts">Контакти</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo($page == 'add_product' ? 'active' : '') ?>" href="?page=add_product">Добави продукт</a>
                        </li>
                    </ul>
                    <div class="d-flex flex-row align-items-center gap-3">
                        <?php
                            if (isset($_SESSION['username'])) {
                                echo '<span class="text-light me-3">Здравей, ' . htmlspecialchars($_SESSION['username']) . '</span>';
                                echo '
                                    <form method="POST" action="./handlers/handle_logout.php" class="m-0">
                                        <button type="submit" class="btn btn-outline-light">Изход</button>
                                    </form>
                                ';
                            } else {
                                echo '<a href="?page=login" class="btn btn-outline-light">Вход</a>';
                                echo '<a href="?page=register" class="btn btn-outline-light">Регистрация</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="container py-4" style="min-height:80vh;">
        <?php
            if (isset($flash['message'])) {
                echo '
                    <div class="alert alert-' . $flash['message']['type'] . '">
                        ' . $flash['message']['text'] . '
                    </div>
                ';
            }

            if (file_exists("pages/$page.php")) {
                require_once("pages/$page.php");
            } else {
                require_once("pages/not_found.php");
            }
        ?>
    </main>
    <footer class="bg-dark text-center py-5 mt-auto">
        <div class="container">
            <span class="text-light">© 2024 All rights reserved</span>
        </div>
    </footer>
</body>
</html>