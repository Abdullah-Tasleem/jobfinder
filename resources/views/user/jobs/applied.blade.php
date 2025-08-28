<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Applied Jobs') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($appliedJobs->count())
                <div class="grid gap-4">
                    @foreach ($appliedJobs as $application)
                        <div class="p-4 border rounded-lg shadow-sm bg-white flex justify-between items-center">
                            <div>
                                <span
                                    class="inline-flex items-center rounded-md bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-200">
                                    Applied
                                </span>
                                <h3 class="text-lg font-semibold">
                                    {{ $application->jobPost->job_title ?? 'N/A' }}
                                </h3>
                                <p class="text-gray-600">
                                    Company: {{ $application->jobPost->company->company_name ?? 'N/A' }}
                                </p>
                                <p class="text-gray-500 text-sm">
                                    Applied on: {{ $application->created_at->format('M d, Y') }}
                                </p>
                            </div>

                            <!-- Withdraw Button -->
                            <button class="withdraw-btn bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700"
                                data-job-id="{{ $application->id }}">
                                Withdraw
                            </button>
                        </div>
                    @endforeach

                    <!-- Withdraw Modal -->
                    <div id="withdrawModal"
                        class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden items-center justify-center z-50">
                        <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
                            <form id="withdrawForm" class="space-y-4">
                                @csrf
                                <input type="hidden" name="job_id" id="withdrawJobId">

                                <h2 class="text-xl font-bold text-gray-800">Withdraw Application</h2>
                                <p class="text-gray-600">Please tell us why you are withdrawing:</p>

                                <div class="space-y-2">
                                    @foreach ($withdrawReasons as $reason)
                                        <label class="flex items-center space-x-2">
                                            <input type="radio" name="reason_id" value="{{ $reason->id }}"
                                                class="text-red-600" required>
                                            <span>{{ $reason->reason }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="flex justify-end space-x-3 pt-4">
                                    <button type="button" id="cancelWithdraw"
                                        class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                        Confirm Withdraw
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-gray-500">You have not applied to any jobs yet.</p>
            @endif
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const withdrawButtons = document.querySelectorAll('.withdraw-btn');
                const withdrawModal = document.getElementById('withdrawModal');
                const jobIdInput = document.getElementById('withdrawJobId');
                const cancelWithdraw = document.getElementById('cancelWithdraw');
                const withdrawForm = document.getElementById('withdrawForm');

                // Show modal
                withdrawButtons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        jobIdInput.value = this.dataset.jobId;
                        withdrawModal.classList.remove('hidden');
                        withdrawModal.classList.add('flex');
                    });
                });

                // Hide modal
                cancelWithdraw.addEventListener('click', () => {
                    withdrawModal.classList.add('hidden');
                    withdrawModal.classList.remove('flex');
                });

                // Submit form via fetch
                // inside withdrawForm submit
                withdrawForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    let formData = new FormData(this);
                    let jobId = jobIdInput.value; // hidden input se mil raha hai

                    let response = await fetch(`/applications/${jobId}/withdraw`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .content,
                            "Accept": "application/json"
                        },
                        body: formData
                    });

                    let result = await response.json();

                    if (result.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Application Withdrawn",
                            text: "Your application has been withdrawn successfully.",
                            confirmButtonColor: "#3085d6",
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong while withdrawing.",
                            confirmButtonColor: "#d33",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });

            });
        </script>
    @endpush
</x-app-layout>
