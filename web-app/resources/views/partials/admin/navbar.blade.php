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
        <div class="flex items-center gap-4">
            {{-- Notification Bell --}}
            <div x-data="{ 
                     count: 0,
                     list: [],
                     openNotif: false,
                     fetchCount() {
                         fetch('{{ route('admin.api.pending-count') }}')
                             .then(res => res.json())
                             .then(data => {
                                 this.count = data.count;
                                 this.list = data.list || [];
                             });
                     }
                 }" 
                 x-init="fetchCount(); setInterval(() => fetchCount(), 30000)" 
                 @click.outside="openNotif = false"
                 class="relative">
                
                <button @click="openNotif = !openNotif" 
                        class="flex items-center justify-center w-10 h-10 text-gray-400 hover:text-[#b87c39] hover:bg-gray-50 rounded-full transition-all relative cursor-pointer focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    
                    <span x-show="count > 0" 
                          x-text="count" 
                          class="absolute top-1.5 right-1.5 min-w-4 h-4 bg-red-500 text-white text-[9px] font-black rounded-full flex items-center justify-center px-1 border border-white">
                    </span>
                </button>

                {{-- Notification Dropdown --}}
                <div x-show="openNotif"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                     class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl z-[1002] overflow-hidden text-sm text-gray-800 dark:text-gray-200">
                    
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                        <span class="font-bold text-xs text-gray-900 dark:text-white uppercase tracking-wider">Notifikasi Usulan</span>
                        <span x-show="count > 0" class="px-2 py-0.5 bg-red-50 text-red-600 text-[10px] font-bold rounded-full dark:bg-red-950/30 dark:text-red-400" x-text="count + ' Baru'"></span>
                    </div>

                    <div class="max-h-64 overflow-y-auto divide-y divide-gray-50 dark:divide-gray-800">
                        <template x-if="list.length === 0">
                            <div class="px-4 py-6 text-center text-xs text-gray-400 font-medium">
                                Tidak ada usulan kafe baru.
                            </div>
                        </template>

                        <template x-for="item in list" :key="item.id">
                            <a :href="'{{ route('admin.approval.index') }}'" 
                               class="flex items-start gap-3 p-4 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-all">
                                <div class="w-7 h-7 rounded-lg bg-[#b87c39]/10 text-[#b87c39] flex items-center justify-center shrink-0 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><rect width="20" height="12" x="2" y="3" rx="2"/><path d="M2 14h20"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-gray-900 dark:text-white leading-tight">Usulan Kafe Baru</p>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 truncate mt-0.5 font-medium" x-text="'Mahasiswa mengajukan: ' + item.nama"></p>
                                    <p class="text-[9px] text-[#b87c39] font-bold mt-1" x-text="item.time"></p>
                                </div>
                            </a>
                        </template>
                    </div>

                    <a href="{{ route('admin.approval.index') }}" 
                       class="block text-center py-2.5 bg-gray-50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-800 border-t border-gray-100 dark:border-gray-800 text-[11px] font-bold text-[#b87c39]">
                        Lihat Semua Usulan
                    </a>
                </div>
            </div>

            {{-- Profile controls --}}
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
</div>
</header>
