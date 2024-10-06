<?php

namespace App\Models;

use PDO;

class Course
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllCourses()
    {
        $stmt = $this->db->query("SELECT * FROM courses");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($title)
    {
        $stmt = $this->db->prepare("INSERT INTO courses (title) VALUES (:title)");
        return $stmt->execute(['title' => $title]);
    }

    public function getAllCoursesWithLessons()
    {
        $stmt = $this->db->query("
            SELECT c.id as course_id, c.title as course_title, l.id as lesson_id, l.title as lesson_title
            FROM courses c
            LEFT JOIN lessons l ON c.id = l.course_id
            ORDER BY c.id, l.id
        ");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $courses = [];
        foreach ($results as $row) {
            if (!isset($courses[$row['course_id']])) {
                $courses[$row['course_id']] = [
                    'id' => $row['course_id'],
                    'title' => $row['course_title'],
                    'lessons' => []
                ];
            }
            if ($row['lesson_id']) {
                $courses[$row['course_id']]['lessons'][] = [
                    'id' => $row['lesson_id'],
                    'title' => $row['lesson_title']
                ];
            }
        }
        return array_values($courses);
    }
}