<?php

namespace App\Models;

use PDO;

class Lesson
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create($courseId, $title)
    {
        $stmt = $this->db->prepare("INSERT INTO lessons (course_id, title) VALUES (:course_id, :title)");
        return $stmt->execute(['course_id' => $courseId, 'title' => $title]);
    }
}