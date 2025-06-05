@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-white">Список шкіл</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(Auth::user()->role === 'admin')
        <a href="{{ route('schools.create') }}" class="inline-block mb-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">Додати школу</a>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 rounded-lg shadow-xl">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="px-4 py-3 border text-white">Назва</th>
                    <th class="px-4 py-3 border text-white">Місто</th>
                    <th class="px-4 py-3 border text-white">Адреса</th>
                    <th class="px-4 py-3 border text-white">Дії</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schools as $school)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-2 border text-white">{{ $school->name }}</td>
                        <td class="px-4 py-2 border text-white">{{ $school->city }}</td>
                        <td class="px-4 py-2 border text-white">{{ $school->address }}</td>
                        <td class="px-4 py-2 border space-x-2">
                            <a href="{{ route('schools.show', $school) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">Переглянути</a>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('schools.edit', $school) }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">Редагувати</a>
                                <form action="{{ route('schools.destroy', $school) }}" method="POST" class="inline" onsubmit="return confirm('Ви впевнені?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">Видалити</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 text-white">
        {{ $schools->links() }}
    </div>
</div>
@endsection