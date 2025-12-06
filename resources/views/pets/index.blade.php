@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Pets</h1>
        <a href="{{ route('pets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Pet</a>
    </div>

    @if(session('success'))
        <div class="mb-4 text-green-700">{{ session('success') }}</div>
    @endif

    @if($pets->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($pets as $pet)
                <div class="border rounded p-4">
                    @if($pet->photo)
                        <img src="{{ asset('storage/' . $pet->photo) }}" alt="{{ $pet->name }}" class="w-full h-40 object-cover mb-3 rounded">
                    @endif
                    <h2 class="text-lg font-semibold">{{ $pet->name }}</h2>
                    <p class="text-sm text-gray-600">Type: {{ $pet->type }} @if($pet->race) • Race: {{ $pet->race }}@endif</p>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('pets.show', $pet) }}" class="text-blue-600">View</a>
                        <a href="{{ route('pets.edit', $pet) }}" class="text-yellow-600">Edit</a>
                        <form action="{{ route('pets.destroy', $pet) }}" method="POST" onsubmit="return confirm('Delete this pet?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $pets->links() }}</div>
    @else
        <p>No pets yet. <a href="{{ route('pets.create') }}" class="text-blue-600">Add your first pet</a>.</p>
    @endif
</div>
@endsection
