<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $actor): bool
    {
        return $actor->role === 'admin';
    }

    public function create(User $actor): bool
    {
        return $this->viewAny($actor);
    }

    public function update(User $actor, User $target): bool
    {
        return $this->viewAny($actor) && (! $target->is_owner || $actor->is($target));
    }

    public function delete(User $actor, User $target): bool
    {
        return $this->viewAny($actor) && ! $target->is_owner && ! $actor->is($target);
    }
}
