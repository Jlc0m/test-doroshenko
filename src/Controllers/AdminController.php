<?php

namespace App\Controllers;

use App\Models\Course;
use App\Models\Lesson;

class AdminController
{
    private $course;
    private $lesson;

    public function __construct()
    {
        $db = require __DIR__ . '/../../config/database.php';
        $this->course = new Course($db);
        $this->lesson = new Lesson($db);
    }

    public function index()
    {
        $courses = $this->course->getAllCourses();
        $content = __DIR__ . '/../Views/admin/dashboard.php';
        include __DIR__ . '/../Views/layout.php';
    }

    public function addCourse()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            if ($this->course->create($title)) {
                header('Location: /admin');
                exit;
            }
        }
        $content = __DIR__ . '/../Views/admin/add_course.php';
        include __DIR__ . '/../Views/layout.php';
    }

    public function addLesson()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseId = $_POST['course_id'] ?? '';
            $title = $_POST['title'] ?? '';
            if ($this->lesson->create($courseId, $title)) {
                header('Location: /admin');
                exit;
            }
        }
        $courses = $this->course->getAllCourses();
        $content = __DIR__ . '/../Views/admin/add_lesson.php';
        include __DIR__ . '/../Views/layout.php';
    }
}