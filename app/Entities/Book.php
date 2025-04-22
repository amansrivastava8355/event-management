<?php
namespace App\Entities;

class Book
{
    public function __construct(
        public string $title,
        public string $author,
        public int $year
    ) {}
}
