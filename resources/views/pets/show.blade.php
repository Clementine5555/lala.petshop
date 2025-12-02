@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-start gap-8">
        @if($pet->photo)
            <img src="{{ asset('storage/' . $pet->photo) }}" alt="{{ $pet->name }}" class="w-64 h-48 object-cover rounded">
        @endif

        <div>
            <h1 class="text-2xl font-bold">{{ $pet->name }}</h1>
            <p class="text-sm text-gray-600">Type: {{ $pet->type }} @if($pet->race) • Race: {{ $pet->race }}@endif</p>
            <p class="mt-3">{{ $pet->description }}</p>

            <div class="mt-4 flex gap-3">
                <a href="{{ route('pets.edit', $pet) }}" class="text-yellow-600">Edit</a>
                <form action="{{ route('pets.destroy', $pet) }}" method="POST" onsubmit="return confirm('Delete this pet?');">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600">Delete</button>
                </form>
                <a href="{{ route('pets.index') }}" class="text-gray-600">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
