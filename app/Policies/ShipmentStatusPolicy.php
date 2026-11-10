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

    public function update(User $actor, ShipmentStatus $status): bool
    {
        return $this->viewAny($actor);
    }
}
