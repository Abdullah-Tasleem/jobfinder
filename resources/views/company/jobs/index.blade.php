<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold">My Jobs</h1>
            <a href="{{ route('company.jobs.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Create Job
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6">

        @if ($jobs->count())
            <table class="min-w-full bg-white border text-center">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Title</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Type</th>
                        <th class="border px-4 py-2">Salary Range</th>
                        <th class="border px-4 py-2">Industry</th>
                        <th class="border px-4 py-2">Actions</th>
                        <th class="border px-4 py-2">Change Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td class="border px-4 py-2">{{ $job->job_title }}</td>
                            <td class="border px-4 py-2 capitalize">{{ $job->job_status }}</td>
                            <td class="border px-4 py-2 capitalize">{{ $job->job_type }}</td>
                            <td class="border px-4 py-2">{{ $job->salary_start ?? 'N/A' }} Pkr -
                                {{ $job->salary_end ?? 'N/A' }} Pkr</td>
                            <td class="border px-4 py-2">{{ $job->industry->name ?? 'N/A' }}</td>
                            <td class="border px-4 py-2 space-x-2">
                                <a href="{{ route('company.jobs.edit', $job->id) }}"
                                    class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                    Edit
                                </a>
                            </td>
                            <td class="border px-4 py-2">
                                <form action="{{ route('company.jobs.updateStatus', $job->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="job_status" onchange="this.form.submit()"
                                        class="border rounded px-2 py-1 capitalize">
                                        @foreach (['draft','inactive', 'filled', 'expired',] as $status)
                                            <option value="{{ $status }}"
                                                {{ $job->job_status === $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $jobs->links() }}
            </div>
        @else
            <p>No jobs posted yet.</p>
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
