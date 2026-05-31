@extends('layouts.user')

@section('title', 'Personalisasi Kafe Saya — Ngafein')
@section('navbar-dark-text', 'true')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 md:pt-40 pb-20"
     x-data="{
        activeTab: 'favorites',
        searchQuery: '',
        sortBy: 'default',
        selectedCafe: null,
        toasts: [],
        addToast(message, type = 'success') {
            const id = Date.now();
            this.toasts.push({ id, message, type });
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 3000);
        },
        cafes: {{ json_encode($cafes) }},
        toggleBookmark(cafe) {
            fetch(`/kafe/${cafe.id}/bookmark`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    cafe.bookmarked = data.bookmarked;
                    if (cafe.bookmarked) {
                        cafe.blacklisted = false;
                        this.addToast(`${cafe.name} ditambahkan ke Favorit!`, 'success');
                    } else {
                        this.addToast(`${cafe.name} dihapus dari Favorit.`, 'info');
                    }
                    $dispatch('bookmark-toggled', { id: cafe.id, bookmarked: cafe.bookmarked });
                }
            });
        },
        toggleBlacklist(cafe) {
            fetch(`/kafe/${cafe.id}/blacklist`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    cafe.blacklisted = data.blacklisted;
                    if (cafe.blacklisted) {
                        cafe.bookmarked = false;
                        this.addToast(`${cafe.name} dimasukkan ke daftar Exclude. Dikecualikan dari perhitungan rekomendasi SAW.`, 'error');
                    } else {
                        this.addToast(`${cafe.name} dikeluarkan dari daftar Exclude.`, 'success');
                    }
                    $dispatch('blacklist-toggled', { id: cafe.id, blacklisted: cafe.blacklisted });
                }
            });
        },
        get filteredCafes() {
            let result = [...this.cafes];
            
            if (this.activeTab === 'favorites') {
                result = result.filter(c => c.bookmarked && !c.blacklisted);
            } else {
                result = result.filter(c => c.blacklisted);
            }

            if (this.searchQuery.trim() !== '') {
                const q = this.searchQuery.toLowerCase();
                result = result.filter(c => c.name.toLowerCase().includes(q) || c.location.toLowerCase().includes(q));
            }

            if (this.sortBy === 'rating') {
                result = result.sort((a, b) => b.rating - a.rating);
            } else if (this.sortBy === 'price-low') {
                result = result.sort((a, b) => a.price - b.price);
            } else if (this.sortBy === 'price-high') {
                result = result.sort((a, b) => b.price - a.price);
            }

            return result;
        }
     }">

    <div class="fixed bottom-5 right-5 z-[200] flex flex-col gap-3 max-w-md w-full pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-transition:enter="transition ease-out duration-300 transform translate-y-2 opacity-0"
                 x-transition:enter-end="transform translate-y-0 opacity-100"
                 x-transition:leave="transition ease-in duration-200 transform translate-y-2 opacity-0"
                 class="p-4 rounded-2xl shadow-xl border flex items-center gap-3 pointer-events-auto transition-all"
                 :class="{
                    'bg-emerald-50 border-emerald-100 text-emerald-800': toast.type === 'success',
                    'bg-red-50 border-red-100 text-red-800': toast.type === 'error',
                    'bg-amber-50 border-amber-100 text-amber-800': toast.type === 'info'
                 }">
                <span class="w-2.5 h-2.5 rounded-full shrink-0 animate-pulse" 
                      :class="{
                        'bg-emerald-500': toast.type === 'success',
                        'bg-red-500': toast.type === 'error',
                        'bg-amber-500': toast.type === 'info'
                      }"></span>
                <p class="text-xs font-bold leading-tight" x-text="toast.message"></p>
            </div>
        </template>
    </div>

    <div class="mb-10">
        <h1 class="text-3xl md:text-5xl font-serif font-bold text-gray-900 tracking-tight leading-tight mb-2">
            Personalisasi Kafe
        </h1>
        <p class="text-gray-500 text-sm max-w-xl leading-relaxed font-light">
            Kelola kafe favorit Anda dan sesuaikan daftar kafe yang ingin dikecualikan dari sistem perhitungan rekomendasi SAW secara praktis.
        </p>
    </div>

    @include('user.favorit.partials.control-bar')

    @include('user.favorit.partials.cards-grid')

</div>

@include('user.favorit.partials.detail-panel')

@endsection
