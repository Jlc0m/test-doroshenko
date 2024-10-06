<?php

namespace App\Models;

class SliderItem
{
    private $db;

    public function __construct()
    {
        $this->db = new \PDO(
            "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );
    }

    public function getSliderItems(): array
    {
        $stmt = $this->db->query("SELECT * FROM slider_items LIMIT 3");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}