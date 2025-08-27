<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Job Finder</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/css/main.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom px-4 py-2">
        <div class="container-fluid">
            <!-- Left: Logo + Home -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('design.png') }}" alt="Logo" height="20" width="40" class="me-2">
                <p class="mb-0">Home</p>
            </a>

            <!-- Right: Links -->
            <div class="ms-auto d-flex align-items-center gap-2 pe-3">
                @guest
                    <a class="btn btn-outline-dark btn-sm px-4" href="{{ route('login') }}">
                        Sign In
                    </a>

                    <a class="btn btn-primary btn-sm px-4 text-white" href="{{ route('company.registerform') }}">
                        Company / Post Job
                    </a>
                @endguest
                @auth
                    @if (auth()->user()->type === 'user')
                        <a href="{{ route('saved.jobs') }}" class="text-dark position-relative pe-3">
                            <i class="bi bi-bookmark-fill fs-5 "></i>
                            @if (session('saved_jobs_count', 0) > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ session('saved_jobs_count') }}
                                </span>
                            @endif
                        </a>
                    @endif
                @endauth
                <a href="profile">
                    <i class="fa-solid fa-user fs-5 "></i>
                </a>
            </div>
        </div>
    </nav>

    <main>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form id="jobSearchForm" action="{{ route('jobs.search') }}" method="GET">
                        <div
                            class="bg-white p-4 rounded shadow d-flex flex-column flex-md-row align-items-stretch gap-3">
                            <!-- Keyword / Company -->
                            <div class="flex-fill">
                                <label class="form-label visually-hidden" for="keyword">Keyword</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" id="keyword" name="keyword" class="form-control"
                                        placeholder="Job title, keywords, or company">
                                </div>
                            </div>
                            <!-- Location -->
                            <div class="flex-fill">
                                <label class="form-label visually-hidden" for="location">Location</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>
                                    <input type="text" id="location" name="location" class="form-control"
                                        placeholder="City or postcode">
                                </div>
                            </div>

                            <!-- Search Button -->
                            <div>
                                <button type="submit" class="btn btn-primary px-4 py-2 w-100">
                                    Find Jobs
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if (session('success'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "{{ session('success') }}",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                });
            </script>
        @endif


        @if (auth()->user())
            <div class="py-4">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Left Side: Company Job List --}}
                        <div class="bg-white rounded shadow p-4">
                            <h3 class="text-lg font-bold mb-4">Jobs for you</h3>
                            @forelse($jobs as $job)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-lg hover:border-blue-400 transition duration-200 mb-4 cursor-pointer job-item"
                                    data-id="{{ $job->id }}">
                                    <div class="flex justify-between items-center">
                                        <h4 class="font-semibold text-gray-800 text-lg">{{ $job->job_title }}</h4>
                                        @auth
                                            @if (auth()->user()->type === 'user')
                                                <i class="bi {{ auth()->user()->savedJobs->contains($job->id) ? 'bi-bookmark-fill text-blue-600' : 'bi-bookmark' }}
                                                    cursor-pointer save-job"
                                                    data-id="{{ $job->id }}" style="font-size: 1.5rem;"></i>
                                            @endif
                                        @endauth
                                    </div>
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
                                    <div class="flex items-center space-x-2 space-y-2">
                                        <i class="fa-solid fa-rocket text-blue-500 pt-2"></i>
                                        <p class="">
                                            Easy apply
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">You haven't posted any jobs yet.</p>
                            @endforelse
                        </div>

                        {{-- Right Side: Latest Job Details --}}
                        <div class="sticky top-4 self-start">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm flex flex-col
                                    max-h-[calc(100vh-2rem)] overflow-y-auto"
                                id="job-details" style="max-height: calc(100vh - 2rem); overflow-y: auto;">
                                @if ($latestJob)

                                    <!-- Job header & apply button -->
                                    <div class="mb-4">
                                        <h3 class="text-2xl font-bold mb-2">{{ $latestJob->job_title }}</h3>
                                        @if ($latestJob->company->company_website)
                                            @php
                                                $url = $latestJob->company->company_website;
                                                $host = parse_url($url, PHP_URL_HOST);
                                                $host = preg_replace('/^www\./', '', $host);
                                                $host = preg_replace('/\.[a-z]+$/', '', $host);
                                            @endphp
                                            <h6 class="text-gray-800">
                                                <a href="{{ $url }}" target="_blank"
                                                    class="text-blue-600 hover:underline">
                                                    {{ $host }} <i class="bi bi-box-arrow-up-right"></i>
                                                </a>
                                            </h6>
                                        @endif
                                        <h4 class="text-lg text-gray-800 mb-2">
                                            {{ ucfirst($latestJob->company->country) }}</h4>

                                        @if ($latestJob->salary_start && $latestJob->salary_end)
                                            <div
                                                class="inline-flex items-center gap-1 text-sm text-green-800 mt-1 px-4 bg-emerald-100 py-2 rounded">
                                                <span class="font-bold">Rs</span>
                                                <span
                                                    class="font-bold">{{ number_format($latestJob->salary_start) }}</span>
                                                -
                                                <span
                                                    class="font-bold">{{ number_format($latestJob->salary_end) }}</span>
                                                <span class="font-bold">a month</span>
                                            </div>
                                        @endif

                                        <div
                                            class="inline-flex items-center gap-1 text-sm text-gray-700 mt-1 px-4 py-2 rounded bg-blue-100">
                                            <i class="bi bi-briefcase-fill text-blue-600"></i>
                                            <span class="font-medium">Job Type:</span>
                                            {{ $latestJob->job_type }}
                                        </div>

                                        @php
                                            $alreadyApplied = \App\Models\JobApplication::where('user_id', auth()->id())
                                                ->where('job_id', $latestJob->id)
                                                ->exists();
                                        @endphp
                                        <div class="flex items-center gap-4 mt-3">
                                            @auth
                                                @if (auth()->user()->type === 'user')
                                                    {{-- Apply Button --}}
                                                    @if ($alreadyApplied)
                                                        <button disabled
                                                            class="inline-flex items-center px-6 py-2 text-sm font-semibold text-white bg-gray-500 rounded-xl shadow-md cursor-not-allowed">
                                                            <i class="bi bi-check2-circle mr-2 text-lg"></i> Applied
                                                        </button>
                                                    @else
                                                        <button id="applyNowBtn"
                                                            data-url="{{ route('user.jobs.apply', ['job' => $latestJob->id]) }}"
                                                            class="apply-now-button inline-flex items-center px-6 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-md hover:from-blue-700 hover:to-blue-800 focus:ring-2 focus:ring-blue-400 focus:outline-none transition duration-200 ease-in-out">
                                                            <i class="bi bi-send-check-fill mr-2 text-lg"></i> Apply Now
                                                        </button>
                                                    @endif

                                                    {{-- Save Job Button --}}
                                                    <i class="bi {{ auth()->user()->savedJobs->contains($latestJob->id) ? 'bi-bookmark-fill text-blue-600' : 'bi-bookmark' }}
                                                        cursor-pointer save-job text-2xl pb-1"
                                                        data-id="{{ $latestJob->id }}"></i>
                                                @endif
                                            @endauth
                                        </div>

                                    </div>
                                    <hr class="my-4 border-none h-1 bg-black shadow-md" />


                                    <!-- Scrollable content grows dynamically -->
                                    <div class="overflow-y-auto flex-1">
                                        <div class="mb-6">
                                            <h2 class="font-semibold text-2xl">Location</h2>
                                            <div class="flex items-center text-gray-600 mt-3">
                                                <i class="bi bi-geo-alt mr-2 text-lg"></i>
                                                {{ $latestJob->job_location }}
                                            </div>
                                        </div>

                                        <hr class="my-4 border-none h-1 bg-black shadow-md" />

                                        <div class="mb-4 leading-loose">
                                            <h2 class="font-semibold text-lg mb-1">Full Job Description</h2>
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
        @else
            <section class="banner">
                <img src="{{ asset('build/assets/images/pexel.jpg') }}" alt="People Banner" class="img-fluid w-100">
            </section>
            <div class="text-center py-4 container">
                <h2 class="mb-3">Welcome to Job Verse!</h2>
                <p class="lead mb-4">Create an account or sign in to see your personalised job recommendations.</p>
                <a href="{{ route('register') }}" class="btn text-white mb-4 banner-btn py-2 px-5">Get Started <i
                        class="fa-solid fa-arrow-right"></i></a>

                <p class="text-muted">
                    <strong>Job Verse</strong> is a modern and user-friendly job portal designed to connect job seekers
                    with
                    employers in a seamless and efficient way. The platform allows users to explore thousands of job
                    listings,
                    create personalized profiles, and receive tailored job recommendations based on their skills and
                    interests.
                    Employers can easily post job openings, manage applications, and find the right candidates faster.
                    With
                    a
                    clean interface, secure authentication system, and responsive design, Job Verse aims to simplify the
                    job
                    search process for both individuals and organizations, making career opportunities more accessible
                    and
                    meaningful.
                </p>
            </div>
        @endif
    </main>

    <footer>
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center footer-links mb-2">
                <div>
                    <a href="#">Browse Jobs</a>
                    <a href="#">Browse Companies</a>
                    <a href="#">Countries</a>
                    <a href="#">About</a>
                    <a href="#">Help</a>
                    <a href="#">ESG at Job Verse</a>
                </div>
                <div>
                    <a href="#">© 2025 Job Verse</a>
                    <a href="#">Privacy Center</a>
                    <a href="#">Terms</a>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("jobSearchForm");
            const results = document.getElementById("job-results");
            const statusHeading = document.querySelector("#job-results h3");


            if (!form) return console.error("#jobSearchForm not found");
            if (!results) return console.error("#job-results not found");

            form.addEventListener("submit", async function(e) {
                e.preventDefault();

                if (statusHeading) statusHeading.textContent = "Searching...";

                const params = new URLSearchParams(new FormData(form)).toString();
                const url = `${form.action}?${params}`;

                try {
                    const res = await fetch(url, {
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    });
                    if (!res.ok) throw new Error(`${res.status} ${res.statusText}`);
                    const html = await res.text();
                    results.innerHTML = html;
                    if (statusHeading) statusHeading.textContent = "Jobs for you";
                } catch (err) {
                    console.error(err);
                    if (statusHeading) statusHeading.textContent = "Error loading jobs";
                }
            });
        });
    </script>
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

            <hr class="my-6 border-none h-1 bg-black shadow-md" />

            <!-- Location -->
            <div>
              <div class="h-5 w-24 bg-gray-300 rounded mb-2"></div>
              <div class="h-4 w-1/2 bg-gray-300 rounded"></div>
            </div>

            <hr class="my-4 border-none h-1 bg-black shadow-md" />

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
                        console.log("AJAX Response:", data);

                        // STEP 3: Render with the same Tailwind look as the Blade view
                        detailsContainer.innerHTML = `
  <!-- Job header & apply button -->
  <div class="mb-4">
    <h3 class="text-2xl font-bold mb-2">${data.title}</h3>

    ${data.company_website
        ? `
                                    <h6 class="text-gray-800">
                                      <a href="${data.company_website}" target="_blank" class="text-blue-600 hover:underline">
                                        ${data.company_name} <i class="bi bi-box-arrow-up-right"></i>
                                      </a>
                                    </h6>
                                  `
        : ''
    }

    <h4 class="text-lg text-gray-800 mb-2">${data.country ? data.country.charAt(0).toUpperCase() + data.country.slice(1) : ''}</h4>

    ${data.salary_start && data.salary_end
        ? `
                                    <div class="inline-flex items-center gap-1 text-sm text-green-800 mt-1 px-4 bg-emerald-100 py-2 rounded">
                                      <span class="font-bold">Rs</span>
                                    <span class="font-bold">${Number(data.salary_start).toLocaleString()}</span> -
                                    <span class="font-bold">${Number(data.salary_end).toLocaleString()}</span>
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

    <div class="flex items-center gap-4 mt-3">
  ${
    data.is_authenticated
      ? (
          (data.already_applied  || item.dataset.applied === "true")
            ? `
                        <button disabled
                          class="inline-flex items-center px-6 py-2 text-sm font-semibold text-white bg-gray-500 rounded-xl shadow-md cursor-not-allowed">
                          <i class="bi bi-check2-circle mr-2 text-lg"></i> Applied
                        </button>
                      `
            : `
                        <button data-url="${data.apply_url}"
                          class="apply-now-button inline-flex items-center px-6 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-md hover:from-blue-700 hover:to-blue-800 focus:ring-2 focus:ring-blue-400 focus:outline-none transition duration-200 ease-in-out">
                          <i class="bi bi-send-check-fill mr-2 text-lg"></i> Apply Now
                        </button>
                      `
        ) + `
                    <i class="bi ${data.is_saved ? 'bi-bookmark-fill text-blue-600' : 'bi-bookmark'}
                      cursor-pointer save-job text-2xl pb-1"
                      data-id="${data.id}"></i>
                  `
      : `<a href="/login" class="text-blue-600 hover:underline">Login to apply</a>`
  }
</div>


  </div>

  <hr class="my-6 border-none h-1 bg-black shadow-md" />

  <!-- Scrollable content grows dynamically -->
  <div class="overflow-y-auto flex-1">
    <div class="mb-6">
      <h2 class="font-semibold text-2xl">Location</h2>
      <div class="flex items-center text-gray-600 mt-3">
        <i class="bi bi-geo-alt mr-2 text-lg"></i>
        ${data.job_location || ''}
      </div>
    </div>

    <hr class="my-4 border-none h-1 bg-black shadow-md" />

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
        document.addEventListener('click', function(e) {
            if (e.target.closest('.apply-now-button')) {
                e.preventDefault();
                const btn = e.target.closest('.apply-now-button');
                const url = btn.dataset.url;
                window.location.href = url;
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.save-job').forEach(function(icon) {
                icon.addEventListener('click', function() {
                    let jobId = this.dataset.id;
                    let el = this;

                    fetch(`/jobs/${jobId}/save`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'saved') {
                                el.classList.remove('bi-bookmark');
                                el.classList.add('bi-bookmark-fill', 'text-blue-600');
                            } else {
                                el.classList.remove('bi-bookmark-fill', 'text-blue-600');
                                el.classList.add('bi-bookmark');
                            }
                        });
                });
            });
        });
    </script>
</body>

</html>
