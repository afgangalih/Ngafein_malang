{{-- resources/views/auth/user/login-modal.blade.php --}}
<div x-data="{ 
        show: false, 
        email: '', 
        password: '', 
        showPassword: false,
        errors: {}, 
        loading: false, 
        successMsg: '' 
     }"
     @open-login-modal.window="show = true"
     x-show="show"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4"
     x-cloak>
    
    {{-- Backdrop Layer: Perpaduan warna ke-2 dengan transparansi --}}
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="show = false"
         class="absolute inset-0 bg-black/50 backdrop-blur-sm">
    </div>

    {{-- Modal Box: Background Putih bersih dengan aksen warna utama dan ke-2 --}}
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="relative w-full max-w-md bg-white rounded-[2rem] border border-[#B87C39]/20 shadow-2xl overflow-hidden p-8 z-10">
        
        {{-- Close Button --}}
        <button @click="show = false" 
                class="absolute top-6 right-6 text-[#2B1A09]/40 hover:text-[#2B1A09] transition-colors cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
        </button>

        {{-- Centered Logo & Header --}}
        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('assets/images/logo-ngafein.png') }}" 
                 alt="Ngafein Logo" 
                 class="h-16 w-auto object-contain mb-3">
            <h3 class="font-serif font-bold text-2xl text-[#2B1A09] text-center tracking-tight">
                Selamat Datang di <span class="text-[#2B1A09]">Ngafe</span><span class="text-[#B87C39]">in</span>
            </h3>
            <p class="text-xs text-[#2B1A09]/60 mt-1.5 text-center font-medium">
                Masuk dulu yuk! Temukan kafe ternyaman untuk nugas & nongkrong di Malang
            </p>
        </div>

        {{-- Status Messages --}}
        <div x-show="successMsg" class="mb-4 p-3.5 bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs font-bold rounded-2xl flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
            <span x-text="successMsg"></span>
        </div>

        {{-- Form --}}
        <form @submit.prevent="
            loading = true;
            errors = {};
            successMsg = '';
            fetch('{{ route('login.post') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email, password })
            })
            .then(res => res.json())
            .then(data => {
                loading = false;
                if (data.success) {
                    successMsg = 'Login berhasil! Sedang dialihkan...';
                    setTimeout(() => { window.location.reload(); }, 800);
                } else {
                    errors = data.errors || { email: ['Email atau password salah.'] };
                }
            })
            .catch(() => {
                loading = false;
                errors = { email: ['Gagal terhubung ke server. Silakan periksa koneksi Anda.'] };
            });
        " class="space-y-5">
            <div>
                <label class="block text-[11px] font-bold text-[#2B1A09] uppercase tracking-wider mb-2">Email</label>
                <div class="relative">
                    <input type="email" 
                           x-model="email" 
                           required 
                           placeholder="nama@email.com"
                           class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-5 py-3.5 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all text-[#2B1A09]"
                           :class="errors.email ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : ''">
                </div>
                <template x-if="errors.email">
                    <p class="text-red-600 text-[11px] font-semibold mt-1.5 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <span x-text="errors.email[0]"></span>
                    </p>
                </template>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-[11px] font-bold text-[#2B1A09] uppercase tracking-wider">Password</label>
                </div>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" 
                           x-model="password" 
                           required 
                           placeholder="••••••••"
                           class="w-full bg-gray-50/50 border border-gray-200 rounded-xl pl-5 pr-12 py-3.5 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all text-[#2B1A09]"
                           :class="errors.password ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : ''">
                    <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none cursor-pointer">
                        <template x-if="showPassword">
                            <svg viewBox="0 0 24 24" class="w-4.5 h-4.5 fill-none stroke-current" stroke-width="2.5"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68M6.61 6.61A13.52 13.52 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61M2 2l20 20"/></svg>
                        </template>
                        <template x-if="!showPassword">
                            <svg viewBox="0 0 24 24" class="w-4.5 h-4.5 fill-none stroke-current" stroke-width="2.5"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                        </template>
                    </button>
                </div>
                <template x-if="errors.password">
                    <p class="text-red-600 text-[11px] font-semibold mt-1.5 flex items-center gap-1">
                        <svg viewBox="0 0 24 24" class="w-3 h-3 fill-none stroke-current" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <span x-text="errors.password[0]"></span>
                    </p>
                </template>
            </div>

            <button type="submit" 
                    :disabled="loading"
                    class="w-full bg-[#B87C39] hover:bg-[#2B1A09] text-white font-bold py-3.5 rounded-xl transition-all shadow-md shadow-[#B87C39]/10 hover:shadow-[#2B1A09]/20 flex items-center justify-center gap-2 mt-2 cursor-pointer disabled:opacity-50">
                <template x-if="loading">
                    <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </template>
                <span x-text="loading ? 'Sedang Masuk...' : 'Masuk'"></span>
            </button>
        </form>

        <div class="mt-6 text-center text-xs text-gray-500">
            Belum punya akun? 
            <button @click="show = false; $dispatch('open-register-modal')" class="text-[#B87C39] font-bold hover:underline ml-1 focus:outline-none cursor-pointer">
                Daftar Sekarang
            </button>
        </div>
    </div>
</div>
