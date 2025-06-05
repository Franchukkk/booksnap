<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BooksImport;

class BookImportController extends Controller
{
    public function import(Request $request)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'librarian') {
            abort(403, 'Unauthorized action.');
        }

        if (auth()->user()->school_id === null) {
            abort(403, 'Для того щоб додати книги, спочатку необхідно створити школу.');
        }

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new BooksImport, $request->file('file'));
            return redirect()->back()->with('success', 'Імпорт успішно завершено');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Сталася помилка під час імпорту: ' . $e->getMessage());
        }
    }
}