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
                                <th class="px-4 py-2 border">Change Status</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs as $job)
                                <tr class="text-center">
                                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border">{{ $job->job_title }}</td>
                                    <td class="px-4 py-2 border">{{ $job->company->company_name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border">
                                        @switch($job->job_status)
                                            @case('inactive')
                                                <span
                                                    class="px-2 py-1 text-xs bg-yellow-200 text-yellow-800 rounded">Inactive</span>
                                            @break

                                            @case('active')
                                                <span
                                                    class="px-2 py-1 text-xs bg-green-200 text-green-800 rounded">Active</span>
                                            @break

                                            @case('pending')
                                                <span
                                                    class="px-2 py-1 text-xs bg-violet-200 text-violet-800 rounded">Pending</span>
                                            @break

                                            @case('expired')
                                                <span class="px-2 py-1 text-xs bg-red-200 text-red-800 rounded">Expired</span>
                                            @break

                                            @default
                                                <span class="px-2 py-1 text-xs bg-gray-300 text-gray-900 rounded">Unknown</span>
                                        @endswitch
                                    </td>
                                    <td class="border px-4 py-2">
                                        <form action="{{ route('admin.jobs.updateStatus', $job->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="job_status" onchange="this.form.submit()"
                                                class="border rounded px-2 py-1 capitalize text-sm focus:ring-indigo-500 focus:border-indigo-500">

                                                @foreach (['draft', 'inactive', 'active', 'filled', 'expired'] as $status)
                                                    <option value="{{ $status }}"
                                                        {{ $job->job_status === $status ? 'selected' : '' }}>
                                                        {{ ucfirst($status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-4 py-2 border flex justify-center gap-2">
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
                    <div class="mt-4">
                        {{ $jobs->links() }}
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
