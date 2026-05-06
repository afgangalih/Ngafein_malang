<header
    class="sticky top-0 z-[999] flex w-full bg-white/80 backdrop-blur-lg border-b border-gray-100 dark:bg-gray-900/80 dark:border-gray-800"
    x-data="{ open: false }">
    <div class="flex items-center justify-between w-full px-6 h-16 xl:px-10">
        <div class="flex items-center gap-4">
            <button
                class="hidden xl:flex items-center justify-center w-10 h-10 text-gray-400 hover:text-[#b87c39] transition-all"
                @click="$store.sidebar.toggleExpanded()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="21" x2="3" y1="6" y2="6"/><line x1="15" x2="3" y1="12" y2="12"/><line x1="17" x2="3" y1="18" y2="18"/></svg>
            </button>
            <button
                class="flex xl:hidden items-center justify-center w-10 h-10 text-gray-400 hover:text-[#b87c39]"
                @click="$store.sidebar.toggleMobileOpen()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
            </button>
            <div class="hidden md:block ml-2">
                @if(trim($__env->yieldContent('breadcrumb')))
                    @yield('breadcrumb')
                @else
                    <x-admin.breadcrumb :links="[]" />
                @endif
            </div>
        </div>
        <div class="flex items-center relative" @click.outside="open = false">
            <button 
                @click="open = !open"
                class="flex items-center gap-3 group px-2 py-1 rounded-full hover:bg-gray-50 transition-all">
                <div class="w-10 h-10 rounded-full overflow-hidden border border-gray-100 shadow-sm text-[0]">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=b87c39&color=fff&bold=true" 
                         alt="Admin Profile" 
                         class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col items-start leading-tight">
                    <span class="text-sm font-bold text-gray-900 group-hover:text-[#b87c39] transition-colors">Bonyra Jon</span>
                    <span class="text-[11px] text-gray-400 font-medium">Admin (M)</span>
                </div>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                 class="absolute right-0 top-full mt-2 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 p-2 z-[1001]">
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-gray-600 hover:bg-amber-50 hover:text-[#b87c39] rounded-xl transition-all">
                    <i data-lucide="user" class="w-4 h-4"></i> Profil Saya
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-red-500 hover:bg-red-50 rounded-xl transition-all">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
