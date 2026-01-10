<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 20px; font-weight: bold;">
            Category Management
        </h2>
    </x-slot>

    <div style="padding: 20px">

        <!-- Add Category -->
        <h3>Add Category</h3>

        <form method="POST" action="{{ route('categories.store') }}">
            @csrf

            <input type="text" name="name" placeholder="Category name" required>

            <button type="submit">Add</button>
        </form>

        <br>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div style="color: red;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <hr>

        <!-- Category List -->
        <h3>Categories</h3>

        <table border="1" cellpadding="10">
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>

            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td style="display: flex; gap: 10px;">

                        <!-- EDIT -->
                        <a href="{{ route('categories.edit', $category) }}">
                            Edit
                        </a>

                        <!-- DELETE -->
                        <form method="POST" action="{{ route('categories.destroy', $category) }}">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Delete this category?')">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach

            @if ($categories->count() === 0)
                <tr>
                    <td colspan="2">No categories found.</td>
                </tr>
            @endif
        </table>

    </div>
</x-app-layout>
