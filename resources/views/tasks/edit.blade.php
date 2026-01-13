<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Edit Task</h2>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <input
                    type="text"
                    name="title"
                    value="{{ $task->title }}"
                    required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                >

                <textarea
                    name="description"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                >{{ $task->description }}</textarea>

                <select
                    name="category_id"
                    required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                >
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $task->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    Update Task
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
