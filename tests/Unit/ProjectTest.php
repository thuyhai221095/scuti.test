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
    use DatabaseTransactions;
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
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
        $this->assertDatabaseMissing('tbl_projects', $request);
    }

    public function testAddProjectCanAlsoContain()
    {
        $request = [
            'name' => 'AC&AB',
            'infomation' => 'infomation',
            'type' => 'lab',
            'status' => 'planned',
            'deadline' => '2019-06-01',
        ];
        $response = $this->call('POST', 'ajax/project', $request);
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
        $this->assertDatabaseMissing('tbl_projects', $request);
    }
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
        $this->assertDatabaseHas('tbl_projects', $request);
    }

    public function testUpdateProjectSuccess()
    {
        $request = [
            'name' => 'AE',
            'infomation' => 'AE infomation',
            'type' => 'lab',
            'status' => 'doing',
            'deadline' => '2019-06-01'
        ];
        $response = $this->json('PUT', 'ajax/project/1', $request);
        $this->assertDatabaseHas('tbl_projects', $request);
    }

    public function testDeleteProjectSuccess()
    {
        $response = $this->call('DELETE', 'ajax/project/1');
        $this->assertDatabaseMissing('tbl_projects', [
            'name' => 'AE',
            'infomation' => 'AE project infomation',
            'type' => 'lab',
            'status' => 'planned',
            'deadline' => '01-06-2019'
        ]);
    }
}
