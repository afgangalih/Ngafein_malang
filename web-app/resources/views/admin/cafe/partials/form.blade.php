<form id="form-cafe-panel" enctype="multipart/form-data" class="space-y-8 animate-fade-in pb-12">
    @csrf
    @if(isset($kafe))
        @method('PUT')
        <input type="hidden" name="id_kafe" value="{{ $kafe->id_kafe }}">
    @endif

    <!-- Seksi 1: Informasi Utama -->
    <div class="space-y-5">
        <p class="text-[11px] font-bold text-[#b87c39] uppercase tracking-widest">Informasi Utama</p>
        
        <div class="space-y-4">
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Nama Kafe <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kafe" value="{{ $kafe->nama_kafe ?? '' }}" required
                       placeholder="Masukkan nama kafe..."
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#b87c39] focus:border-[#b87c39] text-sm transition-all outline-none">
            </div>

            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" 
                          placeholder="Ceritakan keunikan kafe ini secara singkat..."
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#b87c39] focus:border-[#b87c39] text-sm transition-all outline-none leading-relaxed">{{ $kafe->deskripsi ?? '' }}</textarea>
            </div>

            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Alamat Lengkap</label>
                <textarea name="alamat" rows="2" 
                          placeholder="Jl. Nama Jalan No. XX..."
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#b87c39] focus:border-[#b87c39] text-sm transition-all outline-none">{{ $kafe->alamat ?? '' }}</textarea>
            </div>

            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Link Google Maps (Opsional)</label>
                <div class="relative">
                    <i data-lucide="map-pin" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="url" name="link_maps" value="{{ $kafe->link_maps ?? '' }}"
                           placeholder="https://maps.google.com/..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#b87c39] focus:border-[#b87c39] text-sm transition-all outline-none">
                </div>
            </div>
        </div>
    </div>

    <!-- Seksi 2: Metrik & Operasional -->
    <div class="space-y-5 pt-2">
        <p class="text-[11px] font-bold text-[#b87c39] uppercase tracking-widest">Metrik & Operasional</p>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Harga Min (Rp)</label>
                <input type="number" name="harga_min" value="{{ $kafe->harga_min ?? 0 }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#b87c39] focus:border-[#b87c39] text-sm transition-all outline-none">
            </div>
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Harga Max (Rp)</label>
                <input type="number" name="harga_max" value="{{ $kafe->harga_max ?? 0 }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#b87c39] focus:border-[#b87c39] text-sm transition-all outline-none">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Jam Buka</label>
                <input type="time" name="jam_buka" value="{{ $kafe->jam_buka ?? '' }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#b87c39] focus:border-[#b87c39] text-sm transition-all outline-none">
            </div>
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Jam Tutup</label>
                <input type="time" name="jam_tutup" value="{{ $kafe->jam_tutup ?? '' }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#b87c39] focus:border-[#b87c39] text-sm transition-all outline-none">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Jarak (Km)</label>
                <input type="number" step="0.1" name="jarak" value="{{ $kafe->jarak ?? 0 }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#b87c39] focus:border-[#b87c39] text-sm transition-all outline-none">
            </div>
            <div>
                <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Rating (0-5)</label>
                <input type="number" step="0.1" max="5" name="rating" value="{{ $kafe->rating ?? 0 }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#b87c39] focus:border-[#b87c39] text-sm transition-all outline-none">
            </div>
        </div>
    </div>

    <!-- Seksi 3: Fasilitas -->
    <div class="space-y-5 pt-2">
        <p class="text-[11px] font-bold text-[#b87c39] uppercase tracking-widest">Pilih Fasilitas</p>
        <div class="grid grid-cols-2 gap-2">
            @foreach($fasilitas as $f)
                <label class="group flex items-center gap-3 p-3 border rounded-xl cursor-pointer transition-all hover:border-[#b87c39]/30
                            {{ isset($kafe) && $kafe->fasilitas->contains($f->id_fasilitas) ? 'bg-[#b87c39]/5 border-[#b87c39]' : 'bg-white border-gray-100' }}">
                    <input type="checkbox" name="fasilitas[]" value="{{ $f->id_fasilitas }}" 
                           {{ isset($kafe) && $kafe->fasilitas->contains($f->id_fasilitas) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-[#b87c39] focus:ring-[#b87c39] border-gray-300 transition-all">
                    <span class="text-[13px] font-bold text-gray-700 group-hover:text-[#b87c39] transition-colors">{{ $f->nama_fasilitas }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <!-- Seksi 4: Menu Andalan -->
    <div class="space-y-5 pt-2">
        <p class="text-[11px] font-bold text-[#b87c39] uppercase tracking-widest">Pilih Menu Andalan</p>
        <div class="grid grid-cols-2 gap-2">
            @foreach($menus as $m)
                <label class="group flex items-center gap-3 p-3 border rounded-xl cursor-pointer transition-all hover:border-[#b87c39]/30
                            {{ isset($kafe) && $kafe->menus->contains($m->id_menu) ? 'bg-[#b87c39]/5 border-[#b87c39]' : 'bg-white border-gray-100' }}">
                    <input type="checkbox" name="menu[]" value="{{ $m->id_menu }}" 
                           {{ isset($kafe) && $kafe->menus->contains($m->id_menu) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-[#b87c39] focus:ring-[#b87c39] border-gray-300 transition-all">
                    <span class="text-[13px] font-bold text-gray-700 group-hover:text-[#b87c39] transition-colors">{{ $m->nama_menu }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <!-- Seksi 5: Galeri Foto -->
    <div class="space-y-5 pt-2">
        <p class="text-[11px] font-bold text-[#b87c39] uppercase tracking-widest">Galeri Foto</p>
        
        <!-- Existing Images Grid -->
        @if(isset($kafe) && $kafe->gambar->count() > 0)
            <div class="grid grid-cols-3 gap-3 mb-6">
                @foreach($kafe->gambar as $img)
                    <div class="relative group aspect-square rounded-2xl overflow-hidden border border-gray-100 shadow-sm bg-gray-50" id="img-container-{{ $img->id_gambar }}">
                        <img src="{{ $img->link_gambar }}" class="w-full h-full object-cover">
                        <button type="button" 
                                @click="deleteImage({{ $img->id_gambar }})"
                                class="absolute inset-0 bg-red-600/60 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-[2px]">
                            <i data-lucide="trash-2" class="w-6 h-6"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Upload Box -->
        <div>
            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center hover:bg-[#b87c39]/5 hover:border-[#b87c39]/30 transition-all cursor-pointer relative group">
                <input type="file" name="gambar[]" id="input-gambar-baru" multiple accept="image/*"
                       onchange="previewImages(event)"
                       class="absolute inset-0 opacity-0 cursor-pointer">
                <div class="space-y-2">
                    <i data-lucide="image-plus" class="w-10 h-10 mx-auto text-gray-300 group-hover:text-[#b87c39] transition-colors"></i>
                    <p class="text-sm font-bold text-gray-600">Upload Foto Baru</p>
                    <p class="text-[11px] text-gray-400">Dapat memilih lebih dari satu (JPG, PNG, JPEG)</p>
                </div>
            </div>

            <!-- New Image Preview Container -->
            <div id="preview-gambar-baru" class="grid grid-cols-3 gap-3 mt-4">
                <!-- Preview images will appear here -->
            </div>
        </div>
    </div>
</form>
