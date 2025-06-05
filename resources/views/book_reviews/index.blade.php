@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200 mb-6">
                Відгуки про книгу "{{ $book->title }}"
            </h2>

            @if($reviews->isEmpty())
                <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg text-center text-gray-500">
                    Відгуків ще немає.
                </div>
            @else
                <div class="space-y-4">
                    @foreach($reviews as $review)
                        <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-lg font-semibold text-gray-800 dark:text-white">
                                        {{ $review->user->name }} {{ $review->user->surname }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Оцінка: <span class="font-medium text-yellow-500">{{ $review->rating }}/5</span>
                                    </p>
                                </div>
                                @if($review->user_id === auth()->id())
                                    <form action="{{ route('book_reviews.destroy', $book->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button onclick="return confirm('Ви впевнені, що хочете видалити відгук?')">
                                            Видалити
                                        </x-danger-button>
                                    </form>
                                @endif
                            </div>
                            @if($review->review)
                                <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $review->review }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('book_reviews.form', $book->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                    Залишити/редагувати відгук
                </a>
            </div>
        </div>
    </div>
@endsection