<?php

// app/Policies/AcademicDocumentPolicy.php

namespace App\Policies;

use App\Models\AcademicDocument;
use App\Models\User;

class AcademicDocumentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, AcademicDocument $document): bool
    {
        return true;
    }

    public function delete(User $user, AcademicDocument $document): bool
    {
        return true;
    }
}
