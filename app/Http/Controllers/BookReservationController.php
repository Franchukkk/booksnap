<?php

namespace App\Http\Controllers;

use App\Models\BookReservation;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class BookReservationController extends Controller
{
    // Список бронювань
    public function index(Request $request)
    {
        $query = BookReservation::with(['user', 'book']);

        if (auth()->user()->role === 'admin' || auth()->user()->role === 'librarian') {
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }
        } else {
            $query->where('user_id', auth()->user()->id);
        }

        if ($request->has('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $reservations = $query->paginate(15);

        return view('reservations.index', compact('reservations'));
    }
    // Форма створення бронювання
    public function create()
    {
        if (auth()->user()->status == 'pending') {
            abort(403, 'Ваш обліковий запис ще не активовано.');
        }

        $books = Book::all();
        return view('books.index', compact('books'));
    }

    // Зберегти бронювання
    public function store(Request $request)
    {
        if (auth()->user()->status == 'pending') {
            abort(403, 'Ваш обліковий запис ще не активовано.');
        }

        $existing = BookReservation::where('user_id', auth()->user()->id)
            ->where('book_id', $request->book_id)
            ->whereIn('status', ['reserved', 'borrowed'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('success', 'Ви вже маєте активне бронювання цієї книги.');
        }

        $request['user_id'] = auth()->user()->id;

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($data['book_id']);
        $activeReservationsCount = BookReservation::where('book_id', $book->id)
            ->whereIn('status', ['reserved', 'borrowed'])
            ->count();

        if ($activeReservationsCount >= $book->quantity) {
            return redirect()->back()->withErrors(['error' => 'Всі примірники книги наразі заброньовані або позичені']);
        }

        BookReservation::create([
            'user_id' => $data['user_id'],
            'book_id' => $data['book_id'],
            'reserved_at' => Carbon::now(),
            'due_date' => null,
            'status' => 'reserved',
        ]);

        return redirect()->back()->with('success', 'Книгу успішно заброньовано.');
    }

    // Позичити книгу
    public function borrow(BookReservation $bookReservation)
    {
        if (auth()->user()->status == 'pending') {
            abort(403, 'Ваш обліковий запис ще не активовано.');
        }

        if ($bookReservation->status !== 'reserved') {
            return redirect()->back()->withErrors(['error' => 'Книгу можна позичити лише зі статусу reserved']);
        }

        $bookReservation->update([
            'status' => 'borrowed',
            'due_date' => Carbon::now()->addWeeks(2),
            'reserved_at' => Carbon::now(),
        ]);

        return redirect()->route('reservations.index')->with('success', 'Книга успішно позичена');
    }

    // Форма редагування
    public function edit(BookReservation $reservation)
    {
        if (auth()->user()->status == 'pending') {
            abort(403, 'Ваш обліковий запис ще не активовано.');
        }

        return view('reservations.edit', compact('reservation'));
    }

    // Оновити бронювання
    public function update(Request $request, BookReservation $reservation)
    {
        if (auth()->user()->status == 'pending') {
            abort(403, 'Ваш обліковий запис ще не активовано.');
        }

        $data = $request->validate([
            'status' => ['sometimes', Rule::in(['reserved', 'borrowed', 'returned', 'overdue', 'cancelled'])],
            'due_date' => 'nullable|date|after_or_equal:today',
            'returned_at' => 'nullable|date',
        ]);

        $data['returned_at'] = ($data['status'] == 'returned' || $data['status'] == 'overdue') ? $data['returned_at'] : null;

        $reservation->update($data);

        return redirect()->route('reservations.index')->with('success', 'Бронювання оновлено');
    }

    // Видалити бронювання
    public function destroy(BookReservation $reservation)
    {
        if (auth()->user()->status == 'pending') {
            abort(403, 'Ваш обліковий запис ще не активовано.');
        }
        
        $reservation->delete();
        
        return redirect()->route('reservations.index')->with('success', 'Бронювання видалено');
    }
}