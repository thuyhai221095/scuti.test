<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\TblUserRole;

class UserRoleTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testAddUserRoleSuccess()
    {
        // test add user role
        $request = [
            'project_id' => 1,
            'member_id' => 1,
            'role' => 'DEV',
        ];
        $response = $this->json('POST', 'ajax/project', $request);
        $response
            ->assertStatus(201)
            ->assertJson([
                'errors' => false
            ]);
        $this->assertDatabaseHas('tbl_projects', $request);
    }

    public function testUpdateUserRoleSuccess()
    {
        $userRole = factory(TblUserRole::Class)->create();
    }

    public function testDeleteUserRoleSuccess()
    {

    }
}
