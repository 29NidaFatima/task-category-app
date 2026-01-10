<x-app-layout>
    <x-slot name="header">
        <h2>Edit Task</h2>
    </x-slot>

    <div style="padding: 20px">
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PUT')

            <input type="text" name="title" value="{{ $task->title }}" required>
            <br><br>

            <textarea name="description">{{ $task->description }}</textarea>
            <br><br>

            <select name="category_id" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $task->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <br><br>

            <button type="submit">Update Task</button>
        </form>
    </div>
</x-app-layout>
