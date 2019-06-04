<?php

namespace App\Repositories\MemberRepository;

use App\Repositories\RepositoryInterface;

/**
 * Interface MemberRepositoryInterface.
 */
interface MemberRepositoryInterface extends RepositoryInterface
{
    public function getAvatar($name);
}
