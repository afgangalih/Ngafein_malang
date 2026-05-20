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

            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="closeForm()"></div>

            <div
                x-show="showForm"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative w-full max-w-md rounded-xl bg-white p-6 shadow-2xl z-10">

                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-gray-900" x-text="formMode === 'create' ? 'Tambah Admin' : 'Edit Admin'"></h2>
                        <p class="mt-1 text-sm font-medium text-gray-500">Email harus unik.</p>
                    </div>
                    <button type="button" @click="closeForm()" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition hover:bg-gray-50">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>
                <form method="POST" :action="formAction" class="space-y-4">
                    @csrf
                    <template x-if="formMode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <div>
                        <label for="name" class="mb-2 block text-sm font-bold text-gray-700">Nama</label>
                        <input id="name" name="name" type="text" x-model="formName" required class="w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-900 outline-none transition focus:border-[#B87C39] focus:ring-4 focus:ring-[#B87C39]/10">
                    </div>
                    <div>
                        <label for="email" class="mb-2 block text-sm font-bold text-gray-700">Email</label>
                        <input id="email" name="email" type="email" x-model="formEmail" required class="w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-900 outline-none transition focus:border-[#B87C39] focus:ring-4 focus:ring-[#B87C39]/10">
                    </div>
                    <div>
                        <label for="password" class="mb-2 block text-sm font-bold text-gray-700">Password <span x-show="formMode === 'edit'" class="text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                        <input id="password" name="password" type="password" :required="formMode === 'create'" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-900 outline-none transition focus:border-[#B87C39] focus:ring-4 focus:ring-[#B87C39]/10">
                    </div>
                    <div class="mt-2 flex justify-end gap-3 pt-2">
                        <button type="button" @click="closeForm()" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-bold text-gray-600 transition hover:bg-gray-50">Batal</button>
                        <button type="submit" class="rounded-lg bg-[#B87C39] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#6E4A22]">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </template>
