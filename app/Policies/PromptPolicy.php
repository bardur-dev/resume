<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class PromptPolicy
{
    public function edit(User $user)
    {
        return $user->isAdmin();
    }
}
