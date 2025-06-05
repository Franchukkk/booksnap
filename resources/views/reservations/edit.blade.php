@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-900">
    <h1 class="text-3xl font-bold mb-6 text-white">Редагувати бронювання</h1>

    <form method="POST" action="{{ route('reservations.update', $reservation) }}" class="bg-gray-800 shadow-md rounded-lg p-6 max-w-2xl">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="status" class="block text-gray-300 text-sm font-bold mb-2">Статус:</label>
            <select name="status" id="status" class="w-full bg-gray-700 border border-gray-600 text-black rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @foreach(['reserved', 'borrowed', 'returned', 'overdue', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected($reservation->status === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label for="due_date" class="block text-gray-300 text-sm font-bold mb-2">Дата повернення:</label>
            <input type="date" name="due_date" value="{{ optional($reservation->due_date)->format('Y-m-d') }}" class="w-full bg-gray-700 border border-gray-600 text-black rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <div class="mb-6">
            <label for="returned_at" class="block text-gray-300 text-sm font-bold mb-2">Дата фактичного повернення:</label>
            <input type="date" name="returned_at" value="{{ optional($reservation->returned_at)->format('Y-m-d') }}" class="w-full bg-gray-700 border border-gray-600 text-black rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Оновити
        </button>
    </form>
</div>
@endsection