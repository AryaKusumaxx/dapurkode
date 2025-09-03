@extends('layouts.admin.app')

@section('title', $title ?? 'Admin Panel')

@push('styles')
<!-- Additional styles specific to TinyMCE pages -->
<style>
    /* Fix untuk masalah kursor dan pointer-events */
    .tox-tinymce {
        z-index: 0 !important;
    }
    
    /* Pastikan semua elemen dalam TinyMCE menerima klik */
    body .tox .tox-toolbar,
    body .tox .tox-toolbar__group,
    body .tox .tox-tbtn,
    body .tox .tox-menubar,
    body .tox .tox-mbtn {
        pointer-events: auto !important;
        cursor: pointer !important;
    }
    
    /* Menghapus overlay yang mungkin menghalangi */
    body::before {
        display: none !important;
    }
</style>
@endpush

@push('scripts')
<!-- Tambahkan jQuery jika belum ada -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush

@section('content')
    <!-- Konten akan disediakan oleh halaman yang extends layout ini -->
    @yield('content')
@endsection
