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
                        <div class="p-4 border rounded-lg shadow-sm bg-white">
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
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">You have not applied to any jobs yet.</p>
            @endif
        </div>
    </div>
</x-app-layout>
