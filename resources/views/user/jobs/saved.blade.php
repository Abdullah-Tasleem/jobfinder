<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Saved Jobs') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse($savedJobs as $job)
                <div class="bg-white rounded shadow p-4 mb-4 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-lg">{{ $job->job_title }}</h3>
                        <p class="text-gray-600">{{ $job->company->company_name ?? 'No Company' }}</p>
                        <p class="text-sm text-gray-500">{{ $job->job_location }}</p>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Apply Job Button -->
                        <form action="{{ route('user.jobs.apply', ['job' => $job->id]) }}" method="GET" class="inline">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                Apply Now
                            </button>
                        </form>

                        <!-- Save/Unsave Job Icon -->
                        <i class="bi {{ auth()->user()->savedJobs->contains($job->id) ? 'bi-bookmark-fill text-blue-600' : 'bi-bookmark' }}
                            cursor-pointer save-job-icon text-2xl"
                            data-id="{{ $job->id }}" title="Save / Unsave Job"></i>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">You haven't saved any jobs yet.</p>
            @endforelse
        </div>
    </div>

    <!-- JS to handle save/unsave toggle (use your existing JS or add this) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.save-job-icon').forEach(icon => {
                icon.addEventListener('click', () => {
                    const jobId = icon.dataset.id;
                    fetch(`/jobs/${jobId}/save`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        }).then(res => res.json())
                        .then(data => {
                            if (data.status === 'saved') {
                                icon.classList.remove('bi-bookmark');
                                icon.classList.add('bi-bookmark-fill', 'text-blue-600');
                            } else {
                                icon.classList.remove('bi-bookmark-fill', 'text-blue-600');
                                icon.classList.add('bi-bookmark');
                            }
                        });
                });
            });
        });
    </script>

</x-app-layout>
