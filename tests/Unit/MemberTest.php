<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\TblMember;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MemberTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * A basic test example.
     *
     * @return void
     */
    // Test Success
    public function testCreateMemberSuccess()
    {
        // Storage::fake('avatars');
        // $file = UploadedFile::fake()->image('avatar.png');
        // test create member
        $request = [
            'name' => '',
            'infomation' => 'Thuy',
            'phone' => '0984287637',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
            // 'avatar' => $file
        ];
        $response = $this->json('POST', 'ajax/member', $request);
        dd($response);
        $response
            ->assertStatus(201)
            ->assertJson([
                'errors' => false
            ]);
        $this->assertDatabaseHas('tbl_members', $request);
    }

    public function testUpdateMemberSuccess()
    {
        // test update member
        $member = factory(TblMember::class)->create([
            'name' => 'Thuyhai22',
            'infomation' => 'infomation 01',
            'phone' => '0987654321',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ]);
        
        $request = [
            'name' => 'Thuy',
            'infomation' => 'Thuy',
            'phone' => '0984287637',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ];
        $response = $this->json('POST', '/ajax/updateMember/' . $member->id, $request);
        $response
            ->assertStatus(201)
            ->assertJson([
                'errors' => false
            ]);
        $this->assertDatabaseHas('tbl_members', $request);
    }

    public function testDeleteMember()
    {
        // test delete member
        $member = factory(TblMember::class)->create([
            'name' => 'Thuyhai22',
            'infomation' => 'infomation 01',
            'phone' => '0987654321',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior'
        ]);
        $response = $this->call('delete', 'ajax/member/'.$member->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'errors' => false
            ]);
        $this->assertDatabaseMissing('tbl_members', [
            'name' => 'Thuyhai22',
            'infomation' => 'infomation 01',
            'phone' => '0987654321',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior'
        ]);
    }
    // Test Failed
    
}
