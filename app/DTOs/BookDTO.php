<?php
namespace App\DTOs;

class BookDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $author,
        public readonly int $year
    ) {}

    public function toArray(): array
    {
        return [
            'book_id' => $this->id,
            'book_title' => $this->title,
            'written_by' => $this->author,
            'published_year' => $this->year,
        ];
    }
}
