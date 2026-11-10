<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentEvent extends Model
{
    protected $fillable = ['shipment_status_id', 'location'];

    public function status(): BelongsTo
    {
        return $this->belongsTo(ShipmentStatus::class, 'shipment_status_id');
    }
}
