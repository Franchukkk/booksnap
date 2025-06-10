<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $pendingUsers = User::where('status', 'pending')
            ->whereIn('role', ['student', 'teacher', 'librarian'])
            ->with('school', 'class') // якщо потрібно
            ->get();

        return view('admin.pending-users', compact('pendingUsers'));
    }

    public function approve($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);

        if ($user->status !== 'pending') {
            return redirect()->back()->withErrors(['error' => 'Користувач вже підтверджений або не чекає підтвердження']);
        }

        $user->status = 'active';
        $user->save();

        return redirect()->back()->with('success', 'Реєстрацію підтверджено');
    }

    public function reject($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        $user = User::findOrFail($id);

        if ($user->status !== 'pending') {
            return redirect()->back()->withErrors(['error' => 'Неможливо відхилити користувача, який вже активний']);
        }

        $user->delete();

        return redirect()->back()->with('success', 'Реєстрацію відхилено');
    }
}