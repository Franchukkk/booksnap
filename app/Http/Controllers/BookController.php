<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    // Show all books
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%")
                ->orWhere('genre', 'like', "%{$search}%");
            });
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }

        if ($request->has('is_recommended')) {
            $isRecommended = filter_var($request->is_recommended, FILTER_VALIDATE_BOOLEAN);
            $query->where('is_recommended', $isRecommended);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                case 'author_asc':
                    $query->orderBy('author', 'asc');
                    break;
                case 'author_desc':
                    $query->orderBy('author', 'desc');
                    break;
            }
        }

        $books = $query->paginate(10)->appends($request->query());

        $genres = Book::distinct()->pluck('genre');
        $types = Book::distinct()->pluck('type');

        return view('books.index', compact('books', 'genres', 'types'));
    }


    // Show form to create book
    public function create()
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'librarian') {
            abort(403, 'Unauthorized action.');
        }

        return view('books.create');
    }

    // Store a new book
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'librarian') {
            abort(403, 'Unauthorized action.');
        }

        if (auth()->user()->school_id === null) {
            abort(403, 'Для того щоб додати книгу, спочатку необхідно створити школу.');
        }

        $request['school_id'] = auth()->user()->school_id;

        $data = $request->validate([
            'school_id'      => 'required|exists:schools,id',
            'title'          => 'required|string|max:255',
            'author'         => 'nullable|string|max:255',
            'genre'          => 'nullable|string|max:255',
            'type'           => ['required', Rule::in(['textbook', 'non_textbook'])],
            'subject'        => 'nullable|string|max:255',
            'class_level'    => 'nullable|string|max:50',
            'is_recommended' => 'nullable|boolean',
            'isbn'           => 'nullable|string|unique:books,isbn',
            'description'    => 'nullable|string',
            'quantity'       => 'nullable|integer|min:0',
            'cover_image'    => 'nullable|string|max:255',
        ]);

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    // Show single book
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    // Show edit form
    public function edit(Book $book)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'librarian') {
            abort(403, 'Unauthorized action.');
        }

        return view('books.edit', compact('book'));
    }

    // Update book
    public function update(Request $request, Book $book)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'librarian') {
            abort(403, 'Unauthorized action.');
        }

        if (auth()->user()->school_id === null) {
            abort(403, 'Для того щоб редагувати книги, спочатку необхідно створити школу.');
        }

        $data = $request->validate([
            'school_id'      => 'sometimes|required|exists:schools,id',
            'title'          => 'sometimes|required|string|max:255',
            'author'         => 'nullable|string|max:255',
            'genre'          => 'nullable|string|max:255',
            'type'           => ['sometimes', 'required', Rule::in(['textbook', 'non_textbook'])],
            'subject'        => 'nullable|string|max:255',
            'class_level'    => 'nullable|string|max:50',
            'is_recommended' => 'nullable|boolean',
            'isbn'           => ['nullable', 'string', Rule::unique('books')->ignore($book->id)],
            'description'    => 'nullable|string',
            'quantity'       => 'nullable|integer|min:0',
            'cover_image'    => 'nullable|string|max:255',
        ]);

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    // Delete book
    public function destroy(Book $book)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'librarian') {
            abort(403, 'Unauthorized action.');
        }

        if (auth()->user()->school_id === null) {
            abort(403, 'Для того щоб видалити книги, спочатку необхідно створити школу.');
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted.');
    }
}