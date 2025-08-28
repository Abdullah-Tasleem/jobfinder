<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Job Finder</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- ✅ Only Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body style="font-family: 'Poppins', sans-serif;">
    <nav class="bg-white border-b px-4 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Left: Logo + Home -->
            <a class="flex items-center" href="{{ route('home') }}">
                <img src="{{ asset('design.png') }}" alt="Logo" class="h-5 w-10 mr-2" />
                <span class="font-bold text-lg">Home</span>
            </a>

            <!-- Right: Links -->
            <div class="flex items-center gap-2 ml-auto pr-3">
                @guest
                    <a class="border border-gray-800 text-gray-800 rounded px-4 py-1 text-sm hover:bg-gray-100 transition"
                        href="{{ route('login') }}">
                        Sign In
                    </a>
                    <a class="bg-blue-600 text-white rounded px-4 py-1 text-sm hover:bg-blue-700 transition"
                        href="{{ route('company.registerform') }}">
                        Company / Post Job
                    </a>
                @endguest

                @auth
                    @if (auth()->user()->type === 'user')
                        <a href="{{ route('saved.jobs') }}" class="relative text-gray-800 pr-3">
                            <i class="bi bi-bookmark-fill text-xl"></i>
                            @if (session('saved_jobs_count', 0) > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full px-2 py-0.5 text-xs">
                                    {{ session('saved_jobs_count') }}
                                </span>
                            @endif
                        </a>
                    @endif

                    <a href="{{ route('profile.edit') }}">
                        <i class="fa-solid fa-user text-xl"></i>
                    </a>
                @endauth
            </div>
        </div>
    </nav>
    <main>
        <div class="container mx-auto p-4 max-w-xl">
            <h1 class="text-xl font-bold mb-4">Apply for Job</h1>
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
    <footer class="bg-gray-100 border-t border-gray-300 mt-60">
        <div class="max-w-7xl mx-auto py-6 px-4 flex flex-wrap justify-between items-center text-sm">
            <div class="flex flex-col sm:flex-row flex-wrap gap-2 sm:gap-4 mb-2">
                <a href="#" class="text-gray-800 hover:underline mr-4">Browse Jobs</a>
                <a href="#" class="text-gray-800 hover:underline mr-4">Browse Companies</a>
                <a href="#" class="text-gray-800 hover:underline mr-4">Countries</a>
                <a href="#" class="text-gray-800 hover:underline mr-4">About</a>
                <a href="#" class="text-gray-800 hover:underline mr-4">Help</a>
                <a href="#" class="text-gray-800 hover:underline mr-4">ESG at Job Verse</a>
            </div>
            <div class="flex gap-4">
                <a href="#" class="text-gray-800 hover:underline">© 2025 Job Verse</a>
                <a href="#" class="text-gray-800 hover:underline">Privacy Center</a>
                <a href="#" class="text-gray-800 hover:underline">Terms</a>
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
