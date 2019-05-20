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
    use DatabaseTransactions;
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testAddUserRoleSuccess()
    {
        $request = [
            'project_id' => 3,
            'member_id' => 3,
            'role' => 'DEV',
        ];
        $response = $this->call('POST', 'ajax/user_role', $request);
        $this->assertDatabaseHas('tbl_user_roles', $request);
    }

    public function testUpdateUserRoleSuccess()
    {
        $request = [
            'role' => 'PM',
        ];
        $response = $this->call('PUT', 'ajax/user_role/1', $request);
        
        $this->assertDatabaseHas('tbl_user_roles', $request);
    }

    public function testDeleteUserRoleSuccess()
    {
        $request = [
            'project_id' => 1,
            'member_id' => 1,
            'role' => 'DEV',
        ];
        $response = $this->call('delete', 'ajax/user_role/1');
        $response
            ->assertStatus(200)
            ->assertJson([
                'errors' => false
            ]);
        $this->assertDatabaseMissing('tbl_user_roles', $request);
    }
}
