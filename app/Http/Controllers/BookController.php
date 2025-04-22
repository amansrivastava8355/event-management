<?php
namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Services\BookService;
use App\Entities\Book;

class BookController extends Controller
{
    public function __construct(protected BookService $bookService) {}

    public function store(BookRequest $request)
    {
        $book = new Book(...$request->validated());
        $dto = $this->bookService->create($book);
        return response()->json($dto->toArray());
    }

    public function update(BookRequest $request, int $id)
    {
        $book = new Book(...$request->validated());
        $dto = $this->bookService->update($id, $book);
        return response()->json($dto->toArray());
    }

    public function show(int $id)
    {
        $dto = $this->bookService->getById($id);
        return response()->json($dto->toArray());
    }

    public function index()
    {
        $dtos = $this->bookService->getAll();
        return response()->json(array_map(fn($dto) => $dto->toArray(), $dtos));
    }
}


