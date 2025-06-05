@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-white text-4xl font-bold mb-8 border-b border-gray-700 pb-4">Популярні книги за останні {{ $days }} днів:</h1>
        @if($popularBooks->count() > 0)
            <ul class="space-y-4">
                @foreach ($popularBooks as $item)
                    <li class="bg-gray-800 rounded-lg p-4 shadow-lg hover:bg-gray-700 transition duration-300">
                        <div class="flex justify-between items-center">
                            <span class="text-white text-lg font-medium">{{ $item->book->title }}</span>
                            <span class="text-emerald-400 font-semibold px-3 py-1 bg-emerald-400/10 rounded-full text-sm">
                                {{ $item->reservations_count }} бронювань
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="bg-gray-800 rounded-lg p-6 text-center">
                <p class="text-gray-400 text-lg">За цей період немає популярних книг.</p>
            </div>
        @endif
    </div>
@endsection