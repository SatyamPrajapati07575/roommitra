<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VirtualTour;
use Illuminate\Auth\Access\HandlesAuthorization;

class VirtualTourPolicy
{
    use HandlesAuthorization;

    public function view(User $user, VirtualTour $virtualTour)
    {
        // Owner can view their own virtual tours
        return $user->user_id === $virtualTour->room->owner_id;
    }

    public function create(User $user)
    {
        // Only owners can create virtual tours
        return $user->role === 'owner';
    }

    public function update(User $user, VirtualTour $virtualTour)
    {
        // Only the owner of the room can update the virtual tour
        return $user->user_id === $virtualTour->room->owner_id;
    }

    public function delete(User $user, VirtualTour $virtualTour)
    {
        // Only the owner of the room can delete the virtual tour
        return $user->user_id === $virtualTour->room->owner_id;
    }
}
