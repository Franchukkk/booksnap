@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white dark:bg-gray-800 shadow rounded-xl">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Редагувати школу</h1>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('schools.update', $school) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-medium mb-1 text-gray-900 dark:text-white">Назва</label>
            <input type="text" name="name" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-4 py-2" value="{{ old('name', $school->name) }}" required>
        </div>
        <div>
            <label class="block font-medium mb-1 text-gray-900 dark:text-white">Місто</label>
            <input type="text" name="city" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-4 py-2" value="{{ old('city', $school->city) }}">
        </div>
        <div>
            <label class="block font-medium mb-1 text-gray-900 dark:text-white">Адреса</label>
            <input type="text" name="address" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-4 py-2" value="{{ old('address', $school->address) }}">
        </div>
        <div class="flex gap-3 pt-4">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold transition duration-200 ease-in-out transform hover:scale-105 shadow-lg hover:shadow-blue-500/50">Оновити</button>
            <a href="{{ route('schools.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg font-semibold transition duration-200 ease-in-out transform hover:scale-105 shadow-lg hover:shadow-gray-500/50">Назад</a>
        </div>
    </form>
</div>
@endsection