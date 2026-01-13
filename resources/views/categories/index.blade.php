<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            Category Management
        </h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto space-y-8">

        <!-- Add Category -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Add Category</h3>

            <form method="POST" action="{{ route('categories.store') }}" class="flex gap-3">
                @csrf

                <input
                    type="text"
                    name="name"
                    placeholder="Category name"
                    required
                    class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                >

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    Add
                </button>
            </form>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mt-3 text-red-600">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Category List -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Categories</h3>

            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3 border">Name</th>
                        <th class="p-3 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">{{ $category->name }}</td>
                            <td class="p-3 border">
                                <div class="flex gap-3">

                                    <!-- EDIT -->
                                    <a
                                        href="{{ route('categories.edit', $category) }}"
                                        class="text-blue-600 hover:underline"
                                    >
                                        Edit
                                    </a>

                                    <!-- DELETE -->
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Delete this category?')"
                                            class="text-sm bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                        >
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if ($categories->count() === 0)
                        <tr>
                            <td colspan="2" class="p-4 text-center text-gray-500">
                                No categories found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
