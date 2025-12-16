<?php

// app/Policies/AcademicDocumentPolicy.php

namespace App\Policies;

use App\Models\AcademicDocument;
use App\Models\User;

class AcademicDocumentPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function update(User $user, AcademicDocument $document): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function delete(User $user, AcademicDocument $document): bool
    {
        return $user->role === 'admin';
    }
}
