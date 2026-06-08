@extends('layouts.admin')

@section('breadcrumb')
    <x-admin.breadcrumb :links="[
        ['label' => 'Persetujuan Kafe', 'url' => route('admin.approval.index')]
    ]" />
@endsection

@section('content')
<div class="space-y-6" x-data="approvalManager()">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Persetujuan Kafe Usulan</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Daftar kafe yang diusulkan oleh mahasiswa beserta riwayat approval.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#F5ECD7] rounded-[2rem] p-8 shadow-sm space-y-6">
        @include('admin.approval.partials.stats-cards', [
            'totalCount' => $proposals->count(),
            'pendingCount' => $proposals->where('status', 'pending')->count(),
            'approvedCount' => $proposals->where('status', 'approved')->whereNull('deleted_at')->count(),
            'rejectedCount' => $proposals->where('status', 'rejected')->count(),
            'deletedCount' => $proposals->whereNotNull('deleted_at')->count()
        ])

        @include('admin.approval.partials.filter-bar')
        
        <div class="mt-5">
            @include('admin.approval.partials.proposals-table')
        </div>
    </div>

    @include('admin.cafe.partials.side-panel')
</div>
@endsection

@push('scripts')
<script>
function approvalManager() {
    return {
        panelOpen: false,
        panelTitle: '',
        panelMode: 'detail',
        loading: false,
        isApproval: true,
        currentCafeId: null,
        searchQuery: '',
        activeTab: 'all',
        proposals: [
            @foreach($proposals as $cafe)
            {
                id: {{ $cafe->id_kafe }},
                name: '{{ addslashes($cafe->nama_kafe) }}',
                status: '{{ $cafe->status }}',
                address: '{{ addslashes($cafe->alamat) }}',
                distance: '{{ number_format($cafe->jarak, 1) }}',
                hours: '{{ $cafe->jam_buka }} - {{ $cafe->jam_tutup }}',
                user_name: '{{ $cafe->user ? addslashes($cafe->user->name) : 'Anonim' }}',
                user_email: '{{ $cafe->user ? addslashes($cafe->user->email) : '-' }}',
                deleted: {{ $cafe->trashed() ? 'true' : 'false' }}
            },
            @endforeach
        ],
        get filteredProposals() {
            return this.proposals.filter(p => {
                const matchesSearch = p.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                      p.address.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                      p.user_name.toLowerCase().includes(this.searchQuery.toLowerCase());
                
                let matchesTab = true;
                if (this.activeTab === 'pending') matchesTab = (p.status === 'pending' && !p.deleted);
                else if (this.activeTab === 'approved') matchesTab = (p.status === 'approved' && !p.deleted);
                else if (this.activeTab === 'rejected') matchesTab = (p.status === 'rejected' && !p.deleted);
                else if (this.activeTab === 'deleted') matchesTab = p.deleted;

                return matchesSearch && matchesTab;
            });
        },
        openPanel(url, mode, id, status, deleted) {
            this.panelMode = mode;
            this.currentCafeId = id;
            this.panelOpen = true;
            this.loading = true;
            this.panelTitle = 'Detail Usulan Kafe';
            this.isApproval = (status === 'pending' && !deleted);
            document.getElementById('panel-body-inner').innerHTML = '';
            
            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('panel-body-inner').innerHTML = html;
                this.loading = false;
                if (window.lucide) lucide.createIcons();
            })
            .catch(err => {
                console.error(err);
                this.closePanel();
                Swal.fire('Error', 'Gagal memuat data detail usulan', 'error');
            });
        },
        closePanel() {
            this.panelOpen = false;
        },
        approveCafe(id) {
            const form = document.getElementById(`form-approve-${id}`);
            if (form) {
                this.closePanel();
                form.submit();
            }
        },
        rejectCafe(id) {
            const form = document.getElementById(`form-reject-${id}`);
            if (form) {
                this.closePanel();
                form.submit();
            }
        }
    }
}
</script>
@endpush
