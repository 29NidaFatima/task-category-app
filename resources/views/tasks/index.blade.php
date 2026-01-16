<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            Task Management
        </h2>
    </x-slot>

    <div class="p-6 max-w-5xl mx-auto space-y-8">

        <!-- Add Task Form -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Add Task</h3>

            <form method="POST" action="{{ route('tasks.store') }}" class="space-y-4">
                @csrf

                <input
                    type="text"
                    name="title"
                    placeholder="Task title"
                    required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                >

                <textarea
                    name="description"
                    placeholder="Task description"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                ></textarea>

                <select
                    name="category_id"
                    required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                >
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    Add Task
                </button>
            </form>
        </div>

        <!-- Task List -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Your Tasks</h3>

            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3 border">Title</th>
                        <th class="p-3 border">Category</th>
                        <th class="p-3 border">Status</th>
                        <th class="p-3 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">{{ $task->title }}</td>
                            <td class="p-3 border">{{ $task->category->name }}</td>
                            <td class="p-3 border">
                                @if ($task->status === 'completed')
                                    <span class="text-green-600 font-semibold"> Completed</span>
                                @else
                                    <span class="text-yellow-600 font-semibold"> Pending</span>
                                @endif
                            </td>
                            <td class="p-3 border">
                                <div class="flex gap-2">

                                    <!-- EDIT -->
                                    <a
                                        href="{{ route('tasks.edit', $task) }}"
                                        class="text-blue-600 hover:underline"
                                    >
                                        Edit
                                    </a>

                                    <!-- STATUS TOGGLE -->
                                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="title" value="{{ $task->title }}">
                                        <input type="hidden" name="description" value="{{ $task->description }}">
                                        <input type="hidden" name="category_id" value="{{ $task->category_id }}">
                                        <input type="hidden" name="status"
                                               value="{{ $task->status === 'pending' ? 'completed' : 'pending' }}">

                                        <button
                                            type="submit"
                                            class="text-sm bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"
                                        >
                                            {{ $task->status === 'pending' ? 'Mark Done' : 'Undo' }}
                                        </button>
                                    </form>

                                    <!-- DELETE -->
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            onclick="return confirm('Delete task?')"
                                            class="text-sm bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                        >
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if ($tasks->count() === 0)
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                No tasks found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
