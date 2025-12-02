@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Edit Pet</h1>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pets.update', $pet) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name', $pet->name) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium">Type</label>
            <input type="text" name="type" value="{{ old('type', $pet->type) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Race</label>
                <input type="text" name="race" value="{{ old('race', $pet->race) }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Gender</label>
                <select name="gender" class="w-full border rounded px-3 py-2">
                    <option value="">--</option>
                    <option value="male" {{ old('gender', $pet->gender)=='male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $pet->gender)=='female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Age</label>
                <input type="number" name="age" value="{{ old('age', $pet->age) }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Weight</label>
                <input type="number" step="0.1" name="weight" value="{{ old('weight', $pet->weight) }}" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Photo</label>
            @if($pet->photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $pet->photo) }}" alt="{{ $pet->name }}" class="w-48 h-32 object-cover rounded">
                </div>
            @endif
            <input type="file" name="photo" accept="image/*" class="w-full">
        </div>

        <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $pet->description) }}</textarea>
        </div>

        <div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('pets.index') }}" class="ml-3 text-gray-600">Cancel</a>
        </div>
    </form>
</div>
@endsection
