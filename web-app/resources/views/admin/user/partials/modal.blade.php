    <template x-teleport="body">
        <div
            x-show="showForm"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[99999] flex items-center justify-center px-4"
            style="display: none;">

            <div class="absolute inset-0 bg-black/60 backdrop-blur-md" @click="closeForm()"></div>

            <div
                x-show="showForm"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative w-full max-w-md bg-white rounded-[2rem] border border-[#B87C39]/15 shadow-2xl p-8 z-10 animate-fade-up">

                <button type="button" @click="closeForm()" 
                        class="absolute top-6 right-6 text-[#2B1A09]/40 hover:text-[#2B1A09] transition-colors cursor-pointer">
                    <svg viewBox="0 0 24 24" class="w-5.5 h-5.5 fill-none stroke-current" stroke-width="2.5"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                </button>

                <div class="flex flex-col items-center mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#B87C39]/10 text-[#B87C39] flex items-center justify-center mb-3">
                        <i :data-lucide="formMode === 'create' ? 'plus-circle' : 'pencil'" class="w-5.5 h-5.5"></i>
                    </div>
                    <h3 class="font-serif font-bold text-2xl text-[#2B1A09] text-center tracking-tight" x-text="formMode === 'create' ? 'Tambah Admin' : 'Edit Admin'"></h3>
                    <p class="text-xs text-[#2B1A09]/60 mt-1.5 text-center font-medium">Pastikan alamat email yang dimasukkan bersifat unik</p>
                </div>

                <form method="POST" :action="formAction" class="space-y-4">
                    @csrf
                    <template x-if="formMode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <div>
                        <label for="name" class="block text-[11px] font-bold text-[#2B1A09] uppercase tracking-wider mb-1.5">Nama</label>
                        <input id="name" name="name" type="text" x-model="formName" required placeholder="Masukkan nama..." class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-5 py-3 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all text-[#2B1A09]">
                    </div>
                    <div>
                        <label for="email" class="block text-[11px] font-bold text-[#2B1A09] uppercase tracking-wider mb-1.5">Email</label>
                        <input id="email" name="email" type="email" x-model="formEmail" required placeholder="nama@email.com" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-5 py-3 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all text-[#2B1A09]">
                    </div>
                    <div>
                        <label for="password" class="block text-[11px] font-bold text-[#2B1A09] uppercase tracking-wider mb-1.5">Password <span x-show="formMode === 'edit'" class="text-gray-400 font-normal normal-case">(Kosongkan jika tidak diubah)</span></label>
                        <input id="password" name="password" type="password" :required="formMode === 'create'" placeholder="••••••••" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-5 py-3 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all text-[#2B1A09]">
                    </div>
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="closeForm()" 
                            class="px-5 py-2.5 text-xs font-bold text-gray-500 hover:text-[#2B1A09] hover:bg-gray-100/60 rounded-xl transition-all cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-6 py-3 bg-[#B87C39] hover:bg-[#9a662e] text-white font-bold text-xs rounded-xl shadow-md shadow-[#B87C39]/10 transition-all cursor-pointer">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
