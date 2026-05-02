<div class="overflow-x-auto flex-1" id="cafe-table-container">
   <table class="w-full text-left border-collapse">
      <thead>
         <tr class="bg-[#FEF6E7]/50 border-b border-[#F3E8D5]">
            <th class="py-4 px-8 text-[11px] font-extrabold text-[#A36A32] uppercase tracking-[0.15em] w-16">No</th>
            <th class="py-4 px-8 text-[11px] font-extrabold text-[#A36A32] uppercase tracking-[0.15em]">Informasi Cafe</th>
            <th class="py-4 px-8 text-[11px] font-extrabold text-[#A36A32] uppercase tracking-[0.15em]">Jarak</th>
            <th class="py-4 px-8 text-[11px] font-extrabold text-[#A36A32] uppercase tracking-[0.15em]">Operasional</th>
            <th class="py-4 px-8 text-[11px] font-extrabold text-[#A36A32] uppercase tracking-[0.15em] text-right">Aksi</th>
         </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
         @forelse($cafes as $index => $cafe)
            <tr class="hover:bg-gray-50/80 transition-colors group">
               <td class="py-4 px-8 text-[13px] font-bold text-gray-400">
                  {{ $cafes->firstItem() + $index }}.
               </td>
               <td class="py-4 px-8">
                  <div class="flex flex-col">
                     <span class="font-bold text-gray-900 text-[14px] group-hover:text-[#B87A3D] transition-colors line-clamp-1">{{ $cafe->nama_kafe }}</span>
                     <span class="text-[11px] text-gray-400 font-medium line-clamp-1 mt-0.5">{{ $cafe->alamat ?? '-' }}</span>
                  </div>
               </td>
               <td class="py-4 px-8">
                  <div class="flex items-center gap-1.5 text-[13px] font-bold text-gray-700">
                     <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#B87A3D]"></i>
                     <span>{{ $cafe->jarak }} km</span>
                  </div>
               </td>
               <td class="py-4 px-8">
                  <div class="flex items-center gap-2">
                     <span class="px-2.5 py-1 rounded-lg bg-gray-100 text-gray-600 text-[11px] font-bold border border-gray-200">
                        {{ $cafe->jam_buka ?? '--:--' }} - {{ $cafe->jam_tutup ?? '--:--' }}
                     </span>
                  </div>
               </td>
               <td class="py-4 px-8 text-right">
                  <div class="flex justify-end items-center gap-2 relative" x-data="{ open: false }">
                     {{-- tombol detail (utama) --}}
                     <a href="#" class="flex items-center gap-1.5 px-4 py-2 bg-[#FEF6E7] text-[#B87A3D] rounded-xl text-[11px] font-bold hover:bg-[#B87A3D] hover:text-white transition-all shadow-sm border border-[#F3E8D5]">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                        Detail
                     </a>
                     
                     {{-- tombol titik tiga --}}
                     <button @click="open = !open" @click.away="open = false" class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition-all border border-transparent hover:border-gray-200">
                        <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                     </button>

                     {{-- dropdown menu (edit/delete) --}}
                     <div x-show="open" 
                          x-transition:enter="transition ease-out duration-100"
                          x-transition:enter-start="transform opacity-0 scale-95"
                          x-transition:enter-end="transform opacity-100 scale-100"
                          x-transition:leave="transition ease-in duration-75"
                          x-transition:leave-start="transform opacity-100 scale-100"
                          x-transition:leave-end="transform opacity-0 scale-95"
                          class="absolute right-0 top-11 w-40 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 py-2 overflow-hidden"
                          style="display: none;">
                        
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] font-bold text-gray-600 hover:bg-gray-50 hover:text-[#B87A3D] transition-colors">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                            Edit Cafe
                        </a>
                        
                        <button class="w-full flex items-center gap-3 px-4 py-2.5 text-[13px] font-bold text-red-500 hover:bg-red-50 transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            Hapus Cafe
                        </button>
                     </div>
                  </div>
               </td>
            </tr>
         @empty
            <tr>
               <td colspan="5" class="py-20 text-center">
                  <div class="flex flex-col items-center justify-center opacity-40">
                     <i data-lucide="search" class="w-12 h-12 text-gray-300 mb-4"></i>
                     <h3 class="text-lg font-bold text-gray-500">Pencarian Tidak Ditemukan</h3>
                  </div>
               </td>
            </tr>
         @endforelse
      </tbody>
   </table>
   
   <div class="px-8 py-5 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-white z-10 relative">
      <div class="flex items-center gap-2">
         <span class="text-[12px] font-bold text-gray-400 uppercase tracking-wider">
            Menampilkan <span class="text-gray-900">{{ $cafes->firstItem() ?? 0 }} - {{ $cafes->lastItem() ?? 0 }}</span> dari <span class="text-gray-900">{{ $cafes->total() }}</span> data
         </span>
      </div>
      
      <div class="flex items-center gap-1">
         @if ($cafes->onFirstPage())
            <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-100 text-gray-300 cursor-not-allowed"><i data-lucide="chevron-left" class="w-4 h-4"></i></span>
         @else
            <button @click.prevent="fetchPage('{{ $cafes->previousPageUrl() }}')" class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors"><i data-lucide="chevron-left" class="w-4 h-4"></i></button>
         @endif

         @foreach ($cafes->getUrlRange(max(1, $cafes->currentPage() - 1), min($cafes->lastPage(), $cafes->currentPage() + 1)) as $page => $url)
            <button @click.prevent="fetchPage('{{ $url }}')" 
                    class="w-9 h-9 flex items-center justify-center rounded-xl font-bold text-[13px] transition-all
                    {{ $page == $cafes->currentPage() ? 'bg-[#B87A3D] text-white shadow-md' : 'hover:bg-gray-50 text-gray-600' }}">
                {{ $page }}
            </button>
         @endforeach

         @if ($cafes->hasMorePages())
            <button @click.prevent="fetchPage('{{ $cafes->nextPageUrl() }}')" class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors"><i data-lucide="chevron-right" class="w-4 h-4"></i></button>
         @else
            <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-100 text-gray-300 cursor-not-allowed"><i data-lucide="chevron-right" class="w-4 h-4"></i></span>
         @endif
      </div>
   </div>
</div>
