@php
    $isEdit = isset($book);
@endphp

<form action="{{ $isEdit ? route('books.update', $book) : route('books.store') }}"
      method="POST" class="space-y-6">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Назва книги</label>
        <input type="text" name="title" id="title" value="{{ old('title', $book->title ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
        @error('title')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Автор</label>
        <input type="text" name="author" id="author" value="{{ old('author', $book->author ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
        @error('author')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="genre" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Жанр</label>
        <input type="text" name="genre" id="genre" value="{{ old('genre', $book->genre ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
        @error('genre')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Тип</label>
        <select name="type" id="type"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            <option value="">Оберіть тип</option>
            <option value="textbook" @selected(old('type', $book->type ?? '') === 'textbook')>Підручник</option>
            <option value="non_textbook" @selected(old('type', $book->type ?? '') === 'non_textbook')>Непідручник</option>
        </select>
        @error('type')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Предмет</label>
        <input type="text" name="subject" id="subject" value="{{ old('subject', $book->subject ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
        @error('subject')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="class_level" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Клас</label>
        <input type="text" name="class_level" id="class_level" value="{{ old('class_level', $book->class_level ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
        @error('class_level')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_recommended" value="1"
                   @checked(old('is_recommended', $book->is_recommended ?? false))
                   class="rounded border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Рекомендована</span>
        </label>
        @error('is_recommended')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="isbn" class="block text-sm font-medium text-gray-700 dark:text-gray-200">ISBN</label>
        <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
        @error('isbn')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Кількість</label>
        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $book->quantity ?? 0) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
        @error('quantity')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Опис</label>
        <textarea name="description" id="description" rows="3"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">{{ old('description', $book->description ?? '') }}</textarea>
        @error('description')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="pt-4">
        <button type="submit"
                class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            {{ $isEdit ? 'Оновити' : 'Створити' }}
        </button>
    </div>
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li style="color: red">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</form>