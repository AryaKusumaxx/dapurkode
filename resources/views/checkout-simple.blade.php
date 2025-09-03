<html>
<head>
    <title>Simple Checkout</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .product { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; }
        .summary { background: #f9f9f9; padding: 15px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        
        <div class="product">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <p><strong>Price:</strong> Rp {{ number_format($basePrice, 0, ',', '.') }}</p>
        </div>
        
        <div class="summary">
            <h3>Order Summary</h3>
            <p>Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
            <p>Tax (11%): Rp {{ number_format($tax, 0, ',', '.') }}</p>
            <p><strong>Total: Rp {{ number_format($total, 0, ',', '.') }}</strong></p>
            
            <form method="POST" action="{{ route('checkout.process') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" style="background: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer;">
                    Proceed to Payment
                </button>
            </form>
        </div>
    </div>
</body>
</html>
