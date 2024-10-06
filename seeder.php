<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $db = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}", $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $stmt = $db->query("SELECT COUNT(*) FROM users");
    if ($stmt->fetchColumn() == 0) {
        $db->exec("INSERT INTO users (email, password) VALUES ('test@example.com', '" . password_hash('test1234', PASSWORD_DEFAULT) . "')");
    }

    $db->exec("CREATE TABLE IF NOT EXISTS courses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $stmt = $db->query("SELECT COUNT(*) FROM courses");
    if ($stmt->fetchColumn() == 0) {
        $db->exec("INSERT INTO courses (title) VALUES ('Test course')");
    }

    $db->exec("CREATE TABLE IF NOT EXISTS lessons (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT,
        title VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (course_id) REFERENCES courses(id)
    )");

    $stmt = $db->query("SELECT COUNT(*) FROM lessons");
    if ($stmt->fetchColumn() == 0) {
        $db->exec("INSERT INTO lessons (course_id, title) VALUES (1, 'Test lesson')");
    }

    $db->exec("CREATE TABLE IF NOT EXISTS files (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        path VARCHAR(255) NOT NULL,
        type VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $stmt = $db->query("SELECT COUNT(*) FROM files");
    if ($stmt->fetchColumn() == 0) {
        $db->exec("INSERT INTO files (name, path, type) VALUES ('test.txt', 'uploads/test.txt', 'text/plain')");
    }

    $db->exec("CREATE TABLE IF NOT EXISTS slider_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        image_url VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $stmt = $db->query("SELECT COUNT(*) FROM slider_items");
    if ($stmt->fetchColumn() == 0) {
        $db->exec("INSERT INTO slider_items (title, description, image_url) VALUES ('Test slide', 'Test slide', 'http://dummyimage.com/120')");
    }

    echo "Seeding success.\n";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}