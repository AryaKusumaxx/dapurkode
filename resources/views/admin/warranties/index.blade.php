@extends('layouts.admin.app')

@section('title', 'Manajemen Garansi')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Garansi</h1>
        <div>
            <a href="{{ route('admin.warranties.index') }}" class="btn btn-sm btn-primary shadow-sm {{ !request('status') ? 'active' : '' }}">
                <i class="fas fa-list fa-sm text-white-50"></i> Semua
            </a>
            <a href="{{ route('admin.warranties.index', ['status' => 'active']) }}" class="btn btn-sm btn-success shadow-sm {{ request('status') == 'active' ? 'active' : '' }}">
                <i class="fas fa-check-circle fa-sm text-white-50"></i> Aktif
            </a>
            <a href="{{ route('admin.warranties.index', ['status' => 'expired']) }}" class="btn btn-sm btn-danger shadow-sm {{ request('status') == 'expired' ? 'active' : '' }}">
                <i class="fas fa-times-circle fa-sm text-white-50"></i> Kadaluarsa
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Garansi</h6>
            <div>
                <form action="{{ route('admin.warranties.index') }}" method="GET" class="d-inline-flex">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="search" placeholder="Cari produk atau customer" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="25%">Produk</th>
                            <th width="10%">No. Seri</th>
                            <th width="15%">Customer</th>
                            <th width="12%">Mulai</th>
                            <th width="12%">Berakhir</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($warranties as $warranty)
                        <tr>
                            <td>{{ $warranty->id }}</td>
                            <td>
                                @if($warranty->orderItem && $warranty->orderItem->product)
                                    <strong>{{ $warranty->orderItem->product->name }}</strong>
                                    @if($warranty->orderItem->variant_name)
                                        <span class="text-muted d-block small">{{ $warranty->orderItem->variant_name }}</span>
                                    @endif
                                @else
                                    <span class="text-muted">Produk tidak tersedia</span>
                                @endif
                            </td>
                            <td>{{ $warranty->serial_number ?? 'N/A' }}</td>
                            <td>
                                @if($warranty->orderItem && $warranty->orderItem->order && $warranty->orderItem->order->user)
                                    <div>{{ $warranty->orderItem->order->user->name }}</div>
                                    <small class="text-muted">{{ $warranty->orderItem->order->user->email }}</small>
                                @else
                                    <span class="text-muted">Pengguna tidak tersedia</span>
                                @endif
                            </td>
                            <td>{{ $warranty->start_date->format('d M Y') }}</td>
                            <td>{{ $warranty->end_date->format('d M Y') }}</td>
                            <td class="text-center">
                                @if($warranty->isActive())
                                    @php
                                        $remainingDays = \Carbon\Carbon::now()->diffInDays($warranty->end_date);
                                        $badgeClass = $remainingDays < 30 ? 'badge-warning' : 'badge-success';
                                    @endphp
                                    <span class="badge {{ $badgeClass }} p-2">Aktif</span>
                                    @if($remainingDays < 30)
                                        <div class="small text-danger mt-1">{{ $remainingDays }} hari lagi</div>
                                    @endif
                                @else
                                    <span class="badge badge-danger p-2">Kadaluarsa</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.warranties.show', $warranty) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#statusModal{{ $warranty->id }}" title="Ubah Status">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="{{ route('admin.warranties.download', $warranty) }}" class="btn btn-primary btn-sm" title="Download Sertifikat">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                                
                                <!-- Status Update Modal -->
                                <div class="modal fade" id="statusModal{{ $warranty->id }}" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel{{ $warranty->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.warranties.update-status', $warranty) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="statusModalLabel{{ $warranty->id }}">Update Status Garansi</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="is_active">Status Garansi</label>
                                                        <select class="form-control" id="is_active" name="is_active">
                                                            <option value="1" {{ $warranty->is_active ? 'selected' : '' }}>Aktif</option>
                                                            <option value="0" {{ !$warranty->is_active ? 'selected' : '' }}>Non-Aktif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-center mb-3">
                                    <i class="fas fa-file-alt fa-3x text-gray-300"></i>
                                </div>
                                <p class="text-muted">Tidak ada data garansi yang ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $warranties->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Garansi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalWarranties ?? \App\Models\Warranty::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Garansi Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeWarranties ?? \App\Models\Warranty::where('is_active', true)->where('end_date', '>=', now())->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Garansi Kadaluarsa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $expiredWarranties ?? \App\Models\Warranty::where(function($query) { $query->where('is_active', false)->orWhere('end_date', '<', now()); })->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Perpanjangan Garansi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $warrantyExtensions ?? \App\Models\WarrantyExtension::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "ordering": true,
            "paging": false,
            "searching": true
        });
    });
</script>
@endsection
