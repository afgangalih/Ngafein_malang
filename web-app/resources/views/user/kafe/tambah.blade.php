@extends('layouts.user')

@section('title', 'Usulkan Kafe Baru — Ngafein')
@section('navbar-dark-text', 'true')

@section('content')
<div class="max-w-4xl mx-auto px-4 md:px-8 pt-32 md:pt-40 pb-20">
    <div class="mb-10 text-center md:text-left">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Usulkan Kafe Baru</h1>
        <p class="text-gray-500 text-sm">Punya info kafe seru yang belum ada di Ngafein? Daftarkan di sini agar admin bisa memprosesnya.</p>
    </div>

    @if(session('success'))
        <div class="mb-8 p-5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-3xl flex items-start gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <div>
                <p class="text-emerald-950 font-bold mb-1">Berhasil!</p>
                <p class="font-normal text-xs text-emerald-800/90 leading-relaxed">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white border border-[#B87C39]/25 rounded-[2.5rem] shadow-xl p-6 md:p-10">
        <form action="{{ route('user.kafe.tambah.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-[#B87C39] mb-5 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-[#B87C39] rounded-full"></span>
                    Informasi Dasar Kafe
                </h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Kafe <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_kafe" required value="{{ old('nama_kafe') }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all"
                               placeholder="Contoh: Kopi Kenangan Dinoyo">
                        @error('nama_kafe') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Jarak dari Polinema (km) <span class="text-red-500">*</span></label>
                            <input type="number" name="jarak" step="0.1" required value="{{ old('jarak') }}"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all"
                                   placeholder="Contoh: 1.2">
                            @error('jarak') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Rating Awal Kafe (1.0 - 5.0) <span class="text-red-500">*</span></label>
                            <input type="number" name="rating" step="0.1" min="1.0" max="5.0" required value="{{ old('rating', '4.5') }}"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all"
                                   placeholder="Contoh: 4.5">
                            @error('rating') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-[#B87C39] mb-5 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-[#B87C39] rounded-full"></span>
                    Jam Operasional & Rentang Harga
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Jam Buka <span class="text-red-500">*</span></label>
                        <input type="text" name="jam_buka" required value="{{ old('jam_buka', '09:00') }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all"
                               placeholder="09:00">
                        @error('jam_buka') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Jam Tutup <span class="text-red-500">*</span></label>
                        <input type="text" name="jam_tutup" required value="{{ old('jam_tutup', '22:00') }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all"
                               placeholder="22:00">
                        @error('jam_tutup') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Harga Min (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="harga_min" required value="{{ old('harga_min', 10000) }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all"
                               placeholder="10000">
                        @error('harga_min') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Harga Max (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="harga_max" required value="{{ old('harga_max', 35000) }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all"
                               placeholder="35000">
                        @error('harga_max') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-[#B87C39] mb-5 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-[#B87C39] rounded-full"></span>
                    Detail Lokasi & Deskripsi
                </h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat" required rows="3"
                                  class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all resize-none"
                                  placeholder="Tulis alamat detail kafe...">{{ old('alamat') }}</textarea>
                        @error('alamat') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Link Google Maps</label>
                        <input type="url" name="link_maps" value="{{ old('link_maps') }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all"
                               placeholder="https://maps.app.goo.gl/...">
                        @error('link_maps') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Deskripsi / Ulasan Singkat (Opsional)</label>
                        <textarea name="deskripsi" rows="4"
                                  class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all resize-none"
                                  placeholder="Gambarkan suasana kafe, menu andalan, dll...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-[#B87C39] mb-5 pb-2 border-b border-gray-100 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-[#B87C39] rounded-full"></span>
                        Fasilitas Kafe
                    </h3>
                    <div class="grid grid-cols-2 gap-3.5 max-h-60 overflow-y-auto pr-2">
                        @foreach($fasilitas as $fas)
                            <label class="flex items-center gap-3 bg-gray-50 border border-gray-100/50 rounded-xl px-4 py-3.5 hover:border-[#B87C39] hover:bg-[#B87C39]/5 transition-all cursor-pointer">
                                <input type="checkbox" name="fasilitas[]" value="{{ $fas->id_fasilitas }}"
                                       class="rounded text-[#B87C39] focus:ring-[#B87C39] border-gray-300 w-4 h-4">
                                <span class="text-xs font-bold text-gray-700 capitalize">{{ str_replace('_', ' ', $fas->nama_fasilitas) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-[#B87C39] mb-5 pb-2 border-b border-gray-100 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-[#B87C39] rounded-full"></span>
                        Kategori Menu
                    </h3>
                    <div class="grid grid-cols-2 gap-3.5">
                        @foreach($menus as $menu)
                            <label class="flex items-center gap-3 bg-gray-50 border border-gray-100/50 rounded-xl px-4 py-3.5 hover:border-[#B87C39] hover:bg-[#B87C39]/5 transition-all cursor-pointer">
                                <input type="checkbox" name="menu[]" value="{{ $menu->id_menu }}"
                                       class="rounded text-[#B87C39] focus:ring-[#B87C39] border-gray-300 w-4 h-4">
                                <span class="text-xs font-bold text-gray-700 capitalize">{{ str_replace('_', ' ', $menu->nama_menu) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div x-data="{
                images: [],
                handleFiles(event) {
                    const files = event.target.files;
                    this.images = [];
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        this.images.push({
                            name: file.name,
                            url: URL.createObjectURL(file)
                        });
                    }
                }
            }">
                <h3 class="text-sm font-bold uppercase tracking-wider text-[#B87C39] mb-5 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-[#B87C39] rounded-full"></span>
                    Upload Foto Kafe (Maks 3 file)
                </h3>
                <div class="relative w-full border-2 border-dashed border-gray-200 hover:border-[#B87C39]/50 rounded-[2rem] p-8 flex flex-col items-center justify-center transition-all bg-gray-50/50">
                    <svg class="w-10 h-10 text-gray-400 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                    <p class="text-xs font-bold text-gray-700">Pilih atau Seret Foto Kafe di Sini</p>
                    <p class="text-[10px] text-gray-400 mt-1 font-medium">JPEG, JPG, PNG hingga 2MB per gambar</p>
                    <input type="file" name="gambar[]" multiple accept="image/*" @change="handleFiles($event)"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                </div>
                @error('gambar') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                @error('gambar.*') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror

                <template x-if="images.length > 0">
                    <div class="grid grid-cols-3 gap-4 mt-6">
                        <template x-for="(img, index) in images" :key="index">
                            <div class="relative aspect-video rounded-2xl overflow-hidden border border-gray-200 shadow-sm bg-gray-100">
                                <img :src="img.url" class="w-full h-full object-cover">
                                <div class="absolute bottom-0 inset-x-0 bg-[#2B1A09]/85 text-white text-[10px] font-bold px-3 py-2 truncate" :title="img.name" x-text="img.name"></div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-4">
                <a href="{{ route('user.explore.index') }}"
                   class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold text-xs px-6 py-4 rounded-2xl transition-all cursor-pointer">
                    Batal
                </a>
                <button type="submit"
                        class="bg-[#B87C39] hover:bg-[#a66c2e] text-white font-bold text-xs px-8 py-4 rounded-2xl transition-all shadow-md shadow-[#B87C39]/20 cursor-pointer">
                    Kirim Usulan Kafe
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
