<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            Edit Category
        </h2>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <form
                method="POST"
                action="{{ route('categories.update', $category) }}"
                class="space-y-4"
            >
                @csrf
                @method('PUT')

                <input
                    type="text"
                    name="name"
                    value="{{ $category->name }}"
                    required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                >

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    Update Category
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
