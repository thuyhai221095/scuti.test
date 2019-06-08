<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TblMember;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
    /**
     * Determine whether the user can view the member.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TblMember  $member
     * @return mixed
     */
    public function view(User $user, TblMember $member)
    {
        
    }

    /**
     * Determine whether the user can create members.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the member.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Member  $member
     * @return mixed
     */
    public function update(User $user, TblMember $member)
    {
        //
    }

    /**
     * Determine whether the user can delete the member.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Member  $member
     * @return mixed
     */
    public function delete(User $user, TblMember $member)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
