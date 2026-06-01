<div x-data="{ 
        show: false, 
        name: '',
        email: '', 
        password: '', 
        password_confirmation: '',
        showPassword: false,
        errors: {}, 
        loading: false, 
        successMsg: '' 
     }"
     @open-register-modal.window="show = true"
     x-show="show"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4"
     x-cloak>
    
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

    <div x-show="show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="relative w-full max-w-md bg-white rounded-[2rem] border border-[#B87C39]/20 shadow-2xl overflow-hidden p-8 z-10">
        
        <button @click="show = false" 
                class="absolute top-6 right-6 text-[#2B1A09]/40 hover:text-[#2B1A09] transition-colors cursor-pointer">
            <svg viewBox="0 0 24 24" class="w-5.5 h-5.5 fill-none stroke-current" stroke-width="2.5"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
        </button>

        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('assets/images/logo-ngafein.png') }}" 
                 alt="Ngafein Logo" 
                 class="h-14 w-auto object-contain mb-3">
            <h3 class="font-serif font-bold text-2xl text-[#2B1A09] text-center tracking-tight">
                Buat Akun <span class="text-[#2B1A09]">Ngafe</span><span class="text-[#B87C39]">in</span>
            </h3>
            <p class="text-xs text-[#2B1A09]/60 mt-1 text-center font-medium">
                Daftar sekarang untuk menyimpan favorit & beri review kafe
            </p>
        </div>

        <div x-show="successMsg" class="mb-4 p-3.5 bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs font-bold rounded-2xl flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
            <span x-text="successMsg"></span>
        </div>

        <form @submit.prevent="
            loading = true;
            errors = {};
            successMsg = '';
            fetch('{{ route('register.post') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, email, password, password_confirmation })
            })
            .then(res => res.json())
            .then(data => {
                loading = false;
                if (data.success) {
                    successMsg = 'Registrasi berhasil! Mengalihkan...';
                    setTimeout(() => { window.location.reload(); }, 800);
                } else {
                    errors = data.errors || { email: ['Terjadi kesalahan saat pendaftaran.'] };
                }
            })
            .catch(() => {
                loading = false;
                errors = { email: ['Gagal terhubung ke server.'] };
            });
        " class="space-y-4">
            <div>
                <label class="block text-[11px] font-bold text-[#2B1A09] uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                <input type="text" 
                       x-model="name" 
                       required 
                       placeholder="Masukkan nama lengkap Anda"
                       class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-5 py-3 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all text-[#2B1A09]"
                       :class="errors.name ? 'border-red-500 focus:border-red-500' : ''">
                <template x-if="errors.name">
                    <p class="text-red-600 text-[11px] font-semibold mt-1 flex items-center gap-1">
                        <svg viewBox="0 0 24 24" class="w-3 h-3 fill-none stroke-current" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <span x-text="errors.name[0]"></span>
                    </p>
                </template>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-[#2B1A09] uppercase tracking-wider mb-1.5">Email</label>
                <input type="email" 
                       x-model="email" 
                       required 
                       placeholder="nama@email.com"
                       class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-5 py-3 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all text-[#2B1A09]"
                       :class="errors.email ? 'border-red-500 focus:border-red-500' : ''">
                <template x-if="errors.email">
                    <p class="text-red-600 text-[11px] font-semibold mt-1 flex items-center gap-1">
                        <svg viewBox="0 0 24 24" class="w-3 h-3 fill-none stroke-current" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <span x-text="errors.email[0]"></span>
                    </p>
                </template>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-[#2B1A09] uppercase tracking-wider mb-1.5">Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" 
                           x-model="password" 
                           required 
                           placeholder="••••••••"
                           class="w-full bg-gray-50/50 border border-gray-200 rounded-xl pl-5 pr-12 py-3 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all text-[#2B1A09]"
                           :class="errors.password ? 'border-red-500 focus:border-red-500' : ''">
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
                    <p class="text-red-600 text-[11px] font-semibold mt-1 flex items-center gap-1">
                        <svg viewBox="0 0 24 24" class="w-3 h-3 fill-none stroke-current" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <span x-text="errors.password[0]"></span>
                    </p>
                </template>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-[#2B1A09] uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" 
                           x-model="password_confirmation" 
                           required 
                           placeholder="••••••••"
                           class="w-full bg-gray-50/50 border border-gray-200 rounded-xl pl-5 pr-12 py-3 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all text-[#2B1A09]"
                           :class="errors.password_confirmation ? 'border-red-500 focus:border-red-500' : ''">
                </div>
            </div>

            <button type="submit" 
                    :disabled="loading"
                    class="w-full bg-[#B87C39] hover:bg-[#2B1A09] text-white font-bold py-3.5 rounded-xl transition-all shadow-md shadow-[#B87C39]/10 hover:shadow-[#2B1A09]/20 flex items-center justify-center gap-2 mt-4 cursor-pointer disabled:opacity-50">
                <template x-if="loading">
                    <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </template>
                <span x-text="loading ? 'Mendaftarkan...' : 'Daftar Sekarang'"></span>
            </button>
        </form>

        <div class="mt-6 text-center text-xs text-gray-500">
            Sudah punya akun? 
            <button @click="show = false; $dispatch('open-login-modal')" class="text-[#B87C39] font-bold hover:underline ml-1 focus:outline-none cursor-pointer">
                Masuk di Sini
            </button>
        </div>
    </div>
</div>
