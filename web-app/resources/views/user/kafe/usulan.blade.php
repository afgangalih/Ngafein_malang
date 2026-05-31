@extends('layouts.user')

@section('title', 'Usulan Saya — Ngafein')
@section('navbar-dark-text', 'true')

@section('content')
@php
    $totalCount = $proposals->count();
    $approvedCount = $proposals->where('status', 'approved')->count();
    $pendingCount = $proposals->where('status', 'pending')->count();
    $rejectedCount = $proposals->where('status', 'rejected')->count();
@endphp

<div class="max-w-7xl mx-auto px-4 md:px-8 pt-32 md:pt-40 pb-20"
     x-data="{ 
        searchQuery: '', 
        activeTab: 'all',
        selectedCafe: null,
        panelOpen: false,
        proposals: [
            @foreach($proposals as $cafe)
            {
                id: {{ $cafe->id_kafe }},
                name: '{{ addslashes($cafe->nama_kafe) }}',
                status: '{{ $cafe->status }}',
                address: '{{ addslashes($cafe->alamat) }}',
                created: '{{ $cafe->created_at->diffForHumans() }}',
                timestamp: {{ $cafe->created_at->timestamp }},
                facilities: [
                    @foreach($cafe->fasilitas->take(3) as $fas)
                    '{{ str_replace('_', ' ', $fas->nama_fasilitas) }}',
                    @endforeach
                ],
                hasMoreFacilities: {{ $cafe->fasilitas->count() > 3 ? 'true' : 'false' }},
                extraFacilitiesCount: {{ max(0, $cafe->fasilitas->count() - 3) }},
                image: '{{ $cafe->gambar->first()?->link_gambar ?? ($cafe->gambar->first()?->path_gambar ? asset('storage/' . $cafe->gambar->first()->path_gambar) : 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&q=80&w=800') }}',
                deleted: {{ $cafe->trashed() ? 'true' : 'false' }},
                detail_url: '{{ ($cafe->status === 'approved' && !$cafe->trashed()) ? route('user.explore.detail', $cafe->id_kafe) : '#' }}',
                min_price: '{{ number_format($cafe->harga_min, 0, ',', '.') }}',
                max_price: '{{ number_format($cafe->harga_max, 0, ',', '.') }}',
                price_min: 'Rp {{ number_format($cafe->harga_min, 0, ',', '.') }}',
                price_max: 'Rp {{ number_format($cafe->harga_max, 0, ',', '.') }}',
                distance: '{{ number_format($cafe->jarak, 1, ',', '.') }}',
                hours: '{{ $cafe->jam_buka }} - {{ $cafe->jam_tutup }}',
                rating: '{{ number_format($cafe->rating, 1) }}',
                description: '{{ addslashes($cafe->deskripsi ?? 'Tidak ada deskripsi.') }}',
                category: 'Cafe'
            },
            @endforeach
        ],
        get filteredProposals() {
            return this.proposals.filter(p => {
                const matchesSearch = p.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                       p.address.toLowerCase().includes(this.searchQuery.toLowerCase());
                const matchesTab = this.activeTab === 'all' || p.status === this.activeTab;
                return matchesSearch && matchesTab;
            });
        }
     }">
    
    <div class="mb-12 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl md:text-5xl font-plus-jakarta font-bold text-gray-900 tracking-tight mb-3">Usulan Kafe Saya</h1>
            <p class="text-gray-500 text-sm max-w-xl">
                Pantau seluruh pengajuan kafe yang Anda usulkan secara langsung. Tim admin kami akan meninjau kelengkapan informasi sebelum mempublikasikannya.
            </p>
        </div>
        <a href="{{ route('user.kafe.tambah') }}" 
           class="bg-[#B87C39] hover:bg-[#a66c2e] text-white font-bold text-xs px-6 py-4 rounded-2xl transition-all shadow-lg shadow-[#B87C39]/20 flex items-center justify-center gap-2 self-start lg:self-auto hover:-translate-y-0.5 duration-200">
            <svg viewBox="0 0 24 24" class="w-4 h-4 fill-none stroke-current" stroke-width="2.5"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg> Usulkan Kafe Baru
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-12">
        <div class="bg-gradient-to-br from-amber-50/40 to-amber-100/10 border border-amber-200/40 rounded-3xl p-5 md:p-6 transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-700 flex items-center justify-center">
                    <svg viewBox="0 0 24 24" class="w-5 h-5 fill-none stroke-current" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                </div>
                <span class="text-[10px] font-black uppercase text-amber-600 tracking-wider">Total</span>
            </div>
            <div class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $totalCount }}</div>
            <p class="text-[11px] text-gray-400 mt-1">Seluruh usulan Anda</p>
        </div>

        <div class="bg-gradient-to-br from-yellow-50/40 to-yellow-100/10 border border-yellow-200/40 rounded-3xl p-5 md:p-6 transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-yellow-500/10 text-yellow-700 flex items-center justify-center">
                    <svg viewBox="0 0 24 24" class="w-5 h-5 fill-none stroke-current" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <span class="text-[10px] font-black uppercase text-yellow-600 tracking-wider">Pending</span>
            </div>
            <div class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $pendingCount }}</div>
            <p class="text-[11px] text-gray-400 mt-1">Sedang ditinjau admin</p>
        </div>

        <div class="bg-gradient-to-br from-emerald-50/40 to-emerald-100/10 border border-emerald-200/40 rounded-3xl p-5 md:p-6 transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-700 flex items-center justify-center">
                    <svg viewBox="0 0 24 24" class="w-5 h-5 fill-none stroke-current" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <span class="text-[10px] font-black uppercase text-emerald-600 tracking-wider">Disetujui</span>
            </div>
            <div class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $approvedCount }}</div>
            <p class="text-[11px] text-gray-400 mt-1">Telah aktif di platform</p>
        </div>

        <div class="bg-gradient-to-br from-rose-50/40 to-rose-100/10 border border-rose-200/40 rounded-3xl p-5 md:p-6 transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-700 flex items-center justify-center">
                    <svg viewBox="0 0 24 24" class="w-5 h-5 fill-none stroke-current" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
                <span class="text-[10px] font-black uppercase text-rose-600 tracking-wider">Ditolak</span>
            </div>
            <div class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $rejectedCount }}</div>
            <p class="text-[11px] text-gray-400 mt-1">Tidak memenuhi kriteria</p>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-md border border-[#B87C39]/25 rounded-3xl p-4 md:p-6 mb-8 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
        <div class="relative w-full md:max-w-md">
            <svg viewBox="0 0 24 24" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 fill-none stroke-current" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" 
                   x-model="searchQuery" 
                   placeholder="Cari berdasarkan nama atau alamat kafe..." 
                   class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 focus:border-[#B87C39] focus:bg-white rounded-2xl text-xs font-medium outline-none transition-all placeholder:text-gray-400">
        </div>

        <div class="flex items-center gap-1.5 p-1 bg-gray-50 border border-gray-100 rounded-2xl w-full md:w-auto overflow-x-auto whitespace-nowrap">
            <button @click="activeTab = 'all'" 
                    :class="activeTab === 'all' ? 'bg-[#B87C39] text-white shadow-sm' : 'text-gray-500 hover:text-gray-800'"
                    class="px-4 py-2.5 rounded-xl font-bold text-xs transition-all cursor-pointer">
                Semua
            </button>
            <button @click="activeTab = 'pending'" 
                    :class="activeTab === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'text-gray-500 hover:text-amber-600'"
                    class="px-4 py-2.5 rounded-xl font-bold text-xs transition-all cursor-pointer">
                Pending
            </button>
            <button @click="activeTab = 'approved'" 
                    :class="activeTab === 'approved' ? 'bg-emerald-500 text-white shadow-sm' : 'text-gray-500 hover:text-emerald-600'"
                    class="px-4 py-2.5 rounded-xl font-bold text-xs transition-all cursor-pointer">
                Disetujui
            </button>
            <button @click="activeTab = 'rejected'" 
                    :class="activeTab === 'rejected' ? 'bg-rose-500 text-white shadow-sm' : 'text-gray-500 hover:text-rose-600'"
                    class="px-4 py-2.5 rounded-xl font-bold text-xs transition-all cursor-pointer">
                Ditolak
            </button>
        </div>
    </div>

    <div class="relative min-h-[300px]">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-show="filteredProposals.length > 0" x-transition>
            <template x-for="p in filteredProposals" :key="p.id">
                <div @click="selectedCafe = p; panelOpen = true" 
                     class="bg-white border border-[#B87C39]/25 rounded-3xl p-5 shadow-sm flex flex-col sm:flex-row gap-5 transition-all hover:shadow-lg hover:-translate-y-0.5 duration-200 cursor-pointer">
                    
                    <div class="w-full sm:w-40 h-40 rounded-2xl overflow-hidden shrink-0 bg-gray-100 border border-gray-100 relative">
                        <img :src="p.image" :alt="p.name" class="w-full h-full object-cover">
                        
                        <span class="absolute bottom-2.5 left-2.5 px-2.5 py-1 bg-black/70 backdrop-blur-md text-[9px] font-black text-white rounded-lg flex items-center gap-1">
                            <svg viewBox="0 0 24 24" class="w-2.5 h-2.5 text-[#B87C39] fill-none stroke-current" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg> <span x-text="p.distance + ' km'"></span>
                        </span>
                    </div>

                    <div class="flex-1 flex flex-col justify-between min-w-0 py-1">
                        <div>
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <h3 class="text-base font-extrabold text-gray-900 truncate leading-snug" :title="p.name" x-text="p.name"></h3>
                                
                                <template x-if="p.deleted">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-full border border-gray-200 shrink-0">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Dihapus Admin
                                    </span>
                                </template>
                                <template x-if="p.status === 'pending' && !p.deleted">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 text-[10px] font-bold rounded-full border border-amber-200/50 shrink-0">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending
                                    </span>
                                </template>
                                <template x-if="p.status === 'approved' && !p.deleted">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full border border-emerald-200/50 shrink-0">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disetujui
                                    </span>
                                </template>
                                <template x-if="p.status === 'rejected' && !p.deleted">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 text-[10px] font-bold rounded-full border border-rose-200/50 shrink-0">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak
                                    </span>
                                </template>
                            </div>

                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-3" :title="p.address">
                                <span x-text="p.address"></span>
                            </p>

                            <div class="text-[11px] font-bold text-gray-600 mb-4 flex items-center gap-1">
                                <svg viewBox="0 0 24 24" class="w-3.5 h-3.5 text-[#B87C39] fill-none stroke-current" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8M12 6v12"/></svg>
                                Rp <span x-text="p.min_price"></span> - Rp <span x-text="p.max_price"></span>
                            </div>

                            <div class="flex flex-wrap gap-1.5 mb-4">
                                <template x-for="f in p.facilities">
                                    <span class="px-2.5 py-1 bg-gray-50 text-[10px] font-bold text-gray-500 rounded-lg capitalize border border-gray-100" x-text="f"></span>
                                </template>
                                <template x-if="p.hasMoreFacilities">
                                    <span class="px-2 py-1 text-[9px] font-black text-gray-400" x-text="'+' + p.extraFacilitiesCount + ' Lainnya'"></span>
                                </template>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-3.5 border-t border-gray-50 text-[10px] font-bold text-gray-400">
                            <span x-text="'Diajukan ' + p.created"></span>
                            
                            <template x-if="p.status === 'approved' && !p.deleted">
                                <a :href="p.detail_url" @click.stop=""
                                   class="text-[#B87C39] hover:text-[#9a662e] transition-colors flex items-center gap-1 font-extrabold uppercase tracking-wider text-[9px]">
                                    Lihat Detail <svg viewBox="0 0 24 24" class="w-3.5 h-3.5 fill-none stroke-current" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="flex flex-col items-center justify-center py-20 text-center bg-[#B87C39]/5 border border-[#B87C39]/20 rounded-[2.5rem] p-8"
             x-show="proposals.length === 0" x-transition>
            <div class="w-16 h-16 rounded-2xl bg-[#B87C39]/10 text-[#B87C39] flex items-center justify-center mb-6">
                <svg viewBox="0 0 24 24" class="w-8 h-8 fill-none stroke-current" stroke-width="2"><path d="M22 12h-6l-2 3h-4l-2-3H2"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Riwayat Usulan</h3>
            <p class="text-sm text-gray-500 max-w-sm mb-8 leading-relaxed">
                Anda belum pernah mengusulkan kafe. Mulai bagikan tempat ngopi pilihan Anda agar dapat ditinjau oleh tim kami.
            </p>
            <a href="{{ route('user.kafe.tambah') }}"
               class="bg-[#B87C39] hover:bg-[#a66c2e] text-white font-bold text-xs px-6 py-3.5 rounded-xl transition-all shadow-md shadow-[#B87C39]/20">
                Usulkan Kafe Baru
            </a>
        </div>

        <div class="flex flex-col items-center justify-center py-20 text-center bg-[#B87C39]/5 border border-[#B87C39]/20 rounded-[2.5rem] p-8"
             x-show="proposals.length > 0 && filteredProposals.length === 0" x-transition>
            <div class="w-16 h-16 rounded-2xl bg-[#B87C39]/10 text-[#B87C39] flex items-center justify-center mb-6">
                <svg viewBox="0 0 24 24" class="w-8 h-8 fill-none stroke-current" stroke-width="2"><path d="M22 12h-6l-2 3h-4l-2-3H2"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Tidak Ada Usulan Ditemukan</h3>
            <p class="text-sm text-gray-500 max-w-sm mb-8 leading-relaxed">
                Kami tidak menemukan usulan kafe yang sesuai dengan pencarian atau kategori status Anda saat ini.
            </p>
            <button @click="searchQuery = ''; activeTab = 'all'"
                    class="bg-[#B87C39] hover:bg-[#a66c2e] text-white font-bold text-xs px-6 py-3.5 rounded-xl transition-all shadow-md shadow-[#B87C39]/20 cursor-pointer">
                Reset Pencarian & Filter
            </button>
        </div>
    </div>
</div>

@include('user.kafe.partials.detail-modal')

@endsection
