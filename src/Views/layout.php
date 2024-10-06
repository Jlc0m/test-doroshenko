<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Doroshenko.agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/public/css/styles.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/"><img class="me-3" src="public/images/shopping_bag_42dp_000000_FILL0_wght400_GRAD0_opsz40.png" alt="icon" width="42" height="42"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item me-3">
                        <a class="btn btn-warning dropdown-toggle" href="#" data-bs-toggle="modal" data-bs-target="#coursesModal">
                            Курси
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link dropdown-toggle" href="#">Тренінги</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">Про нас</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin">Панель керування</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="tel:+1234567890" class="text-dark d-flex align-items-center me-3 phone-link">
                        <i class="fas fa-phone nav-icon"></i>
                        <span class="phone-number">+1234567890</span>
                    </a>
                    <a href="https://www.youtube.com" target="_blank" class="text-dark me-3"><i class="fab fa-youtube nav-icon"></i></a>
                    <a href="https://www.facebook.com" target="_blank" class="text-dark me-3"><i class="fab fa-facebook nav-icon"></i></a>
                    <a href="https://www.instagram.com" target="_blank" class="text-dark me-4"><i class="fab fa-instagram nav-icon"></i></a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/logout" class="login-link">
                            <i class="fas fa-sign-out-alt nav-icon me-2"></i>
                            <span>Выйти</span>
                        </a>
                    <?php else: ?>
                        <a href="/login" class="login-link">
                            <i class="fas fa-user nav-icon me-2"></i>
                            <span>Увійти</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php include $content; ?>
    </div>

    <?php include __DIR__ . '/popups/courses_popup.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/js/main.js"></script>
</body>

</html>