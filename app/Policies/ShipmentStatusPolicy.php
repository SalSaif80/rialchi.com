<?php

namespace App\Policies;

use App\Models\ShipmentStatus;
use App\Models\User;

class ShipmentStatusPolicy
{
    public function viewAny(User $actor): bool
    {
        return $actor->role === 'admin';
    }

    public function create(User $actor): bool
    {
        return $this->viewAny($actor);
    }

    public function delete(User $actor, ShipmentStatus $status): bool
    {
        return $this->viewAny($actor) && !\App\Models\ShipmentEvent::where('shipment_status_id', $status->id)->exists();
    }

    public function update(User $actor, ShipmentStatus $status): bool
    {
        return $this->viewAny($actor);
    }
}
