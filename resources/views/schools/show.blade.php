@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white dark:bg-gray-800 shadow rounded-xl">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Інформація про школу</h1>

    <table class="w-full text-left border border-gray-300 dark:border-gray-600 rounded">
        <tr class="bg-gray-100 dark:bg-gray-700">
            <th class="px-4 py-2 border dark:border-gray-600 w-1/3 text-gray-900 dark:text-white">Назва:</th>
            <td class="px-4 py-2 border dark:border-gray-600 text-gray-800 dark:text-gray-200">{{ $school->name }}</td>
        </tr>
        <tr class="dark:bg-gray-800">
            <th class="px-4 py-2 border dark:border-gray-600 text-gray-900 dark:text-white">Місто:</th>
            <td class="px-4 py-2 border dark:border-gray-600 text-gray-800 dark:text-gray-200">{{ $school->city }}</td>
        </tr>
        <tr class="dark:bg-gray-800">
            <th class="px-4 py-2 border dark:border-gray-600 text-gray-900 dark:text-white">Адреса:</th>
            <td class="px-4 py-2 border dark:border-gray-600 text-gray-800 dark:text-gray-200">{{ $school->address }}</td>
        </tr>
    </table>

    <div class="mt-6 flex gap-4">
        <a href="{{ route('schools.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 shadow-md hover:shadow-lg">Назад</a>
    </div>
</div>
@endsection