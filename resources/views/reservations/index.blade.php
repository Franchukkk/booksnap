@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-white">Список бронювань</h1>
        <a href="{{ route('books.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
            Створити нове бронювання
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-6 shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-700">
                    <th class="px-6 py-4 text-white font-semibold">Книга</th>
                    <th class="px-6 py-4 text-white font-semibold">Користувач</th>
                    <th class="px-6 py-4 text-white font-semibold">Статус</th>
                    <th class="px-6 py-4 text-white font-semibold">Дата бронювання</th>
                    <th class="px-6 py-4 text-white font-semibold">Дата повернення</th>
                    <th class="px-6 py-4 text-white font-semibold">Дії</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition duration-200">
                        <td class="px-6 py-4 text-white">{{ $reservation->book->title }}</td>
                        <td class="px-6 py-4 text-white">{{ $reservation->user->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if($reservation->status === 'reserved') bg-blue-500 text-white
                                @elseif($reservation->status === 'borrowed') bg-blue-500 text-white
                                @else bg-green-500 text-white
                                @endif">
                                {{ $reservation->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-white">{{ $reservation->reserved_at }}</td>
                        <td class="px-6 py-4 text-white">{{ $reservation->due_date }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                @if(auth()->user()->role == 'librarian' || auth()->user()->role == 'admin')
                                    <a href="{{ route('reservations.edit', $reservation) }}" 
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md transition duration-200">
                                        Редагувати
                                    </a>
                                @endif
                                <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('Ви впевнені?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md transition duration-200">
                                        Видалити
                                    </button>
                                </form>
                                @if($reservation->status === 'reserved' && (auth()->user()->role == 'librarian' || auth()->user()->role == 'admin'))
                                    <form action="{{ route('reservations.borrow', $reservation) }}" method="POST">
                                        @csrf
                                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md transition duration-200">
                                            Позичити
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $reservations->links() }}
    </div>
</div>
@endsection