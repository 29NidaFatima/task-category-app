<aside class="w-64 fixed inset-y-0 left-0 bg-gradient-to-b from-white to-gray-50 border-r shadow-md flex flex-col z-40">

    <!-- Logo -->
    <div class="h-16 flex items-center justify-center border-b bg-white shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <x-application-logo class="h-9 w-auto text-blue-600" />
            <span class="font-bold text-lg tracking-wide text-gray-800">
                Dashboard
            </span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-xl transition
           {{ request()->routeIs('dashboard')
               ? 'bg-blue-600 text-white shadow'
               : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            📊 Dashboard
        </a>

        <a href="{{ route('tasks.index') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-xl transition
           {{ request()->routeIs('tasks.*')
               ? 'bg-blue-600 text-white shadow'
               : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            📝 Tasks
        </a>

        <a href="{{ route('categories.index') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-xl transition
           {{ request()->routeIs('categories.*')
               ? 'bg-blue-600 text-white shadow'
               : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            📂 Categories
        </a>
    </nav>

    <!-- User Section -->
    <div class="border-t bg-white px-4 py-4 shrink-0">
        <p class="text-sm font-semibold text-gray-800 truncate">
            {{ Auth::user()->name }}
        </p>
        <p class="text-xs text-gray-500 truncate mb-3">
            {{ Auth::user()->email }}
        </p>

        <a href="{{ route('profile.edit') }}"
           class="block text-sm text-gray-600 hover:text-blue-600 mb-3">
            👤 Profile
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm text-red-600 hover:text-red-700">
                🚪 Log Out
            </button>
        </form>
    </div>

</aside>
