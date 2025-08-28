<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold">Add Reason</h1>
            <a href="{{ route('admin.withdraw-reasons.index') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                ← Back
            </a>
        </div>
    </x-slot>
    <div class="max-w-3xl mx-auto p-6 mt-6 bg-white rounded shadow">
        <form action="{{ route('admin.withdraw-reasons.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700">Reason</label>
                <input type="text" name="reason" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-gray-700">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </form>
    </div>
</x-app-layout>
