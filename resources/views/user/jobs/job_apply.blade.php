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

    <!-- ✅ Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Your Custom CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/css/main.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #resumeDropzone .dz-preview {
            @apply flex flex-col items-center mx-auto;
        }
    </style>
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
                        <a href="{{ route('saved.jobs') }}" class="text-dark position-relative">
                            <i class="bi bi-bookmark-fill fs-5"></i>
                            @if (session('saved_jobs_count', 0) > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ session('saved_jobs_count') }}
                                </span>
                            @endif
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <main>
        <div class="container mx-auto p-4 max-w-xl">
            <h1 class="text-xl font-bold mb-4">Apply for Job</h1>

            @if (session('success'))
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: "{{ session('success') }}",
                            confirmButtonColor: "#3085d6"
                        });
                    });
                </script>
            @endif

            @if ($errors->any())
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            html: `{!! implode('<br>', $errors->all()) !!}`,
                            confirmButtonColor: "#d33"
                        });
                    });
                </script>
            @endif


            <form id="applicationForm" action="{{ route('user.jobs.submit.application', ['job' => $job->id]) }}"
                method="POST">
                @csrf
                <input type="hidden" name="job_id" value="{{ $job->id }}" />
                <input type="hidden" name="resume_path" id="resume_path" required />

                <!-- Dropzone area -->
                <label class="block mb-2">Upload Resume (PDF, DOC, DOCX):</label>
                <div class="dropzone flex justify-center items-center min-h-[150px]" id="resumeDropzone"></div>


                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Submit
                    Application</button>
            </form>
        </div>
    </main>
    <footer class="mt-48">
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
    <link href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        Dropzone.autoDiscover = false;
        let resumeDropzone = new Dropzone("#resumeDropzone", {
            url: "{{ route('user.jobs.upload.resume') }}",
            maxFiles: 1,
            acceptedFiles: ".pdf,.doc,.docx",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(file, response) {
                document.getElementById('resume_path').value = response.path;
            },
            removedfile: function(file) {
                document.getElementById('resume_path').value = '';
                file.previewElement.remove();
            }
        });
    </script>
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "{{ session('success') }}",
                    confirmButtonColor: "#3085d6"
                });

                // prevent popup on back button
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
            });
        </script>
    @endif
    <script>
        document.getElementById("applicationForm").addEventListener("submit", function(e) {
            e.preventDefault();
            let form = this;
            let resumePath = document.getElementById("resume_path").value;

            if (!resumePath) {
                Swal.fire({
                    icon: "warning",
                    title: "Resume Required",
                    text: "Please upload your resume before submitting the application.",
                    confirmButtonColor: "#d33"
                });
                return; // Stop form submission
            }

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to submit this job application?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, submit"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
