<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\User;

class DoctorPolicy
{
    public function access(User $user, Doctor $doctor): bool
    {
        return $user->id === $doctor->user_id;
    }
}
