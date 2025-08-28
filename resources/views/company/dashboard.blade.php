<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @auth
        @if (auth()->user()->type === 'company')
            <div class="py-4">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Left Side: Company Job List --}}
                        <div class="bg-white rounded shadow p-4">
                            <h3 class="text-lg font-bold mb-4">My Job Posts</h3>
                            @forelse($myJobs as $job)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-lg hover:border-blue-400 transition duration-200 mb-4 cursor-pointer job-item"
                                    data-id="{{ $job->id }}">
                                    <h4 class="font-semibold text-gray-800 text-lg">{{ $job->job_title }}</h4>
                                    <h6 class=" text-gray-800">{{ $job->company->company_name ?? 'No Company' }}</h6>
                                    <p class="text-sm text-gray-600">{{ $job->job_location }}</p>
                                    @if ($job->salary_start && $job->salary_end)
                                        <div
                                            class="inline-flex items-center gap-1 text-sm text-green-800 mt-1 px-4 bg-emerald-100 py-2 rounded">
                                            <span class="font-bold">Rs</span>
                                            <span class="font-bold">{{ number_format($job->salary_start) }}</span> -
                                            <span class="font-bold">{{ number_format($job->salary_end) }}</span>
                                            <span class="font-bold">a month</span>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">You haven't posted any jobs yet.</p>
                            @endforelse
                        </div>

                        {{-- Right Side: Latest Job Details --}}
                        <div class="sticky top-4 self-start">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm flex flex-col
                                    max-h-[calc(100vh-2rem)] overflow-y-auto"
                                id="job-details">
                                @if ($latestJob)
                                    <div class="my-3">
                                        <h3 class="text-2xl font-bold mb-2">{{ $latestJob->job_title }}</h3>
                                        <h6 class="text-gray-800">
                                            @if ($latestJob->company->company_website)
                                                @php
                                                    $url = $latestJob->company->company_website;
                                                    $host = parse_url($url, PHP_URL_HOST);
                                                    $host = preg_replace('/^www\./', '', $host);
                                                    $host = preg_replace('/\.[a-z]+$/', '', $host);
                                                @endphp
                                                <a href="{{ $url }}" target="_blank"
                                                    class="text-blue-600 hover:underline">
                                                    {{ $host }} <i class="bi bi-box-arrow-up-right"></i>
                                                </a>
                                            @endif
                                        </h6>
                                        <h4 class="text-lg text-gray-800 mb-2">
                                            {{ ucfirst($latestJob->company->country) }}
                                        </h4>

                                        @if ($latestJob->salary_start && $latestJob->salary_end)
                                            <div
                                                class="inline-flex items-center gap-1 text-sm text-green-800 mt-1 px-4 bg-emerald-100 py-2 rounded">
                                                <span class="font-bold">Rs</span>
                                                <span
                                                    class="font-bold">{{ number_format($latestJob->salary_start) }}</span>
                                                -
                                                <span class="font-bold">{{ number_format($latestJob->salary_end) }}</span>
                                                <span class="font-bold">a month</span>
                                            </div>
                                        @endif

                                        <div
                                            class="inline-flex items-center gap-1 text-sm text-gray-700 mt-1 px-4 py-2 rounded bg-blue-100">
                                            <i class="bi bi-briefcase-fill text-blue-600"></i>
                                            <span class="font-medium">Job Type:</span>
                                            {{ $latestJob->job_type }}
                                        </div>
                                    </div>
                                    <hr class="my-4 border-t bg-black" />


                                    <div class="overflow-y-auto" style="max-height: 350px;">
                                        <div class="my-6">
                                            <h2 class="font-semibold text-2xl">Location</h2>
                                            <div class="flex items-center text-gray-600 mt-3">
                                                <i class="bi bi-geo-alt mr-2 text-lg"></i>
                                                {{ $latestJob->job_location }}
                                            </div>
                                        </div>

                                                                            <hr class="my-4 border-t bg-black" />

                                        <div class="mb-4 leading-loose line">
                                            <h2 class="font-semibold text-lg mb-1">Full Job description</h2>
                                            {!! $latestJob->job_description !!}
                                        </div>
                                    </div>
                                @else
                                    <p>No open jobs available.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (auth()->user()->type === 'admin')
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            You're logged in as an Admin!
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const jobItems = document.querySelectorAll('.job-item');
                const detailsContainer = document.querySelector('#job-details');

                jobItems.forEach(item => {
                    item.addEventListener('click', async function() {
                        const jobId = this.dataset.id;

                        // Highlight the selected job
                        jobItems.forEach(j => j.classList.remove('bg-blue-100'));
                        this.classList.add('bg-blue-100');

                        // STEP 1: Show Skeleton Loader (Tailwind-aligned)
                        detailsContainer.innerHTML = `
        <div class="p-6">
          <div class="animate-pulse space-y-16">

            <!-- Job Title -->
            <div class="h-7 w-2/3 bg-gray-300 rounded"></div>

            <!-- Company + Country -->
            <div class="space-y-2">
              <div class="h-5 w-1/3 bg-gray-300 rounded"></div>
              <div class="h-4 w-1/4 bg-gray-300 rounded"></div>
            </div>

            <!-- Salary + Job Type badges -->
            <div class="flex gap-3">
              <div class="h-6 w-32 bg-gray-300 rounded-full"></div>
              <div class="h-6 w-24 bg-gray-300 rounded-full"></div>
            </div>

            <hr class="my-4 border-t bg-black" />


            <!-- Location -->
            <div>
              <div class="h-5 w-24 bg-gray-300 rounded mb-2"></div>
              <div class="h-4 w-1/2 bg-gray-300 rounded"></div>
            </div>

                                    <hr class="my-4 border-t bg-black" />

            <!-- Job Description -->
            <div>
              <div class="h-5 w-40 bg-gray-300 rounded mb-3"></div>
              <div class="space-y-2">
                <div class="h-3 w-full bg-gray-300 rounded"></div>
                <div class="h-3 w-11/12 bg-gray-300 rounded"></div>
                <div class="h-3 w-10/12 bg-gray-300 rounded"></div>
                <div class="h-3 w-2/3 bg-gray-300 rounded"></div>
              </div>
            </div>
          </div>
        </div>
      `;

                        try {
                            // STEP 2: Fetch job details
                            const response = await fetch(`/company/jobs/${jobId}/ajax`);
                            if (!response.ok) throw new Error(
                                `Server responded with ${response.status}`);
                            const data = await response.json();

                            // STEP 3: Render with the same Tailwind look as the Blade view
                            detailsContainer.innerHTML = `
          <!-- Job header & apply button -->
          <div class="mb-4">
            <h3 class="text-2xl font-bold mb-2">${data.title}</h3>

            ${
              data.company_website
                ? `
                                          <h6 class="text-gray-800">
                                            <a href="${data.company_website}" target="_blank" class="text-blue-600 hover:underline">
                                              ${data.company_name} <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                          </h6>
                                        `
                : ''
            }

            <h4 class="text-lg text-gray-800 mb-2">${(data.country || '').charAt(0).toUpperCase()}${(data.country || '').slice(1)}</h4>

            ${
              data.salary_start && data.salary_end
                ? `
                                          <div class="inline-flex items-center gap-1 text-sm text-green-800 mt-1 px-4 bg-emerald-100 py-2 rounded">
                                            <span class="font-bold">Rs</span>
                                            <span class="font-bold">${data.salary_start}</span>
                                            -
                                            <span class="font-bold">${data.salary_end}</span>
                                            <span class="font-bold">a month</span>
                                          </div>
                                        `
                : ''
            }

            <div class="inline-flex items-center gap-1 text-sm text-gray-700 mt-1 px-4 py-2 rounded bg-blue-100">
              <i class="bi bi-briefcase-fill text-blue-600"></i>
              <span class="font-medium">Job Type:</span>
              ${data.job_type || ''}
            </div>
          </div>

                      <hr class="my-4 border-t bg-black" />


          <!-- Scrollable content grows dynamically -->
          <div class="overflow-y-auto flex-1">
            <div class="mb-6">
              <h2 class="font-semibold text-2xl">Location</h2>
              <div class="flex items-center text-gray-600 mt-3">
                <i class="bi bi-geo-alt mr-2 text-lg"></i>
                ${data.job_location || ''}
              </div>
            </div>

                        <hr class="my-4 border-t bg-black" />


            <div class="mb-4 leading-loose">
              <h2 class="font-semibold text-lg mb-1">Full Job Description</h2>
              ${data.job_description || ''}
            </div>
          </div>
        `;
                        } catch (error) {
                            console.error('Error loading job:', error);
                            detailsContainer.innerHTML = `
          <div class="p-4 bg-red-100 text-red-700 rounded">
            Failed to load job details. Please try again later.
          </div>
        `;
                        }
                    });
                });
            });
        </script>
    @endpush

</x-app-layout>
