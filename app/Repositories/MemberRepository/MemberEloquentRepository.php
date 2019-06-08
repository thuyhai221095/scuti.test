<?php
namespace App\Repositories\MemberRepository;

use App\Models\TblMember;
use App\Repositories\EloquentRepository;
use File;

class MemberEloquentRepository extends EloquentRepository implements MemberRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return TblMember::class;
    }

    public function getAvatar($name)
    {
        $path = storage_path('app/public/').$name;
        if (!File::exists($path)) {
            $path = storage_path('app/public/') . 'default.png';
        }
        return response()->file($path);
    }
}