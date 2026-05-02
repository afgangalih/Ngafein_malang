@extends('layouts.user')

@section('title', $title . ' — Ngafein')

@section('content')
<div class="bg-[#FBFBFB] min-h-screen pb-20">
    
    <div class="max-w-7xl mx-auto px-4 md:px-8 pt-10 md:pt-16">
        
        {{-- Header Section --}}
        <div class="mb-16">
            <x-user.ui.user-back-button :href="route('user.cafe.index')" class="mb-6" />
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight mb-3">{{ $title }}</h1>
                    <p class="text-gray-500 font-medium max-w-2xl">
                        Menampilkan daftar kafe yang telah dikurasi secara otomatis oleh sistem kami berdasarkan data real-time.
                    </p>
                </div>
                <div class="flex items-center gap-4 bg-white px-6 py-3 rounded-2xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total</p>
                    <span class="text-lg font-black text-gray-900">{{ $cafes->total() }}</span>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div>
            @if($cafes->isEmpty())
                <div class="bg-white border border-gray-100 rounded-[3rem] p-20 text-center shadow-sm">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8 text-gray-200">
                        <i class="fa-solid fa-mug-hot text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">Belum Ada Kafe</h3>
                    <p class="text-gray-400 max-w-sm mx-auto font-medium leading-relaxed">
                        Kategori ini sedang dalam pembaruan data. Silakan cek kembali beberapa saat lagi.
                    </p>
                </div>
            @else
                {{-- Full Width Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach($cafes as $k)
                        @include('components.user.ui.user-cafe-card', ['k' => $k])
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-24">
                    {{ $cafes->links('components.user.ui.user-pagination') }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection

