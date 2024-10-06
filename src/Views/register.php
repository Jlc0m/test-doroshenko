<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація - Test Doroshenko.agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }
        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }
    </style>
</head>
<body class="text-center">
    <main class="form-signin">
        <form action="/register" method="post">
            <img class="mb-4" src="/public/images/shopping_bag_42dp_000000_FILL0_wght400_GRAD0_opsz40.png" alt="" width="72" height="72">
            <h1 class="h3 mb-3 fw-normal">Реєстрація</h1>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
                <label for="floatingInput">Email адреса</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Пароль" required>
                <label for="floatingPassword">Пароль</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingConfirmPassword" name="confirm_password" placeholder="Підтвердіть пароль" required>
                <label for="floatingConfirmPassword">Підтвердіть пароль</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Зареєструватися</button>
            <p class="mt-3">Уже є аккаунт? <a href="/login">Увійти</a></p>
        </form>
    </main>
</body>
</html>