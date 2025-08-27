<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold">Add Industry</h1>
            <a href="{{ route('admin.industries.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 mt-6 bg-white rounded shadow">
        <form method="POST" action="{{ route('admin.industries.store') }}">
            @csrf

            <div class="mb-4 text-left">
                <label class="block text-gray-700 font-medium mb-1">Industry Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border-gray-300 rounded shadow-sm p-2 focus:ring focus:ring-blue-200"
                       placeholder="Enter industry name" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 text-left">
                <label class="block text-gray-700 font-medium mb-1">Status</label>
                <select name="status"
                        class="w-full border-gray-300 rounded shadow-sm p-2 focus:ring focus:ring-blue-200">
                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center space-x-3">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                    Save
                </button>
                <a href="{{ route('admin.industries.index') }}"
                   class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 2000
                    });
                @endif
            });
        </script>
    @endpush
</x-app-layout>
