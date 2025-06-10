@extends('layouts.app')

@section('content')
    <div class="py-6 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="p-4 mb-4 text-white bg-green-900 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="p-4 mb-4 text-white bg-red-900 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="bg-gray-800 shadow-sm rounded p-6 text-white">
                @if($pendingUsers->isEmpty())
                    <p>Немає користувачів, що очікують підтвердження.</p>
                @else
                    <table class="w-full border border-gray-700 text-left">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-white">Імʼя</th>
                                <th class="px-4 py-2 text-white">Прізвище</th>
                                <th class="px-4 py-2 text-white">Email</th>
                                <th class="px-4 py-2 text-white">Роль</th>
                                <th class="px-4 py-2 text-white">Школа</th>
                                <th class="px-4 py-2 text-white">Клас</th>
                                <th class="px-4 py-2 text-white">Дії</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingUsers as $user)
                                <tr class="border-t border-gray-700">
                                    <td class="px-4 py-2 text-white">{{ $user->name }}</td>
                                    <td class="px-4 py-2 text-white">{{ $user->surname }}</td>
                                    <td class="px-4 py-2 text-white">{{ $user->email }}</td>
                                    <td class="px-4 py-2 text-white">{{ ucfirst($user->role) }}</td>
                                    <td class="px-4 py-2 text-white">{{ $user->school->name ?? '-' }}</td>
                                    <td class="px-4 py-2 text-white">{{ $user->class[0]->name ?? '-' }}</td>
                                    <td class="px-4 py-2 space-x-2">
                                        <form method="POST" action="{{ route('admin.users.approve', $user->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-emerald-500 text-white px-3 py-1 rounded hover:bg-emerald-600">Підтвердити</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.reject', $user->id) }}" class="inline" onsubmit="return confirm('Ви впевнені, що хочете відхилити цього користувача?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500 text-white px-3 py-1 rounded hover:bg-rose-600">Відхилити</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection