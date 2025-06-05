@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200 mb-6">
                    {{ $existingReview ? 'Редагування відгуку' : 'Залишити відгук' }} про книгу "{{ $book->title }}"
                </h2>

                <form action="{{ route('book_reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                    <div class="mb-4">
                        <x-input-label for="rating" :value="__('Оцінка (1-5)')" />
                        <x-text-input id="rating" name="rating" type="number" min="1" max="5" required
                            class="mt-1 block w-full" value="{{ old('rating', $existingReview->rating ?? '') }}" />
                        <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="review" :value="__('Текст відгуку (необов\'язково)')" />
                        <textarea id="review" name="review" rows="4"
                            class="mt-1 block w-full rounded-md shadow-sm dark:bg-gray-700 dark:text-white border-gray-300 focus:ring focus:ring-indigo-200 focus:border-indigo-300">
                            {{ old('review', $existingReview->review ?? '') }}
                        </textarea>
                        <x-input-error :messages="$errors->get('review')" class="mt-2" />
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('book_reviews.index', $book->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring ring-gray-300 dark:ring-gray-600 transition ease-in-out duration-150">
                            Назад
                        </a>
                        <x-primary-button>
                            {{ $existingReview ? 'Оновити відгук' : 'Зберегти відгук' }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection