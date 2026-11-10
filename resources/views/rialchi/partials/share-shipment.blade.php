<div x-data="{ copied: false }">
    <p dir="auto" x-ref="message">{{ $shipment->message() }}</p>
    <x-filament::button type="button" x-on:click="navigator.clipboard.writeText($refs.message.textContent).then(() => copied = true)">
        <span x-text="copied ? 'تم النسخ' : 'نسخ الرسالة'">نسخ الرسالة</span>
    </x-filament::button>
</div>
