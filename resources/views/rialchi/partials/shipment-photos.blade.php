<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,160px),1fr));gap:1rem">
    @foreach ($shipment->photos as $photo)
        <a href="{{ route('rialchi.shipment-photo', [$shipment->number, $loop->index]) }}" target="_blank" rel="noopener">
            <img src="{{ route('rialchi.shipment-photo', [$shipment->number, $loop->index]) }}"
                 alt="صورة المنتج {{ $loop->iteration }}" loading="lazy" style="width:100%;height:160px;object-fit:contain">
        </a>
    @endforeach
</div>
