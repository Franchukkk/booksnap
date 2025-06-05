@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Додати нову книгу</h1>
    <h2 class="text-xl font-medium text-gray-900 dark:text-white mt-6 mb-4">Імпортувати з excel-таблиці:</h2>
    <form action="{{ route('books.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit" class="btn btn-primary">Імпортувати</button>
    </form>
    <h2 class="text-xl font-medium text-gray-900 dark:text-white mt-6 mb-4">Завантажити вручну:</h2>
    @include('books._form')
</div>
@endsection