<div x-data="{ copied: false }">
    <p dir="auto" x-ref="message">{{ $shipment->message() }}</p>
    <x-filament::button type="button" x-on:click="navigator.clipboard.writeText($refs.message.textContent).then(() => copied = true)">
        <span x-show="!copied">{{ __("نسخ الرسالة") }}</span><span x-cloak x-show="copied">{{ __('تم النسخ') }}</span>
    </x-filament::button>
</div>
