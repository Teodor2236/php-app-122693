<?php
// страница контакти

if (isset($_POST['submit'])) {
    $errors = [];
    foreach ($_POST as $key => $value) {
        if ($key != 'submit' && empty($value)) {
            $errors[] = "Полето $key не е попълнено!";
        }
    }

    if (count($errors) > 0) {
        echo '<div class="alert alert-danger" role="alert">';
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-success" role="alert">Благодарим Ви за съобщението, ' . $_POST['name'] . '! На имейл адрес ' . $_POST['email'] . ' ще получите отговор.</div>';
    }
}

?>
<h1>Свържете се с нас</h1>
<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Имена</label>
        <input type="text" class="form-control" id="name" placeholder="Your Name" name="name">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Имейл</label>
        <input type="email" class="form-control" id="email" placeholder="Your Email" name="email">
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Съобщение</label>
        <textarea class="form-control" id="message" rows="4" name="message"></textarea>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Изпрати</button>
</form>