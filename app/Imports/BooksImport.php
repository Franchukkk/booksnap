<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Http;


class BooksImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $response = Http::get("https://openlibrary.org/api/books", [
            'bibkeys' => "ISBN:" . $row['isbn'],
            'format' => 'json',
            'jscmd' => 'data',
        ]);

        $data = $response->json();

        return new Book([
            'school_id' => auth()->user()->school_id,
            'title'          => $row['title'],
            'author'         => $row['author'] ?? null,
            'genre'          => $row['genre'] ?? null,
            'type'           => $row['type'] ?? 'non_textbook',
            'subject'        => $row['subject'],
            'class_level'    => $row['class_level'],
            'is_recommended' => filter_var($row['is_recommended'], FILTER_VALIDATE_BOOLEAN),
            'isbn'           => $row['isbn'],
            'description'    => $row['description'],
            'quantity'       => $row['quantity'] ?? 1,
            'cover_image'    => $data['ISBN:' . $row['isbn']]['cover']['medium'] ?? null,
        ]);
    }
}


