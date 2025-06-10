<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use App\Models\ClassModel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $schools = School::all();
        $classes = ClassModel::all();
        return view('auth.register', compact('schools', 'classes'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date'],
            'role' => ['required', 'in:student,teacher,librarian,admin'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'school_id' => ['nullable', 'required_unless:role,admin', 'exists:schools,id'],
            'class_id' => ['nullable', 'required_if:role,student,teacher', 'exists:classes,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'status' => 'pending', // за замовчуванням
            'school_id' => $request->role !== 'admin' ? $request->school_id : null,
        ]);

        if ($request->role === 'admin') {
            $user->status = 'active';
            $user->save();
        }

        if (in_array($request->role, ['student', 'teacher']) && $request->class_id) {
            $class = ClassModel::findOrFail($request->class_id);
            if ($request->role === 'student') {
                $class->students()->attach($user->id);
            } elseif ($request->role === 'teacher') {
                $class->teachers()->attach($user->id);
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
