<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Job Applications</h1>
            <a href="{{ route('company.applications.index') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Back
            </a>
        </div>
    </x-slot>
    <div class="max-w-4xl mx-auto mt-6 px-4">

        {{-- Application Card --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">Applicant: {{ $application->user->name }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Email: {{ $application->user->email }}</p>

                <p class="text-gray-700 dark:text-gray-200"><strong>Applied for:</strong>
                    {{ $application->jobPost->job_title ?? '—' }}</p>
                <p class="text-gray-700 dark:text-gray-200"><strong>Applied at:</strong>
                    {{ $application->created_at->format('d M, Y h:i A') }}</p>

                @if ($application->resume)
                    <p class="mt-2">
                        <strong class="text-gray-800 dark:text-gray-100">Resume:</strong>
                        <a href="{{ route('company.applications.resume', $application->id) }}" target="_blank"
                            class="inline-flex items-center px-3 py-1 ml-2 text-sm font-medium text-indigo-600 bg-indigo-100 rounded-lg hover:bg-indigo-200">
                            Download / View
                        </a>
                    </p>
                @endif

                <p class="mt-4"><strong class="text-gray-800 dark:text-gray-100">Current status:</strong>
                    @if ($application->status == 'pending')
                        <span
                            class="ml-2 inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-200 text-gray-800">Pending</span>
                    @elseif($application->status == 'seen')
                        <span
                            class="ml-2 inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-200 text-blue-800">Seen</span>
                    @elseif($application->status == 'accepted')
                        <span
                            class="ml-2 inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-200 text-green-800">Accepted</span>
                    @elseif($application->status == 'rejected')
                        <span
                            class="ml-2 inline-flex px-2 py-1 text-xs font-medium rounded-full bg-red-200 text-red-800">Rejected</span>
                    @endif
                </p>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Update status</h3>
                <form action="{{ route('company.applications.update', $application->id) }}" method="POST"
                    class="flex flex-wrap gap-3">
                    @csrf
                    @method('PUT')

                    <select name="status"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="seen" {{ $application->status == 'seen' ? 'selected' : '' }}>Seen</option>
                        <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accept
                        </option>
                        <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Reject
                        </option>
                    </select>

                    <button
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Update
                    </button>
                </form>
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
