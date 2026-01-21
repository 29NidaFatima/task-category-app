<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">
                Archived Tasks
            </h2>

            <a href="{{ route('tasks.index') }}"
               class="text-sm text-blue-600 hover:underline">
                ← Back to Active Tasks
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-5xl mx-auto">

        <div class="bg-white shadow rounded-lg p-6">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3 border">Title</th>
                        <th class="p-3 border">Category</th>
                        <th class="p-3 border">Status</th>
                        <th class="p-3 border">Priority</th>
                        <th class="p-3 border">Archived On</th>
                        <th class="p-3 border">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tasks as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">{{ $task->title }}</td>
                            <td class="p-3 border">{{ $task->category->name }}</td>
                            <td class="p-3 border capitalize font-semibold">{{ $task->status }}</td>
                            <td class="p-3 border capitalize font-semibold">{{ $task->priority }}</td>
                            <td class="p-3 border text-sm text-gray-600">
                                {{ $task->archived_at->format('d M Y') }}
                            </td>

                            <td class="p-3 border">
                                <div class="flex gap-2 flex-wrap">

                                    <!-- Restore -->
                                    <form method="POST" action="{{ route('tasks.unarchive', $task) }}">
                                        @csrf
                                        <button class="text-sm bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                            Restore
                                        </button>
                                    </form>

                                    <!-- Permanent Delete -->
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete permanently?')"
                                                class="text-sm bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">
                                No archived tasks found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
