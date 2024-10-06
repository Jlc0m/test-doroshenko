<?php

namespace App\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\File;
use App\Models\SliderItem;

class HomeController
{
    private $course;
    private $lesson;
    private $file;
    private $sliderItem;

    public function __construct()
    {
        $db = require __DIR__ . '/../../config/database.php';
        $this->course = new Course($db);
        $this->lesson = new Lesson($db);
        $this->file = new File($db);
        $this->sliderItem = new SliderItem($db);
    }

    public function index()
    {
        $courses = $this->course->getAllCoursesWithLessons();
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $itemsPerPage = $_ENV['ITEMS_PER_PAGE'];
        $totalItems = $this->file->getTotalCount();
        $totalPages = ceil($totalItems / $itemsPerPage);
        $files = $this->file->getFiles($page, $itemsPerPage);
        $sliderItems = $this->sliderItem->getSliderItems();

        $content = __DIR__ . '/../Views/home.php';
        include __DIR__ . '/../Views/layout.php';
    }

    public function addFile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $uploadedFile = $_FILES['file'];
            
            $uploadDir = __DIR__ . '/../../data/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = uniqid() . '_' . basename($uploadedFile['name']);
            $path = $uploadDir . $fileName;

            if (move_uploaded_file($uploadedFile['tmp_name'], $path)) {
                $relativePath = 'data/uploads/' . $fileName;
                if ($this->file->addFile($name, $relativePath, $uploadedFile['type'])) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Не вдалося додати файл до бази даних']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Не вдалося завантажити файл']);
            }
            exit;
        }
    }

    public function deleteFile($id)
    {
        $file = $this->file->getFileById($id);
        if ($file) {
            $filePath = __DIR__ . '/../../' . $file['path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            if ($this->file->deleteFile($id)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Не вдалося видалити файл з бази даних']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Файл не знайдено']);
        }
        exit;
    }

    public function updateFile($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $type = null;
            $relativePath = null;

            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $uploadedFile = $_FILES['file'];
                $type = $uploadedFile['type'];
                
                $uploadDir = __DIR__ . '/../../data/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $fileName = uniqid() . '_' . basename($uploadedFile['name']);
                $path = $uploadDir . $fileName;

                if (move_uploaded_file($uploadedFile['tmp_name'], $path)) {
                    $relativePath = 'data/uploads/' . $fileName;
                } else {
                    echo json_encode(['success' => false, 'error' => 'Не вдалося завантажити файл']);
                    exit;
                }
            }

            $currentFile = $this->file->getFileById($id);
            if (!$currentFile) {
                echo json_encode(['success' => false, 'error' => 'Файл не знайдено']);
                exit;
            }

            $updatedType = $type ?? $currentFile['type'];
            $updatedPath = $relativePath ?? $currentFile['path'];

            if ($this->file->updateFile($id, $name, $updatedPath, $updatedType)) {
                if ($relativePath && $currentFile['path'] !== $updatedPath) {
                    $oldFilePath = __DIR__ . '/../../' . $currentFile['path'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Не вдалося оновити файл в базі даних']);
            }
            exit;
        }
    }
}