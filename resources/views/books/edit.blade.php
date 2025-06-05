@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Редагувати книгу</h1>

    @include('books._form', ['book' => $book])
</div>
@endsection