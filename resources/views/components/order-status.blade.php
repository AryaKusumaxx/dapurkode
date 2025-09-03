<div>
    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $getClasses()['bg'] }} {{ $getClasses()['text'] }}">
        {{ $status['label'] }}
    </span>
    @if(isset($showDescription) && $showDescription && $status['description'])
        <p class="mt-1 text-xs text-gray-500">{{ $status['description'] }}</p>
    @endif
    @if(isset($showActions) && $showActions)
        <div class="mt-2">
            @if($status['payment_required'] && isset($invoice))
                <a href="{{ route('payment.show', $invoice) }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                    Bayar Sekarang
                </a>
            @endif
            @if($status['can_cancel'] && isset($order))
                <button type="button" class="ml-2 text-sm text-red-600 hover:text-red-900">
                    Batalkan
                </button>
            @endif
        </div>
    @endif
</div>
