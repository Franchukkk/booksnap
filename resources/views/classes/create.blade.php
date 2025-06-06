@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6">
    <h1 class="text-xl font-semibold mb-6 text-gray-800 dark:text-white">Додати клас</h1>

    <form action="{{ route('classes.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="school_id" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Школа</label>
            <select name="school_id" id="school_id" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
                @foreach($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="name" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Назва класу</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Зберегти</button>
    </form>
</div>
@endsection