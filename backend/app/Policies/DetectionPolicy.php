<?php

namespace App\Policies;

use App\Models\Detection;
use App\Models\User;

/**
 * A user may only view or delete their own detection records.
 * Auto-discovered by Laravel (Detection => DetectionPolicy).
 */
class DetectionPolicy
{
    public function view(User $user, Detection $detection): bool
    {
        return $user->id === $detection->user_id;
    }

    public function delete(User $user, Detection $detection): bool
    {
        return $user->id === $detection->user_id;
    }
}
