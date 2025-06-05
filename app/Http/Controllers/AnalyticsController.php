<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookReservation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function popularBooks(Request $request)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'librarian') {
            abort(403, 'Доступ заборонено');
        }

        if (auth()->user()->school_id === null) {
            abort(403, 'Для того щоб переглядати аналітику, спочатку необхідно створити школу.');
        }

        $days = $request->input('days', 30);
        $limit = $request->input('limit', 10);
        $schoolId = auth()->user()->school_id;

        $dateFrom = Carbon::now()->subDays($days);

        $query = BookReservation::select('book_id', DB::raw('COUNT(*) as reservations_count'))
            ->whereIn('status', ['reserved', 'borrowed'])
            ->where('reserved_at', '>=', $dateFrom);

        if ($schoolId) {
            $query->whereHas('book', function ($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
        }

        $popularBooks = $query->groupBy('book_id')
            ->orderByDesc('reservations_count')
            ->with('book')
            ->limit($limit)
            ->get();

        return view('analytics.popular', compact('popularBooks', 'days', 'limit'));
    }

    public function unpopularBooks(Request $request)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'librarian') {
            abort(403, 'Доступ заборонено');
        }

        if (auth()->user()->school_id === null) {
            abort(403, 'Для того щоб переглядати аналітику, спочатку необхідно створити школу.');
        }

        $days = $request->input('days', 30);
        $limit = $request->input('limit', 10);
        $schoolId = auth()->user()->school_id;

        $dateFrom = Carbon::now()->subDays($days);

        $bookIdsWithReservations = BookReservation::whereIn('status', ['reserved', 'borrowed'])
            ->where('reserved_at', '>=', $dateFrom)
            ->when($schoolId, function ($query) use ($schoolId) {
                $query->whereHas('book', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
            })
            ->distinct()
            ->pluck('book_id')
            ->toArray();

        $unpopularBooksQuery = Book::query();

        if ($schoolId) {
            $unpopularBooksQuery->where('school_id', $schoolId);
        }

        $unpopularBooks = $unpopularBooksQuery->whereNotIn('id', $bookIdsWithReservations)
            ->limit($limit)
            ->get();

        return view('analytics.unpopular', compact('unpopularBooks', 'days', 'limit'));
    }
}