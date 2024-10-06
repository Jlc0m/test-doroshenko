<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    private $user;

    public function __construct()
    {
        try {
            $db = require __DIR__ . '/../../config/database.php';
            $this->user = new User($db);
        } catch (\PDOException $e) {
            // Логирование ошибки
            error_log('Database connection failed: ' . $e->getMessage());
            // Отображение пользовательского сообщения об ошибке
            die('Произошла ошибка при подключении к базе данных. Пожалуйста, попробуйте позже.');
        }
    }

    public function showLoginForm()
    {
        include __DIR__ . '/../Views/login.php';
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->user->findByEmail($email);

        if ($user && $this->user->verifyPassword($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: /');
            exit;
        } else {
            $error = 'Неверный email или пароль';
            include __DIR__ . '/../Views/login.php';
        }
    }

    public function showRegistrationForm()
    {
        include __DIR__ . '/../Views/register.php';
    }

    public function register()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($password !== $confirmPassword) {
            $error = 'Пароли не совпадают';
            include __DIR__ . '/../Views/register.php';
            return;
        }

        if ($this->user->findByEmail($email)) {
            $error = 'Пользователь с таким email уже существует';
            include __DIR__ . '/../Views/register.php';
            return;
        }

        if ($this->user->create($email, $password)) {
            $_SESSION['success'] = 'Регистрация успешна. Теперь вы можете войти.';
            header('Location: /login');
            exit;
        } else {
            $error = 'Ошибка при регистрации. Попробуйте еще раз.';
            include __DIR__ . '/../Views/register.php';
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}