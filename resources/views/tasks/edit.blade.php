<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            Edit Task
        </h2>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">

            <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Task Title
                    </label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $task->title) }}"
                        required
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
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
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                    >{{ old('description', $task->description) }}</textarea>
                </div>

                <!-- Priority -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Priority
                    </label>
                    <select
                        name="priority"
                        required
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                        <option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>High</option>
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
                        value="{{ optional($task->due_date)->toDateString() }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Status
                    </label>
                    <select
                        name="status"
                        required
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                        <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>
                    </select>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Category
                    </label>
                    <select
                        name="category_id"
                        required
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $task->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                        Update Task
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
