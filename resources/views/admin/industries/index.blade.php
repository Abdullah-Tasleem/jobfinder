<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold">Industries</h1>
            <a href="{{ route('admin.industries.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
               + Add Industry
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    @if ($industries->count())
                        <table class="min-w-full border border-gray-300 dark:border-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="border px-4 py-2">ID</th>
                                    <th scope="col" class="border px-4 py-2">Name</th>
                                    <th scope="col" class="border px-4 py-2">Status</th>
                                    <th scope="col" class="border px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($industries as $industry)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $industry->id }}</td>
                                        <td class="border px-4 py-2">{{ $industry->name }}</td>
                                        <td class="border px-4 py-2">
                                            <span class="px-2 py-1 text-sm rounded {{ $industry->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $industry->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="border px-4 py-2 space-x-2">
                                            <a href="{{ route('admin.industries.edit', $industry) }}"
                                               class="inline-block bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
                                               Edit
                                            </a>
                                            <form action="{{ route('admin.industries.destroy', $industry) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $industries->links() }}
                        </div>
                    @else
                        <p>No industries found.</p>
                    @endif
                </div>
            </div>
        </div>
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
