<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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
    public function testCreateProjectSuccess()
    {
        // Test create project
        $request = [
            'name' => 'AE',
            'infomation' => 'AE project infomation',
            'type' => 'lab',
            'status' => 'planned',
            'deadline' => '2019-06-01',
        ];
        $response = $this->json('POST', 'ajax/project', $request);
        $response
            ->assertStatus(201)
            ->assertJson([
                'errors' => false
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
                'errors' => false
            ]);
        $this->assertDatabaseHas('tbl_projects', $request);
    }

    public function testDeleteProjectSuccess()
    {
        $project = factory(TblProject::class)->create();
        $response = $this->json('DELETE', 'ajax/project/'.$project->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'errors' => false
            ]);
        $this->assertDatabaseMissing('tbl_members', [
            'name' => $project['name'],
            'infomation' => $project['infomation'],
            'type' => $project['type'],
            'status' => $project['status'],
            'deadline' => $project['deadline']
        ]);
    }
}
