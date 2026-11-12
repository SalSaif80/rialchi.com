<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Shipment extends Model
{
    protected $fillable = ['customer_id', 'destination', 'weight', 'method', 'details', 'photos'];

    protected $casts = ['photos' => 'array'];

    protected static function booted(): void
    {
        static::creating(function (self $shipment) {
            $shipment->number = 'RLC-'.strtoupper(bin2hex(random_bytes(8)));
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(ShipmentEvent::class)->orderBy('id');
    }

    public function latestEvent(): HasOne
    {
        return $this->hasOne(ShipmentEvent::class)->latestOfMany();
    }

    public function trackingUrl(): string
    {
        return route('rialchi.tracking', ['number' => $this->number, 'locale' => app()->getLocale()]);
    }

    public function message(): string
    {
        return __('عميلنا العزيز، رقم تتبع شحنتك لدى ريالتشي هو :number. يمكنك متابعة شحنتك هنا: :url', [
            'number' => $this->number,
            'url' => $this->trackingUrl(),
        ]);
    }
}
