<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Job Applications</h1>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

        {{-- Filter Form --}}
        <form method="GET" class="flex flex-wrap gap-3 mb-6">
            <input type="text" name="search" value="{{ request('search') }}"
                class="w-full sm:w-64 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                placeholder="Search applicant or job">

            <select name="status"
                class="w-full sm:w-48 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <option value="">All statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="seen" {{ request('status') == 'seen' ? 'selected' : '' }}>Seen</option>
                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <button
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Filter
            </button>
            <a href="{{ route('company.applications.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                Reset
            </a>
        </form>

        {{-- Applications Table --}}
        @if ($applications->count())
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-200">
                                Applicant</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-200">Job
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-200">
                                Applied</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-200">
                                Status</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600 dark:text-gray-200">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($applications as $app)
                            <tr class="{{ !$app->is_seen ? 'bg-yellow-50 dark:bg-yellow-900/30' : '' }}">
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-100">
                                    <div class="font-semibold">{{ $app->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $app->user->email }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                    {{ $app->jobPost->job_title ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $app->created_at->format('d M, Y h:i A') }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($app->status == 'pending')
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-gray-200 text-gray-800">Pending</span>
                                    @elseif($app->status == 'seen')
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-blue-200 text-blue-800">Seen</span>
                                    @elseif($app->status == 'accepted')
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-green-200 text-green-800">Accepted</span>
                                    @elseif($app->status == 'rejected')
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-red-200 text-red-800">Rejected</span>
                                    @endif

                                    @if (!$app->is_seen)
                                        <span
                                            class="ml-2 px-2 py-1 text-xs font-medium rounded-full bg-yellow-300 text-yellow-900">New</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('company.applications.show', $app->id) }}"
                                        class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow hover:bg-indigo-700">
                                        View
                                    </a>

                                    <form action="{{ route('company.applications.destroy', $app->id) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this application?');">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-red-600 rounded-lg shadow hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $applications->links() }}
            </div>
        @else
            <div class="rounded-lg bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3">
                No applications found.
            </div>
        @endif
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
