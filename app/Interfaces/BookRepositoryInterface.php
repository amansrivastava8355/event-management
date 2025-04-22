<?php

namespace App\Interfaces;

use App\Entities\Book;
use App\DTOs\BookDTO;

interface BookRepositoryInterface
{
    public function create(Book $book): BookDTO;
    public function update(int $id, Book $book): BookDTO;
    public function findById(int $id): BookDTO;
    public function findAll(): array; 
}
