<header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8">
    <div class="font-semibold text-gray-700">Admin Panel</div>
    <div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                <i class="fa-solid fa-right-from-bracket mr-1"></i> Logout
            </button>
        </form>
    </div>
</header>
