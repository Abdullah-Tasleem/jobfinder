<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold">Manage Reasons</h1>
            <a href="{{ route('admin.withdraw-reasons.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Add Reason
            </a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    @if ($reasons->count())

                        <table class="min-w-full border border-gray-300 dark:border-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr class="bg-gray-100">
                                    <th scope="col" class="border px-4 py-2">#</th>
                                    <th scope="col" class="border px-4 py-2">Reason</th>
                                    <th scope="col" class="border px-4 py-2">Status</th>
                                    <th scope="col" class="border px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reasons as $reason)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="border px-4 py-2">{{ $reason->reason }}</td>
                                        <td class="border px-4 py-2">
                                            @if ($reason->status)
                                                <span
                                                    class="bg-green-200 text-green-800 px-2 py-1 rounded">Active</span>
                                            @else
                                                <span class="bg-red-200 text-red-800 px-2 py-1 rounded">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2 space-x-2">
                                            <a href="{{ route('admin.withdraw-reasons.edit', $reason) }}"
                                                class="inline-block bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.withdraw-reasons.destroy', $reason) }}"
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
                            {{ $reasons->links() }}
                        </div>
                    @else
                        <p>No reasons found.</p>
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
