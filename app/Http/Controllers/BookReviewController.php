<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookReviewController extends Controller
{
    // Вивід усіх відгуків по книзі
    public function index($bookId)
    {
        $book = Book::with(['reviews.user'])->findOrFail($bookId);
        $reviews = $book->reviews;

        return view('book_reviews.index', compact('book', 'reviews'));
    }

    // Показати форму для створення або редагування відгуку
    public function createOrEdit($bookId)
    {
        $book = Book::findOrFail($bookId);
        $user = Auth::user();
        $existingReview = BookReview::where('book_id', $bookId)->where('user_id', $user->id)->first();

        return view('book_reviews.form', compact('book', 'existingReview'));
    }

    // Зберегти або оновити відгук
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $review = BookReview::updateOrCreate(
            ['book_id' => $validated['book_id'], 'user_id' => Auth::id()],
            ['rating' => $validated['rating'], 'review' => $validated['review']]
        );

        return redirect()->route('book_reviews.index', $validated['book_id'])->with('success', 'Відгук збережено.');
    }

    // Видалити відгук
    public function destroy($bookId)
    {
        $deleted = BookReview::where('book_id', $bookId)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->route('books.show', $bookId)->with(
            'success',
            $deleted ? 'Відгук видалено.' : 'Відгук не знайдено.'
        );
    }
}