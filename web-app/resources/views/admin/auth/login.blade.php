<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Ngafein Admin</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="flex flex-col h-screen bg-[#FEF6E7] font-sans selection:bg-[#B87A3D] selection:text-white overflow-hidden">

    <div class="flex-1 flex overflow-hidden">
        <div class="hidden lg:flex w-1/2 relative bg-black overflow-hidden">
            <img
                src="{{ asset('assets/images/auth-bg.jpg') }}"
                alt="Cafe Interior"
                class="absolute inset-0 w-full h-full object-cover opacity-80"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-black/10 pointer-events-none"></div>

            <div class="absolute inset-0 flex items-center">
                <div class="px-16">
                    <p class="text-white/60 text-[13px] font-semibold tracking-[0.25em] uppercase mb-4">Ngafein Admin Panel</p>
                    <h1 class="font-bold leading-[1.08] drop-shadow-2xl">
                        <span class="block text-white text-[3.8rem]">Sistem</span>
                        <span class="block italic text-[4.2rem] font-black" style="color: #E4CBAF;">Rekomendasi Cafe</span>
                        <span class="block text-white text-[3.8rem]">Malang</span>
                    </h1>
                    <div class="mt-6 w-16 h-1 rounded-full" style="background-color: #E4CBAF; opacity: 0.6;"></div>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center relative bg-[#FEF6E7]">
            <div class="absolute top-10 right-10 w-64 h-64 bg-[#B87A3D]/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="w-[85%] max-w-[420px] bg-[#B87A3D] rounded-[3rem] px-10 py-16 shadow-[0_20px_50px_rgba(184,122,61,0.25)] relative z-10">
                <div class="text-center mb-14">
                    <h2 class="text-3xl font-black text-white mb-3 tracking-wide">Login Admin</h2>
                    <p class="text-white/80 text-[14px] font-medium leading-relaxed">Silakan masuk untuk mengelola<br>data sistem</p>
                </div>

                @if ($errors->any())
                    <div class="flex items-start gap-3 bg-red-600/30 backdrop-blur-md border border-red-500/40 rounded-[1.5rem] px-5 py-4 mb-10 shadow-lg shadow-red-900/20">
                        <div class="mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-white text-[13px] font-bold leading-tight uppercase tracking-wide mb-1">Ada Masalah Nih!</p>
                            <p class="text-red-100/90 text-[12px] font-medium leading-relaxed italic">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-7">
                    @csrf
                    <div class="relative flex items-center group">
                        <div class="absolute left-4 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="adminngafein@gmail.com"
                            class="w-full pl-12 pr-4 py-4 bg-white/10 hover:bg-white/15 focus:bg-white/20 border-none rounded-2xl text-white placeholder-white/50 focus:outline-none focus:ring-0 transition-all text-[14px] font-medium"
                        >
                    </div>

                    <div class="relative flex items-center group">
                        <div class="absolute left-4 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            placeholder="Masukkan Password"
                            class="w-full pl-12 pr-12 py-4 bg-white/10 hover:bg-white/15 focus:bg-white/20 border-none rounded-2xl text-white placeholder-white/50 focus:outline-none focus:ring-0 transition-all text-[14px] font-medium"
                        >
                        <button type="button" id="togglePassword" class="absolute right-4 w-10 h-10 flex items-center justify-center text-white hover:text-white transition-colors focus:outline-none">
                            <svg id="iconEyeOff" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                            <svg id="iconEye" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <div class="relative flex items-center justify-center">
                                <input type="checkbox" name="remember" class="peer appearance-none w-4 h-4 rounded-[4px] border-2 border-white/40 bg-transparent checked:bg-white checked:border-white transition-all cursor-pointer">
                                <svg class="absolute w-3 h-3 text-[#B87A3D] opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity" viewBox="0 0 14 10" fill="none">
                                    <path d="M1 5L4.5 8.5L13 1" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span class="text-white/80 text-[13px] group-hover:text-white transition-colors font-medium">Remember me</span>
                        </label>
                        <a href="#" class="text-white/80 hover:text-white text-[13px] font-medium transition-colors hover:underline">Lupa Password?</a>
                    </div>

                    <button type="submit" class="w-full mt-2 py-4 bg-white hover:bg-[#FEF6E7] text-[#B87A3D] font-extrabold rounded-2xl shadow-lg transition-all active:scale-[0.98] text-[15px] flex justify-center items-center gap-2 group">
                        Masuk Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </button>
                </form>
            </div>

            <div class="mt-8 text-center relative z-10">
                <p class="text-gray-600 text-[13px] font-medium">
                    Belum memiliki akun?
                    <a href="#" class="text-[#B87A3D] font-bold hover:underline ml-1">Hubungi administrator utama</a>
                </p>
            </div>
        </div>
    </div>

    <footer class="flex-shrink-0 flex items-center justify-between px-8 py-3.5 bg-[#4A3018]">
        <p class="text-[12px] font-medium text-white/40">Login Page</p>
        <p class="text-[12px] font-medium text-white/70">
            &copy; {{ date('Y') }} <strong class="text-white font-semibold">Politeknik Negeri Malang</strong>
        </p>
    </footer>

    <script>
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const iconEye = document.getElementById('iconEye');
        const iconEyeOff = document.getElementById('iconEyeOff');

        toggleBtn.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            iconEye.classList.toggle('hidden', !isHidden);
            iconEyeOff.classList.toggle('hidden', isHidden);
        });
    </script>
</body>
</html>
