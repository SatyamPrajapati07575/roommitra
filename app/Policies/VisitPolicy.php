<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Auth\Access\HandlesAuthorization;

class VisitPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Visit $visit)
    {
        // User can view their own visits or owner can view visits for their rooms
        return $user->user_id === $visit->user_id || 
               $user->user_id === $visit->room->owner_id;
    }

    public function update(User $user, Visit $visit)
    {
        // User can update their own visits (cancel) or owner can update visits for their rooms
        return $user->user_id === $visit->user_id || 
               $user->user_id === $visit->room->owner_id;
    }

    public function delete(User $user, Visit $visit)
    {
        // Only the user who created the visit can delete it
        return $user->user_id === $visit->user_id;
    }
}
