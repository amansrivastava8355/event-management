<?php
namespace App\Services;

use App\Interfaces\BookRepositoryInterface;
use App\Entities\Book;
use App\DTOs\BookDTO;

class BookService
{
    public function __construct(protected BookRepositoryInterface $repo) {}

    public function create(Book $book): BookDTO
    {
        return $this->repo->create($book);
    }

    public function update(int $id, Book $book): BookDTO
    {
        return $this->repo->update($id, $book);
    }

    public function getById(int $id): BookDTO
    {
        return $this->repo->findById($id);
    }

    public function getAll(): array
    {
        return $this->repo->findAll();
    }
}
