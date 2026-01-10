<x-app-layout>
    <x-slot name="header">
        <h2>Edit Category</h2>
    </x-slot>

    <div style="padding: 20px">
        <form method="POST" action="{{ route('categories.update', $category) }}">
            @csrf
            @method('PUT')

            <input type="text" name="name" value="{{ $category->name }}" required>

            <br><br>

            <button type="submit">Update Category</button>
        </form>
    </div>
</x-app-layout>
