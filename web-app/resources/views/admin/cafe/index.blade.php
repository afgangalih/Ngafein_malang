@extends('layouts.admin')

@section('title', 'Data Alternatif — Ngafein Admin')

@section('content')
<div class="flex flex-col h-full space-y-6 pb-12" x-data="cafeSearch()">
    
    {{-- page header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-col">
            <h1 class="text-[1.5rem] font-black text-gray-900 tracking-tight">Data Alternatif</h1>
            <p class="text-gray-500 text-[13px] font-medium mt-1">Daftar cafe (alternatif) yang akan diproses dalam perhitungan SPK.</p>
        </div>
        
        <div class="flex items-center gap-3">
             <button class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-[#B87A3D]/30 transition-all font-bold text-[12px] shadow-sm group">
               <i data-lucide="upload" class="w-4 h-4 text-gray-400 group-hover:text-[#B87A3D] transition-colors"></i> 
               Import Dataset
             </button>
             <a href="#" class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-[#B87A3D] to-[#A36A32] text-white rounded-xl hover:-translate-y-0.5 transition-all font-bold text-[12px] shadow-lg shadow-[#B87A3D]/20">
               <i data-lucide="plus" class="w-4 h-4"></i> 
               Tambah Cafe
             </a>
        </div>
    </div>

    {{-- main table card --}}
    <div class="bg-white rounded-[2rem] shadow-[0_4px_24px_rgb(0,0,0,0.03)] border border-gray-100 flex flex-col relative overflow-hidden flex-1 min-h-[500px]">
        
        <div class="px-8 py-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white/50 backdrop-blur-sm z-10 relative">
           <div>
              <h2 class="text-lg font-bold text-gray-900">Database Cafe</h2>
              <p class="text-[12px] text-gray-500 mt-0.5" x-text="isLoading ? 'Mencari data...' : 'Daftar kafe yang tersedia untuk analisis.'"></p>
           </div>
           
           <div class="relative w-full sm:w-80 group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400 group-focus-within:text-[#B87A3D] transition-colors"></i>
                </div>
                <input 
                    type="text" 
                    x-model="search"
                    @input.debounce.400ms="fetchData()"
                    class="w-full pl-11 pr-4 py-2.5 bg-[#F8F9FA] border border-transparent rounded-xl text-[13px] text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-[#B87A3D]/40 focus:ring-4 focus:ring-[#B87A3D]/10 transition-all font-medium"
                    placeholder="Cari cafe atau alamat..."
                >
            </div>
        </div>

        <div id="table-wrapper" :class="{ 'opacity-50 pointer-events-none': isLoading }" class="transition-opacity duration-200">
           @include('admin.cafe._table')
        </div>

    </div>

</div>

@push('scripts')
<script>
    function cafeSearch() {
        return {
            search: '',
            isLoading: false,
            fetchData() {
                this.isLoading = true;
                const url = new URL(window.location.href);
                url.searchParams.set('search', this.search);
                url.searchParams.delete('page');

                fetch(url, {
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('table-wrapper').innerHTML = html;
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                    this.isLoading = false;
                })
                .catch(err => {
                    console.error(err);
                    this.isLoading = false;
                });
            },
            fetchPage(url) {
                this.isLoading = true;
                fetch(url, {
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('table-wrapper').innerHTML = html;
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                    this.isLoading = false;
                    window.history.pushState({}, '', url);
                });
            }
        }
    }
</script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endpush

@endsection
