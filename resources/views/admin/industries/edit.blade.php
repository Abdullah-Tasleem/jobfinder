<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold">Edit Industry</h1>
            <a href="{{ route('admin.industries.index') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 mt-6 bg-white rounded shadow">

        <form method="POST" action="{{ route('admin.industries.update', $industry) }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Industry Name</label>
                <input type="text" name="name" value="{{ old('name', $industry->name) }}"
                    class="w-full border-gray-300 rounded shadow-sm p-2" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 rounded shadow-sm p-2">
                    <option value="1" {{ $industry->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$industry->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600">
                Update
            </button>
            <a href="{{ route('admin.industries.index') }}"
                class="ml-2 bg-gray-500 hover:bg-gray-600 px-4 py-2 rounded text-white">Cancel</a>
        </form>
    </div>
</x-app-layout>
