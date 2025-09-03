<style>
    /* Base animations */
    .fade-in {
        animation: fadeIn 0.5s ease-in-out forwards;
    }
    
    .slide-in {
        animation: slideIn 0.5s ease-out forwards;
    }
    
    .slide-up {
        animation: slideUp 0.5s ease-out forwards;
    }
    
    .scale-in {
        animation: scaleIn 0.4s ease-out forwards;
    }
    
    .hover-grow {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-grow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .product-card {
        position: relative;
        overflow: hidden;
    }
    
    .product-card .detail-btn {
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .product-card:hover .detail-btn {
        transform: translateY(0);
        opacity: 1;
    }
    
    /* Payment page specific animations */
    .payment-method-card {
        transition: all 0.3s ease;
    }
    
    .payment-method-card:hover {
        transform: scale(1.02);
    }
    
    .payment-method-card.selected {
        border-color: #3B82F6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
    }
    
    .tab-content {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    
    .tab-content.hidden {
        opacity: 0;
        transform: translateY(10px);
    }
    
    .tab-content.active {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Receipt animation */
    .receipt-animation {
        animation: receiptDrop 0.8s ease-out forwards;
    }
    
    /* Success checkmark animation */
    .checkmark-circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    
    .checkmark {
        animation: fill 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both;
    }
    
    .checkmark-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }
    
    /* Loading spinner */
    .loading-spinner {
        animation: spin 1s linear infinite;
    }
    
    /* Animation keyframes */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(-20px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    @keyframes scaleIn {
        from {
            transform: scale(0.95);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    
    @keyframes receiptDrop {
        0% {
            transform: translateY(-100%);
            opacity: 0;
        }
        70% {
            transform: translateY(5%);
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }
    
    @keyframes scale {
        0%, 100% {
            transform: none;
        }
        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }
    
    @keyframes fill {
        100% {
            box-shadow: inset 0 0 0 30px #4CAF50;
        }
    }
</style>
