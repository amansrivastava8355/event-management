<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:1500|max:' . date('Y'),
        ];
    }

    public function getMappedData(): array {
        return [
            'title' => $this->input('book_title'),
            'author' => $this->input('written_by'),
            'year' => $this->input('published_year'),
        ];
    }
    
    public function authorize(): bool
    {
        return true;
    }
}
