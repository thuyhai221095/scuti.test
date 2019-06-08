<?php

namespace App\Services;

use App\Repositories\MemberRepository\MemberRepositoryInterface;
/**
 * Class NewsService.
 */
class MemberService
{
    /**
     * @var MemberRepositoryInterface 
     */
    protected $repository;

    /**
     * NewsService constructor.
     *
     * @param MemberRepositoryInterface $repository
     */
    public function __construct(MemberRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle create new member.
     *
     * @param $data
     *
     * @return mixed
     */
    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function create($data)
    {
        $data['date_of_birth'] = date("Y-m-d", strtotime($data['date_of_birth']));
        if ($data['avatar']) {
            $file = $this->handleSaveImage($data['avatar'], true, false);
            $data['avatar'] = $file;
        }
        $member = $this->repository->create($data);
        return $member;
    }
    
    public function update($id, $data)
    {
        $data['date_of_birth'] = date("Y-m-d", strtotime($data['date_of_birth']));
        if ($data['avatar']) {
            $file = $this->handleSaveImage($data['avatar'], true, false);
            $data['avatar'] = $file;
        }
        $member = $this->repository->update($id, $data);
        return $member;
    }

    public function destroy($id)
    {
        return $this->repository->delete($id);
    }

    public function getAvatar($name)
    {
        return $this->repository->getAvatar($name);
    }

    public function handleSaveImage($image, $check = true, $get = false)
    {
        $file = $image->store('', 'public');
        return $file;
    }
}
