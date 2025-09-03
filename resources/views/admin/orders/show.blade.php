@extends('layouts.admin.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail Pesanan #{{ $order->id }}</h1>
            <p class="mt-2 mb-0">
                @switch($order->status)
                    @case('pending')
                        <span class="badge badge-warning">Pending</span>
                        @break
                    @case('processing')
                        <span class="badge badge-info">Processing</span>
                        @break
                    @case('completed')
                        <span class="badge badge-success">Completed</span>
                        @break
                    @case('cancelled')
                        <span class="badge badge-danger">Cancelled</span>
                        @break
                    @default
                        <span class="badge badge-secondary">{{ $order->status }}</span>
                @endswitch
                <span class="ml-2">Dibuat pada {{ $order->created_at->format('d M Y H:i') }}</span>
            </p>
        </div>
        <div>
            <button type="button" class="btn btn-primary btn-sm shadow-sm mr-2" data-toggle="modal" data-target="#updateStatusModal">
                <i class="fas fa-edit fa-sm text-white-50"></i> Update Status
            </button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Detail Pesanan</h6>
                    @if($order->invoice)
                        <a href="{{ route('admin.invoices.show', $order->invoice) }}" class="btn btn-sm btn-light">
                            <i class="fas fa-file-invoice"></i> Lihat Invoice
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    <!-- Order Items -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="40%">Produk</th>
                                    <th width="15%">Harga</th>
                                    <th width="10%">Qty</th>
                                    <th width="15%">Total</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->product_name }}</strong>
                                        @if($item->variant_name)
                                            <div class="small text-muted">Varian: {{ $item->variant_name }}</div>
                                        @endif
                                        @if($item->warranty_months)
                                            <div class="small text-success">
                                                <i class="fas fa-shield-alt"></i> Garansi {{ $item->warranty_months }} bulan
                                            </div>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                    <td>
                                        @if($item->warranty)
                                            <a href="{{ route('admin.warranties.show', $item->warranty->id) }}" class="btn btn-info btn-sm" title="Lihat Garansi">
                                                <i class="fas fa-shield-alt"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right font-weight-bold">Subtotal</td>
                                    <td colspan="2">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right font-weight-bold">Diskon</td>
                                    <td colspan="2">
                                        @if($order->discount_amount > 0)
                                            - Rp {{ number_format($order->discount_amount, 0, ',', '.') }}
                                            @if($order->discount_code)
                                                <div class="small text-muted">Kode: {{ $order->discount_code }}</div>
                                            @endif
                                        @else
                                            Rp 0
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right font-weight-bold">Total</td>
                                    <td colspan="2" class="font-weight-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-left-info shadow-sm h-100 py-2 mb-4">
                                <div class="card-body">
                                    <h6 class="font-weight-bold text-info mb-3">Informasi Customer</h6>
                                    <div class="d-flex mb-2">
                                        <div class="mr-3">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                        <div>
                                            <h6 class="font-weight-bold mb-1">{{ $order->user->name }}</h6>
                                            <p class="mb-1">{{ $order->user->email }}</p>
                                            <p class="mb-0">{{ $order->user->phone_number ?? 'Tidak ada nomor telepon' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-left-primary shadow-sm h-100 py-2 mb-4">
                                <div class="card-body">
                                    <h6 class="font-weight-bold text-primary mb-3">Alamat Pengiriman</h6>
                                    @if($order->shipping_address)
                                        <p class="mb-1">{{ $order->shipping_name }}</p>
                                        <p class="mb-1">{{ $order->shipping_address }}</p>
                                        <p class="mb-1">{{ $order->shipping_city }}, {{ $order->shipping_postcode }}</p>
                                        <p class="mb-0">{{ $order->shipping_phone }}</p>
                                    @else
                                        <p class="text-muted">Tidak ada informasi pengiriman</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($order->notes)
                        <div class="card border-left-warning shadow-sm mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-warning">Catatan Pesanan</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $order->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Timeline & Payments -->
        <div class="col-lg-4">
            <!-- Payment Information -->
            @if($order->payments->count() > 0)
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold">Informasi Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        @foreach($order->payments as $payment)
                            <div class="card mb-3 {{ $payment->status == 'verified' ? 'border-success' : 'border-warning' }}">
                                <div class="card-body py-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="font-weight-bold mb-0">Pembayaran #{{ $payment->id }}</h6>
                                        <div>
                                            @if($payment->status == 'verified')
                                                <span class="badge badge-success p-2">Terverifikasi</span>
                                            @elseif($payment->status == 'pending')
                                                <span class="badge badge-warning p-2">Menunggu Verifikasi</span>
                                            @else
                                                <span class="badge badge-danger p-2">Ditolak</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Tanggal:</small>
                                        <span>{{ $payment->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Jumlah:</small>
                                        <strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Metode:</small>
                                        <span>{{ $payment->payment_method }}</span>
                                    </div>
                                    
                                    @if($payment->status == 'pending')
                                        <div class="mt-3 text-center">
                                            <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-check-circle"></i> Verifikasi
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-warning text-white">
                        <h6 class="m-0 font-weight-bold">Informasi Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-5">
                            <i class="fas fa-credit-card fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">Belum ada pembayaran untuk pesanan ini.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Order Timeline -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Timeline</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-indicator bg-success"></div>
                            </div>
                            <div class="timeline-item-content">
                                <span class="font-weight-bold">Order Dibuat</span>
                                <p class="small text-muted mb-0">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($order->payments->count() > 0)
                            <div class="timeline-item">
                                <div class="timeline-item-marker">
                                    <div class="timeline-item-marker-indicator {{ $order->payments->where('status', 'verified')->count() > 0 ? 'bg-success' : 'bg-warning' }}"></div>
                                </div>
                                <div class="timeline-item-content">
                                    <span class="font-weight-bold">Pembayaran</span>
                                    <p class="small text-muted mb-0">
                                        {{ $order->payments->first()->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        
                        @if(in_array($order->status, ['processing', 'completed']))
                            <div class="timeline-item">
                                <div class="timeline-item-marker">
                                    <div class="timeline-item-marker-indicator {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning' }}"></div>
                                </div>
                                <div class="timeline-item-content">
                                    <span class="font-weight-bold">Pemrosesan</span>
                                    <p class="small text-muted mb-0">
                                        {{ $order->updated_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        
                        @if($order->status == 'completed')
                            <div class="timeline-item">
                                <div class="timeline-item-marker">
                                    <div class="timeline-item-marker-indicator bg-success"></div>
                                </div>
                                <div class="timeline-item-content">
                                    <span class="font-weight-bold">Selesai</span>
                                    <p class="small text-muted mb-0">
                                        {{ $order->updated_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        
                        @if($order->status == 'cancelled')
                            <div class="timeline-item">
                                <div class="timeline-item-marker">
                                    <div class="timeline-item-marker-indicator bg-danger"></div>
                                </div>
                                <div class="timeline-item-content">
                                    <span class="font-weight-bold">Dibatalkan</span>
                                    <p class="small text-muted mb-0">
                                        {{ $order->updated_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Update Status Modal -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStatusModalLabel">Update Status Pesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="status">Status Pesanan</label>
                            <select class="form-control" id="status" name="status">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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
</div>
@endsection

@section('styles')
<style>
    /* Timeline styling */
    .timeline {
        position: relative;
        padding-left: 1rem;
        margin: 0 0 0 1rem;
        border-left: 1px solid #e3e6ec;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    .timeline-item-marker {
        position: absolute;
        left: -1rem;
        width: 1rem;
        height: 1rem;
        margin-top: 0.25rem;
    }
    .timeline-item-marker-indicator {
        display: block;
        width: 0.75rem;
        height: 0.75rem;
        border-radius: 100%;
    }
    .timeline-item-content {
        padding-left: 1rem;
    }
</style>
@endsection
