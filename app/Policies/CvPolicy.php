<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Cv;
use Illuminate\Auth\Access\HandlesAuthorization;

class CvPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Cv');
    }

    public function view(AuthUser $authUser, Cv $cv): bool
    {
        return $authUser->can('View:Cv');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Cv');
    }

    public function update(AuthUser $authUser, Cv $cv): bool
    {
        return $authUser->can('Update:Cv');
    }

    public function delete(AuthUser $authUser, Cv $cv): bool
    {
        return $authUser->can('Delete:Cv');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Cv');
    }

    public function restore(AuthUser $authUser, Cv $cv): bool
    {
        return $authUser->can('Restore:Cv');
    }

    public function forceDelete(AuthUser $authUser, Cv $cv): bool
    {
        return $authUser->can('ForceDelete:Cv');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Cv');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Cv');
    }

    public function replicate(AuthUser $authUser, Cv $cv): bool
    {
        return $authUser->can('Replicate:Cv');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Cv');
    }

}