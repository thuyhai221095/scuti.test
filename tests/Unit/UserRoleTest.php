<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\TblUserRole;
use App\Models\TblMember;
use App\Models\TblProject;

class UserRoleTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testAddUserRoleSuccess()
    {
        $member = factory(TblMember::class)->create();
        $project = factory(TblProject::class)->create();
        $request = [
            'project_id' => $project->id,
            'member_id' => $member->id,
            'role' => 'DEV',
        ];
        $response = $this->call('POST', 'ajax/user_role', $request);
        $response
            ->assertStatus(201)
            ->assertJson([
                'errors' => false
            ]);
        $this->assertDatabaseHas('tbl_user_roles', $request);
    }

    public function testUpdateUserRoleSuccess()
    {
        $member = factory(TblMember::class)->create();
        $project = factory(TblProject::class)->create();
        $user_role = factory(TblUserRole::class)->create([
            'project_id' => $project->id,
            'member_id' => $member->id,
            'role' => 'DEV'
        ]);
        $request = [
            'role' => 'PM',
        ];
        $response = $this->call('PUT', 'ajax/user_role/'.$user_role->id, $request);
        $response
            ->assertStatus(201)
            ->assertJson([
                'errors' => false
            ]);
        $this->assertDatabaseHas('tbl_user_roles', $request);
    }

    public function testDeleteUserRoleSuccess()
    {
        $member = factory(TblMember::class)->create();
        $project = factory(TblProject::class)->create();
        $user_role = factory(TblUserRole::class)->create([
            'project_id' => $project->id,
            'member_id' => $member->id,
            'role' => 'DEV'
        ]);
        $response = $this->call('delete', 'ajax/user_role/'.$user_role->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'errors' => false
            ]);
        
    }

    // Test Faild
    public function testAddMemberProjectEmpty()
    {
        $member = factory(TblMember::class)->create();
        $request = [
            'project_id' => '',
            'member_id' => $member->id,
            'role' => 'DEV',
        ];
        $response = $this->call('POST', 'ajax/user_role', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'project_id' => [
                        0 => 'The project id field is required.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_user_roles', $request);
    }

    public function testAddMemberMemberEmpty()
    {
        $project = factory(TblProject::class)->create();
        $request = [
            'project_id' => $project->id,
            'member_id' => '',
            'role' => 'DEV',
        ];
        $response = $this->call('POST', 'ajax/user_role', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'member_id' => [
                        0 => 'The member field is required.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_user_roles', $request);
    }

    public function testAddMemberRoleEmpty()
    {
        $project = factory(TblProject::class)->create();
        $member = factory(TblMember::class)->create();
        $request = [
            'project_id' => $project->id,
            'member_id' => $member->id,
            'role' => '',
        ];
        $response = $this->call('POST', 'ajax/user_role', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'role' => [
                        0 => 'The role field is required.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_user_roles', $request);
    }
}
