@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-12 min-h-screen bg-gray-900">
        <h1 class="text-white text-4xl font-bold mb-8 border-b border-gray-700 pb-4 tracking-wide">Непопулярні книги за останні {{ $days }} днів:</h1>
        <div class="max-w-4xl mx-auto">
            <ul class="space-y-4 bg-gray-800 rounded-2xl p-8 shadow-2xl">
                @foreach ($unpopularBooks as $book)
                    <li class="text-white text-lg hover:bg-gray-700 p-6 rounded-xl transition-all duration-300 ease-in-out cursor-pointer flex items-center group transform hover:scale-102 hover:shadow-lg">
                        <span class="mr-4 text-2xl group-hover:rotate-12 transition-transform duration-300">📚</span>
                        <span class="font-medium group-hover:text-blue-400 transition-colors duration-300">{{ $book->title }}</span>
                        <span class="ml-auto text-gray-400 text-sm bg-gray-700 px-4 py-2 rounded-full">
                            Бронювань: {{ $book->reservations_count ?? 0 }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection