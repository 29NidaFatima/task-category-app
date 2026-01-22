<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">
                Task Management
            </h2>

            <a href="{{ route('tasks.archived') }}"
               class="text-sm text-blue-600 hover:underline">
                View Archived Tasks
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-5xl mx-auto space-y-8">

        <!-- ================= Add Task ================= -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Add Task</h3>

            <form method="POST" action="{{ route('tasks.store') }}" class="space-y-5">
                @csrf

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Task Title
                    </label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        required
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                    @error('title')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea
                        name="description"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">{{ old('description') }}</textarea>
                </div>

                <!-- Priority -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Priority
                    </label>
                    <select
                        name="priority"
                        required
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                        <option value="">Select Priority</option>
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority','medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                <!-- Due Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Due Date
                    </label>
                    <input
                        type="date"
                        name="due_date"
                        value="{{ old('due_date') }}"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Category
                    </label>
                    <select
                        name="category_id"
                        required
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- ================= Tags ================= -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tags
                    </label>

                    <div class="flex flex-wrap gap-3">
                        @forelse ($tags as $tag)
                            <label class="flex items-center gap-1 text-sm">
                                <input
                                    type="checkbox"
                                    name="tags[]"
                                    value="{{ $tag->id }}"
                                    {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                    class="rounded border-gray-300">
                                {{ $tag->name }}
                            </label>
                        @empty
                            <span class="text-sm text-gray-500">No tags available</span>
                        @endforelse
                    </div>
                </div>

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                    Add Task
                </button>
            </form>
        </div>

        <!-- ================= Task List ================= -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Your Tasks</h3>

            <!-- ================= Filter by Tag ================= -->
            <form method="GET" action="{{ route('tasks.index') }}"
                  class="mb-4 flex gap-3 items-center">

                <label class="text-sm font-medium text-gray-700">
                    Filter by Tag:
                </label>
<select
    name="tag_id"
    onchange="this.form.submit()"
    class="border border-gray-300 rounded-lg
           px-5 py-3
           text-base
           w-55
           bg-white
           shadow-sm
           focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400
           hover:border-blue-300 transition">

    <option value="">All Tags</option>

    @foreach ($tags as $tag)
        <option value="{{ $tag->id }}"
            {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
            {{ $tag->name }}
        </option>
    @endforeach
</select>

            </form>

            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3 border">Title</th>
                        <th class="p-3 border">Category</th>
                        <th class="p-3 border">Status</th>
                        <th class="p-3 border">Priority</th>
                        <th class="p-3 border">Tags</th>
                        <th class="p-3 border">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tasks as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">{{ $task->title }}</td>
                            <td class="p-3 border">{{ $task->category->name }}</td>

                            <td class="p-3 border">
                                <span class="{{ $task->status === 'completed' ? 'text-green-600' : 'text-yellow-600' }} font-semibold">
                                    {{ ucfirst($task->status) }}
                                </span>

                                @if ($task->isOverdue())
                                    <span class="ml-2 text-red-600 font-bold">Overdue</span>
                                @endif
                            </td>

                            <td class="p-3 border capitalize font-semibold">
                                {{ $task->priority }}
                            </td>

                            <td class="p-3 border">
                                @if ($task->tags->count())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($task->tags as $tag)
                                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">No tags</span>
                                @endif
                            </td>

                            <td class="p-3 border">
                                <div class="flex gap-2 flex-wrap">

                                    <a href="{{ route('tasks.edit', $task) }}"
                                       class="text-blue-600 hover:underline">
                                        Edit
                                    </a>

                                    <!-- Status Toggle -->
                                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="title" value="{{ $task->title }}">
                                        <input type="hidden" name="description" value="{{ $task->description }}">
                                        <input type="hidden" name="category_id" value="{{ $task->category_id }}">
                                        <input type="hidden" name="priority" value="{{ $task->priority }}">
                                        <input type="hidden" name="due_date" value="{{ optional($task->due_date)->toDateString() }}">
                                        <input type="hidden" name="status"
                                               value="{{ $task->status === 'pending' ? 'completed' : 'pending' }}">

                                        <button class="text-sm bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                            {{ $task->status === 'pending' ? 'Mark Done' : 'Undo' }}
                                        </button>
                                    </form>

                                    <!-- Archive -->
                                    <form method="POST" action="{{ route('tasks.archive', $task) }}">
                                        @csrf
                                        <button class="text-sm bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                                            Archive
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete task?')"
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
                                No tasks found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
