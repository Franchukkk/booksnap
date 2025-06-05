@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white dark:bg-gray-800 shadow rounded-xl">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Створити школу</h1>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('schools.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block font-medium mb-1 text-gray-900 dark:text-white">Назва</label>
            <input type="text" name="name" class="w-full border border-gray-300 dark:border-gray-600 rounded px-4 py-2 dark:bg-gray-700 dark:text-white" required>
        </div>
        <div>
            <label class="block font-medium mb-1 text-gray-900 dark:text-white">Місто</label>
            <input type="text" name="city" class="w-full border border-gray-300 dark:border-gray-600 rounded px-4 py-2 dark:bg-gray-700 dark:text-white">
        </div>
        <div>
            <label class="block font-medium mb-1 text-gray-900 dark:text-white">Адреса</label>
            <input type="text" name="address" class="w-full border border-gray-300 dark:border-gray-600 rounded px-4 py-2 dark:bg-gray-700 dark:text-white">
        </div>
        <div class="flex gap-3 pt-4">
            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 shadow-lg hover:shadow-xl font-semibold">Зберегти</button>
            <a href="{{ route('schools.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 shadow-lg hover:shadow-xl font-semibold">Назад</a>
        </div>
    </form>
</div>
@endsection