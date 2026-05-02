{{-- ============================================================
     partials/admin/footer.blade.php
     Footer split: kiri mengikuti lebar sidebar (Alpine store),
     kanan mengisi sisa. Pakai :style agar width dinamis
     tidak terblokir Tailwind JIT scanner.
     ============================================================ --}}
<footer class="flex w-full flex-shrink-0">

    {{-- KIRI: di bawah sidebar, lebar mengikuti sidebar state --}}
    <div class="flex-shrink-0 transition-all duration-300 ease-in-out flex items-center justify-center"
         style="background-color: #8c5c24;"
         :style="{
             width: ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)
                 ? '280px'
                 : '80px'
         }">
    </div>

    {{-- KANAN: di bawah main content --}}
    <div class="flex-1 flex items-center justify-between px-6 py-3"
         style="background-color: #6e4a22;">
        <span class="text-xs" style="color: rgba(255,255,255,0.65);">
            &copy; {{ date('Y') }}
            <strong style="color: white; font-weight: 600;">Ngafein</strong>
            &mdash; Sistem Rekomendasi Kafe Berbasis KBS
        </span>
        <span style="color: rgba(255,255,255,0.35); font-size: 11px; font-weight: 500; letter-spacing: 0.05em;">
            v1.0.0
        </span>
    </div>

</footer>
