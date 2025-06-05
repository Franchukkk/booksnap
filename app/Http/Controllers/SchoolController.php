<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $query = School::query();

        if ($request->has('name')) {
            $query->where('name', $request->name);
        }

        if ($request->has('city')) {
            $query->where('city', $request->city);
        }

        $schools = $query->paginate(15);

        return view('schools.index', compact('schools'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Доступ заборонено');
        }

        return view('schools.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Доступ заборонено');
        }

        if (Auth::user()->school_id) {
            abort(403, 'Ви вже маєте створену школу');
        }

        $data = $request->validate([
            'name' => 'required|string|unique:schools,name',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $school = School::create($data);

        Auth::user()->update([
            'school_id' => $school->id
        ]);

        return redirect()->route('schools.index')->with('success', 'Школу створено успішно.');
    }

    public function show(School $school)
    {
        return view('schools.show', compact('school'));
    }

    public function edit(School $school)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Доступ заборонено');
        }

        return view('schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Доступ заборонено');
        }

        $data = $request->validate([
            'name' => 'sometimes|required|string|unique:schools,name,' . $school->id,
            'city' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $school->update($data);

        return redirect()->route('schools.index')->with('success', 'Школу оновлено успішно.');
    }

    public function destroy(School $school)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Доступ заборонено');
        }

        Auth::user()->update([
            'school_id' => null
        ]);

        $school->delete();

        return redirect()->route('schools.index')->with('success', 'Школу видалено.');
    }
}