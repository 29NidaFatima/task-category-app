<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 20px; font-weight: bold;">
            Task Management
        </h2>
    </x-slot>

    <div style="padding: 20px">

        <!-- Add Task Form -->
        <h3>Add Task</h3>

        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf

            <div>
                <input type="text" name="title" placeholder="Task title" required>
            </div>

            <br>

            <div>
                <textarea name="description" placeholder="Task description"></textarea>
            </div>

            <br>

            <div>
                <select name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <br>

            <button type="submit">Add Task</button>
        </form>

        <hr>

        <!-- Task List -->
        <h3>Your Tasks</h3>

        <table border="1" cellpadding="10">
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->category->name }}</td>
                    <td>
                        {{ $task->status === 'completed' ? '✅ Completed' : '⏳ Pending' }}
                    </td>
                    <td style="display: flex; gap: 10px;">

                        <!-- EDIT -->
                        <a href="{{ route('tasks.edit', $task) }}">Edit</a>

                        <!-- STATUS TOGGLE -->
                        <form method="POST" action="{{ route('tasks.update', $task) }}">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="title" value="{{ $task->title }}">
                            <input type="hidden" name="description" value="{{ $task->description }}">
                            <input type="hidden" name="category_id" value="{{ $task->category_id }}">
                            <input type="hidden" name="status"
                                   value="{{ $task->status === 'pending' ? 'completed' : 'pending' }}">

                            <button type="submit">
                                {{ $task->status === 'pending' ? 'Mark Done' : 'Undo' }}
                            </button>
                        </form>

                        <!-- DELETE -->
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete task?')">Delete</button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>
