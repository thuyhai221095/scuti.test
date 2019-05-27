<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\TblProject;

class ProjectTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */

     // Test Success
    public function testCreateProjectSuccess()
    {
        $request = [
            'name' => 'Project01',
            'infomation' => 'Project01 project infomation',
            'type' => 'lab',
            'status' => 'planned',
            'deadline' => '2019-06-01',
        ];
        $response = $this->call('POST', 'ajax/project', $request);
        $response
            ->assertStatus(201)
            ->assertJson([
                'errors' => false,
                'msg' => 'Add new successfully'
            ]);
        $this->assertDatabaseHas('tbl_projects', $request);
    }

    public function testUpdateProjectSuccess()
    {
        $project = factory(TblProject::class)->create();
        $request = [
            'name' => 'AE',
            'infomation' => 'AE infomation',
            'type' => 'lab',
            'status' => 'doing',
            'deadline' => '2019-06-01'
        ];
        $response = $this->json('PUT', 'ajax/project/'.$project->id, $request);
        $response
        ->assertStatus(201)
        ->assertJson([
            'errors' => false,
            'msg' => 'Update successfully'
        ]);
        $this->assertDatabaseHas('tbl_projects', $request);
    }

    public function testDeleteProjectSuccess()
    {
        $project = factory(TblProject::class)->create();
        $response = $this->call('DELETE', 'ajax/project/'.$project->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'errors' => false,
                'msg' => 'Delete successfully'
            ]);
    }
    // Test Failed
    public function testAddProjectNameEmpty()
    {
        $request = [
            'name' => '',
            'infomation' => 'AE project infomation',
            'type' => 'lab',
            'status' => 'planned',
            'deadline' => '2019-06-01',
        ];
        $response = $this->call('POST', 'ajax/project', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'name' => [
                        0 => 'The name field is required.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_projects', $request);
    }

    public function testAddProjectName10Character()
    {
        $request = [
            'name' => str_random(11),
            'infomation' => 'infomation',
            'type' => 'lab',
            'status' => 'planned',
            'deadline' => '2019-06-01',
        ];
        $response = $this->call('POST', 'ajax/project', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'name' => [
                        0 => 'The name may not be greater than 10 characters.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_projects', $request);
    }

    public function testAddProjectNameCanAlsoContain()
    {
        $request = [
            'name' => 'AC&AB',
            'infomation' => 'infomation',
            'type' => 'lab',
            'status' => 'planned',
            'deadline' => '2019-06-01',
        ];
        $response = $this->call('POST', 'ajax/project', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'name' => [
                        0 => 'The name format is invalid.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_projects', $request);
    }

    public function testAddProjectInfomation300Character()
    {
        $request = [
            'name' => 'name',
            'infomation' => str_random(301),
            'type' => 'lab',
            'status' => 'planned',
            'deadline' => '2019-06-01',
        ];
        $response = $this->call('POST', 'ajax/project', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'infomation' => [
                        0 => 'The infomation may not be greater than 300 characters.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_projects', $request);
    }

    public function testAddProjectDeadlineValidDate()
    {
        $request = [
            'name' => 'name',
            'infomation' => 'infomation',
            'type' => 'lab',
            'status' => 'planned',
            'deadline' => '2019-06-010',
        ];
        $response = $this->call('POST', 'ajax/project', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'deadline' => [
                        0 => 'The deadline is not a valid date.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_projects', $request);
    }

    public function testAddProjectTypeEmpty()
    {
        $request = [
            'name' => 'name',
            'infomation' => 'infomation',
            'type' => '',
            'status' => 'planned',
            'deadline' => '2019-06-01',
        ];
        $response = $this->call('POST', 'ajax/project', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'type' => [
                        0 => 'The type field is required.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_projects', $request);
    }

    public function testAddProjectStatusEmpty()
    {
        $request = [
            'name' => 'name',
            'infomation' => 'infomation',
            'type' => 'lab',
            'status' => '',
            'deadline' => '2019-06-01',
        ];
        $response = $this->call('POST', 'ajax/project', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'status' => [
                        0 => 'The status field is required.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_projects', $request);
    }
}
