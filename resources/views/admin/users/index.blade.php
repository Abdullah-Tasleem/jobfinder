<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold">Manage Users & Companies</h1>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <table class="min-w-full border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Email</th>
                                <th class="px-4 py-2 border">Type</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="text-center">
                                    <td class="px-4 py-2 border">{{ $user->id }}</td>
                                    @if ($user->type == 'user' || $user->type == 'admin')
                                        <td class="px-4 py-2 border">{{ $user->first_name }}</td>
                                    @else
                                        <td class="px-4 py-2 border">{{ $user->company_name }}</td>
                                    @endif
                                    <td class="px-4 py-2 border">{{ $user->email }}</td>
                                    <td class="px-4 py-2 border capitalize">{{ $user->type }}</td>
                                    <td class="px-4 py-2 border">
                                        @if ($user->is_blocked == 0)
                                            <span
                                                class="px-2 py-1 text-xs bg-green-200 text-green-800 rounded">Active</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs bg-red-200 text-red-800 rounded">Blocked</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">
                                        <form action="{{ route('admin.users.toggleStatus', $user->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-3 py-1 rounded text-white
                                                    {{ $user->is_blocked == 0 ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}">
                                                {{ $user->is_blocked == 0 ? 'Block' : 'Unblock' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
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
