<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold">Edit Job</h2>
            <a href="{{ route('company.jobs.index') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Back
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow my-6">
        <form action="{{ route('company.jobs.update', $job->id) }}" method="POST" class="space-y-4"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif


            {{-- Job Title --}}
            <div>
                <label for="job_title" class="block font-medium">Job Title</label>
                <input type="text" name="job_title" id="job_title" value="{{ old('job_title', $job->job_title) }}"
                    class="w-full border rounded px-3 py-2" placeholder="Job Title">
            </div>

            {{-- Job Type --}}
            <div>
                <label for="job_type" class="block font-medium">Job Type</label>
                <select name="job_type" id="job_type" class="w-full border rounded px-3 py-2">
                    <option value="hybrid" {{ old('job_type', $job->job_type) == 'hybrid' ? 'selected' : '' }}>Hybrid
                    </option>
                    <option value="on-site" {{ old('job_type', $job->job_type) == 'on-site' ? 'selected' : '' }}>On Site
                    </option>
                    <option value="remote" {{ old('job_type', $job->job_type) == 'remote' ? 'selected' : '' }}>Remote
                    </option>
                </select>
            </div>

            {{-- Salary --}}
            <div class="flex space-x-4">
                <div class="flex-1">
                    <label for="salary_start" class="block font-medium">Start Salary</label>
                    <input type="number" name="salary_start" id="salary_start"
                        value="{{ old('salary_start', $job->salary_start) }}" placeholder="e.g. 25000"
                        class="w-full border rounded px-3 py-2">
                </div>
                <div class="flex-1">
                    <label for="salary_end" class="block font-medium">End Salary</label>
                    <input type="number" name="salary_end" id="salary_end"
                        value="{{ old('salary_end', $job->salary_end) }}" placeholder="e.g. 50000"
                        class="w-full border rounded px-3 py-2">
                </div>
            </div>

            {{-- Job Description --}}
            <div>
                <label for="job_description" class="block font-medium">Job Description</label>
                <textarea name="job_description" id="job_description" rows="4" class="w-full border rounded px-3 py-2">{{ old('job_description', $job->job_description) }}</textarea>
            </div>

            {{-- Job Location --}}
            <div>
                <label for="job_location" class="block font-medium">Job Location</label>
                <input type="text" name="job_location" id="job_location"
                    value="{{ old('job_location', $job->job_location) }}" class="w-full border rounded px-3 py-2"
                    placeholder="e.g. Karachi, Pakistan" required>
            </div>

            {{-- Job Timing --}}
            <div>
                <label class="block font-medium">Job Timing</label>
                <div class="flex space-x-2">
                    <input type="time" name="job_start_time"
                        value="{{ old('job_start_time', \Carbon\Carbon::parse($job->job_start_time)->format('H:i')) }}"
                        class="border rounded px-3 py-2" required>
                    <span class="self-center">to</span>
                    <input type="time" name="job_end_time"
                        value="{{ old('job_end_time', \Carbon\Carbon::parse($job->job_end_time)->format('H:i')) }}"
                        class="border rounded px-3 py-2" required>
                </div>
            </div>

            {{-- Job Skills --}}
            @php
                $selectedSkills = old('job_skills', $job->job_skills ?? []);
            @endphp

            <div class="mb-3">
                <label for="job_skills">Job skills</label>
                <select name="job_skills[]" id="job_skills" class="w-full border rounded px-3 py-2" multiple>
                    @foreach ($skills as $id => $name)
                        <option value="{{ $id }}" {{ in_array($id, $selectedSkills) ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Industry --}}
            <div>
                <label for="industry_id" class="block font-medium">Industry</label>
                <select name="industry_id" id="industry_id" class="w-full border rounded px-3 py-2">
                    <option value="">Select an industry</option>
                    @foreach ($industries as $industry)
                        <option value="{{ $industry->id }}"
                            {{ old('industry_id', $job->industry_id) == $industry->id ? 'selected' : '' }}>
                            {{ $industry->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Expiration Date --}}
            <div>
                <label for="expires_at" class="block font-medium">Expires At</label>
                <input type="date" name="expires_at" id="expires_at"
                    value="{{ old('expires_at', optional($job->expires_at)->format('Y-m-d')) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- Submit --}}
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Update Job
            </button>
        </form>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if ($errors->any())
                document.addEventListener('DOMContentLoaded', function() {
                    let errors = @json($errors->all());
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errors.join('<br>'),
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                });
        </script>
        @endif

        </script>

        {{-- TinyMCE --}}
        <script src="https://cdn.tiny.cloud/1/q7713k7rim7e35m6va2uiuexqf9ra7u16iwqv4wezqv2qbnd/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#job_description',
                height: 300,
                plugins: 'link code table lists advlist autolink charmap preview anchor pagebreak searchreplace wordcount visualblocks fullscreen insertdatetime emoticons help',
                toolbar: 'undo redo | formatselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | code preview',
                menubar: false,
                relative_urls: false,
                convert_urls: false
            });
        </script>

        {{-- Select2 --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#job_skills').select2({
                    placeholder: "Select skills",
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>
    @endpush
</x-app-layout>
