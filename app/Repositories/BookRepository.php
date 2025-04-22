<?php
namespace App\Repositories;

use App\Models\Book as BookModel;
use App\Entities\Book;
use App\Interfaces\BookRepositoryInterface;
use App\DTOs\BookDTO;

class BookRepository implements BookRepositoryInterface
{
    public function create(Book $book): BookDTO
    {
        $model = BookModel::create([
            'title' => $book->title,
            'author' => $book->author,
            'year' => $book->year,
        ]);

        return $this->toDTO($model);
    }

    public function update(int $id, Book $book): BookDTO
    {
        $model = BookModel::findOrFail($id);
        $model->update([
            'title' => $book->title,
            'author' => $book->author,
            'year' => $book->year,
        ]);

        return $this->toDTO($model);
    }

    public function findById(int $id): BookDTO
    {
        $model = BookModel::findOrFail($id);
        return $this->toDTO($model);
    }

    public function findAll(): array
    {
        return BookModel::all()->map(fn ($model) => $this->toDTO($model))->all();
    }

    private function toDTO(BookModel $model): BookDTO
    {
        return new BookDTO(
            id: $model->id,
            title: $model->title,
            author: $model->author,
            year: $model->year
        );
    }
}
