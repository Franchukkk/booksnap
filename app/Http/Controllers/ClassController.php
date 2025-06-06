<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\School;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    // Список класів
    public function index()
    {
        $classes = ClassModel::with('school')->paginate(10);
        return view('classes.index', compact('classes'));
    }

    // Форма створення нового класу
    public function create()
    {
        $schools = School::all();
        return view('classes.create', compact('schools'));
    }

    // Збереження нового класу
    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
        ]);

        ClassModel::create($validated);

        return redirect()->route('classes.index')->with('success', 'Клас створено успішно.');
    }

    // Показати деталі класу
    public function show($id)
    {
        $class = ClassModel::with('school')->findOrFail($id);
        return view('classes.show', compact('class'));
    }

    // Форма редагування класу
    public function edit($id)
    {
        $class = ClassModel::findOrFail($id);
        $schools = School::all();
        return view('classes.edit', compact('class', 'schools'));
    }

    // Оновити клас
    public function update(Request $request, $id)
    {
        $class = ClassModel::findOrFail($id);

        $validated = $request->validate([
            'school_id' => 'sometimes|exists:schools,id',
            'name' => 'sometimes|string|max:255',
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')->with('success', 'Клас оновлено успішно.');
    }

    // Видалити клас
    public function destroy($id)
    {
        $class = ClassModel::findOrFail($id);
        $class->delete();

        return redirect()->route('classes.index')->with('success', 'Клас видалено успішно.');
    }
}