@push('styles')
<style>
    /* Animation for content */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-down {
        animation: fadeInDown 0.3s ease-out forwards;
    }
    
    /* Hide Alpine elements before initializing */
    [x-cloak] {
        display: none !important;
    }
</style>
@endpush
