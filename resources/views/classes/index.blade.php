@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Класи</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('classes.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        + Додати клас
    </a>

    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden rounded-lg">
        <table class="min-w-full text-left">
            <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <tr>
                    <th class="px-4 py-3">Назва</th>
                    <th class="px-4 py-3">Школа</th>
                    <th class="px-4 py-3">Дії</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                @foreach($classes as $class)
                    <tr>
                        <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $class->name }}</td>
                        <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $class->school->name ?? '—' }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('classes.edit', $class) }}" class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Редагувати</a>
                            <form action="{{ route('classes.destroy', $class) }}" method="POST" class="inline" onsubmit="return confirm('Видалити клас?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection