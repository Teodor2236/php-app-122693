<?php
    // страница login
?>

<form class="border rounded p-4 w-50 mx-auto" method="POST" action="./handlers/handle_login.php">
    <h3 class="text-center">Вход в системата</h3>
    <div class="mb-3">
        <label for="email" class="form-label">Имейл</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $_COOKIE['last_login'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Парола</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <button type="submit" class="btn btn-primary mx-auto">Вход</button>
</form>