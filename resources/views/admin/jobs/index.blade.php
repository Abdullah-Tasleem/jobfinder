<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold">Manage Job Posts</h1>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Title</th>
                                <th class="px-4 py-2 border">Company</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs as $job)
                                <tr class="text-center">
                                    <td class="px-4 py-2 border">{{ $job->id }}</td>
                                    <td class="px-4 py-2 border">{{ $job->job_title }}</td>
                                    <td class="px-4 py-2 border">{{ $job->company->company_name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border">
                                        @if ($job->job_status == 'active')
                                            <span
                                                class="px-2 py-1 text-xs bg-green-200 text-green-800 rounded">Active</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs bg-yellow-200 text-yellow-800 rounded">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border flex justify-center gap-2">
                                        <!-- Toggle status -->
                                        <form action="{{ route('admin.jobs.toggleStatus', $job->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-3 py-1 rounded text-white
                                                    {{ $job->job_status == 'active' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }}">
                                                {{ $job->job_status == 'active' ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                        <!-- Delete -->
                                        <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

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
